<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
</head>

<body>
    <header>
        <h1 style="text-align: center;">Menambahkan Modul</h1>
        <p style="text-align: center;">Formulir ini digunakan oleh admin untuk menambahkan modul baru ke sistem
            pembelajaran.</p>
    </header>
    <section>
        {{--
        Keterangan Form Upload Modul:
        1. action="{{ route('modul.store') }}" : Mengarah ke ModulController@store untuk menyimpan data ke database.
        2. method="POST" : Mengirimkan data baru ke server secara aman.
        3. enctype="multipart/form-data" : Wajib disertakan agar form dapat mengunggah berkas fisik (PDF/Video/Gambar).
        --}}
        <form action="{{ route('modul.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 1. Judul Modul -->
            <div class="form-group">
                <label for="judul_modul">Judul Modul Pembelajaran *</label>
                <input type="text" id="judul_modul" name="judul_modul" required>
            </div>
            <!-- 2. Pilihan Jenis Modul -->
            <div class="form-group">
                <label for="id_tipemodul">Jenis Modul *</label>
                <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType()" required>
                    @foreach ($tipeModul as $tipe)
                        <option value="{{ $tipe->id_tipemodul }}">{{ $tipe->nama_tipe }}</option>
                    @endforeach
                </select>
            </div>
            <!-- 3. Pilihan Jenjang Pendidikan -->
            <div class="form-group">
                <label for="id_jenjang">Jenjang *</label>
                <select id="id_jenjang" name="id_jenjang" required>
                    @foreach ($jenjang as $j)
                        <option value="{{ $j->id_jenjang }}">{{ $j->nama_tipe }}</option>
                    @endforeach
                </select>
            </div>
            <!-- 4. Upload File Materi (Dinamis: Dokumen PDF/Docx/Video) -->
            <div class="form-group" id="container_file">
                <label for="file_upload">Upload Berkas Materi (PDF / Dokumen / Video)</label>
                <div class="file-box">
                    <input type="file" id="file_upload" name="file_upload">
                    <small style="color: #78909c; display: block; margin-top: 6px;">Format yang didukung: .pdf, .docx,
                        .pptx, .mp4 (Maksimal 50MB)</small>
                </div>
            </div>
            <!-- 5. Input Link Eksternal (Opsional jika video YouTube atau link luar) -->
            <div class="form-group" id="container_link">
                <label for="file_link">Atau Masukkan Tautan Video / Materi Luar</label>
                <input type="url" id="file_link" name="file_link" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <!-- 6. Upload Cover Modul / Thumbnail -->
            <div class="form-group">
                <label for="foto_modul">Gambar Sampul / Thumbnail Modul (Opsional)</label>
                <input type="file" id="foto_modul" name="foto_modul" accept="image/*">
            </div>
            <!-- Tombol Simpan -->
            <button type="submit" class="btn-submit">Simpan & Terbitkan Modul</button>
        </form>
        </div>
        <!-- Script Sederhana untuk Menyesuaikan Tampilan Input Sesuai Jenis Modul -->
        <script>
            function toggleInputType() {
                const tipe = document.getElementById('id_tipemodul').value;
                const containerLink = document.getElementById('container_link');
                // Jika jenis modul Video (id 1), tampilkan kolom link URL YouTube
                if (tipe == 1) {
                    containerLink.style.display = 'block';
                } else {
                    containerLink.style.display = 'none';
                }
            }
            toggleInputType();
        </script>
</body>

</html>
</form>
</section>
<footer></footer>
</body>

</html>