<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Tambah Modul Pembelajaran">
    <title>Tambah Modul Pembelajaran</title>
    <!-- Menggunakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Bagian Atas -->
    <header class="py-8 px-4 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Menambahkan Modul</h1>
            <p class="mt-2 text-sm text-slate-600">
                Formulir ini digunakan oleh admin untuk menambahkan modul baru ke sistem pembelajaran.
            </p>
        </div>
    </header>

    <!-- Konten Utama Form -->
    <main class="flex-grow max-w-3xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden p-6 sm:p-8">
            
            <!-- Perbaikan Route Action: Menggunakan admin.modul.store sesuai group route admin -->
            <form action="{{ route('admin.modul.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- 1. Judul Modul -->
                <div>
                    <label for="judul_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Judul Modul Pembelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="judul_modul" name="judul_modul" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                        placeholder="Masukkan judul modul...">
                </div>

                <!-- 2. Pilihan Jenis Modul -->
                <div>
                    <label for="id_tipemodul" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenis Modul <span class="text-red-500">*</span>
                    </label>
                    <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType()" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($tipeModul as $tipe)
                            <option value="{{ $tipe->id_tipemodul }}">{{ $tipe->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Pilihan Jenjang Pendidikan -->
                <div>
                    <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select id="id_jenjang" name="id_jenjang" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($jenjang as $j)
                            <option value="{{ $j->id_jenjang }}">{{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. Upload File Materi (Dinamis: Dokumen PDF/PPT) -->
                <div id="container_file">
                    <label for="file_upload" class="block text-sm font-medium text-slate-700 mb-1">
                        Upload Berkas Materi (PDF / PPT)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-blue-400 transition bg-slate-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Pilih berkas</span>
                                    <input id="file_upload" name="file_upload" type="file" accept=".pdf,.ppt,.pptx" class="sr-only" onchange="previewFile(this)">
                                </label>
                                <p class="pl-1">atau seret ke sini</p>
                            </div>
                            <p class="text-xs text-slate-500">Format yang didukung: .pdf, .ppt, .pptx (Maksimal 50MB)</p>
                        </div>
                    </div>
                    <!-- File Preview Area -->
                    <div id="file_preview_container" class="hidden mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                            <div>
                                <p id="file_preview_name" class="text-sm font-bold text-blue-900"></p>
                                <p id="file_preview_size" class="text-xs text-blue-700"></p>
                            </div>
                        </div>
                        <!-- Modal Trigger Button -->
                        <button type="button" onclick="openFileModal()" id="btn_preview_file" class="mt-2 text-xs font-bold text-white bg-blue-600 px-3 py-1.5 rounded hover:bg-blue-700 hidden">
                            Lihat Preview PDF
                        </button>
                    </div>
                </div>

                <!-- 5. Input Link Eksternal (Opsional jika video YouTube atau link luar) -->
                <div id="container_link" class="hidden">
                    <label for="file_link" class="block text-sm font-medium text-slate-700 mb-1">
                        Atau Masukkan Tautan Video / Materi Luar
                    </label>
                    <input type="url" id="file_link" name="file_link" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                </div>

                <!-- 6. Upload Cover Modul / Thumbnail -->
                <div>
                    <label for="foto_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Gambar Sampul / Thumbnail Modul <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="file" id="foto_modul" name="foto_modul" accept="image/*" onchange="previewCover(this)"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                    
                    <!-- Cover Preview Area -->
                    <div id="cover_preview_container" class="hidden mt-3">
                        <img id="cover_preview_img" src="#" alt="Preview Cover" class="w-48 h-32 object-cover rounded-lg border border-slate-300 cursor-pointer" onclick="openCoverModal()">
                        <p class="text-xs text-slate-500 mt-1">Klik gambar untuk memperbesar</p>
                    </div>
                </div>

                <!-- Tombol Aksi / Simpan -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.modul') }}" 
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan & Terbitkan Modul
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Modal Preview PDF -->
    <div id="pdfModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl h-[85vh] flex flex-col overflow-hidden">
            <div class="px-4 py-3 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800">Preview PDF</h3>
                <button type="button" onclick="closeFileModal()" class="text-slate-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-grow bg-slate-200">
                <iframe id="pdf_iframe" src="" class="w-full h-full" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <!-- Modal Preview Cover -->
    <div id="coverModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4 transition-opacity" onclick="closeCoverModal()">
        <div class="relative max-w-3xl max-h-[90vh]" onclick="event.stopPropagation()">
            <button type="button" onclick="closeCoverModal()" class="absolute -top-10 right-0 text-white hover:text-red-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img id="cover_modal_img" src="" alt="Cover Full" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain">
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-200 bg-white mt-12">
        &copy; {{ date('Y') }} Sistem Pembelajaran. All rights reserved.
    </footer>

    <!-- Script Sederhana untuk Menyesuaikan Tampilan Input Sesuai Jenis Modul -->
    <script>
        function toggleInputType() {
            const tipe = document.getElementById('id_tipemodul').value;
            const containerLink = document.getElementById('container_link');
            
            // Jika jenis modul Video (misal ID 1, sesuaikan dengan database Anda), tampilkan kolom link URL
            if (tipe == 1) {
                containerLink.classList.remove('hidden');
            } else {
                containerLink.classList.add('hidden');
            }
        }
        // Jalankan saat halaman dimuat
        toggleInputType();

        // ---- LOGIKA PREVIEW FILE PDF/PPT ----
        function previewFile(input) {
            const container = document.getElementById('file_preview_container');
            const nameEl = document.getElementById('file_preview_name');
            const sizeEl = document.getElementById('file_preview_size');
            const btnPreview = document.getElementById('btn_preview_file');
            const iframe = document.getElementById('pdf_iframe');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                container.classList.remove('hidden');
                nameEl.textContent = file.name;
                
                // Kalkulasi ukuran
                const sizeKB = file.size / 1024;
                if (sizeKB > 1024) {
                    sizeEl.textContent = (sizeKB / 1024).toFixed(2) + ' MB';
                } else {
                    sizeEl.textContent = sizeKB.toFixed(2) + ' KB';
                }

                // Jika PDF, kita bisa preview
                if (file.type === "application/pdf") {
                    btnPreview.classList.remove('hidden');
                    const fileURL = URL.createObjectURL(file);
                    iframe.src = fileURL;
                } else {
                    // PPT tidak bisa dipreview langsung di iframe secara native
                    btnPreview.classList.add('hidden');
                    iframe.src = "";
                }
            } else {
                container.classList.add('hidden');
                iframe.src = "";
            }
        }

        function openFileModal() {
            document.getElementById('pdfModal').classList.remove('hidden');
        }
        function closeFileModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // ---- LOGIKA PREVIEW COVER GAMBAR ----
        function previewCover(input) {
            const container = document.getElementById('cover_preview_container');
            const imgEl = document.getElementById('cover_preview_img');
            const modalImgEl = document.getElementById('cover_modal_img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.classList.remove('hidden');
                    imgEl.src = e.target.result;
                    modalImgEl.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.classList.add('hidden');
                imgEl.src = "#";
            }
        }

        function openCoverModal() {
            document.getElementById('coverModal').classList.remove('hidden');
        }
        function closeCoverModal() {
            document.getElementById('coverModal').classList.add('hidden');
        }
    </script>
</body>

</html>