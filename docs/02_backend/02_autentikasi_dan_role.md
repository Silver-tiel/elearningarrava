# 🔐 Autentikasi, Hak Akses & Pembagian Peran (Auth & RBAC)

Dokumen ini menjelaskan arsitektur autentikasi, manajemen session, pembagian peran pengguna (*Role-Based Access Control*), dan isolasi data per jenjang pada backend **Arrava E-Learning**.

---

## 1. Mekanisme Autentikasi

Autentikasi dikendalikan oleh [`AuthController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/AuthController.php):

* **Multi-Identifier Login**: Pengguna dapat masuk menggunakan **Email** atau **NISN** (Nomor Induk Siswa Nasional) yang terdaftar.
* **Keamanan Kata Sandi**: Menggunakan algoritma hash standar industri `bcrypt` (`password_hash`).
* **Pendaftaran Siswa Baru**:
  * Siswa mendaftar dengan menginput nama, email, NISN, kata sandi, dan memilih **Jenjang Sekolah** (SD, SMP, atau SMA).
  * Data otomatis diberi `id_tipeuser = 3` (siswa) dan `total_poin = 0`.
* **Pencegahan Akses Tak Sah**:
  * Pengguna yang belum terautentikasi otomatis dialihkan ke rute `/login`.
  * Middleware [`CheckRole`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Middleware/CheckRole.php) memvalidasi peran pengguna pada setiap rute berproteksi.

---

## 2. Struktur Pembagian Peran & Prefix Rute

```mermaid
flowchart TD
    User["Request Masuk"] --> Auth{"Sudah Login?"}
    Auth -- "Belum" --> Login["Redirect ke /login"]
    Auth -- "Sudah" --> Role{"Periksa id_tipeuser"}
    Role -- "1 (Admin)" --> AdminArea["Akses Rute: /admin/* (Dashboard, Kelola Modul, Kelola Kuis, Data Siswa)"]
    Role -- "2 (Guru)" --> GuruArea["Akses Rute: /guru/* (Pembuatan Konten & Penilaian)"]
    Role -- "3 (Siswa)" --> SiswaArea["Akses Rute: /siswa/* (Dashboard, Belajar Modul, Kerjakan Kuis, Profil)"]
    Role -- "Orang Tua" --> OT["Akses Rute: /orangtua/* (Monitoring Nilai Anak)"]
```

### Tabel Rincian Hak Akses Rute:
| Aktor | Prefix Rute | Izin Utama | Larangan Akses |
| :--- | :---: | :--- | :--- |
| **Admin** | `/admin` | Mengubah seluruh kuis/modul, publish/draft materi, manajemen data siswa, melihat preview kuis tanpa skor. | Tidak dapat mengerjakan kuis sebagai peserta berpoin. |
| **Guru** | `/guru` | Membuat draft modul dan butir pertanyaan latihan. | Tidak dapat menghapus master data sistem. |
| **Siswa** | `/siswa` | Mempelajari modul jenjangnya, mengerjakan kuis, klaim reward EXP, mengubah foto profil. | Tidak dapat mengakses panel administrasi `/admin/*`. |
| **Orang Tua** | `/orangtua` | Memilih anak asuh terhubung, memantau riwayat kuis dan skor anak. | Tidak dapat mengisi jawaban kuis atas nama anak. |

---

## 3. Isolasi Jenjang Pendidikan (Jenjang-Scoped Isolation)

Untuk mencegah siswa SD melihat atau mengerjakan kuis SMA (atau sebaliknya), backend menerapkan isolasi berlapis:

1. **Lapisan Query Listing**:
   ```php
   // SiswaController.php
   $user = Auth::user();
   $query = Quiz::published()->belumKadaluarsa();

   if ($user && $user->id_jenjang) {
       $query->where('id_jenjang', $user->id_jenjang);
   }
   ```
2. **Lapisan Validasi Eksekusi**:
   Saat siswa mencoba memulai kuis via URL langsung (`/siswa/quiz/{id}`), method `tolakJikaBukanJenjangnya()` memverifikasi apakah kuis tersebut sesuai dengan `id_jenjang` siswa. Jika tidak cocok, request langsung dialihkan kembali dengan pesan error larangan akses.
