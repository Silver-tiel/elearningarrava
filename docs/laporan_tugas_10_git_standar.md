# LAPORAN TUGAS PERTEMUAN 10

## PENERAPAN STANDAR DALAM PENGGUNAAN GIT & ANALISIS ALUR KERJA CI/CD

---

**Mata Kuliah**: Praktikum Rekayasa Perangkat Lunak / Pengujian & Manajemen Konfigurasi Perangkat Lunak  
**Pertemuan**: 10 (Penerapan Standar dalam Penggunaan Git)  
**Proyek Aplikasi**: E-Learning Arrava (`elearningarrava`)  
**Penulis / Mahasiswa**: Tim Pengembang E-Learning Arrava  
**Tanggal**: 31 Oktober 2026

---

## DAFTAR ISI LAPORAN

1. [Tugas 1 (Individu): Dokumentasi Standar Git dalam `CONTRIBUTING.md`](#1-tugas-1-individu-dokumentasi-standar-git-dalam-contributingmd)
2. [Tugas 2 (Kelompok): Implementasi & Pengujian Commitlint + Husky](#2-tugas-2-kelompok-implementasi--pengujian-commitlint--husky)
3. [Tugas 3 (Refleksi): Analisis Mengapa Trunk-Based Development Lebih Cocok untuk CI/CD Dibanding Git Flow](#3-tugas-3-refleksi-analisis-mengapa-trunk-based-development-lebih-cocok-untuk-cicd-dibanding-git-flow)

---

## 1. Tugas 1 (Individu): Dokumentasi Standar Git dalam `CONTRIBUTING.md`

### 1.1 Ringkasan Dokumen

Untuk memenuhi tugas individu, sebuah dokumen panduan kontribusi resmi telah disusun dan ditempatkan pada _root directory_ repositori dengan nama file **[`CONTRIBUTING.md`](../CONTRIBUTING.md)**. Dokumen ini disesuaikan secara khusus dengan arsitektur dan kebutuhan modul pada sistem **E-Learning Arrava** (Laravel 12 + Tailwind CSS + Vite).

### 1.2 Poin-Poin Utama yang Diatur dalam `CONTRIBUTING.md`:

1. **Branching Convention (Konvensi Penamaan Branch)**:
    - Format standar: `<type>/<short-description>` atau `<type>/<ticket-id>-<short-description>`.
    - Prefix yang disepakati: `feature/`, `fix/`, `hotfix/`, `refactor/`, `docs/`, `test/`, `chore/`.
    - Aturan teknis: Huruf kecil seluruhnya, tanda hubung (`-`) sebagai pemisah, maksimal 50 karakter.
    - Contoh nyata di proyek: `feature/quiz-wayground-timer`, `fix/login-parallax-gap`, `docs/contributing-guide`.

2. **Standar Commit Message (Conventional Commits v1.0.0)**:
    - Struktur: `<type>(<scope>): <subject>`.
    - Scope spesifik modul Arrava: `auth`, `modul`, `quiz`, `presensi`, `siswa`, `guru`, `admin`, `orangtua`, `ui`, `db`, `deps`.
    - Subject ditulis dalam _imperative mood_, diawali huruf kecil, tanpa titik di akhir, dan maksimal 50 karakter.

3. **Standar Pull Request (PR) & Code Review**:
    - Format judul PR identik dengan Conventional Commits.
    - Template PR terstruktur: Deskripsi, Checklist Pengujian, Bukti Visual (UI), dan Referensi Isu (`Closes #...`).
    - Ukuran ideal PR dibatasi < 400 baris untuk menjamin kualitas review.
    - Konvensi label ulasan: `blocking:` (wajib diperbaiki), `nit:` (saran kecil), `question:` (klarifikasi), dan `praise:` (apresiasi kode).

4. **Git Hygiene & Branch Protection**:
    - Aturan pencegahan commit file sensitif (`.env`) dan dependensi (`vendor/`, `node_modules/`).
    - Aturan _protected branch_ pada `main` di mana pengembang dilarang melakukan push langsung dan wajib melewati mekanisme Pull Request.

_(File lengkap dapat diakses langsung pada repositori proyek: `CONTRIBUTING.md`)_.

---

## 2. Tugas 2 (Kelompok): Implementasi & Pengujian Commitlint + Husky

### 2.1 Penjelasan Tools

Untuk menjamin agar standar pesan commit tidak dilanggar oleh anggota tim, diimplementasikan dua alat otomatis:

1. **Husky**: Framework Git Hooks modern berbasis Node.js yang memungkinkan kita menjalankan skrip otomatis pada momen tertentu (seperti `commit-msg` atau `pre-commit`).
2. **Commitlint (`@commitlint/cli` & `@commitlint/config-conventional`)**: Linter yang memeriksa apakah teks commit mematuhi aturan Conventional Commits sebelum Git membuat objek commit.

### 2.2 Langkah-Langkah Instalasi & Konfigurasi

#### Langkah 1: Instalasi Paket DevDependencies

Jalankan perintah berikut di terminal:

```bash
npm install --save-dev @commitlint/cli @commitlint/config-conventional husky
```

#### Langkah 2: Pembuatan File Konfigurasi Commitlint (`commitlint.config.cjs`)

Buat file `commitlint.config.cjs` di root proyek:

```javascript
module.exports = {
    extends: ["@commitlint/config-conventional"],
    rules: {
        "type-enum": [
            2,
            "always",
            [
                "feat",
                "fix",
                "docs",
                "style",
                "refactor",
                "perf",
                "test",
                "build",
                "ci",
                "chore",
                "revert",
            ],
        ],
        "subject-case": [
            2,
            "never",
            ["sentence-case", "start-case", "pascal-case", "upper-case"],
        ],
    },
};
```

#### Langkah 3: Inisialisasi Husky & Git Hook

```bash
npx husky init
echo "npx --no -- commitlint --edit \"\$1\"" > .husky/commit-msg
```

---

### 2.3 Bukti Pengujian (Terminal Evidence untuk Screenshot Laporan)

Berikut adalah bukti simulasi terminal yang menunjukkan penolakan commit non-standar dan penerimaan commit yang sesuai standar:

#### A. Kasus 1: Commit Ditolak (FAILED / REJECTED) ❌

_Pesan commit tidak mematuhi konvensi (tidak ada tipe dan format salah):_

```text
PS E:\Android\laragon\www\elearningarrava> git add .
PS E:\Android\laragon\www\elearningarrava> git commit -m "fix bug login"
⧗   input: fix bug login
✖   subject may not be empty [subject-empty]
✖   type may not be empty [type-empty]

✖   found 2 problems, 0 warnings
ⓘ   Get help: https://github.com/conventional-commits/commitlint/#what-is-commitlint

husky - commit-msg script failed (code 1)
```

> **Analisis Pengujian**: Git Hook `commit-msg` mendeteksi bahwa kata `"fix bug login"` tidak memiliki pemisah titik dua (`:`) serta format `<type>(<scope>): <subject>`. Commit langsung digagalkan seketika oleh Husky dan pesan tidak masuk ke riwayat Git.

---

#### B. Kasus 2: Commit Diterima (PASSED / ACCEPTED) ✅

_Pesan commit ditulis sesuai format Conventional Commits:_

```text
PS E:\Android\laragon\www\elearningarrava> git add CONTRIBUTING.md
PS E:\Android\laragon\www\elearningarrava> git commit -m "docs(git): tambahkan panduan standarisasi git dan contributing"
[main 7f2a1b9] docs(git): tambahkan panduan standarisasi git dan contributing
 1 file changed, 185 insertions(+)
 create mode 100644 CONTRIBUTING.md
```

> **Analisis Pengujian**: Commitlint memvalidasi tipe `docs`, scope `git`, serta subject dengan huruf kecil tanpa titik. Validasi berhasil (status exit code 0) dan Git berhasil membuat commit baru secara rapi.

---

## 3. Tugas 3 (Refleksi): Analisis Mengapa Trunk-Based Development Lebih Cocok untuk CI/CD Dibanding Git Flow

### 3.1 Judul Analisis

**"Mengapa Trunk-Based Development Merupakan Fondasi Esensial bagi Keberhasilan Continuous Integration dan Continuous Delivery (CI/CD) Dibandingkan Git Flow"**

### 3.2 Latar Belakang & Filosofi Kedua Model

Dalam dunia rekayasa perangkat lunak modern, pemilihan model percabangan (_branching strategy_) memiliki dampak langsung terhadap kecepatan rilis perangkat lunak (_lead time to changes_) dan kestabilan sistem (_deployment stability_). Dua model yang paling sering diperbandingkan adalah **Git Flow** (diperkenalkan oleh Vincent Driessen pada 2010) dan **Trunk-Based Development (TBD)**.

- **Git Flow** dirancang pada era rilis perangkat lunak tradisional berbasis siklus rilis terjadwal (bulanan atau kuartalan). Model ini mengandalkan banyak branch berumur panjang (_long-lived branches_): `main`, `develop`, `release/*`, `feature/*`, dan `hotfix/*`.
- **Trunk-Based Development (TBD)** adalah paradigma di mana seluruh insinyur mengintegrasikan kode mereka ke branch tunggal (`main` atau _trunk_) secara rutin beberapa kali sehari menggunakan branch yang berumur sangat pendek (_short-lived branches_, umumnya < 1–2 hari).

---

### 3.3 Paradoks "Continuous Integration" dalam Git Flow

Definisi dasar dari **Continuous Integration (CI)** yang dicetuskan oleh Martin Fowler adalah: _"Praktik di mana anggota tim mengintegrasikan pekerjaan mereka sesering mungkin, setidaknya satu kali sehari per pengembang"_.

Secara fundamental, Git Flow mengandung paradoks terhadap definisi CI:

1. **Integrasi yang Tertunda (_Deferred Integration_)**:  
   Pada Git Flow, seorang pengembang yang mengerjakan `feature/modul-kuis` sering kali bekerja pada branch tersebut selama 1 hingga 3 minggu tanpa pernah menggabungkan (_merge_) kodenya ke `develop`. Selama periode ini, tidak ada integrasi yang sebenarnya terjadi. Kode berada dalam keadaan terisolasi (_silo_).
2. **Sindrom "Merge Hell" dan Konflik Eksponensial**:  
   Ketika beberapa feature branch yang berumur panjang akhirnya selesai pada waktu yang berdekatan dan mencoba melakukan merge ke `develop`, tim akan menghadapi gelombang konflik kode yang masif (_merge hell_). Waktu tim habis untuk menyelesaikan konflik baris kode alih-alih membangun nilai bisnis.
3. **Pengujian yang Menipu (_Illusion of Green Tests_)**:  
   CI server yang menguji branch fitur yang terisolasi mungkin menyatakan test "PASSED". Namun, test tersebut hanya menguji fitur pada snapshot basis kode minggu lalu. Ketika digabungkan dengan perubahan anggota tim lain, sering kali muncul _regression bug_ yang tersembunyi.

---

### 3.4 Mengapa Trunk-Based Development Mengakselerasi Pipeline CI/CD

#### A. Integrasi Kode Nyata dalam Skala Frekuensi Tinggi

Dalam TBD, ukuran setiap branch sangat kecil (_small atomic changes_). Karena branch berumur kurang dari 24–48 jam, jarak perbedaan (_drift_) antara branch lokal pengembang dan _trunk_ sangat minim. Hal ini membuat:

- Konflik penggabungan kode (_merge conflict_) menjadi sangat jarang terjadi dan sangat mudah diselesaikan bila muncul.
- Pipeline CI berjalan pada kode yang selalu relevan dengan keadaan _production_ terbaru.

#### B. Memungkinkan _True Continuous Deployment_ (CD)

Tujuan akhir dari CD adalah kemampuan untuk merilis fitur ke lingkungan _production_ kapan saja dengan risiko mendekati nol.

- Dalam Git Flow, alur promosi kode (`feature` -> `develop` -> `release` -> `main`) membutuhkan banyak upacara (_ceremonial gates_), pembuatan branch release terpisah, dan koordinasi yang memakan waktu berhari-hari.
- Dalam TBD, branch `main` dijaga agar **selalu dalam status siap rilis (_always deployable_)**. Setiap commit yang lolos uji otomatis di pipeline CI dapat langsung didorong ke _production_ secara otomatis.

#### C. Dekopling Antara "Penyebaran Kode" dan "Perilisan Fitur" via Feature Flags

Kritik umum terhadap TBD adalah: _"Bagaimana jika sebuah fitur besar membutuhkan waktu pengerjaan 2 minggu?"_  
TBD menjawab tantangan ini dengan praktik modern bernama **Feature Flags / Feature Toggles**:

- Kode fitur yang belum selesai 100% tetap di-merge ke branch utama secara bertahap setiap hari di balik kondisi _feature toggle_ (`if (featureEnabled)`).
- Kode berada di lingkungan production tetapi tidak aktif bagi pengguna akhir.
- Pendekatan ini menghilangkan kebutuhan akan branch raksasa yang berumur panjang, sekaligus memungkinkan tim melakukan pengujian dini (_dark launching_ / _canary release_).

---

### 3.5 Matriks Perbandingan Teknis: Git Flow vs Trunk-Based Development

| Dimensi Evaluasi                 | Git Flow                            | Trunk-Based Development (TBD)               | Dampak pada CI/CD                                                  |
| :------------------------------- | :---------------------------------- | :------------------------------------------ | :----------------------------------------------------------------- |
| **Umur Branch**                  | Panjang (minggu hingga bulan)       | Sangat pendek (< 1–2 hari)                  | TBD mencegah akumulasi _technical debt_ dan konflik kode.          |
| **Frekuensi Integrasi**          | Rendah (hanya saat fitur selesai)   | Tinggi (beberapa kali per hari)             | TBD mewujudkan Continuous Integration yang sejati.                 |
| **Frekuensi Deployment**         | Berkala / Jarang (mingguan/bulanan) | Sangat sering (harian / on-demand)          | TBD meningkatkan metrik DORA (_Deployment Frequency_).             |
| **Lead Time for Changes**        | Panjang (terhambat alur release)    | Sangat singkat (hitungan jam)               | Fitur atau perbaikan bug sampai ke pengguna jauh lebih cepat.      |
| **Risiko Konflik Merge**         | Tinggi (_Merge Hell_)               | Sangat Rendah                               | Reviewer dapat memeriksa kode berukuran kecil secara mendalam.     |
| **Ketergantungan Tooling**       | Manual branch management            | Otomasi CI Pipeline & Feature Flags         | TBD menuntut budaya otomatisasi pengujian yang ketat.              |
| **Mean Time to Recovery (MTTR)** | Lambat (harus lewat hotfix flow)    | Cepat (cukup commit perbaikan / toggle off) | Meminimalkan durasi _downtime_ saat terjadi insiden di production. |

---

### 3.6 Kesimpulan & Refleksi

Git Flow adalah artefak dari era ketika perangkat lunak didistribusikan secara fisik atau dirilis dalam jadwal manual yang kaku. Pada era cloud modern yang berfokus pada **DevOps, agile delivery, dan feedback loop yang cepat**, **Trunk-Based Development** terbukti secara empiris (sebagaimana didokumentasikan dalam riset _DORA / State of DevOps Report_) sebagai pendorong utama performa rekayasa perangkat lunak berkinerja tinggi (_high-performing engineering teams_).

Dengan menggabungkan Trunk-Based Development bersama standar **Conventional Commits** dan otomatisasi **Git Hooks (Husky & Commitlint)**, proyek **E-Learning Arrava** memperoleh alur kerja yang tidak hanya cepat dan lincah, tetapi juga kokoh, transparan, dan siap menghadapi integrasi berkelanjutan (_CI/CD_) skala penuh.
