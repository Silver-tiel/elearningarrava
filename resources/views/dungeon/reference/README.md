# Kartu Dungeon Kuis

## Isi paket
- `preview/` : 4 pratinjau HTML (buka langsung di browser, tidak perlu server)
  - kartu-mata-pelajaran.html : kartu guru versi awal (bersih, profesional)
  - kartu-dungeon-anak.html   : kartu guru bergaya game (peti harta karun)
  - kartu-masuk-dungeon.html  : kartu siswa tanpa gambar pintu
  - kartu-dungeon-pintu.html  : kartu siswa FINAL (gambar pintu, judul di atas gambar, grafik lantai)
- `laravel/` : kode siap pakai (Blade + Tailwind)
  - resources/views/components/dungeon-card.blade.php  (kartu siswa, final)
  - resources/views/components/subject-card.blade.php  (kartu guru)
  - public/images/dungeon-door.jpg                     (gambar pintu yang sudah dipotong)
  - tailwind.config.js                                 (warna, font, bayangan)

## Pasang di Laravel
1. Salin isi folder `laravel/` ke proyek Anda (gabungkan dengan struktur yang ada).
   Jika sudah punya tailwind.config.js, tambahkan bagian `extend` saja.
2. Tambahkan font di `<head>` layout:
   <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
3. Jalankan `npm run dev` (atau `npm run build`) agar kelas Tailwind dibuat.

## Pemakaian
Kartu siswa:
  <x-dungeon-card title="Pendidikan Pancasila & Kewarganegaraan" level="SD"
      :total="62" :rekor="0" :lantai-max="1" :lantai-total="10"
      :url="route('dungeon.play', $subject)" />
  Tambahkan :locked="true" untuk status terkunci (gambar abu-abu + gembok).

Kartu guru:
  <x-subject-card title="Bahasa Indonesia" level="SMP" :mudah="12" :sedang="7" :sulit="3"
      :editor-url="..." :import-url="..." :trial-url="..." />

## Catatan
- Jumlah lantai (10) adalah asumsi, ubah lewat prop `lantai-total`.
- Pastikan Anda berhak memakai gambar pintu (cek lisensi atau cantumkan kredit).
- Gambar sampul bisa diganti per mata pelajaran lewat prop `cover`.
