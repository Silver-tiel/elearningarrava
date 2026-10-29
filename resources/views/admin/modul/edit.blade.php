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
        <div class="max-w-3xl mx-auto text-center space-y-2">
            <div class="flex items-center justify-center gap-2.5">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Edit Modul</h1>
                @if($module->isDraft())
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                        📝 Draf
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        ✓ Terbit
                    </span>
                @endif
            </div>
            <p class="text-sm text-slate-600">
                Formulir ini digunakan oleh admin untuk mengedit modul pembelajaran atau mengubah status publikasinya.
            </p>
        </div>
    </header>
    <!-- Konten Utama Form -->
    <main class="flex-grow max-w-3xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                    <div class="flex items-center gap-2 font-bold mb-1 text-rose-900">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Terjadi kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formModulEdit" action="{{ route('admin.modul.update', $module->id_modul) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="action_type" id="input-action-type" value="{{ $module->isDraft() ? 'draft' : 'publish' }}">

                <!-- 1. Judul Modul -->
                <div>
                    <label for="judul_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Judul Modul Pembelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="judul_modul" name="judul_modul" value="{{ old('judul_modul', $module->judul_modul) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border @error('judul_modul') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                    @error('judul_modul')
                        <p class="mt-1 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <!-- 2. Pilihan Jenis Modul -->
                <div>
                    <label for="id_tipemodul" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenis Modul <span class="text-red-500">*</span>
                    </label>
                    <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType()" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($tipeModul as $tipe)
                            <option value="{{ $tipe->id_tipemodul }}" {{ old('id_tipemodul', $module->id_tipemodul) == $tipe->id_tipemodul ? 'selected' : '' }}>{{ $tipe->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- 3. Pilihan Jenjang Pendidikan -->
                <div>
                    <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select id="id_jenjang" name="id_jenjang" onchange="filterAndSortQuizzes()" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($jenjang as $j)
                            <option value="{{ $j->id_jenjang }}" data-name="{{ $j->nama_tipe }}" {{ old('id_jenjang', $module->id_jenjang) == $j->id_jenjang ? 'selected' : '' }}>{{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- 4. Kuis Evaluasi Modul & Poin Kelulusan (In-Module Quiz) -->
                <div class="p-5 rounded-xl border-2 border-indigo-100 bg-gradient-to-br from-indigo-50/50 via-white to-blue-50/40 space-y-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-indigo-100/80 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="p-2 rounded-lg bg-indigo-600 text-white shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Kuis Evaluasi Modul & Poin Kelulusan</h3>
                                <p class="text-xs text-slate-500">Kuis in-modul ini dikerjakan siswa langsung di halaman modul untuk menyelesaikan modul.</p>
                            </div>
                        </div>
                        <span id="soal_badge_count" class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 w-fit">
                            0 Soal
                        </span>
                    </div>

                    <!-- Pengaturan Bobot EXP & Standar KKM Kuis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="poin_modul" class="block text-xs font-bold text-slate-700 mb-1">
                                Poin / EXP Kelulusan Modul <span class="text-indigo-600 font-normal">(Default: 50)</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="poin_modul" name="poin_modul" min="0" max="1000" value="{{ old('poin_modul', $module->poin_modul ?? 50) }}"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                <span class="absolute left-3 top-2 text-indigo-600 text-sm">⭐</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1">EXP yang diterima siswa saat menuntaskan materi & kuis modul.</p>
                        </div>

                        <div>
                            <label for="kkm_quiz" class="block text-xs font-bold text-slate-700 mb-1">
                                Nilai KKM Kuis Evaluasi (0 - 100) <span class="text-indigo-600 font-normal">(Default: 70)</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="kkm_quiz" name="kkm_quiz" min="0" max="100" value="{{ old('kkm_quiz', $module->kkm_quiz ?? 70) }}"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                <span class="absolute left-3 top-2 text-indigo-600 text-sm">🎯</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1">Standar nilai kelulusan kuis agar modul dianggap tuntas.</p>
                        </div>
                    </div>

                    <!-- Daftar Butir Soal Builder -->
                    <div class="space-y-3 pt-2 border-t border-indigo-100/60">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Daftar Soal Kuis Modul
                            </label>
                            <button type="button" onclick="tambahSoal()"
                                class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Soal
                            </button>
                        </div>

                        <!-- Empty state notice jika belum ada soal -->
                        <div id="soal_empty_state" class="p-6 text-center rounded-xl border-2 border-dashed border-slate-200 bg-white/70 text-slate-500 space-y-1">
                            <span class="text-2xl">📝</span>
                            <p class="text-xs font-semibold text-slate-700">Belum ada butir soal kuis modul.</p>
                            <p class="text-[11px] text-slate-400">Klik tombol <strong>"+ Tambah Soal"</strong> di atas untuk membuat pertanyaan kuis evaluasi. Jika dikosongkan, modul dapat dituntaskan hanya dengan mempelajari materi.</p>
                        </div>

                        <!-- Container Kartu Soal Dinamis -->
                        <div id="soal_container" class="space-y-4"></div>
                    </div>
                </div>

                <!-- Opsi Tambahan: Hubungkan Quiz Eksternal (Kompatibilitas Legacy) -->
                <details class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/70 text-xs">
                    <summary class="font-semibold text-slate-700 cursor-pointer flex items-center justify-between select-none">
                        <span>🔗 Opsi Lanjutan: Kaitkan Kuis Eksternal (Opsional / Kompatibilitas)</span>
                        <span class="text-[11px] text-slate-400 font-normal">Klik untuk buka/tutup</span>
                    </summary>

                    <div class="mt-3 pt-3 border-t border-slate-200 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
                            <label for="id_quiz" class="block text-xs font-semibold text-slate-600">
                                Pilih Kuis Eksternal
                            </label>
                            <span id="quiz_jenjang_info" class="text-[11px] font-semibold text-blue-700 bg-blue-100/70 border border-blue-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 w-fit">
                                <span>🎯</span> <span id="quiz_jenjang_text">Kuis Jenjang: -</span>
                            </span>
                        </div>

                        <p class="text-[11px] text-slate-500">
                            Kuis eksternal disaring otomatis agar memiliki jenjang yang sama dengan modul ini.
                        </p>

                        <!-- Bar Pencarian & Sortir Kuis -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 pt-1">
                            <div class="sm:col-span-7 relative">
                                <input type="text" id="search_quiz_input" placeholder="Cari nama kuis..." oninput="filterAndSortQuizzes()"
                                    class="w-full pl-8 pr-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="sm:col-span-5">
                                <select id="sort_quiz_select" onchange="filterAndSortQuizzes()"
                                    class="w-full px-2 py-1.5 rounded-lg border border-slate-300 bg-white text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                                    <option value="name_asc">Urutkan: A - Z</option>
                                    <option value="name_desc">Urutkan: Z - A</option>
                                    <option value="latest">Urutkan: Terbaru</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dropdown Utama Kuis -->
                        <select id="id_quiz" name="id_quiz"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs transition font-medium">
                            <option value="" data-jenjang="" data-judul="" data-nama="">-- Tanpa Kuis Eksternal --</option>
                            @foreach ($quizzes as $quiz)
                                <option value="{{ $quiz->id_quiz }}"
                                    data-jenjang="{{ $quiz->id_jenjang }}"
                                    data-judul="{{ strtolower($quiz->judul) }}"
                                    data-nama="{{ $quiz->judul }}"
                                    data-draft="{{ $quiz->isDraft() ? '1' : '0' }}"
                                    data-created="{{ $quiz->created_at ? $quiz->created_at->timestamp : 0 }}"
                                    data-jenjang-nama="{{ $quiz->jenjang->nama_tipe ?? '-' }}"
                                    {{ old('id_quiz', $module->id_quiz) == $quiz->id_quiz ? 'selected' : '' }}>
                                    [{{ $quiz->jenjang->nama_tipe ?? 'Umum' }}] {{ $quiz->judul }}{{ $quiz->isDraft() ? ' (Draf)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p id="quiz_empty_notice" class="hidden text-xs text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg">
                            ⚠️ Belum ada kuis untuk jenjang ini. Anda tetap bisa menyimpan modul tanpa mengaitkan kuis.
                        </p>
                    </div>
                </details>
                <!-- 4. Upload File Materi -->
                <div id="container_file">
                    <label for="file_upload" class="block text-sm font-medium text-slate-700 mb-1">
                        Upload Berkas Materi Baru (Biarkan kosong jika tidak ingin mengubah)
                    </label>
                    <input type="file" id="file_upload" name="file_upload" accept=".pdf,.ppt,.pptx" class="w-full">
                    @error('file_upload')
                        <p class="mt-1 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                    @if($module->file_materi && $module->tipe_file != 'link')
                        <p class="text-xs mt-1 text-slate-500">File saat ini: <a href="{{ Storage::url($module->file_materi) }}" target="_blank" class="text-blue-500 underline">Lihat File</a></p>
                    @endif
                </div>
                <!-- 5. Input Link Eksternal -->
                <div id="container_link" class="hidden">
                    <label for="file_link" class="block text-sm font-medium text-slate-700 mb-1">
                        Tautan Video / Materi Eksternal <span class="text-red-500">*</span>
                    </label>
                    <input type="url" id="file_link" name="file_link" value="{{ old('file_link', $module->tipe_file == 'link' ? $module->file_materi : '') }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                        oninput="previewYoutubeEdit(this.value)"
                        class="w-full px-4 py-2.5 rounded-lg border @error('file_link') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                    @error('file_link')
                        <p class="mt-1 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
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
                    @if($module->foto_modul && Storage::disk('public')->exists($module->foto_modul))
                        <div class="mt-2">
                            <img src="{{ Storage::url($module->foto_modul) }}" class="w-32 h-32 object-cover rounded-lg border shadow-sm">
                            <span class="text-xs text-slate-500 font-medium block mt-1">Sampul foto khusus</span>
                        </div>
                    @elseif($module->youtube_id)
                        <div class="mt-2 flex items-center gap-3">
                            <img src="https://img.youtube.com/vi/{{ $module->youtube_id }}/hqdefault.jpg" class="w-36 h-24 object-cover rounded-lg border shadow-sm">
                            <span class="text-xs text-slate-500 font-medium">Sampul otomatis dari video YouTube</span>
                        </div>
                    @endif
                </div>
                <!-- Tombol Aksi / Simpan -->
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.modul') }}" 
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition text-center">
                        Batal
                    </a>
                    <button type="button" onclick="submitModul('draft')"
                        class="px-5 py-2.5 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-800 text-sm font-semibold transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>📝</span>
                        <span>Simpan Draf</span>
                    </button>
                    <button type="button" onclick="submitModul('publish')"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition flex items-center justify-center gap-1.5">
                        <span>🚀</span>
                        <span>Perbarui & Terbitkan Modul</span>
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

        // ---- SINKRONISASI JENJANG & SORTIR KUIS ----
        let allQuizOptions = [];

        function initQuizOptions() {
            const quizSelect = document.getElementById('id_quiz');
            if (!quizSelect) return;
            const options = Array.from(quizSelect.options);
            allQuizOptions = options.map(opt => ({
                value: opt.value,
                text: opt.text,
                jenjang: opt.getAttribute('data-jenjang') || '',
                judul: opt.getAttribute('data-judul') || '',
                nama: opt.getAttribute('data-nama') || opt.text,
                draft: opt.getAttribute('data-draft') || '0',
                created: parseInt(opt.getAttribute('data-created') || '0', 10),
                selected: opt.selected
            }));
        }

        function filterAndSortQuizzes() {
            const jenjangSelect = document.getElementById('id_jenjang');
            const quizSelect = document.getElementById('id_quiz');
            const searchInput = document.getElementById('search_quiz_input');
            const sortSelect = document.getElementById('sort_quiz_select');
            const infoText = document.getElementById('quiz_jenjang_text');
            const emptyNotice = document.getElementById('quiz_empty_notice');

            if (!jenjangSelect || !quizSelect) return;

            const selectedJenjangId = jenjangSelect.value;
            const selectedJenjangName = jenjangSelect.options[jenjangSelect.selectedIndex]?.getAttribute('data-name') || jenjangSelect.options[jenjangSelect.selectedIndex]?.text || '';
            if (infoText) {
                infoText.textContent = `Kuis Jenjang: ${selectedJenjangName}`;
            }

            const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const sortBy = sortSelect ? sortSelect.value : 'name_asc';

            const currentVal = quizSelect.value;

            // Filter options: hanya jenjang yang cocok
            let filtered = allQuizOptions.filter(opt => {
                if (!opt.value) return true; // Option '-- Tanpa Kuis Terikat --'
                if (opt.jenjang && opt.jenjang !== selectedJenjangId) return false;
                if (keyword && !opt.judul.includes(keyword)) return false;
                return true;
            });

            const emptyOpt = filtered.find(opt => !opt.value);
            let quizOpts = filtered.filter(opt => opt.value);

            if (sortBy === 'name_asc') {
                quizOpts.sort((a, b) => a.nama.localeCompare(b.nama));
            } else if (sortBy === 'name_desc') {
                quizOpts.sort((a, b) => b.nama.localeCompare(a.nama));
            } else if (sortBy === 'latest') {
                quizOpts.sort((a, b) => b.created - a.created);
            }

            const finalOptions = emptyOpt ? [emptyOpt, ...quizOpts] : quizOpts;

            quizSelect.innerHTML = '';
            let hasSelected = false;

            finalOptions.forEach(opt => {
                const optionEl = document.createElement('option');
                optionEl.value = opt.value;
                optionEl.textContent = opt.text;
                optionEl.setAttribute('data-jenjang', opt.jenjang);
                optionEl.setAttribute('data-judul', opt.judul);
                optionEl.setAttribute('data-nama', opt.nama);
                optionEl.setAttribute('data-draft', opt.draft);
                optionEl.setAttribute('data-created', opt.created);

                if (opt.value && opt.value === currentVal) {
                    optionEl.selected = true;
                    hasSelected = true;
                }
                quizSelect.appendChild(optionEl);
            });

            if (!hasSelected && currentVal !== '') {
                quizSelect.value = '';
            }

            if (emptyNotice) {
                emptyNotice.classList.toggle('hidden', quizOpts.length > 0);
            }
        }

        @php
        $existingSoal = old('soal') ?? $module->soalModul->map(function ($s) {
            $kunciIdx = 0;
            $pilihanArray = [];
            foreach ($s->pilihan as $idx => $p) {
                $pilihanArray[] = ['teks' => $p->teks_pilihan];
                if ($p->is_benar) {
                    $kunciIdx = $idx;
                }
            }
            return [
                'pertanyaan' => $s->pertanyaan,
                'kunci' => $kunciIdx,
                'pilihan' => $pilihanArray,
            ];
        })->toArray();
        @endphp

        // ---- QUESTION BUILDER (KUIS EVALUASI IN-MODUL) ----
        let soalCounter = 0;
        const initialSoalData = @json($existingSoal);

        function tambahSoal(data = null) {
            const container = document.getElementById('soal_container');
            const emptyState = document.getElementById('soal_empty_state');
            if (emptyState) emptyState.classList.add('hidden');

            const idx = soalCounter++;
            const pertanyaan = data?.pertanyaan || '';
            const kunci = parseInt(data?.kunci ?? 0, 10);
            const pilihanList = data?.pilihan || ['', '', '', ''];

            const letters = ['A', 'B', 'C', 'D'];
            let pilihanHtml = '';

            letters.forEach((letter, pIdx) => {
                const teksPilihan = typeof pilihanList[pIdx] === 'object' && pilihanList[pIdx] !== null 
                    ? (pilihanList[pIdx].teks || '') 
                    : (pilihanList[pIdx] || '');
                const isChecked = pIdx === kunci ? 'checked' : '';

                pilihanHtml += `
                    <div class="pilihan-item flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 bg-white hover:border-indigo-300 transition">
                        <label class="flex items-center gap-2 cursor-pointer shrink-0" title="Tandai sebagai kunci jawaban yang benar">
                            <input type="radio" name="soal[${idx}][kunci]" value="${pIdx}" ${isChecked} required
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 transition">
                            <span class="w-6 h-6 rounded bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center border border-slate-200">${letter}</span>
                        </label>
                        <input type="text" name="soal[${idx}][pilihan][${pIdx}][teks]" value="${escapeHtml(teksPilihan)}" required
                            placeholder="Jawaban opsi ${letter}..."
                            class="w-full px-2 py-1 text-xs border border-transparent hover:border-slate-300 focus:border-indigo-500 rounded bg-transparent focus:bg-white focus:outline-none transition">
                    </div>
                `;
            });

            const card = document.createElement('div');
            card.className = 'soal-card p-4 rounded-xl border border-indigo-200/80 bg-white shadow-sm space-y-3 transition';
            card.id = `soal_card_${idx}`;
            card.innerHTML = `
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center soal-badge-number">1</span>
                        <span class="text-xs font-bold text-slate-800 soal-title">Pertanyaan Kuis</span>
                    </div>
                    <button type="button" onclick="hapusSoal(this)" class="px-2 py-1 text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Soal
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Teks Pertanyaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="soal[${idx}][pertanyaan]" rows="2" required placeholder="Tuliskan soal pertanyaan di sini..."
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">${escapeHtml(pertanyaan)}</textarea>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-slate-700">Pilihan Jawaban</label>
                        <span class="text-[11px] text-emerald-700 font-medium bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            Pilih radio hijau untuk menentukan kunci jawaban yang benar
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        ${pilihanHtml}
                    </div>
                </div>
            `;

            container.appendChild(card);
            renumberSoal();
        }

        function hapusSoal(btn) {
            const card = btn.closest('.soal-card');
            if (card) {
                card.remove();
                renumberSoal();
            }
        }

        function renumberSoal() {
            const container = document.getElementById('soal_container');
            const emptyState = document.getElementById('soal_empty_state');
            const badgeCount = document.getElementById('soal_badge_count');
            const cards = container.querySelectorAll('.soal-card');

            cards.forEach((card, i) => {
                const num = i + 1;
                const badge = card.querySelector('.soal-badge-number');
                const title = card.querySelector('.soal-title');
                if (badge) badge.textContent = num;
                if (title) title.textContent = `Pertanyaan #${num}`;
            });

            if (badgeCount) {
                badgeCount.textContent = `${cards.length} Soal`;
            }

            if (emptyState) {
                emptyState.classList.toggle('hidden', cards.length > 0);
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // ---- SUBMIT DRAF VS PUBLIKASI ----
        function submitModul(actionType) {
            const inputAction = document.getElementById('input-action-type');
            const form = document.getElementById('formModulEdit');
            inputAction.value = actionType;

            if (actionType === 'draft') {
                const judul = document.getElementById('judul_modul');
                if (!judul.value.trim()) {
                    alert('Judul modul wajib diisi sebelum menyimpan draf.');
                    judul.focus();
                    return;
                }
                const requiredInputs = form.querySelectorAll('[required]');
                requiredInputs.forEach(el => {
                    if (el.id !== 'judul_modul' && el.id !== 'id_jenjang') {
                        el.removeAttribute('required');
                    }
                });
                form.submit();
            } else {
                if (form.reportValidity()) {
                    form.submit();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleInputType();
            initQuizOptions();
            filterAndSortQuizzes();

            if (Array.isArray(initialSoalData) && initialSoalData.length > 0) {
                initialSoalData.forEach(s => tambahSoal(s));
            }
        });
    </script>
</body>
</html>
