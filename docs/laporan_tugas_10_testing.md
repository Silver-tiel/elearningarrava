# LAPORAN TUGAS PENGUJIAN PERANGKAT LUNAK (PERTEMUAN KE-10)
## PENGUJIAN SISTEM E-LEARNING ARRAVA (TEST PLAN, TEST SCENARIO, TEST CASE)

---

### **COVER LAPORAN**

* **Mata Kuliah** : Pengujian & Penjaminan Kualitas Perangkat Lunak / Software Quality Assurance
* **Pertemuan** : Ke-10
* **Judul Tugas** : Penyusunan Test Plan, Test Scenario, dan Test Case Sistem Pembelajaran Berbasis Web (Arrava E-Learning)
* **Proyek yang Diuji** : Arrava E-Learning Platform (Berbasis Laravel & MySQL)
* **Disusun Oleh** :
  * Nama Mahasiswa / Anggota Kelompok : [Nama Anda / Anggota Kelompok]
  * NIM / NPM : [NIM Anda / Anggota]
  * Kelas : [Nama Kelas Anda, contoh: TI-5A / IF-04]
* **Program Studi** : [Teknik Informatika / Sistem Informasi / Rekayasa Perangkat Lunak]
* **Fakultas / Universitas** : [Nama Universitas Anda]
* **Tahun Akademik** : 2026

---

### **LEMBAR SOAL TUGAS**

> **Tugas Pertemuan ke 10:**  
> Buatlah dokumen yang berkaitan dengan project anda:  
> 1. Tes plan 1,  
> 2. Tes Scenario 1,  
> 3. Tes Case 3,  
>  
> Dikumpulkan di Google Drive.  
> Pengumpulan pada tanggal 01 November 2026 Jam 23.59.  
> Dibuat folder per kelas, Cover Laporan, Soal dan Jawaban.

---

### **JAWABAN TUGAS**

---

## 1. TEST PLAN (RENCANA PENGUJIAN)

### 1.1 Pendahuluan & Ringkasan Proyek
Aplikasi **Arrava E-Learning** adalah platform manajemen pembelajaran digital terintegrasi yang melayani peserta didik lintas jenjang pendidikan (SD, SMP, SMA). Sistem ini mencakup modul ajar interaktif (video YouTube & dokumen bacaan PDF), bank soal evaluasi (pilihan ganda, benar/salah, dan isian singkat), serta sistem kuis multi-mode (*Biasa* dan *Wayground*) yang dilengkapi fitur gamifikasi poin EXP dan kenaikan tingkat rank.

### 1.2 Tujuan Pengujian (*Test Objectives*)
Tujuan dari pengujian ini adalah:
1. Memverifikasi bahwa seluruh alur fungsional pengerjaan kuis siswa berjalan sesuai dengan spesifikasi kebutuhan perangkat lunak.
2. Memastikan sistem mampu memvalidasi kelengkapan jawaban siswa sebelum form terkirim pada kuis mode normal.
3. Menjamin keakuratan perhitungan nilai otomatis dan integritas data perolehan poin EXP (mencegah eksploitasi perolehan poin berulang/ganda).
4. Memastikan kenyamanan dan responsivitas antarmuka pengguna (*User Experience*) saat terjadi kesalahan pengisian.

### 1.3 Ruang Lingkup Pengujian (*Test Scope*)
* **Fitur yang Diuji (*In-Scope*)**:
  * Autentikasi dan hak akses siswa ke halaman kuis sesuai jenjang.
  * Navigasi butir soal bertahap (*Previous*, *Next*, dan kisi nomor).
  * Validasi *client-side* dan *server-side* untuk butir soal yang belum terjawab.
  * Penilaian otomatis untuk ragam tipe soal (Pilihan Ganda, Benar/Salah, Isian Singkat).
  * Mekanisme penyimpanan transaksi nilai dan poin atomik pada tabel `hasilquizmodul` dan `user`.
* **Fitur di Luar Lingkup (*Out-of-Scope*)**:
  * Pengujian beban kapasitas server (*Load/Stress Testing* di atas 10.000 pengguna bersamaan).
  * Pengujian kompatibilitas peramban legacy seperti Internet Explorer.

### 1.4 Strategi & Metodologi Pengujian
Pengujian dilakukan menggunakan pendekatan **Black-Box Testing** yang berfokus pada masukan (*input*) dan keluaran (*output*) fungsional sistem tanpa melihat struktur kode internal, menggunakan teknik:
* **Equivalence Partitioning**: Menguji partisi nilai batas lulus KKM (contoh: nilai $\ge 70\%$ lulus, $< 70\%$ remedial).
* **Boundary Value Analysis**: Menguji batas durasi hitung mundur timer ujian.
* **Automated Feature Testing**: Didukung skrip uji otomatis PHPUnit pada framework Laravel untuk validasi integritas database.

