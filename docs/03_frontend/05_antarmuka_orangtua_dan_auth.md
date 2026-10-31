# 👨‍👩‍👧 Antarmuka Portal Orang Tua & Autentikasi (Parent Portal & Auth UI)

Dokumen ini menjelaskan antarmuka autentikasi pengguna (`login.blade.php`, `pendaftaran.blade.php`) serta portal pendampingan orang tua di direktori [`resources/views/orangtua/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/orangtua/).

---

## 1. Antarmuka Autentikasi (Login & Registrasi)

### A. Halaman Masuk ([`login.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/login.blade.php))
* **Desain Simpel & Aman**: Form berada di tengah layar berlatar belakang bersih dengan kartu putih berbayang halus.
* **Input Fleksibel**: Menerima **Email** atau **NISN** pada satu bidang input yang sama.
* **Pesan Error Terpadu**: Notifikasi kegagalan otentikasi (misal: kata sandi salah atau akun tidak ditemukan) ditampilkan secara jelas di bagian atas form.

### B. Halaman Pendaftaran Siswa ([`pendaftaran.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/pendaftaran.blade.php))
* Memandu calon siswa mengisi data identitas akademik:
  * Nama Lengkap
  * Nomor Induk Siswa Nasional (NISN)
  * Alamat Email Aktif
  * Pilihan Jenjang Pendidikan (SD, SMP, atau SMA)
  * Kata Sandi dan Konfirmasi Sandi

---

## 2. Antarmuka Portal Orang Tua ([`resources/views/orangtua/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/orangtua/))

Portal orang tua dirancang informatif dan transparan agar wali murid dapat mendukung perkembangan belajar anak dari rumah:

### A. Dashboard Orang Tua ([`dashboard.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/orangtua/dashboard.blade.php))
* **Pemilih Anak (Multi-Child Selector)**: Jika orang tua memiliki lebih dari satu anak yang bersekolah di platform Arrava, tersedia dropdown untuk beralih profil anak dengan cepat.
* **Kartu Prestasi Anak**:
  * Total EXP dan Lencana Tingkatan Rank anak saat ini.
  * Jumlah modul yang sudah selesai ditonton/dibaca.
  * Jumlah kuis evaluasi yang berhasil dilalui anak.

### B. Laporan Riwayat Kuis Anak ([`riwayat_quiz.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/orangtua/riwayat_quiz.blade.php))
* **Tabel Riwayat Nilai**:
  * Waktu dan tanggal pengerjaan kuis.
  * Judul kuis dan kategori (Harian atau Ulangan).
  * Status kelulusan (*Lulus KKM* berbadge hijau atau *Remedial* berbadge kuning).
  * Skor poin yang disumbangkan untuk kenaikan rank anak.

