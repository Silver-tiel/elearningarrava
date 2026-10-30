# 🚦 Pemetaan Rute & Data Awal Seeder (Routing & Seeders)

Dokumen ini memetakan seluruh rute HTTP pada file [`routes/web.php`](file:///e:/Android/laragon/www/elearningarrava/routes/web.php) serta daftar seeder di direktori `database/seeders/`.

---

## 1. Pemetaan Rute Utama (`routes/web.php`)

### A. Rute Publik & Autentikasi
* `GET  /` -> Redirect ke halaman login atau dashboard jika sudah autentikasi.
* `GET  /login` & `POST /login` -> Tampilan form dan proses verifikasi login.
* `GET  /register` & `POST /register` -> Pendaftaran akun siswa baru.
* `POST /logout` -> Mengakhiri sesi dan membersihkan cache riwayat peramban.

### B. Portal Siswa (Middleware: `auth`, `role:siswa`)
* `GET  /siswa/dashboard` -> Dashboard utama siswa (kartu progres, modul terbaru, peringkat EXP).
* `GET  /siswa/modul` -> Daftar katalog modul belajar per jenjang.
* `GET  /siswa/materi-video/{id}` -> Ruang belajar modul (video YouTube/PDF, catatan, dan tab kuis evaluasi in-modul).
* `POST /siswa/modul/{id}/selesai-materi` -> Menandai penyelesaian tahap 1 belajar materi.
* `POST /siswa/modul/{id}/kuis-submit` -> Mengirim jawaban kuis evaluasi in-modul.
* `GET  /siswa/quiz` -> Katalog kuis global (filter jenjang & tingkat kesulitan).
* `GET  /siswa/quiz/{id}/detail` -> Rincian informasi kuis sebelum mulai.
* `POST /siswa/quiz/{id}/mulai` -> Memulai sesi pengerjaan (verifikasi token jika ber-token).
* `GET  /siswa/quiz/{id}` -> Halaman interaktif mengerjakan kuis.
* `POST /siswa/quiz/{id}/submit` -> Penyerahan jawaban kuis, kalkulasi skor, dan pemberian poin.
* `GET  /siswa/profil` -> Halaman data diri, pencapaian rank, dan ganti foto profil.

### C. Portal Admin (Middleware: `auth`, `role:admin`)
* `GET  /admin/dashboard` -> Statistik analitik jumlah siswa, modul, dan kuis.
* `GET  /admin/modul` -> Manajemen modul (daftar modul, filter draft/published, hapus).
* `GET  /admin/modul/create` & `POST /admin/modul/store` -> Form pembuatan modul + builder kuis in-modul.
* `GET  /admin/modul/{id}/edit` & `PUT /admin/modul/{id}` -> Form edit materi dan kuis modul.
* `GET  /admin/quiz` -> Manajemen kuis global.
* `GET  /admin/quiz/create` & `POST /admin/quiz/store` -> Form interaktif pembuat kuis global.
* `GET  /admin/quiz/{id}/edit` & `PUT /admin/quiz/{id}` -> Form pembaruan kuis global.
* `DELETE /admin/quiz/{id}` -> Penghapusan kuis (cascade soal & pilihan).
* `GET  /admin/quiz/{id}/preview` -> Preview pengerjaan kuis tanpa timer server dan tanpa penyimpanan nilai.
* `GET  /admin/data-siswa` -> Manajemen dan verifikasi data akun siswa.

### D. Portal Orang Tua (Middleware: `auth`)
* `GET  /orangtua/dashboard` -> Ringkasan keaktifan anak.
* `GET  /orangtua/riwayat-quiz` -> Laporan pencapaian nilai dan perolehan poin anak.

---

## 2. Daftar Seeder Basis Data

Daftar file seeder pada direktori [`database/seeders/`](file:///e:/Android/laragon/www/elearningarrava/database/seeders/):

| File Seeder | Fungsi & Konten Data |
| :--- | :--- |
| **`MasterDataSeeder.php`** | Mengisi tabel referensi dasar: Jenjang (SD, SMP, SMA), TipeUser (admin, guru, siswa), TipeModul, TipeQuiz, TingkatQuiz, dan JenisSoal. |
| **`UserAwalSeeder.php`** | Mengisi akun default untuk pengembangan: Admin, Guru, dan Siswa contoh. |
| **`QuizSeeder.php`** | Menghasilkan dataset 9 kuis komprehensif lengkap: SD, SMP, SMA, mode Biasa & Wayground, soal Pilihan Ganda, Benar/Salah, Isian Singkat, serta kuis bertoken (`SDJUARA`, `SMPHEBAT`, `SMASUKSES`). Bersifat idempoten. |
| **`ModulSeeder.php`** | Mengisi contoh modul pembelajaran (Matematika SD, IPA SMP, Fisika SMA) lengkap dengan catatan materi dan butir soal kuis evaluasi in-modul. |
| **`AchievementSeeder.php`** | Mengisi data badge pencapaian (*achievements*). |
| **`DatabaseSeeder.php`** | Pemicu utama seluruh seeder di atas secara berurutan. |

### Perintah Eksekusi Seeder:
```bash
# Menjalankan seluruh seeder
php artisan db:seed

# Menjalankan seeder kuis spesifik
php artisan db:seed --class=QuizSeeder

# Menjalankan seeder modul spesifik
php artisan db:seed --class=ModulSeeder
```
