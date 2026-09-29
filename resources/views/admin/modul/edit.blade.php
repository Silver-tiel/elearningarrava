<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Edit Modul Pembelajaran">
    <title>Edit Modul Pembelajaran</title>
    <!-- Menggunakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">
    <!-- Header / Bagian Atas -->
    <header class="py-8 px-4 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Edit Modul</h1>
            <p class="mt-2 text-sm text-slate-600">
                Formulir ini digunakan oleh admin untuk mengedit modul pembelajaran.
            </p>
        </div>
    </header>
    <!-- Konten Utama Form -->
    <main class="flex-grow max-w-3xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden p-6 sm:p-8">
            <form action="{{ route('admin.modul.update', $module->id_modul) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- 1. Judul Modul -->
                <div>
                    <label for="judul_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Judul Modul Pembelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="judul_modul" name="judul_modul" value="{{ $module->judul_modul }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                </div>
                <!-- 2. Pilihan Jenis Modul -->
                <div>
                    <label for="id_tipemodul" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenis Modul <span class="text-red-500">*</span>
                    </label>
                    <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType()" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($tipeModul as $tipe)
                            <option value="{{ $tipe->id_tipemodul }}" {{ $module->id_tipemodul == $tipe->id_tipemodul ? 'selected' : '' }}>{{ $tipe->nama_tipe }}</option>
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
                            <option value="{{ $j->id_jenjang }}" {{ $module->id_jenjang == $j->id_jenjang ? 'selected' : '' }}>{{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Pilihan Kuis Terkait -->
                <div>
                    <label for="id_quiz" class="block text-sm font-medium text-slate-700 mb-1">
                        Hubungkan ke Kuis <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <select id="id_quiz" name="id_quiz"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        <option value="">-- Tanpa Kuis Terikat --</option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id_quiz }}" {{ $module->id_quiz == $quiz->id_quiz ? 'selected' : '' }}>{{ $quiz->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- 4. Upload File Materi -->
                <div id="container_file">
                    <label for="file_upload" class="block text-sm font-medium text-slate-700 mb-1">
                        Upload Berkas Materi Baru (Biarkan kosong jika tidak ingin mengubah)
                    </label>
                    <input type="file" id="file_upload" name="file_upload" accept=".pdf,.ppt,.pptx" class="w-full">
                    @if($module->file_materi && $module->tipe_file != 'link')
                        <p class="text-xs mt-1 text-slate-500">File saat ini: <a href="{{ Storage::url($module->file_materi) }}" target="_blank" class="text-blue-500 underline">Lihat File</a></p>
                    @endif
                </div>
                <!-- 5. Input Link Eksternal -->
                <div id="container_link" class="hidden">
                    <label for="file_link" class="block text-sm font-medium text-slate-700 mb-1">
                        Tautan Video / Materi Eksternal <span class="text-red-500">*</span>
                    </label>
                    <input type="url" id="file_link" name="file_link" value="{{ $module->tipe_file == 'link' ? $module->file_materi : '' }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                        oninput="previewYoutubeEdit(this.value)"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                    <p class="text-xs text-slate-400 mt-1">Dapat berupa tautan YouTube (Watch, Share/youtu.be, Shorts, atau Live).</p>

                    <!-- Pratinjau Video Player Langsung di Halaman Edit -->
                    <div id="edit_yt_container" class="mt-3 aspect-video w-full max-w-lg rounded-xl overflow-hidden bg-black shadow hidden border border-slate-300">
                        <iframe id="edit_yt_iframe" src="" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <!-- 6. Upload Cover Modul / Thumbnail -->
                <div>
                    <label for="foto_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Gambar Sampul / Thumbnail Modul (Biarkan kosong jika tidak ingin mengubah)
                    </label>
                    <input type="file" id="foto_modul" name="foto_modul" accept="image/*" class="w-full">
                    @if($module->foto_modul)
                        <img src="{{ Storage::url($module->foto_modul) }}" class="mt-2 w-32 h-32 object-cover rounded-lg border">
                    @endif
                </div>
                <!-- Tombol Aksi / Simpan -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.modul') }}" 
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        function extractYoutubeId(url) {
            if (!url) return null;
            url = url.trim();
            const iframeMatch = url.match(/src=["']([^"']+)["']/);
            if (iframeMatch) url = iframeMatch[1];
            const regExp = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|live|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
            const match = url.match(regExp);
            if (match && match[1]) return match[1];
            if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
            return null;
        }

        function previewYoutubeEdit(url) {
            const container = document.getElementById('edit_yt_container');
            const iframe = document.getElementById('edit_yt_iframe');
            const ytId = extractYoutubeId(url);
            if (ytId) {
                iframe.src = `https://www.youtube.com/embed/${ytId}?rel=0&enablejsapi=1`;
                container.classList.remove('hidden');
            } else {
                iframe.src = "";
                container.classList.add('hidden');
            }
        }

        function toggleInputType() {
            const tipe = document.getElementById('id_tipemodul').value;
            const containerLink = document.getElementById('container_link');
            const containerFile = document.getElementById('container_file');
            if (tipe == 1) { 
                containerLink.classList.remove('hidden');
                if (containerFile) containerFile.classList.add('hidden');
                const linkVal = document.getElementById('file_link').value;
                if (linkVal) previewYoutubeEdit(linkVal);
            } else {
                containerLink.classList.add('hidden');
                if (containerFile) containerFile.classList.remove('hidden');
                const container = document.getElementById('edit_yt_container');
                const iframe = document.getElementById('edit_yt_iframe');
                if (container) container.classList.add('hidden');
                if (iframe) iframe.src = "";
            }
        }
        toggleInputType();
    </script>
</body>
</html>
