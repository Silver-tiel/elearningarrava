# ⚙️ Antarmuka Panel Administrasi (Admin Interface)

Dokumen ini menjelaskan rancangan halaman dan alur kerja panel admin di direktori [`resources/views/admin/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/admin/).

---

## 1. Dashboard Admin ([`dashboard.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/admin/dashboard.blade.php))

Pusat kendali admin menampilkan metrik operasional aplikasi:
* **Statistik Utama**: Total siswa terdaftar, total materi modul diterbitkan, dan total kuis aktif.
* **Akses Cepat**: Tombol pintas untuk menambah modul ajar baru, menyusun kuis evaluasi, atau meninjau daftar siswa.

---

## 2. Pembuat Kuis Global Interaktif ([`admin/quiz/create.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/admin/quiz/create.blade.php))

Editor kuis admin dirancang modern dengan sistem *Single Page Application (SPA)* berbasis JavaScript:

```text
┌─────────────────────────┬─────────────────────────────────────────────────┐
│  DAFTAR BUTIR SOAL      │  EDITOR SOAL #1                                 │
│  [+ Tambah Soal]        │  Jenis: [Pilihan Ganda ▼]    Durasi: [20s ▼]     │
│                         │                                                 │
│  ┌───────────────────┐  │  Teks Pertanyaan:                               │
│  │ 1. Kuis (20s)     │  │  [ Tuliskan pertanyaan di sini...            ]  │
│  │ "Ibukota RI..."   │  │                                                 │
│  └───────────────────┘  │  Pilihan Jawaban:                               │
│  ┌───────────────────┐  │  [A] (✓ Kunci) Jakarta     [B] Bandung          │
│  │ 2. Isian (15s)    │  │  [C] Surabaya              [D] Medan            │
│  │ "Alat ukur arus.."│  │                                                 │
│  └───────────────────┘  │  [Simpan Draf]                [Publikasikan]    │
└─────────────────────────┴─────────────────────────────────────────────────┘
```

### Fitur Utama Editor Kuis:
1. **Sidebar Thumbnail Interaktif**: Menampilkan daftar seluruh nomor soal, tipe soal (Kuis, B/S, Isian), dan waktu timer. Mengklik thumbnail akan langsung memuat soal tersebut ke kanvas utama.
2. **Pilihan Tipe Soal Dinamis**:
   * *Pilihan Ganda*: Menyediakan 4 kartu opsi dengan tombol centang hijau untuk menentukan satu kunci jawaban yang benar.
   * *Benar / Salah*: Otomatis mengunci ke 2 pilihan (A: Benar, B: Salah).
   * *Isian Singkat*: Menutup kartu opsi dan membuka input pengetikan kunci teks langsung.
3. **Pemberitahuan Validasi Menyebut Nomor Soal**:
   * Jika ada bagian soal yang belum lengkap saat tombol publikasi ditekan, sistem mengeluarkan alert spesifik:
     * `⚠️ Kesalahan pada Soal #2: Teks pertanyaan wajib diisi sebelum kuis dipublikasikan!`
     * `⚠️ Kesalahan pada Soal #3 (Isian Singkat): Kunci jawaban isian singkat wajib diisi!`
     * `⚠️ Kesalahan pada Soal #1 (Pilihan Ganda): Harus mengisi minimal 2 pilihan jawaban yang valid!`
   * Sistem otomatis **mengalihkan tampilan kanvas langsung ke thumbnail nomor soal yang bermasalah** tersebut dan menempatkan fokus kursor pada bidang input terkait.

---

## 3. Pembuat Modul & Kuis In-Modul ([`admin/modul/create.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/admin/modul/create.blade.php))

Form pembuatan modul memadukan materi fisik/link dengan butir evaluasi internal:
* **Metadata & Media**: Judul modul, target jenjang (SD, SMP, SMA), format berkas (link YouTube atau upload PDF), cover gambar, dan KKM kuis (default 70%).
* **Builder Catatan Materi**: Tombol dinamis untuk menambahkan kartu ringkasan catatan materi.
* **Builder Kuis Evaluasi In-Modul**:
  * Mengizinkan admin merancang butir pertanyaan evaluasi khusus modul bersangkutan lengkap dengan pilihan ganda dan kunci jawaban.
  * Dilengkapi validasi nomor soal: Memperingatkan *"Soal Modul #X: Teks pertanyaan kuis modul belum diisi!"* sebelum form terkirim.
* **Draf vs Publikasi**: Tombol simpan draf memungkinkan modul disimpan sementara tanpa memvalidasi kelengkapan berkas media.

---

## 4. Manajemen & Profil Siswa ([`admin/daftar_siswa/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/admin/daftar_siswa/))
* **Daftar Siswa**: Tabel paginasi berisi nama, NISN, email, kelas, jenjang, status keaktifan, dan perolehan poin.
* **Detail Profil Siswa**: Memantau portofolio belajar siswa, modul yang telah diselesaikan, riwayat skor kuis, dan lencana rank tier yang telah diraih.

