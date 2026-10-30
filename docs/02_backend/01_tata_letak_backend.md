# 🏗️ Tata Letak & Struktur Direktori Backend (Backend Layout)

Dokumen ini memetakan seluruh file dan struktur folder di sisi backend aplikasi **Arrava E-Learning**, mencakup controller, model Eloquent, middleware, migrasi skema database, dan seeder.

---

## 1. Peta Direktori Backend

```text
elearningarrava/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       -> Autentikasi (login, register, logout, switch role)
│   │   │   ├── AdminController.php      -> Dashboard admin, statistik, verifikasi siswa
│   │   │   ├── SiswaController.php      -> Dashboard siswa, pembelajaran modul & eksekusi kuis
│   │   │   ├── ModulController.php      -> CRUD modul ajar, draf, upload fisik & link YouTube
│   │   │   ├── QuizController.php       -> CRUD kuis global, builder soal, verifikasi token
│   │   │   ├── OrangtuaController.php   -> Portal orang tua, riwayat pencapaian anak
│   │   │   └── SoalController.php       -> Manipulasi butir soal individual
│   │   └── Middleware/
│   │       ├── CheckRole.php            -> Pemeriksaan hak akses berdasarkan id_tipeuser
│   │       └── PreventBackHistory.php   -> Pencegahan cache browser setelah logout
│   └── Models/
│       ├── User.php                     -> Pengguna, atribut rank tier, relasi jenjang & peran
│       ├── Jenjang.php                  -> Master data tingkatan sekolah (SD, SMP, SMA)
│       ├── TipeUser.php                 -> Master peran pengguna (Admin, Guru, Siswa)
│       ├── Modul.php                    -> Entitas materi belajar & link video/PDF
│       ├── CatatanModul.php             -> Rangkuman materi per modul
│       ├── ModulSoal.php                -> Butir soal evaluasi in-modul
│       ├── ModulSoalPilihan.php         -> Opsi jawaban butir soal evaluasi in-modul
│       ├── ProgresModulSiswa.php        -> Status tuntas belajar & nilai evaluasi kuis siswa
│       ├── Quiz.php                     -> Entitas kuis global (mode biasa & wayground)
│       ├── Soal.php                     -> Butir soal kuis global
│       ├── PilihanSoal.php              -> Opsi pilihan ganda / benar salah kuis global
│       ├── HasilQuizModul.php           -> Riwayat nilai & klaim perolehan poin kuis
│       ├── TipeQuiz.php                 -> Kategori kuis (Harian vs Ulangan)
│       ├── TingkatQuiz.php              -> Tingkat kesulitan (Mudah, Sedang, Sulit)
│       └── JenisSoal.php                -> Format soal (Pilihan Ganda, Isian, Benar/Salah)
│
├── database/
│   ├── migrations/                      -> 25+ file migrasi pembentuk skema database
│   └── seeders/                         -> Data pemula (DatabaseSeeder, QuizSeeder, ModulSeeder, dsb)
│
└── routes/
    └── web.php                          -> Definisi seluruh endpoint rute HTTP web
```

---

## 2. Deskripsi Fungsi File Controller Utama

1. **[`SiswaController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/SiswaController.php)**:
   * Mengatur pengerjaan materi video dan dokumen pembelajaran siswa.
   * Mengatur sesi pengerjaan kuis, baik mode `wayground` (per-soal bertahap dengan grace period) maupun mode `biasa` (timer total dengan validasi wajib menjawab seluruh nomor sebelum pengiriman).
   * Menghitung skor kelulusan KKM dan memicu level-up rank tier secara atomik.

2. **[`QuizController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/QuizController.php)**:
   * Menangani pembuatan kuis lengkap dari admin panel.
   * Melakukan normalisasi format soal (`normalizeQuestionAnswers`), memvalidasi keutuhan butir pertanyaan, serta memberikan pesan error spesifik yang menyebutkan nomor soal yang bermasalah.

3. **[`ModulController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/ModulController.php)**:
   * Mengelola penyimpanan berkas fisik materi (PDF/PPT) dan tautan YouTube.
   * Menghubungkan modul dengan butir soal evaluasi in-modul melalui tabel `modul_soal`.
   * Mendukung penyimpanan draf sehingga materi yang belum rampung tidak terlihat di akun siswa.

---

## 3. Fitur Model Eloquent & Scopes

* **`Quiz::published()` & `Quiz::draft()`**: Memisahkan kuis yang siap dipelajari dengan kuis yang masih dirancang.
* **`Quiz::belumKadaluarsa()`**: Menyeleksi kuis yang masih aktif atau kuis khusus yang memiliki token akses.
* **`User::getRankTierAttribute()`**: Perhitungan *accessor* pintar yang menghitung nama rank, warna tema badge, dan persentase progres menuju rank berikutnya berdasarkan akumulasi `total_poin`.

