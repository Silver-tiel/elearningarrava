# 📖 Logika Modul Pembelajaran & Evaluasi Materi (Module Logic)

Dokumen ini menjelaskan arsitektur modul belajar, penanganan berkas fisik & video YouTube, catatan rangkuman, sistem evaluasi kuis in-modul, serta pelacakan progres siswa di [`ModulController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/ModulController.php) dan [`SiswaController.php`](file:///e:/Android/laragon/www/elearningarrava/app/Http/Controllers/SiswaController.php).

---

## 1. Tipe Konten & Ekstraksi Media

Model [`Modul.php`](file:///e:/Android/laragon/www/elearningarrava/app/Models/Modul.php) mendukung dua jenis media materi:

1. **Video Pembelajaran (YouTube Link)**:
   * Pengguna menginput URL YouTube standar (misal: `https://www.youtube.com/watch?v=...` atau `https://youtu.be/...`).
   * Accessor `getYoutubeIdAttribute()` mengekstrak ID video 11 karakter menggunakan ekspresi reguler (*regex*).
   * Accessor `getYoutubeEmbedUrlAttribute()` mengubahnya menjadi URL iframe yang aman untuk disematkan (`https://www.youtube.com/embed/{id}`).
2. **Dokumen Pembelajaran (PDF / PPT)**:
   * Berkas fisik diunggah ke disk lokal Laravel `storage/app/public/modul/` dan diakses publik via tautan simbolik `/storage/modul/...`.
   * Accessor `getFileUrlAttribute()` mengembalikan URL lengkap berkas untuk dibaca di peramban.

---

## 2. Catatan Rangkuman Materi (`CatatanModul`)

Setiap modul dapat memiliki banyak catatan ringkas untuk membantu pemahaman siswa.
* Disimpan di tabel `catatan_modul` dengan kolom `judul`, `isi` (text berformat), dan `urutan`.
* Ditampilkan pada tab **Catatan** di halaman materi video siswa.

---

## 3. Kuis Evaluasi Khusus Modul (In-Module Quiz)

Berbeda dari kuis global yang berdiri sendiri di halaman Kuis, kuis in-modul dirancang khusus untuk menguji pemahaman materi yang baru saja dipelajari siswa:

* **Struktur Data**:
  * Modul memiliki relasi `hasMany` ke [`ModulSoal`](file:///e:/Android/laragon/www/elearningarrava/app/Models/ModulSoal.php).
  * Setiap butir `ModulSoal` memiliki relasi `hasMany` ke [`ModulSoalPilihan`](file:///e:/Android/laragon/www/elearningarrava/app/Models/ModulSoalPilihan.php) dengan penanda kolom boolean `is_benar`.
* **Kriteria Kelulusan (KKM)**:
  * Kolom `kkm_quiz` pada tabel modul menentukan batas minimal persentase nilai (default: `70%`).
  * Jika siswa belum mencapai KKM, status kuis modul dinyatakan *Remedial* dan siswa diperbolehkan mencoba kembali tanpa batas hingga lulus.

---

## 4. Mekanisme Progres Belajar (`ProgresModulSiswa`)

Progres belajar siswa dilacak melalui model [`ProgresModulSiswa`](file:///e:/Android/laragon/www/elearningarrava/app/Models/ProgresModulSiswa.php):

| Status Atribut | Kondisi Terpenuhi | Dampak Sistem |
| :--- | :--- | :--- |
| `materi_selesai` | Siswa menekan tombol **"Tandai Selesai Menonton/Membaca"** | Langkah 1 centang hijau (Tuntas). |
| `quiz_selesai` | Siswa mengirimkan jawaban kuis in-modul | Nilai disimpan ke kolom `nilai_quiz`. |
| `quiz_lulus` | Nilai kuis modul $\ge$ KKM modul | Langkah 2 centang hijau (Lulus KKM). |
| **Modul Tuntas Sempurna** | `materi_selesai == true` **DAN** (`quiz_lulus == true` atau modul bebas kuis) | Reward EXP (`poin_modul`) ditambahkan ke akun siswa secara atomik (hanya 1x seumur hidup per modul). |

---

## 5. Draf vs Publikasi Modul

* Modul yang sedang dirancang memiliki status `progressModul = 'Draft'`.
* Menggunakan scope Eloquent `Modul::published()` di seluruh tampilan publik siswa, sehingga siswa tidak dapat melihat modul sebelum admin secara resmi menerbitkannya (`progressModul = 'Tersedia'`).
