# 🎓 Antarmuka Portal Siswa (Student Interface)

Dokumen ini menjelaskan rancangan halaman, alur interaksi, dan komponen antarmuka pengguna pada portal siswa di direktori [`resources/views/siswa/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/).

---

## 1. Dashboard Siswa ([`dashboard.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/dashboard.blade.php))

Halaman beranda utama siswa dirancang ramah pengguna dengan metrik gamifikasi:
* **Kartu Gamifikasi**: Menampilkan nama siswa, akumulasi poin EXP, dan lencana tingkatan rank (Pemula s.d. Legenda).
* **Ringkasan Aktivitas**: Jumlah modul yang telah dipelajari dan total kuis yang telah diselesaikan.
* **Katalog Cepat**: Menampilkan 4 materi modul terbaru yang sesuai dengan jenjang siswa.

---

## 2. Ruang Belajar Modul ([`materi-video.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/materi-video.blade.php))

Halaman ini memadukan literatur materi dengan evaluasi kuis terpadu:

```text
┌────────────────────────────────────────────────────────────────────────┐
│  Syarat Penyelesaian Modul                                 +50 EXP 🏆  │
│  ┌───────────────────────────────┐ ┌─────────────────────────────────┐ │
│  │ 1. Pelajari Materi  [ Tuntas ]│ │ 2. Kuis Modul      [ Kerjakan ] │ │
│  └───────────────────────────────┘ └─────────────────────────────────┘ │
└────────────────────────────────────────────────────────────────────────┘
┌────────────────────────────────────────────────────────────────────────┐
│  [Overview]          [Catatan]          [Kuis Modul (3 Soal)]          │
│                                                                        │
│  - Tab Overview: Deskripsi materi & tombol 'Tandai Selesai Membaca'    │
│  - Tab Catatan : Poin-poin ringkasan penting materi                   │
│  - Tab Kuis    : Lembar soal evaluasi in-modul berformat pilihan ganda │
└────────────────────────────────────────────────────────────────────────┘
```

* **Indikator 2 Langkah**:
  * Langkah 1 otomatis berubah menjadi centang hijau saat tombol *Tandai Selesai* dikirim.
  * Langkah 2 mengarahkan siswa ke tab *Kuis Modul* jika modul memiliki soal evaluasi.
* **Form Kuis In-Modul**: Menampilkan opsi pilihan ganda warna-warni yang dapat dikirimkan langsung di dalam halaman untuk mendapatkan nilai kelulusan KKM.

---

## 3. Layar Pengerjaan Kuis Interaktif ([`mengerjakan-quiz.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/mengerjakan-quiz.blade.php))

Layar pengerjaan kuis dirancang fokus, bebas distraksi, dan adaptif sesuai mode ujian:

### A. Kontrol Tombol Bertahap (Step-by-Step Navigation)
* Pada mode biasa (waktu total), tombol navigasi diatur secara intuitif:
  * **Belum Soal Terakhir**: Menampilkan tombol indigo **`Soal Selanjutnya →`** dan **`← Soal Sebelumnya`**.
  * **Soal Terakhir**: Tombol berganti menjadi **`🚀 Kumpulkan Jawaban Saya`**.

### B. Validasi Kuis Normal (Pencegahan Soal Kosong)
* Jika siswa menekan tombol kumpulkan jawaban sementara ada nomor yang terlewat:
  * Form diblokir secara otomatis di sisi klien.
  * Tampil modal [`#quizUnansweredModal`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/mengerjakan-quiz.blade.php) yang menyebutkan daftar nomor soal yang belum dijawab.
  * Tampilan langsung melompat (*auto-focus*) ke nomor pertama yang belum terjawab.
  * Tombol navigasi soal di sidebar yang kosong disorot dengan cincin merah menyala (*ring rose*).

### C. Ragam Tampilan Soal
* **Pilihan Ganda**: Tombol berbentuk kartu interaktif bergaya Kahoot dengan ikon segitiga (A), belah ketupat (B), lingkaran (C), dan kotak (D).
* **Isian Singkat**: Kotak input teks elegan dengan panduan pengetikan jawaban langsung.
* **Benar / Salah**: Dua pilihan cepat (Benar atau Salah) berukuran proporsional.