### 1.5 Lingkungan Pengujian (*Test Environment*)
* **Perangkat Keras (*Hardware*)**: Laptop/PC Processor Intel Core i5/Ryzen 5, RAM 8GB, SSD 256GB.
* **Perangkat Lunak (*Software*)**:
  * Sistem Operasi: Windows 11 64-bit
  * Web Server Stack: Laragon (Apache 2.4, MySQL 8.0, PHP 8.2)
  * Framework Backend: Laravel 11
  * Peramban Web (*Browser*): Google Chrome (Versi Terbaru) & Microsoft Edge
  * Resolusi Layar Uji: 1920 × 1080 (Desktop) dan 375 × 667 (Mobile Emulation)

### 1.6 Kriteria Kelulusan & Penghentian (*Pass/Fail Criteria*)
* **Lolos (*Pass*)**: Fitur dinyatakan lulus apabila 100% kasus uji berstatus *Pass*, tidak ada *critical bug* yang menghentikan alur pengiriman data, dan poin EXP terhitung secara akurat.
* **Gagal (*Fail*)**: Jika form dapat terkirim saat masih ada soal kosong, nilai tidak tersimpan, atau terjadi duplikasi perolehan poin EXP.

---

## 2. TEST SCENARIO (SKENARIO PENGUJIAN)

| Kode Skenario | **TS-QUIZ-01** |
| :--- | :--- |
| **Modul / Fitur** | Evaluasi Pembelajaran Siswa — Pengerjaan Kuis Mode Biasa & Sistem Poin |
| **Deskripsi Skenario** | Menguji seluruh alur pengerjaan kuis siswa pada mode waktu total (*Biasa*), mencakup navigasi nomor soal bertahap, validasi pencegahan pengumpulan saat ada soal kosong, mekanisme pengiriman data, perhitungan skor kelulusan KKM, dan penambahan reward poin EXP secara atomik ke akun siswa. |
| **Aktor Terlibat** | Siswa (Pengguna Terautentikasi) |
| **Prasyarat Sistem** | Akun siswa aktif, terdaftar pada jenjang yang sesuai, dan terdapat minimal 1 kuis mode biasa yang berstatus 'Tersedia'. |

---

## 3. TEST CASES (KASUS PENGUJIAN RINCI)

Berikut adalah 3 kasus uji (*test cases*) spesifik yang diturunkan dari skenario pengujian di atas:

### **Test Case 1: Alur Positif — Pengerjaan Lengkap & Kelulusan Kuis**

| Parameter | Rincian Kasus Uji |
| :--- | :--- |
| **Test Case ID** | **TC-QUIZ-01** |
| **Deskripsi** | Memverifikasi bahwa siswa yang menjawab seluruh butir soal dengan benar dapat mengumpulkan kuis, mendapatkan status lulus, dan menerima reward poin EXP. |
| **Prasyarat (*Pre-conditions*)** | Siswa sudah login, membuka kuis mode biasa (misal: 3 soal bernilai total 30 poin), dan belum pernah lulus pada kuis tersebut sebelumnya. Total poin awal siswa = 0. |
| **Langkah Pengujian (*Steps*)** | 1. Buka rute `/siswa/quiz/{id}` untuk memulai pengerjaan kuis.<br>2. Pada Soal #1 (Pilihan Ganda), pilih opsi jawaban yang benar (Opsi B).<br>3. Klik tombol **"Soal Selanjutnya →"**.<br>4. Pada Soal #2 (Benar/Salah), pilih opsi yang benar (Opsi A: Benar).<br>5. Klik tombol **"Soal Selanjutnya →"**.<br>6. Pada Soal #3 (Isian Singkat), ketikkan teks kunci jawaban dengan benar.<br>7. Klik tombol **"🚀 Kumpulkan Jawaban Saya"** yang muncul di nomor terakhir. |
| **Data Uji (*Test Data*)** | Jawaban Soal 1 = 'B', Jawaban Soal 2 = 'A', Jawaban Soal 3 = 'klorofil'. |
| **Hasil yang Diharapkan (*Expected Result*)** | 1. Modal maskot loading transisi muncul sesaat menampilkan progress bar.<br>2. Halaman memunculkan pop-up hasil: Status = "Lulus KKM", Jawaban Benar = 3/3, Poin Didapat = 30 Poin.<br>3. Poin EXP akun siswa bertambah tepat 30 (Total Poin berubah dari 0 menjadi 30). |
| **Hasil Aktual (*Actual Result*)** | Kuis berhasil dikumpulkan, modal loading dan hasil evaluasi tampil akurat, dan nilai poin EXP bertambah 30 di database. |
| **Status** | **PASS** ✅ |

---

### **Test Case 2: Alur Negatif — Validasi Pencegahan Pengumpulan Soal Kosong**

