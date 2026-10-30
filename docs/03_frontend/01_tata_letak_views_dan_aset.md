# 🎨 Tata Letak Tampilan & Aset Frontend (Views & Assets Layout)

Dokumen ini menjelaskan struktur direktori tampilan Blade (`resources/views/`), organisasi aset grafis dan audio (`public/assets/`), serta sistem desain UI pada aplikasi **Arrava E-Learning**.

---

## 1. Peta Direktori Tampilan Blade (`resources/views/`)

```text
resources/views/
├── components/                       -> Komponen UI yang dapat digunakan kembali
│   ├── sidebar.blade.php             -> Sidebar navigasi utama + widget pixel salju bersuara
│   ├── navbar.blade.php              -> Top navigation bar + notifikasi & profil ringkas
│   └── hover-effects.blade.php       -> Efek visual animasi kursor & tombol interaktif
│
├── layouts/                          -> Kerangka dasar layout halaman
│   ├── app.blade.php                 -> Master layout aplikasi
│   └── guest.blade.php               -> Layout untuk halaman sebelum login
│
├── siswa/                            -> Seluruh antarmuka portal siswa
│   ├── dashboard.blade.php           -> Halaman utama beranda siswa
│   ├── modul.blade.php               -> Katalog modul belajar
│   ├── materi-video.blade.php        -> Halaman pembelajaran video/PDF + tabs catatan & kuis
│   ├── materi-video-list.blade.php   -> Daftar playlist video
│   ├── quiz.blade.php                -> Katalog kuis global (filter jenjang & tingkat)
│   ├── mengerjakan-quiz.blade.php    -> Layar interaktif pengerjaan kuis (Kahoot UI & timer)
│   ├── quiz-detail.blade.php         -> Modal rincian kuis sebelum mulai
│   ├── quiz-result.blade.php         -> Layar perolehan skor & evaluasi kelulusan
│   ├── profil_siswa.blade.php        -> Halaman data profil & badge rank tier
│   └── partials/
│       └── tabs-modul.blade.php      -> Tab navigasi Overview, Catatan, Kuis Modul
│
├── admin/                            -> Seluruh antarmuka panel administrasi
│   ├── dashboard.blade.php           -> Statistik analitik admin
│   ├── daftar_siswa/
│   │   ├── data_siswa.blade.php      -> Tabel dan filter data siswa
│   │   └── profil_siswa.blade.php    -> Detail profil siswa yang dilihat admin
│   ├── modul/
│   │   ├── index.blade.php           -> Tabel manajemen modul
│   │   ├── create.blade.php          -> Form buat modul + builder soal in-modul
│   │   └── edit.blade.php            -> Form perbarui modul
│   └── quiz/
│       ├── index.blade.php           -> Tabel manajemen kuis global
│       └── create.blade.php          -> Form builder kuis interaktif (sidebar thumbnail)
│
├── orangtua/                         -> Portal pendamping orang tua
│   ├── dashboard.blade.php           -> Ringkasan pencapaian anak
│   └── riwayat_quiz.blade.php        -> Tabel riwayat kuis dan nilai anak
│
├── login.blade.php                   -> Halaman login pengguna
└── pendaftaran.blade.php             -> Halaman registrasi akun siswa baru
```

---

## 2. Struktur Aset Statis (`public/assets/`)

File media pendukung disimpan di direktori `public/assets/`:

1. **Aset Widget Sidebar Interaktif**:
   * [`public/assets/background/sidebar/sideSnow.webp`](file:///e:/Android/laragon/www/elearningarrava/public/assets/background/sidebar/sideSnow.webp): Gambar diam pixel art pemandangan salju malam dan rubah salju.
   * [`public/assets/background/sidebar/sideSnow.gif`](file:///e:/Android/laragon/www/elearningarrava/public/assets/background/sidebar/sideSnow.gif): Animasi rubah dan salju bergerak saat widget diklik.
   * [`public/assets/sounds/widgets/jingleSnowSound.wav`](file:///e:/Android/laragon/www/elearningarrava/public/assets/sounds/widgets/jingleSnowSound.wav): Efek suara lonceng jingle Natal berfrekuensi jernih yang diputar saat animasi berjalan.

2. **Aset Maskot Loading Animasi**:
   * [`public/assets/foto_karakter/loading/silverwolfloading.png`](file:///e:/Android/laragon/www/elearningarrava/public/assets/foto_karakter/loading/silverwolfloading.png): Maskot pixel art yang bergerak bolak-balik di atas progress bar saat proses penyerahan jawaban kuis berlangsung.

---

## 3. Sistem Desain & Palet Warna UI

* **Latar Belakang Aplikasi**: `#F8FAFC` (Slate Ultra-Light) memberikan kontras lembut terhadap kartu putih.
* **Warna Tema Utama (Brand Primary)**:
  * **Indigo** (`bg-indigo-600`, `text-indigo-600`, hover `bg-indigo-700`): Digunakan untuk tombol aksi primer, tab aktif, navigasi aktif, dan kartu fokus.
* **Palet Warna Jawaban Kuis Interaktif (Kahoot Palette)**:
  * Opsi A: **Rose / Merah** (`bg-rose-500`, Simbol Segitiga ▲)
  * Opsi B: **Blue / Biru** (`bg-blue-600`, Simbol Belah Ketupat ◆)
  * Opsi C: **Amber / Kuning** (`bg-amber-500`, Simbol Lingkaran ●)
  * Opsi D: **Emerald / Hijau** (`bg-emerald-600`, Simbol Kotak ■)
