<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Tambah Modul Pembelajaran dengan Live Preview">
    <title>Tambah Modul Pembelajaran</title>
    <!-- Menggunakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Bagian Atas -->
    <header class="py-6 px-4 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Menambahkan Modul Baru</h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-0.5">
                    Formulir admin dengan fitur live preview untuk pengelolaan e-learning.
                </p>
            </div>
            <a href="{{ route('admin.modul') }}" 
                class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </header>

    <!-- Konten Utama: 2 Kolom (Kiri: Form, Kanan: Live Preview) -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- KOLOM KIRI: FORMULIR (Span 7) -->
            <div class="lg:col-span-7 bg-white rounded-xl shadow-md border border-slate-200 p-6 sm:p-8">
                <form action="{{ route('admin.modul.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Judul Modul -->
                    <div>
                        <label for="judul_modul" class="block text-sm font-medium text-slate-700 mb-1">
                            Judul Modul Pembelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul_modul" name="judul_modul" required oninput="updatePreview()"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                            placeholder="Masukkan judul modul...">
                    </div>

                    <!-- 2. Pilihan Jenis Modul -->
                    <div>
                        <label for="id_tipemodul" class="block text-sm font-medium text-slate-700 mb-1">
                            Jenis Modul <span class="text-red-500">*</span>
                        </label>
                        <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType(); updatePreview();" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                            @foreach ($tipeModul as $tipe)
                                <option value="{{ $tipe->id_tipemodul }}" data-name="{{ $tipe->nama_tipe }}" {{ strtolower($tipe->nama_tipe) === 'pdf' ? 'selected' : '' }}>{{ $tipe->nama_tipe }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Pilihan Jenjang Pendidikan -->
                    <div>
                        <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">
                            Jenjang <span class="text-red-500">*</span>
                        </label>
                        <select id="id_jenjang" name="id_jenjang" onchange="updatePreview()" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                            @foreach ($jenjang as $j)
                                <option value="{{ $j->id_jenjang }}" data-name="{{ $j->nama_tipe }}">{{ $j->nama_tipe }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Hubungkan Quiz Terkait -->
                    <div>
                        <label for="id_quiz" class="block text-sm font-medium text-slate-700 mb-1">
                            Hubungkan ke Kuis <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <select id="id_quiz" name="id_quiz"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                            <option value="">-- Tanpa Kuis Terikat --</option>
                            @foreach ($quizzes as $quiz)
                                <option value="{{ $quiz->id_quiz }}">{{ $quiz->judul }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Upload File Materi (Dokumen PDF/PPT) -->
                    <div id="container_file">
                        <label for="file_upload" class="block text-sm font-medium text-slate-700 mb-1">
                            Upload Berkas Materi (PDF / PPT)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-blue-400 transition bg-slate-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="file_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Pilih berkas</span>
                                        <input id="file_upload" name="file_upload" type="file" accept=".pdf,.ppt,.pptx" class="sr-only" onchange="previewFile(this)">
                                    </label>
                                    <p class="pl-1">atau seret ke sini</p>
                                </div>
                                <p class="text-xs text-slate-500">Format: .pdf, .ppt, .pptx (Maks. 50MB)</p>
                            </div>
                        </div>
                        
                        <div id="file_preview_container" class="hidden mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200 flex items-center justify-between">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <svg class="w-7 h-7 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                <div class="truncate">
                                    <p id="file_preview_name" class="text-xs font-bold text-blue-900 truncate"></p>
                                    <p id="file_preview_size" class="text-[11px] text-blue-700"></p>
                                </div>
                            </div>
                            <button type="button" onclick="openFileModal()" id="btn_preview_file" class="text-xs font-semibold text-white bg-blue-600 px-2.5 py-1 rounded hover:bg-blue-700 hidden flex-shrink-0">
                                Lihat PDF
                            </button>
                        </div>
                    </div>

                    <!-- 5. Input Link Eksternal (Opsional/Video) -->
                    <div id="container_link" class="hidden">
                        <label for="file_link" class="block text-sm font-medium text-slate-700 mb-1">
                            Tautan Video / Materi Eksternal <span class="text-red-500">*</span>
                        </label>
                        <input type="url" id="file_link" name="file_link" placeholder="https://www.youtube.com/watch?v=..." oninput="updatePreview(); previewYoutubeLive(this.value);"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        <p class="text-xs text-slate-400 mt-1">Dapat berupa tautan YouTube (Watch, Share/youtu.be, Shorts, atau Live). Pratinjau video akan langsung muncul di panel kanan.</p>
                    </div>

                    <!-- 6. Upload Cover Modul / Thumbnail -->
                    <div>
                        <label for="foto_modul" class="block text-sm font-medium text-slate-700 mb-1">
                            Gambar Sampul / Thumbnail Modul <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="file" id="foto_modul" name="foto_modul" accept="image/*" onchange="previewCover(this)"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                        <a href="{{ route('admin.modul') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                            Simpan & Terbitkan Modul
                        </button>
                    </div>
                </form>
            </div>

            <!-- KOLOM KANAN: LIVE PREVIEW KARTU & KONTEN (Span 5) -->
            <div class="lg:col-span-5 sticky top-6 space-y-6">
                <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                    <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Live Preview Kartu Modul
                        </span>
                        <span id="preview_badge_tipe" class="text-[10px] bg-blue-600 px-2 py-0.5 rounded font-medium">Modul</span>
                    </div>

                    <!-- Tampilan Kartu Modul -->
                    <div class="p-5 space-y-4">
                        <!-- Thumbnail Preview -->
                        <div class="relative w-full h-44 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 flex items-center justify-center">
                            <img id="preview_cover_img" src="#" alt="Cover Preview" class="w-full h-full object-cover hidden">
                            <div id="preview_cover_placeholder" class="text-center p-4">
                                <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs text-slate-400 mt-1 block">Belum ada thumbnail</span>
                            </div>
                        </div>

                        <!-- Informasi Judul & Jenjang -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span id="preview_jenjang_badge" class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">Jenjang</span>
                                <span class="text-xs text-slate-400">• Tersedia</span>
                            </div>
                            <h3 id="preview_judul" class="text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                Judul modul akan muncul di sini...
                            </h3>
                        </div>

                        <!-- Indikator Jenis Konten di Dalam Kartu -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span id="preview_file_status" class="flex items-center gap-1.5 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Belum ada berkas/link
                            </span>
                            <span class="font-medium text-blue-600">Preview Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Live Preview Dokumen PDF / Materi Video -->
                <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                    <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            <span id="preview_doc_title">Live Preview Materi</span>
                        </span>
                        <button type="button" onclick="openFileModal()" id="btn_fullscreen_pdf" class="hidden text-xs text-blue-300 hover:text-white flex items-center gap-1 transition">
                            <span>Perbesar Layar</span> ↗
                        </button>
                    </div>

                    <div id="inline_preview_container" class="p-4 bg-slate-50 min-h-[300px] flex items-center justify-center">
                        <div id="inline_preview_placeholder" class="text-center p-6 text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-xs font-medium text-slate-500">Pratinjau berkas PDF atau video YouTube akan tampil di sini saat dipilih/diisi</p>
                        </div>
                        <iframe id="inline_pdf_iframe" src="" class="w-full h-[450px] rounded-lg border border-slate-200 hidden bg-white" frameborder="0"></iframe>
                        
                        <!-- Video Player Preview Container -->
                        <div id="inline_video_container" class="w-full aspect-video rounded-xl overflow-hidden bg-black shadow hidden border border-slate-300">
                            <iframe id="inline_youtube_iframe" src="" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Preview PDF -->
    <div id="pdfModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl h-[85vh] flex flex-col overflow-hidden">
            <div class="px-4 py-3 border-b flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 text-sm">Preview Berkas PDF</h3>
                <button type="button" onclick="closeFileModal()" class="text-slate-500 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-grow bg-slate-200">
                <iframe id="pdf_iframe" src="" class="w-full h-full" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-200 bg-white mt-12">
        &copy; {{ date('Y') }} Sistem Pembelajaran. All rights reserved.
    </footer>

    <!-- Script JavaScript untuk Sinkronisasi Live Preview & Interaksi Form -->
    <script>
        function extractYoutubeId(url) {
            if (!url) return null;
            url = url.trim();
            // Cek iframe tag
            const iframeMatch = url.match(/src=["']([^"']+)["']/);
            if (iframeMatch) url = iframeMatch[1];
            // Ekstraksi ID
            const regExp = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|live|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
            const match = url.match(regExp);
            if (match && match[1]) return match[1];
            if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
            return null;
        }

        function previewYoutubeLive(url) {
            const ytContainer = document.getElementById('inline_video_container');
            const ytIframe = document.getElementById('inline_youtube_iframe');
            const pdfIframe = document.getElementById('inline_pdf_iframe');
            const placeholder = document.getElementById('inline_preview_placeholder');
            const fileStatus = document.getElementById('preview_file_status');
            const previewCoverImg = document.getElementById('preview_cover_img');
            const previewCoverPlaceholder = document.getElementById('preview_cover_placeholder');
            const fotoModulInput = document.getElementById('foto_modul');

            const ytId = extractYoutubeId(url);

            if (ytId) {
                // Tampilkan video player langsung di pratinjau panel kanan
                ytIframe.src = `https://www.youtube.com/embed/${ytId}?rel=0&enablejsapi=1`;
                ytContainer.classList.remove('hidden');
                pdfIframe.classList.add('hidden');
                placeholder.classList.add('hidden');

                if (fileStatus) {
                    fileStatus.innerHTML = `<span class="flex items-center gap-1.5 text-red-600 font-semibold"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg> YouTube: ${ytId}</span>`;
                }

                // Otomatis sinkronkan thumbnail YouTube ke kartu pratinjau jika user belum mengunggah gambar khusus
                if (!fotoModulInput.files || fotoModulInput.files.length === 0) {
                    previewCoverImg.src = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
                    previewCoverImg.classList.remove('hidden');
                    previewCoverPlaceholder.classList.add('hidden');
                }
            } else {
                ytIframe.src = "";
                ytContainer.classList.add('hidden');
                if (pdfIframe.src && !pdfIframe.classList.contains('hidden')) {
                    // Masih ada PDF
                } else {
                    placeholder.classList.remove('hidden');
                }
            }
        }

        function toggleInputType() {
            const selectEl = document.getElementById('id_tipemodul');
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            const tipeName = selectedOption ? selectedOption.getAttribute('data-name').toLowerCase() : '';
            const containerLink = document.getElementById('container_link');
            const containerFile = document.getElementById('container_file');
            const ytContainer = document.getElementById('inline_video_container');
            const ytIframe = document.getElementById('inline_youtube_iframe');
            
            // Jika tipe mengandung kata 'video' atau 'link'
            if (tipeName.includes('video') || tipeName.includes('link')) {
                containerLink.classList.remove('hidden');
                containerFile.classList.add('hidden');
                const linkVal = document.getElementById('file_link').value;
                if (linkVal) {
                    previewYoutubeLive(linkVal);
                }
            } else {
                containerLink.classList.add('hidden');
                containerFile.classList.remove('hidden');
                if (ytContainer) ytContainer.classList.add('hidden');
                if (ytIframe) ytIframe.src = "";
            }
        }
        // Jalankan saat load
        toggleInputType();

        // ---- FUNGSI UPDATE LIVE PREVIEW KANAN ----
        function updatePreview() {
            // 1. Update Judul
            const judulInput = document.getElementById('judul_modul').value;
            const previewJudul = document.getElementById('preview_judul');
            previewJudul.textContent = judulInput.trim() !== '' ? judulInput : 'Judul modul akan muncul di sini...';

            // 2. Update Badge Jenis Modul
            const tipeSelect = document.getElementById('id_tipemodul');
            const selectedTipe = tipeSelect.options[tipeSelect.selectedIndex];
            document.getElementById('preview_badge_tipe').textContent = selectedTipe ? selectedTipe.text : 'Modul';

            // 3. Update Badge Jenjang
            const jenjangSelect = document.getElementById('id_jenjang');
            const selectedJenjang = jenjangSelect.options[jenjangSelect.selectedIndex];
            document.getElementById('preview_jenjang_badge').textContent = selectedJenjang ? selectedJenjang.text : 'Jenjang';
        }
        // Inisialisasi awal preview
        updatePreview();

        // ---- LOGIKA PREVIEW FILE PDF/PPT & STATUSNYA ----
        function previewFile(input) {
            const container = document.getElementById('file_preview_container');
            const nameEl = document.getElementById('file_preview_name');
            const sizeEl = document.getElementById('file_preview_size');
            const btnPreview = document.getElementById('btn_preview_file');
            const btnFullscreen = document.getElementById('btn_fullscreen_pdf');
            const iframe = document.getElementById('pdf_iframe');
            const inlineIframe = document.getElementById('inline_pdf_iframe');
            const inlinePlaceholder = document.getElementById('inline_preview_placeholder');
            const fileStatus = document.getElementById('preview_file_status');
            const ytContainer = document.getElementById('inline_video_container');
            const ytIframe = document.getElementById('inline_youtube_iframe');
            
            // Sembunyikan player video jika upload file
            if (ytContainer) ytContainer.classList.add('hidden');
            if (ytIframe) ytIframe.src = "";

            if (input.files && input.files[0]) {
                const file = input.files[0];
                container.classList.remove('hidden');
                nameEl.textContent = file.name;
                
                const sizeKB = file.size / 1024;
                sizeEl.textContent = sizeKB > 1024 ? (sizeKB / 1024).toFixed(2) + ' MB' : sizeKB.toFixed(2) + ' KB';

                // Update teks di kartu preview
                fileStatus.innerHTML = `<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Berkas: ${file.name.substring(0, 15)}...`;

                const isPdf = (file.type && file.type.includes('pdf')) || file.name.toLowerCase().endsWith('.pdf');

                if (isPdf) {
                    const blobUrl = URL.createObjectURL(file);
                    btnPreview.classList.remove('hidden');
                    if (btnFullscreen) btnFullscreen.classList.remove('hidden');
                    iframe.src = blobUrl;
                    if (inlineIframe) {
                        inlineIframe.src = blobUrl;
                        inlineIframe.classList.remove('hidden');
                    }
                    if (inlinePlaceholder) inlinePlaceholder.classList.add('hidden');
                } else {
                    btnPreview.classList.add('hidden');
                    if (btnFullscreen) btnFullscreen.classList.add('hidden');
                    iframe.src = "";
                    if (inlineIframe) {
                        inlineIframe.src = "";
                        inlineIframe.classList.add('hidden');
                    }
                    if (inlinePlaceholder) {
                        inlinePlaceholder.classList.remove('hidden');
                        inlinePlaceholder.innerHTML = `<p class="text-xs text-slate-500 font-medium">Berkas <b>${file.name}</b> siap diunggah. Pratinjau langsung hanya tersedia untuk format PDF.</p>`;
                    }
                }
            } else {
                container.classList.add('hidden');
                iframe.src = "";
                if (btnFullscreen) btnFullscreen.classList.add('hidden');
                if (inlineIframe) {
                    inlineIframe.src = "";
                    inlineIframe.classList.add('hidden');
                }
                if (inlinePlaceholder) {
                    inlinePlaceholder.classList.remove('hidden');
                    inlinePlaceholder.innerHTML = `<svg class="mx-auto h-12 w-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg><p class="text-xs font-medium text-slate-500">Pratinjau berkas PDF atau video YouTube akan tampil di sini saat dipilih/diisi</p>`;
                }
                fileStatus.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Belum ada berkas/link`;
            }
        }

        function openFileModal() {
            document.getElementById('pdfModal').classList.remove('hidden');
        }
        function closeFileModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // ---- LOGIKA PREVIEW THUMBNAIL/COVER GAMBAR ----
        function previewCover(input) {
            const imgEl = document.getElementById('preview_cover_img');
            const placeholderEl = document.getElementById('preview_cover_placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgEl.src = e.target.result;
                    imgEl.classList.remove('hidden');
                    placeholderEl.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                // Jika input cover dibersihkan, cek apakah ada link youtube yang bisa digunakan thumbnail-nya
                const ytId = extractYoutubeId(document.getElementById('file_link').value);
                if (ytId) {
                    imgEl.src = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
                    imgEl.classList.remove('hidden');
                    placeholderEl.classList.add('hidden');
                } else {
                    imgEl.src = "#";
                    imgEl.classList.add('hidden');
                    placeholderEl.classList.remove('hidden');
                }
            }
        }
    </script>
</body>

</html> 