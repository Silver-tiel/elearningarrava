# 🧩 Komponen Reusable & Widget Interaktif (Components & Widgets)

Dokumen ini menjelaskan komponen modular Blade di [`resources/views/components/`](file:///e:/Android/laragon/www/elearningarrava/resources/views/components/) dan widget interaktif pada aplikasi **Arrava E-Learning**.

---

## 1. Komponen Sidebar Interaktif ([`sidebar.blade.php`](file:///e:/Android/laragon/www/elearningarrava/resources/views/components/sidebar.blade.php))

Sidebar merupakan poros navigasi vertikal di sisi kiri layar dengan fitur-fitur utama:

1. **Daftar Menu Navigasi Berdasarkan Peran**:
   * Menampilkan menu sesuai peran yang sedang login (Dashboard, Modul Belajar, Kuis Latihan, Profil Siswa, dsb).
   * Menyorot menu aktif secara otomatis menggunakan class `text-indigo-600 bg-indigo-50`.
2. **Profil Singkat & Tombol Logout**:
   * Menampilkan nama dan avatar pengguna di bagian bawah sidebar.
   * Tombol keluar (*logout*) yang mengirimkan POST request untuk mengakhiri sesi.

### Widget Pixel Salju Bersuara (Interactive Pixel Snow Widget)
Tepat di atas tombol logout, terdapat widget visual interaktif:
* **Desain Visual**: Menggunakan gambar *pixel art* pemandangan malam bersalju dengan rubah salju yang berposisi natural tanpa kartu/border hitam pekat (`bg-transparent`).
* **Interaksi Klik (Audio + Animasi 1 Siklus)**:
  * Dalam keadaan diam, menampilkan gambar statis [`sideSnow.webp`](file:///e:/Android/laragon/www/elearningarrava/public/assets/background/sidebar/sideSnow.webp).
  * Saat diklik pengguna, widget memutar efek suara instrumen lonceng jingle [`jingleSnowSound.wav`](file:///e:/Android/laragon/www/elearningarrava/public/assets/sounds/widgets/jingleSnowSound.wav) dan beralih ke gambar animasi [`sideSnow.gif`](file:///e:/Android/laragon/www/elearningarrava/public/assets/background/sidebar/sideSnow.gif).
  * Setelah 1 siklus pemutaran selesai, widget otomatis kembali ke gambar diam dengan mulus tanpa memerlukan tombol intervensi.

---

## 2. Dialog Modal Dinamis (Modals)

Sistem menggunakan dialog modal terpadu untuk menjaga alur kerja tanpa me-*reload* seluruh halaman:

### A. Modal Pratinjau Kuis ([`#quizPreviewModal`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/quiz.blade.php))
* Membuka ringkasan kuis saat siswa mengklik kartu kuis pada katalog.
* Menampilkan jumlah soal, durasi pengerjaan, KKM, input token (jika kuis ber-token), dan stempel *Tuntas* jika kuis sudah pernah diselesaikan.

### B. Modal Peringatan Soal Belum Lengkap ([`#quizUnansweredModal`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/mengerjakan-quiz.blade.php))
* Mencegah pengiriman jawaban pada kuis mode biasa jika masih ada soal kosong.
* Menampilkan pesan terformat:
  > *"Mohon maaf, Anda belum dapat mengumpulkan jawaban karena **soal nomor X** belum dijawab."*
* Menyediakan tombol satu klik **"Lengkapi Jawaban Sekarang →"** yang langsung memfokuskan siswa ke nomor yang belum terisi.

### C. Modal Loading & Trivia Edukasi ([`#quizSubmitLoadingModal`](file:///e:/Android/laragon/www/elearningarrava/resources/views/siswa/mengerjakan-quiz.blade.php))
* Muncul seketika saat siswa mengirimkan jawaban kuis.
* Menampilkan animasi maskot karakter berlari di atas progress bar dan menyajikan fakta edukatif/trivia sains acak selagi backend menghitung hasil evaluasi kuis secara atomik.