| Parameter | Rincian Kasus Uji |
| :--- | :--- |
| **Test Case ID** | **TC-QUIZ-02** |
| **Deskripsi** | Memverifikasi bahwa sistem menolak pengumpulan jawaban jika terdapat butir soal yang belum dijawab pada kuis mode biasa, serta menampilkan notifikasi spesifik nomor soal yang terlewat. |
| **Prasyarat (*Pre-conditions*)** | Siswa berada di halaman pengerjaan kuis mode biasa yang terdiri dari minimal 3 butir pertanyaan. |
| **Langkah Pengujian (*Steps*)** | 1. Siswa menjawab Soal #1.<br>2. Siswa menekan nomor #3 pada kisi navigasi sidebar (melewati Soal #2).<br>3. Siswa menjawab Soal #3.<br>4. Pada Soal #3 (nomor terakhir), siswa langsung menekan tombol **"🚀 Kumpulkan Jawaban Saya"** tanpa mengisi Soal #2. |
| **Data Uji (*Test Data*)** | Jawaban Soal 1 = Terisi, Jawaban Soal 2 = Kosong (Belum dijawab), Jawaban Soal 3 = Terisi. |
| **Hasil yang Diharapkan (*Expected Result*)** | 1. Form submission diblokir (tidak terkirim ke server).<br>2. Dialog peringatan modal (`#quizUnansweredModal`) muncul di layar dengan pesan:<br>   *"Mohon maaf, Anda belum dapat mengumpulkan jawaban karena **soal nomor 2** belum dijawab."*<br>3. Kisi navigasi Soal #2 di sidebar diberi sorotan cincin merah menyala (*ring rose*).<br>4. Tampilan kanvas soal langsung berpindah (*auto-focus*) kembali ke Soal #2. |
| **Hasil Aktual (*Actual Result*)** | Pengiriman jawaban dicegah, dialog peringatan muncul dengan menyebutkan Soal nomor 2 belum dijawab, dan tampilan otomatis diarahkan ke Soal nomor 2. |
| **Status** | **PASS** ✅ |

---

### **Test Case 3: Alur Integritas Sistem — Pencegahan Eksploitasi Poin Ganda (*Anti-Duplication*)**

| Parameter | Rincian Kasus Uji |
| :--- | :--- |
| **Test Case ID** | **TC-QUIZ-03** |
| **Deskripsi** | Memverifikasi bahwa siswa yang mengerjakan ulang kuis yang sudah pernah dilulusinya tetap dapat menyimpan riwayat nilai baru, namun poin EXP akun tidak bertambah ganda (*anti-farming EXP*). |
| **Prasyarat (*Pre-conditions*)** | Siswa sudah pernah menyelesaikan kuis ini dan telah menerima 30 poin kelulusan pertama. Total poin akun siswa saat ini = 30. |
| **Langkah Pengujian (*Steps*)** | 1. Siswa kembali membuka rute kuis yang sama via katalog kuis.<br>2. Siswa menyelesaikan seluruh pertanyaan dengan benar untuk kedua kalinya.<br>3. Siswa menekan tombol **"🚀 Kumpulkan Jawaban Saya"**.<br>4. Periksa perolehan poin pada notifikasi hasil dan cek kolom `total_poin` pada tabel `user`. |
| **Data Uji (*Test Data*)** | User ID = [ID Siswa], Quiz ID = [ID Kuis], Jawaban = Semua Benar (100%). |
| **Hasil yang Diharapkan (*Expected Result*)** | 1. Kuis berhasil diserahkan dan nilai pengerjaan kedua (100%) tetap tercatat di tabel `hasilquizmodul`.<br>2. Kolom `poin_diberikan` pada sesi bernilai 0 karena status kuis sudah pernah lulus sebelumnya.<br>3. Nilai `total_poin` pada akun siswa tetap 30 (tidak bertambah menjadi 60). |
| **Hasil Aktual (*Actual Result*)** | Riwayat pengerjaan baru tercatat dengan nilai 100%, sistem menolak penambahan poin ganda secara atomik melalui transaksi database, dan total poin user tetap 30. |
| **Status** | **PASS** ✅ |

---

### **KESIMPULAN PENGUJIAN**
Berdasarkan serangkaian pengujian fungsional pada modul kuis aplikasi Arrava E-Learning:
1. **Rencana Pengujian (*Test Plan*)** telah mencakup seluruh kebutuhan fungsional dan teknis lingkungan aplikasi web Laravel.
2. **Skenario Pengujian (*Test Scenario*)** berhasil mensimulasikan siklus nyata pengerjaan evaluasi oleh siswa dari awal hingga akhir.
3. Seluruh **Kasus Uji (*Test Cases*)** yang mencakup pengujian jalur positif (*happy path*), jalur negatif (validasi nomor soal kosong), dan uji integritas data (*anti-farming*) berstatus **PASS (100%)**, sehingga aplikasi memenuhi standar mutu perangkat lunak yang andal dan siap digunakan.

