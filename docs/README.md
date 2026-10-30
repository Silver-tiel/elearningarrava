# 📚 Dokumentasi Arsitektur Sistem — Arrava E-Learning

Selamat datang di pusat dokumentasi resmi aplikasi **Arrava E-Learning**. Dokumentasi ini disusun untuk memberikan gambaran menyeluruh mengenai arsitektur sistem, tata letak kode program, fungsi bisnis, skema basis data, antarmuka pengguna, serta integrasi antara Frontend dan Backend.

---

## 🗺️ Peta Navigasi Dokumen

Dokumentasi ini dibagi menjadi empat pilar utama:

### 1. [01. Arsitektur & Basis Data](file:///e:/Android/laragon/www/elearningarrava/docs/01_arsitektur_dan_data/)
* **[01_flow_aplikasi_dan_aktor.md](file:///e:/Android/laragon/www/elearningarrava/docs/01_arsitektur_dan_data/01_flow_aplikasi_dan_aktor.md)**: Gambaran alur kerja 4 aktor utama (Admin, Guru, Siswa, Orang Tua), siklus belajar modul, sistem perolehan EXP, dan tingkatan rank.
* **[02_skema_database_dan_relasi.md](file:///e:/Android/laragon/www/elearningarrava/docs/01_arsitektur_dan_data/02_skema_database_dan_relasi.md)**: Diagram relasi entitas (ERD), struktur tabel utama (`user`, `modul`, `quiz`, `soal`, `hasilquizmodul`), jenis data, dan kunci relasi (*foreign keys*).

### 2. [02. Backend (Logika & Server)](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/)
* **[01_tata_letak_backend.md](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/01_tata_letak_backend.md)**: Struktur direktori `app/`, Controller, Model Eloquent, Middleware, dan Migrasi.
* **[02_autentikasi_dan_role.md](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/02_autentikasi_dan_role.md)**: Mekanisme login, pendaftaran siswa berbasis NISN, relasi wali murid, dan pembatasan hak akses berbasis jenjang.
* **[03_logika_modul_dan_materi.md](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/03_logika_modul_dan_materi.md)**: Manajemen modul fisik (PDF/PPT) & link video YouTube, catatan rangkuman, kuis evaluasi in-modul, dan sistem draf/publikasi.
* **[04_logika_kuis_dan_penilaian.md](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/04_logika_kuis_dan_penilaian.md)**: Dua mode kuis (*Biasa* vs *Wayground*), durasi waktu, sistem penilaian otomatis (Pilihan Ganda, Benar/Salah, Isian Singkat), transaksi poin atomik, dan pencegahan duplikasi skor.
* **[05_routing_dan_seeder.md](file:///e:/Android/laragon/www/elearningarrava/docs/02_backend/05_routing_dan_seeder.md)**: Pemetaan rute (`routes/web.php`) serta seeder data awal dan dataset komprehensif kuis & modul.

### 3. [03. Frontend (Tampilan & Interaksi)](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/)
* **[01_tata_letak_views_dan_aset.md](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/01_tata_letak_views_dan_aset.md)**: Struktur direktori Blade templates (`resources/views/`), layout global, palet warna Tailwind CSS, dan aset audio/grafis.
* **[02_komponen_dan_widget.md](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/02_komponen_dan_widget.md)**: Widget interaktif, sidebar edge-to-edge dengan jingle audio lonceng salju, navbar, dan modal dialog.
* **[03_antarmuka_siswa.md](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/03_antarmuka_siswa.md)**: UI Dashboard siswa, ruang belajar modul video/PDF, tabs catatan & kuis evaluasi, serta layar pengerjaan kuis interaktif dengan timer dan penanda nomor soal.
* **[04_antarmuka_admin.md](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/04_antarmuka_admin.md)**: Dashboard analitik admin, interaktif quiz builder, modul creator, dan manajemen data siswa.
* **[05_antarmuka_orangtua_dan_auth.md](file:///e:/Android/laragon/www/elearningarrava/docs/03_frontend/05_antarmuka_orangtua_dan_auth.md)**: Portal monitoring orang tua, riwayat kuis anak, dan form autentikasi.

### 4. [04. Integrasi Frontend & Backend](file:///e:/Android/laragon/www/elearningarrava/docs/04_integrasi_fe_be/)
* **[alur_komunikasi_data.md](file:///e:/Android/laragon/www/elearningarrava/docs/04_integrasi_fe_be/alur_komunikasi_data.md)**: Alur siklus pertukaran data, validasi client-side & server-side, pesan error interaktif (termasuk penomoran nomor soal yang belum lengkap), dan session lock pengerjaan.

---

## 🛠️ Ringkasan Teknologi Utama
* **Backend Framework**: Laravel 11 (PHP 8.2+)
* **Database**: MySQL / MariaDB (via Laragon)
* **Frontend Engine**: Blade Templating + Tailwind CSS
* **Scripting**: Vanilla JavaScript Modern (Event-driven, DOM Manipulation, Web Audio API)
* **Testing Suite**: PHPUnit 11

