# 🎯 Logika Kuis, Mode Pengerjaan & Sistem Penilaian (Quiz Logic)

Dokumen ini menjelaskan logika teknis sistem kuis global di [`SiswaController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/SiswaController.php) dan [`QuizController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/QuizController.php), mencakup mode ujian, jenis pertanyaan, kalkulasi skor, serta transaksi atomik anti-duplikasi poin.

---

## 1. Dua Mode Pengerjaan Kuis

Aplikasi Arrava mendukung dua paradigma pengerjaan kuis yang tersimpan di kolom `mode_pengerjaan`:

### A. Mode "Biasa" (Waktu Total Ujian)
* **Karakteristik**: Siswa diberikan waktu total (misal: 30 menit melalui `durasi_total_menit`).
* **Navigasi Fleksibel**: Siswa bebas berpindah nomor soal maju-mundur menggunakan tombol *Previous*, *Next*, atau kisi tombol nomor di panel sidebar.
* **Validasi Kelengkapan Soal (Unanswered Check)**:
  * Siswa **tidak diizinkan mengumpulkan jawaban** jika masih ada soal yang belum dijawab.
  * Sistem menghentikan pengiriman dan memunculkan notifikasi spesifik yang menyebutkan nomor soal mana saja yang belum diisi (misal: *"Soal nomor 2 dan 4 belum dijawab"*).
  * *Pengecualian*: Jika timer total kuis habis di sisi klien, flag `is_timeout = 1` dikirimkan sehingga sistem otomatis menerima jawaban apa adanya tanpa memblokir.

### B. Mode "Wayground" (Waktu per Soal Bertahap)
* **Karakteristik**: Menghitung mundur waktu untuk tiap butir soal (misal: 15–25 detik per nomor melalui `durasi_detik`).
* **Sesi Pengerjaan**:
  * Menggunakan session state di server: `wayground_attempt.{userId}.{quizId}` yang menyimpan `active_question_index`, `question_started_at`, dan array `answers`.
  * Sistem menyediakan batas toleransi waktu latensi jaringan (*grace period* 3 detik).
  * Setelah nomor terakhir dijawab, seluruh jawaban yang terkumpul langsung dinilai secara serentak.

---

## 2. Format & Penilaian Bentuk Soal

Method [`hitungSkor()`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/SiswaController.php) mendukung tiga jenis soal:

1. **Pilihan Ganda (`id_jenis_soal = 1`)**:
   * Memiliki 4 opsi pada tabel `pilihan_soal`.
   * Jawaban benar ditandai dengan `is_correct = true`.
   * Evaluasi: Label jawaban siswa (`A`, `B`, `C`, atau `D`) dicocokkan dengan label pilihan yang bernilai benar.
2. **Benar / Salah (`id_jenis_soal = 3`)**:
   * Memiliki 2 opsi (A: Benar, B: Salah).
   * Evaluasi: Jawaban siswa dicocokkan dengan label `A` atau `B`.
3. **Isian Singkat (`id_jenis_soal = 2`)**:
   * Tidak memiliki rekaman di tabel `pilihan_soal`.
   * Evaluasi: Teks input siswa dibersihkan dari spasi pinggir dan diubah ke huruf kecil (*case-insensitive*), lalu dicocokkan dengan teks `jawaban_benar` di tabel `soal`:
     ```php
     $kunci = mb_strtolower(trim((string) $soal->jawaban_benar));
     $isCorrect = ($kunci !== '' && $kunci === mb_strtolower(trim((string) $jawab)));
     ```

---

## 3. Transaksi Poin Atomik & Pencegahan Duplikasi (Anti-Cheat / Anti-Duplication)

Untuk menjamin keadilan sistem gamifikasi, poin reward kuis diatur dengan prinsip **"Poin Kelulusan Pertama"**:

```php
// app/Http/Controllers/SiswaController.php
[$hasil, $poinDiberikan] = DB::transaction(function () use ($user, $quiz, $totalPoinQuiz, $poinDidapat, $isLulus) {
    // 1. Kunci baris user agar request ganda simultan tidak menimbulkan race condition
    User::whereKey($user->id_user)->lockForUpdate()->firstOrFail();

    // 2. Periksa apakah siswa sudah pernah lulus di kuis ini sebelumnya
    $sudahLulusSebelumnya = HasilQuizModul::where('id_user', $user->id_user)
        ->where('id_quiz', $quiz->id_quiz)
        ->where('is_lulus', true)
        ->exists();

    // 3. Poin hanya dihadiahkan jika ini adalah kelulusan pertama
    $poinDiberikan = ($isLulus && !$sudahLulusSebelumnya) ? $poinDidapat : 0;

    // 4. Catat riwayat pengerjaan
    $hasil = HasilQuizModul::create([
        'id_user' => $user->id_user,
        'id_quiz' => $quiz->id_quiz,
        'total_poin' => $totalPoinQuiz,
        'poin_didapat' => $poinDidapat,
        'is_lulus' => $isLulus,
        'waktu_dapat' => now(),
    ]);

    // 5. Tambahkan poin ke profil user
    if ($poinDiberikan > 0) {
        User::whereKey($user->id_user)->increment('total_poin', $poinDiberikan);
    }

    return [$hasil, $poinDiberikan];
});
```

* **Dampak**: Siswa dapat mengulang kuis untuk memperbaiki nilai pribadinya kapan saja, tetapi poin XP akun tidak akan bisa di-*farming* atau digandakan secara curang.
