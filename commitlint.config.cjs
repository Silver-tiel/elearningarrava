/**
 * =============================================================================
 * PANDUAN STANDAR COMMIT MESSAGE (CONVENTIONAL COMMITS)
 * E-Learning Arrava Pintar
 * =============================================================================
 *
 * FORMAT UMUM COMMIT MESSAGE:
 *   <type>(<scope>): <subject>
 *
 *   [body opsional: penjelasan detail mengapa perubahan ini dilakukan]
 *
 *   [footer opsional: referensi tiket/isu, misal: Closes #123, Refs: #456]
 *
 * -----------------------------------------------------------------------------
 * ATURAN PENULISAN:
 * 1. Gunakan huruf kecil (lowercase) untuk <type>, <scope>, dan awal <subject>.
 * 2. Jangan akhiri <subject> dengan tanda titik (.).
 * 3. Gunakan imperative mood pada subjek ("add", bukan "added" / "adds").
 * 4. Panjang <subject> maksimal 50-72 karakter agar mudah dibaca di git log.
 * 5. Satu commit = satu tujuan logis (atomik).
 *
 * -----------------------------------------------------------------------------
 * DAFTAR TYPE & CONTOH COMMIT YANG BENAR (✅):
 *
 * 1. feat     : Menambah fitur baru bagi pengguna/sistem
 *    Contoh   : feat(auth): add multi-step form for parent registration
 *               feat(profil): implement qr presensi card and download png
 *
 * 2. fix      : Memperbaiki bug atau kesalahan sistem
 *    Contoh   : fix(auth): resolve login redirect loop on expired token
 *               fix(pendaftaran): match phone number field validation
 *
 * 3. docs     : Perubahan dokumentasi (README, CONTRIBUTING, dokumen tugas)
 *    Contoh   : docs(contributing): add conventional commit guide and examples
 *               docs(readme): update installation and migration steps
 *
 * 4. style    : Format kode, perapihan tampilan/spasi tanpa mengubah logika kode
 *    Contoh   : style(pendaftaran): adjust button padding and stepper alignment
 *               style(navbar): fix icon vertical alignment on mobile
 *
 * 5. refactor : Restrukturisasi kode tanpa menambah fitur baru atau memperbaiki bug
 *    Contoh   : refactor(pendaftaran-controller): split registration logic into service
 *               refactor(sidebar): extract menu items into blade component
 *
 * 6. perf     : Peningkatan performa kode atau optimasi query database
 *    Contoh   : perf(dashboard): eager load class relations to prevent n+1 queries
 *               perf(image): optimize pixel background asset size
 *
 * 7. test     : Menambah atau memperbaiki pengujian otomatis (unit / feature test)
 *    Contoh   : test(pendaftaran): add feature test for parent and student accounts
 *               test(profil): add test cases for qr code generation
 *
 * 8. build    : Perubahan build system, dependensi npm, atau composer packages
 *    Contoh   : build(deps): install husky and commitlint packages
 *               build(vite): update asset build configuration
 *
 * 9. ci       : Konfigurasi continuous integration / deployment (GitHub Actions)
 *    Contoh   : ci(github): add automated phpunit workflow on pull request
 *
 * 10. chore   : Tugas pemeliharaan rutin, file konfigurasi, atau git hooks
 *    Contoh   : chore(husky): setup commit-msg hook for commitlint
 *               chore(git): update .gitignore to exclude temporary files
 *
 * 11. revert  : Membatalkan commit sebelumnya
 *    Contoh   : revert(auth): revert commit abc1234 due to regression bug
 *
 * -----------------------------------------------------------------------------
 * CONTOH SALAH (❌) vs BENAR (✅):
 *   ❌ fix bug login
 *   ✅ fix(auth): resolve login failure on expired session
 *
 *   ❌ Update README.md
 *   ✅ docs(readme): update installation and local setup instructions
 *
 *   ❌ Tambah fitur baru untuk user
 *   ✅ feat(user): add profile picture upload and crop feature
 *
 *   ❌ feat(auth): Menambahkan Halaman Pendaftaran Baru. (ada huruf besar & titik)
 *   ✅ feat(auth): add multi-step registration page for parents
 *
 *   ❌ wip / coba2 / asdf (hindari commit tidak jelas / tidak atomik)
 *   ✅ feat(quiz): add countdown timer for exam mode
 * =============================================================================
 */

module.exports = {
  // Menggunakan preset standar Conventional Commits
  extends: ['@commitlint/config-conventional'],

  rules: {
    /**
     * 'type-enum': Menentukan daftar type commit yang diizinkan.
     * Level 2 = ERROR (commit akan dibatalkan/ditolak jika type tidak ada di daftar)
     * 'always' = aturan ini wajib dipatuhi di setiap commit
     */
    'type-enum': [
      2,
      'always',
      [
        'feat',     // Fitur baru
        'fix',      // Perbaikan bug
        'docs',     // Dokumentasi
        'style',    // Formatting / tampilan tanpa ubah logika
        'refactor', // Refactoring kode
        'perf',     // Optimasi performa
        'test',     // Unit / feature testing
        'build',    // Build system & dependency
        'ci',       // Konfigurasi CI/CD
        'chore',    // Pemeliharaan rutin / utilitas
        'revert'    // Membatalkan commit sebelumnya
      ]
    ],

    /**
     * 'subject-case': Menjaga konsistensi huruf subject commit.
     * Level 2 = ERROR
     * 'never' = TIDAK BOLEH menggunakan Sentence-case, Start-case, PascalCase, atau UPPERCASE.
     * Subject WAJIB diawali huruf kecil (lowercase).
     */
    'subject-case': [
      2,
      'never',
      ['sentence-case', 'start-case', 'pascal-case', 'upper-case']
    ]
  }
};
