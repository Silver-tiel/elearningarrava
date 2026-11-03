# Panduan Kontribusi & Standarisasi Git — E-Learning Arrava

Selamat datang di proyek **E-Learning Arrava**! Dokumen ini merupakan panduan dan kontrak standar kolaborasi tim pengembang dalam mengelola repositori kode menggunakan Git.

Standarisasi ini bertujuan menjaga riwayat Git tetap bersih, terstruktur, mudah diaudit (*traceable*), mempermudah proses *code review*, serta mendukung integrasi otomatis (*CI/CD*) dan otomatisasi *changelog*.

---

## Daftar Isi
1. [Standar Penamaan Branch](#1-standar-penamaan-branch-branching-convention)
2. [Standar Commit Message (Conventional Commits)](#2-standar-commit-message-conventional-commits)
3. [Alur Kerja Git (Git Workflow)](#3-alur-kerja-git-git-workflow)
4. [Standar Pull Request (PR)](#4-standar-pull-request-pr)
5. [Standar Code Review](#5-standar-code-review)
6. [Kebersihan Repositori (Git Hygiene)](#6-kebersihan-repositori-git-hygiene)
7. [Tools Otomatisasi (Husky & Commitlint)](#7-tools-otomatisasi-husky--commitlint)

---

## 1. Standar Penamaan Branch (Branching Convention)

Setiap pengembangan fitur, perbaikan kutu (*bug*), atau pemeliharaan wajib dikerjakan pada branch terpisah yang dibuat dari branch `main`.

### 1.1 Format Penamaan
```text
<type>/<short-description>
```
atau bila merujuk pada nomor tiket/isu:
```text
<type>/<ticket-id>-<short-description>
```

### 1.2 Tipe Prefix Branch
| Prefix | Kegunaan | Contoh Kasus di Proyek Arrava |
| :--- | :--- | :--- |
| `feature/` | Penambahan fitur baru | `feature/quiz-wayground-timer`, `feature/102-siswa-qr-presensi` |
| `fix/` | Perbaikan bug pada branch pengembangan | `fix/login-parallax-gap`, `fix/redirect-after-quiz-submit` |
| `hotfix/` | Perbaikan darurat langsung untuk production | `hotfix/session-csrf-error`, `hotfix/qr-generator-missing-class` |
| `refactor/` | Perbaikan struktur internal kode tanpa ubah fitur | `refactor/quiz-scoring-service`, `refactor/sidebar-component` |
| `docs/` | Perubahan atau penambahan dokumentasi | `docs/contributing-guide`, `docs/api-documentation` |
| `test/` | Penambahan atau perbaikan automated unit/feature test | `test/presensi-qr-feature`, `test/quiz-timeout-validation` |
| `chore/` | Pemeliharaan rutin, konfigurasi alat, update dependensi | `chore/update-composer-deps`, `chore/setup-husky-commitlint` |

### 1.3 Aturan Penulisan Branch
- ✅ **Gunakan huruf kecil semua** (*lowercase*).
- ✅ **Gunakan tanda hubung (`-`)** sebagai pemisah kata, bukan spasi atau garis bawah (`_`).
- ✅ **Deskripsi ringkas & jelas** (maksimal ~50 karakter).
- ❌ **Contoh Salah**:
  - `Budi_TambahFitur` (menggunakan huruf kapital dan underscore)
  - `fix bug login` (mengandung spasi)
  - `coba-coba` / `asdf` (tidak deskriptif dan tidak memiliki prefix)
- ✅ **Contoh Benar**:
  - `feature/104-presensi-qr-profile`
  - `fix/login-animation-white-gap`
  - `refactor/siswa-controller-methods`

---

## 2. Standar Commit Message (Conventional Commits)

Proyek ini menerapkan standar **[Conventional Commits v1.0.0](https://www.conventionalcommits.org/)**.

### 2.1 Struktur Pesan Commit
```text
<type>(<scope>): <subject>

[optional body: penjelasan latar belakang & alasan perubahan]

[optional footer: referensi issue, breaking changes]
```

### 2.2 Tipe Commit (`type`)
* **`feat`**: Penambahan fitur baru bagi pengguna (contoh: modul baru, kuis baru).
* **`fix`**: Perbaikan *bug* atau kecacatan sistem.
* **`docs`**: Perubahan dokumentasi saja (seperti README, CONTRIBUTING, PHPDoc).
* **`style`**: Perubahan gaya kode/formatting tanpa mengubah logika program (spasi, titik koma).
* **`refactor`**: Restrukturisasi kode tanpa mengubah fungsionalitas luar atau menambah fitur.
* **`perf`**: Perubahan kode yang bertujuan meningkatkan performa eksekusi.
* **`test`**: Menambah, memperbaiki, atau merefaktor automated test (PHPUnit/Pest).
* **`build`**: Perubahan yang mempengaruhi sistem build atau dependensi eksternal (Composer, NPM, Vite).
* **`ci`**: Perubahan konfigurasi CI/CD pipeline (GitHub Actions, workflow scripts).
* **`chore`**: Tugas pemeliharaan rutin yang tidak memodifikasi kode inti aplikasi.
* **`revert`**: Membatalkan commit sebelumnya.

### 2.3 Scope Proyek Arrava (`scope`)
Pilih scope yang spesifik terhadap modul yang Anda sentuh:
* `auth`: Login, registrasi, lupa kata sandi, logout.
* `modul`: Pengelolaan materi, video pembelajaran, ringkasan catatan.
* `quiz`: Pembuatan kuis, pengerjaan kuis biasa, wayground, penilaian & timer.
* `presensi`: Sistem absensi QR, scanner kamera guru, log presensi.
* `siswa`: Halaman dasbor siswa, profil siswa, tanda penghargaan (*achievement*).
* `guru`: Dasbor guru, rekap presensi kelas, penugasan.
* `admin`: Manajemen kelas, data siswa/guru, verifikasi akun.
* `orangtua`: Pemantauan riwayat kuis & kehadiran anak.
* `ui`: Komponen Blade bersama (sidebar, modal, efek parallax retro).
* `db`: Migrasi skema database, seeder data awal.
* `deps`: Pengelolaan paket Composer / NPM.

### 2.4 Aturan Penulisan
1. **Subject**:
   - Gunakan kata kerja bentuk perintah / *imperative mood* (contoh: `tambahkan` / `add`, bukan `menambahkan` / `added`).
   - Awali dengan huruf kecil.
   - Jangan akhiri dengan tanda titik (`.`).
   - Panjang subject maksimal **50 karakter**.
2. **Body (Opsional tetapi disarankan untuk perubahan kompleks)**:
   - Pisahkan dari subject dengan satu baris kosong.
   - Jelaskan *mengapa* perubahan dilakukan dan konteks masalah, bukan sekadar *apa* yang diubah.
   - Batas panjang per baris maksimal **72 karakter**.
3. **Footer (Opsional)**:
   - Referensikan nomor tiket/isu: `Closes #12`, `Fixes #34`, `Refs: #56`.
   - Breaking changes ditandai dengan `BREAKING CHANGE: <penjelasan>`.

### 2.5 Contoh Commit Benar
```text
feat(presensi): integrasikan qr presensi ke halaman profil siswa

Memindahkan kartu QR presensi dari menu terpisah langsung ke dalam
halaman profil siswa agar navigasi lebih terpusat dan ringkas.
Menyertakan fitur cetak kartu dan unduh format PNG.

Closes #88
```

```text
fix(auth): perbaiki celah putih pada animasi transisi login

Menambahkan ekstensi warna dasar #0e59e0 pada bagian bawah layer
gelombang sehingga saat elemen naik ke atas, tidak ada celah putih
yang terekspos sebelum panel sukses muncul.

Fixes #104
```

---

## 3. Alur Kerja Git (Git Workflow)

Proyek ini mengadopsi model **Short-Lived Feature Branches** (turunan dari prinsip *Trunk-Based Development* untuk tim skala kecil-menengah).

```text
main  ─────────●───────────────────────────● (Squash & Merge)
                \                         /
feature/auth     ●──────●──────●─────────● (PR + Code Review + CI Test)
```

### 3.1 Siklus Pengembangan
1. **Perbarui Branch Utama**:
   ```bash
   git checkout main
   git pull origin main
   ```
2. **Buat Feature Branch Baru**:
   ```bash
   git checkout -b feature/nama-fitur-anda
   ```
3. **Kerjakan Perubahan Secara Atomik**:
   - Lakukan commit kecil yang terfokus (*satu commit untuk satu tujuan logis*).
   - Pastikan kode telah diuji secara lokal:
     ```bash
     php artisan test
     ```
4. **Push Branch ke Remote**:
   ```bash
   git push -u origin feature/nama-fitur-anda
   ```
5. **Buka Pull Request (PR)** di GitHub.
6. **Lakukan Code Review & Pengujian CI**:
   - Tunggu minimal 1 rekan tim memberikan persetujuan (*Approved*).
7. **Merge & Hapus Branch**:
   - Gunakan opsi **Squash and Merge** agar riwayat branch utama tetap linear dan rapi.
   - Hapus branch lokal dan remote setelah merge selesai.

---

## 4. Standar Pull Request (PR)

### 4.1 Judul PR
Judul Pull Request wajib mengikuti format Conventional Commits yang sama dengan commit:
```text
<type>(<scope>): <subject singkat>
```
*Contoh*: `feat(profil): pindahkan kartu qr presensi ke halaman profil siswa`

### 4.2 Batasan Ukuran PR
- **Target**: Di bawah **400 baris perubahan** (*lines changed*).
- PR yang terlalu besar wajib dipecah menjadi beberapa tahap logis agar reviewer dapat melakukan audit secara mendalam dan cepat.

### 4.3 Template Deskripsi PR
Setiap kali membuka Pull Request, gunakan format berikut:

```markdown
## Deskripsi Perubahan
Ringkasan singkat mengenai fitur atau perbaikan yang dikerjakan pada PR ini.

## Tipe Perubahan
- [ ] 🐛 Bug fix (perbaikan masalah tanpa merusak fitur lain)
- [ ] ✨ Fitur baru (penambahan kapabilitas sistem)
- [ ] ♻️ Refactoring (perbaikan struktur internal tanpa ubah output)
- [ ] 📚 Dokumentasi (penambahan / perbaikan dokumen teknis)

## Cakupan Pengujian
- [ ] Unit Test / Feature Test (PHPUnit) lulus: `php artisan test`
- [ ] Pengujian manual di browser telah dilakukan
- [ ] Responsif di tampilan mobile & desktop

## Tangkapan Layar / Bukti Visual (Opsional untuk perubahan UI)
[Lampirkan screenshot sebelum dan sesudah jika ada perubahan antarmuka]

## Referensi Isu
Closes #<nomor_tiket>
```

---

## 5. Standar Code Review

Code review adalah sarana saling belajar dan menjaga kualitas arsitektur aplikasi bersama, bukan ajang mencari kesalahan personal.

### 5.1 Tanggung Jawab Reviewer
- Periksa logika bisnis, keamanan (mencegah IDOR, CSRF, SQL Injection), dan penanganan error.
- Urusan penulisan gaya kode (*formatting*) diserahkan pada linter/formatter otomatis.
- Berikan respon dalam waktu maksimal **24 jam kerja**.

### 5.2 Konvensi Label Komentar Review
Gunakan label awalan berikut untuk memperjelas bobot ulasan:
* **`blocking:`** Isu krusial (bug logika, celah keamanan, test gagal). Wajib diperbaiki sebelum PR dapat disetujui untuk merge.
* **`nit:`** (*Nitpick*) Saran kecil yang bersifat estetika atau alternatif minor. Tidak menghalangi merge.
* **`question:`** Pertanyaan untuk memahami alasan implementasi atau desain tertentu.
* **`praise:`** Apresiasi atas solusi kode yang bersih, cerdas, atau pengujian yang menyeluruh.

*Contoh*:
> `blocking: Parameter user_id di controller ini berpotensi IDOR, gunakan auth()->id() atau Gate authorize.`
> `praise: Pemisahan method kalkulasi skor ini sangat rapi dan mudah dibaca!`

---

## 6. Kebersihan Repositori (Git Hygiene)

1. **Jangan Pernah Meng-commit File Sensitif atau Build Artifacts**:
   - File konfigurasi lokal (`.env`, `.env.local`).
   - Direktori dependensi (`vendor/`, `node_modules/`).
   - Berkas build dan cache (`public/build/`, `bootstrap/cache/`, `storage/framework/views/*`).
   - File konfigurasi IDE privat (`.idea/`, `.vscode/`, `.gemini/`).
2. **Aturan Rebase vs Merge**:
   - Diperbolehkan menggunakan `git rebase main` pada branch lokal milik sendiri sebelum membuka PR agar cabang tetap sinkron.
   - **DILARANG KERAS** melakukan rebase atau force push (`git push -f`) pada branch bersama atau branch `main`.
3. **Protected Branch `main`**:
   - Push langsung ke branch `main` dilarang.
   - Seluruh perubahan wajib melalui Pull Request yang disetujui.

---

## 7. Tools Otomatisasi (Husky & Commitlint)

Repositori ini dilengkapi dengan git hooks otomatis menggunakan **Husky** dan **Commitlint** untuk menjamin tidak ada pesan commit yang menyimpang dari standar.

### 7.1 Cara Kerja
Saat Anda menjalankan perintah `git commit`:
1. Git Hook `commit-msg` dieksekusi secara otomatis oleh Husky.
2. Commitlint memvalidasi apakah format pesan memenuhi aturan `@commitlint/config-conventional`.
3. Jika format salah (misalnya: `git commit -m "update"`), commit **dibatalkan seketika** dan terminal menampilkan letak kesalahannya.
4. Jika format benar (misalnya: `git commit -m "docs(git): tambahkan panduan kontribusi"`), commit akan **diterima**.

Dengan mematuhi panduan ini, kita menjaga proyek **E-Learning Arrava** tetap profesional, stabil, dan menyenangkan untuk dikembangkan bersama!

