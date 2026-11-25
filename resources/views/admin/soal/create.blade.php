<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal Bank — Arrava Editor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Montserrat', 'sans-serif'] },
                    colors: {
                        kahoot: {
                            blue: '#1368CE',
                            darkblue: '#0B4FB3',
                            deepnavy: '#0A3875',
                            red: '#E21B3C',
                            yellow: '#D89E00',
                            green: '#26890C',
                            purple: '#46178F',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #F2F4F7;
        }

        .answer-card {
            transition: all 0.15s ease-in-out;
        }

        .answer-card:focus-within {
            ring: 2px;
            ring-color: #1368CE;
        }

        .answer-card.is-correct-card {
            ring: 4px;
            ring-color: #26890C;
            border-color: #26890C;
        }

        .thumb-card.active {
            border-color: #1368CE;
            box-shadow: 0 0 0 2px #1368CE;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 99px;
        }
    </style>
</head>

<body class="h-screen flex flex-col overflow-hidden text-gray-800">

    <form id="form-soal-bank" action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data" class="h-full flex flex-col">
        @csrf

        @if(isset($errors) && $errors->any())
            <div role="alert" aria-live="assertive" class="mx-4 mt-2 max-h-28 shrink-0 overflow-y-auto rounded-xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm">
                <div class="font-bold">Input soal belum valid. Periksa kembali:</div>
                <ul class="mt-1 list-inside list-disc space-y-0.5">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ==================== TOP BAR ==================== --}}
        <header class="h-16 bg-white border-b border-gray-200 px-4 flex items-center justify-between shrink-0 z-30 shadow-sm">
            {{-- Kiri: Logo + Judul Bank Soal --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-[#007FBE] text-white px-3 py-1.5 rounded-lg font-black tracking-tight text-lg shadow-sm">
                    <span>Arrava</span>
                    <span class="text-xs bg-yellow-400 text-black px-1.5 py-0.5 rounded ml-1.5 font-bold uppercase">Bank Soal</span>
                </div>

                <div class="hidden sm:flex items-center gap-2">
                    <span class="text-sm font-extrabold text-slate-800">Buat Soal Mandiri</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-[#007FBE] border border-[#B2E7FC]">
                        Siap Digunakan ke Kuis &amp; Ujian
                    </span>
                </div>
            </div>

            {{-- Kanan: Aksi Simpan & Keluar --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.soal') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Keluar ke Bank Soal</span>
                </a>
                <button type="submit" id="btn-submit-form"
                    class="px-5 py-2 text-sm font-bold text-white bg-[#007FBE] hover:bg-[#00689E] rounded-lg shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan ke Bank Soal</span>
                </button>
            </div>
        </header>

        {{-- ==================== WORKSPACE 3-COLUMN ==================== --}}
        <div class="flex-1 flex overflow-hidden">

            {{-- ===== LEFT SIDEBAR: QUESTION LIST ===== --}}
            <aside class="w-48 bg-white border-r border-gray-200 flex flex-col shrink-0">
                <div class="p-3 text-xs font-bold text-gray-500 border-b border-gray-100 flex justify-between items-center">
                    <span id="total-soal-count">1 Soal Bank</span>
                </div>

                {{-- Scrollable List Thumbnail --}}
                <div id="thumb-container" class="flex-1 overflow-y-auto p-3 space-y-3">
                    {{-- Generated via JavaScript --}}
                </div>

                {{-- Bottom Buttons --}}
                <div class="p-3 border-t border-gray-200 space-y-2 bg-gray-50">
                    <button type="button" id="btn-add-soal"
                        class="w-full py-2.5 bg-[#007FBE] hover:bg-[#00689E] text-white font-bold text-xs rounded-lg shadow transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambahkan Soal
                    </button>
                </div>
            </aside>

            {{-- ===== CENTER CANVAS: QUESTION EDITOR ===== --}}
            <main class="flex-1 bg-gradient-to-br from-[#0B4FB3] to-[#1368CE] p-6 flex flex-col justify-between overflow-y-auto relative">

                {{-- Top Question Input Card --}}
                <div class="max-w-4xl w-full mx-auto mb-4">
                    <div class="bg-white rounded-xl shadow-xl p-3 border border-white/20">
                        <input type="text" id="input-pertanyaan" placeholder="Ketikkan pertanyaan Anda di sini..."
                            class="w-full text-center text-lg sm:text-xl font-bold text-gray-800 placeholder-gray-400 py-3 px-4 bg-gray-50 rounded-lg focus:bg-white transition border border-transparent focus:border-blue-400">
                    </div>
                </div>

                {{-- Center Media Upload Card --}}
                <div class="max-w-md w-full mx-auto my-auto py-4" id="media-upload-wrapper">
                    {{-- Hidden file inputs container --}}
                    <div id="file-inputs-container" class="hidden"></div>

                    {{-- Drop Zone --}}
                    <div id="upload-dropzone"
                        class="bg-white/80 backdrop-blur rounded-2xl border-2 border-dashed border-white/60 flex flex-col items-center justify-center shadow-2xl hover:bg-white transition group cursor-pointer relative overflow-hidden"
                        style="min-height: 140px; padding: 1.25rem;"
                        ondragover="handleDragOver(event)"
                        ondragleave="handleDragLeave(event)"
                        ondrop="handleDrop(event)"
                        onclick="triggerFileInput()">

                        {{-- State: No Image --}}
                        <div id="upload-placeholder" class="flex flex-col items-center">
                            <div class="w-14 h-14 bg-white rounded-xl shadow-md flex items-center justify-center mb-2.5 group-hover:scale-110 transition">
                                <svg class="w-7 h-7 text-[#1368CE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-[#0A3875] underline">Unggah gambar soal (opsional)</span>
                            <span class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — Maks 2MB</span>
                            <span class="text-xs text-gray-400">atau seret & lepas di sini</span>
                        </div>

                        {{-- State: Image Preview --}}
                        <div id="upload-preview" class="hidden w-full flex flex-col items-center gap-2">
                            <img id="preview-img" src="" alt="Preview gambar soal"
                                class="max-h-28 max-w-full rounded-xl object-contain shadow-lg border border-white">
                            <div class="flex items-center gap-2 mt-1">
                                <span id="preview-filename" class="text-xs font-semibold text-[#0A3875] max-w-[160px] truncate"></span>
                                <button type="button" onclick="removeCurrentImage(event)"
                                    class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition flex-shrink-0"
                                    title="Hapus gambar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <span class="text-xs text-gray-400">Klik untuk ganti gambar</span>
                        </div>
                    </div>

                    {{-- Error message --}}
                    <p id="upload-error" class="hidden text-xs text-red-200 font-semibold text-center mt-2"></p>
                </div>

                {{-- Bottom Area: Pilihan Ganda OR Isian Singkat Container --}}
                <div class="max-w-5xl w-full mx-auto">

                    {{-- 1. Container Pilihan Ganda (4 Choices) --}}
                    <div id="choices-grid-container">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">

                            {{-- Choice 1: Red Triangle --}}
                            <div class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div class="w-12 h-12 bg-[#E21B3C] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2L2 19h20L12 2z" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-0" placeholder="Tambahkan jawaban 1"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="0"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 2: Blue Diamond --}}
                            <div class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div class="w-12 h-12 bg-[#1368CE] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="4" y="4" width="16" height="16" transform="rotate(45 12 12)" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-1" placeholder="Tambahkan jawaban 2"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="1"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 3: Yellow Circle --}}
                            <div id="choice-wrapper-2" class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div class="w-12 h-12 bg-[#D89E00] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-2" placeholder="Tambahkan jawaban 3 (opsional)"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="2"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 4: Green Square --}}
                            <div id="choice-wrapper-3" class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div class="w-12 h-12 bg-[#26890C] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="4" y="4" width="16" height="16" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-3" placeholder="Tambahkan jawaban 4 (opsional)"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="3"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Container Isian Singkat --}}
                    <div id="isian-singkat-container" class="hidden bg-white rounded-2xl p-5 shadow-2xl border-2 border-emerald-400">
                        <label class="block text-xs font-extrabold text-emerald-800 mb-2 flex items-center gap-1.5 uppercase tracking-wider">
                            <span>✏️</span> Kunci Jawaban Isian Singkat:
                        </label>
                        <input type="text" id="input-jawaban-singkat" placeholder="Ketikkan kunci jawaban yang benar di sini..."
                            class="w-full bg-emerald-50 text-emerald-950 font-bold text-base px-4 py-3 rounded-xl border border-emerald-300 focus:bg-white focus:border-emerald-500 transition">
                        <p class="text-xs text-slate-500 mt-2 font-medium">Siswa akan dinilai berdasarkan kecocokan teks dengan kunci ini.</p>
                    </div>

                </div>

            </main>

            {{-- ===== RIGHT SIDEBAR: PROPERTIES PANEL ===== --}}
            <aside class="w-80 bg-white border-l border-gray-200 flex flex-col justify-between shrink-0">
                <div class="overflow-y-auto flex-1 p-4 space-y-5">

                    {{-- Header Panel --}}
                    <div class="pb-3 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#007FBE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Properti Soal
                        </h3>
                        <span class="text-[10px] font-bold text-[#007FBE] bg-sky-50 border border-[#B2E7FC] px-2 py-0.5 rounded">
                            Soal Aktif
                        </span>
                    </div>

                    {{-- 1. PROPERTI SOAL AKTIF --}}
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 shadow-xs space-y-3">
                        {{-- Jenis Soal --}}
                        <div>
                            <label for="select-jenis-soal" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Jenis Soal
                            </label>
                            <select id="select-jenis-soal"
                                class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition">
                                <option value="kuis">Kuis (Pilihan Ganda)</option>
                                <option value="true_false">Benar atau Salah</option>
                                <option value="isian_singkat">Isian Singkat</option>
                            </select>
                        </div>

                        {{-- Tingkat Kesulitan --}}
                        <div>
                            <label for="select-tingkat-soal" class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center justify-between">
                                <span>Tingkat Kesulitan</span>
                                <span class="text-[10px] text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded font-extrabold">Bloom / Level</span>
                            </label>
                            <select id="select-tingkat-soal"
                                class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-purple-500 transition">
                                <option value="mudah">Mudah</option>
                                <option value="sedang" selected>Sedang</option>
                                <option value="sulit">Sulit</option>
                            </select>
                        </div>

                        {{-- Batas Waktu Timer --}}
                        <div>
                            <label for="select-timer" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Batas Waktu Soal
                            </label>
                            <select id="select-timer"
                                class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-blue-500 transition">
                                <option value="5">5 Detik</option>
                                <option value="10">10 Detik</option>
                                <option value="20" selected>20 Detik</option>
                                <option value="30">30 Detik</option>
                                <option value="60">1 Menit</option>
                                <option value="90">1.5 Menit</option>
                                <option value="120">2 Menit</option>
                                <option value="240">4 Menit</option>
                            </select>
                        </div>

                        {{-- Poin --}}
                        <div>
                            <label for="input-poin" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Poin Soal
                            </label>
                            <input type="number" id="input-poin" value="10" min="0" required
                                class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    {{-- 2. KATEGORI BANK SOAL (MAPEL & JENJANG) --}}
                    <div class="bg-blue-50/70 p-3.5 rounded-xl border border-blue-200 shadow-xs space-y-3">
                        <div class="flex items-center justify-between pb-1.5 border-b border-blue-200/60">
                            <span class="text-xs font-black text-blue-950 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-700 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Kategori Bank Soal</span>
                            </span>
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div>
                            <label for="select-mapel" class="block text-xs font-bold text-blue-950 mb-1.5">
                                Mata Pelajaran <span class="text-rose-500">*</span>
                            </label>
                            <select id="select-mapel" name="id_mapel" required
                                class="w-full bg-white border border-blue-300 rounded-lg px-3 py-2 text-xs font-bold text-blue-950 focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel->id_mapel }}" data-jenjang="{{ $mapel->id_jenjang ?? '' }}" data-name="{{ $mapel->nama_mapel }}" @selected(old('id_mapel') == $mapel->id_mapel)>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jenjang Sekolah --}}
                        <div>
                            <label for="select-jenjang" class="block text-xs font-bold text-blue-950 mb-1.5">
                                Jenjang Sekolah
                            </label>
                            <select id="select-jenjang" name="id_jenjang"
                                class="w-full bg-white border border-blue-300 rounded-lg px-3 py-2 text-xs font-bold text-blue-950 focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Semua Jenjang / Umum --</option>
                                @foreach($jenjangList as $jenjang)
                                    <option value="{{ $jenjang->id_jenjang }}" @selected(old('id_jenjang') == $jenjang->id_jenjang)>
                                        {{ $jenjang->nama_tipe ?? $jenjang->nama_jenjang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Peruntukan Bank Soal --}}
                        <div>
                            <label for="select-kategori-bank" class="block text-xs font-bold text-blue-950 mb-1.5">
                                Peruntukan Bank Soal
                            </label>
                            <select id="select-kategori-bank" name="kategori_bank"
                                class="w-full bg-white border border-blue-300 rounded-lg px-3 py-2 text-xs font-bold text-blue-950 focus:ring-2 focus:ring-blue-500 transition">
                                <option value="umum" @selected(old('kategori_bank', 'umum') === 'umum')>Umum / Latihan &amp; Dungeon</option>
                                <option value="ujian" @selected(old('kategori_bank') === 'ujian')>Khusus Ujian (Terpisah dari Dungeon)</option>
                            </select>
                        </div>
                    </div>

                </div>
            </aside>

        </div>

        {{-- Container tersembunyi untuk input soal yang akan dikirim saat submit form --}}
        <div id="hidden-inputs-container"></div>
    </form>

    {{-- ==================== JAVASCRIPT STATE & LOGIC ==================== --}}
    <script>
        // State awal soal
        let soalList = [{
            jenis_soal: "kuis",
            tingkat_soal: "sedang",
            pertanyaan: "",
            timer: "20",
            poin: 10,
            jawaban_singkat: "",
            foto_soal: null,
            pilihan: [
                { label: "A", teks: "", is_correct: 1 },
                { label: "B", teks: "", is_correct: 0 },
                { label: "C", teks: "", is_correct: 0 },
                { label: "D", teks: "", is_correct: 0 },
            ]
        }];

        let currentIndex = 0;
        const fotoFiles = {};
        const fotoPreviews = {};

        // Elemen
        const thumbContainer = document.getElementById('thumb-container');
        const inputPertanyaan = document.getElementById('input-pertanyaan');
        const selectJenisSoal = document.getElementById('select-jenis-soal');
        const selectTingkatSoal = document.getElementById('select-tingkat-soal');
        const selectTimer = document.getElementById('select-timer');
        const inputPoin = document.getElementById('input-poin');
        const countBadge = document.getElementById('total-soal-count');
        const hiddenInputs = document.getElementById('hidden-inputs-container');

        const choicesGridContainer = document.getElementById('choices-grid-container');
        const isianSingkatContainer = document.getElementById('isian-singkat-container');
        const inputJawabanSingkat = document.getElementById('input-jawaban-singkat');

        // File upload
        const fileInputsContainer = document.getElementById('file-inputs-container');
        const uploadDropzone    = document.getElementById('upload-dropzone');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const uploadPreview     = document.getElementById('upload-preview');
        const previewImg        = document.getElementById('preview-img');
        const previewFilename   = document.getElementById('preview-filename');
        const uploadError       = document.getElementById('upload-error');

        const ALLOWED_TYPES = ['image/jpeg','image/png','image/jpg','image/webp'];
        const MAX_SIZE_MB   = 2;

        function getOrCreateFileInput(idx) {
            let el = document.getElementById(`file-input-soal-${idx}`);
            if (!el) {
                el = document.createElement('input');
                el.type = 'file';
                el.id   = `file-input-soal-${idx}`;
                el.name = `soal_foto[${idx}]`;
                el.accept = 'image/jpeg,image/png,image/jpg,image/webp';
                el.className = 'sr-only';
                el.addEventListener('change', () => onFileSelected(el, idx));
                fileInputsContainer.appendChild(el);
            }
            return el;
        }

        function triggerFileInput() {
            getOrCreateFileInput(currentIndex).click();
        }

        function onFileSelected(input, idx) {
            const file = input.files[0];
            if (!file) return;

            if (!ALLOWED_TYPES.includes(file.type)) {
                showUploadError('Format tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                input.value = '';
                return;
            }
            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                showUploadError(`Ukuran file terlalu besar. Maksimal ${MAX_SIZE_MB}MB.`);
                input.value = '';
                return;
            }

            hideUploadError();
            const objectUrl = URL.createObjectURL(file);
            fotoFiles[idx]    = file;
            fotoPreviews[idx] = objectUrl;
            soalList[idx].foto_soal = file.name;
            if (idx === currentIndex) showImagePreview(objectUrl, file.name);
            renderThumbnails();
        }

        function showImagePreview(src, name) {
            previewImg.src       = src;
            previewFilename.textContent = name;
            uploadPlaceholder.classList.add('hidden');
            uploadPreview.classList.remove('hidden');
            uploadDropzone.classList.add('bg-white');
        }

        function clearImagePreview() {
            previewImg.src = '';
            previewFilename.textContent = '';
            uploadPlaceholder.classList.remove('hidden');
            uploadPreview.classList.add('hidden');
            uploadDropzone.classList.remove('bg-white');
        }

        function removeCurrentImage(e) {
            e.stopPropagation();
            const idx = currentIndex;
            if (fotoPreviews[idx] && fotoPreviews[idx].startsWith('blob:')) {
                URL.revokeObjectURL(fotoPreviews[idx]);
            }
            delete fotoFiles[idx];
            delete fotoPreviews[idx];
            soalList[idx].foto_soal = null;

            const fileInput = document.getElementById(`file-input-soal-${idx}`);
            if (fileInput) fileInput.value = '';

            clearImagePreview();
            renderThumbnails();
        }

        function showUploadError(msg) {
            uploadError.textContent = msg;
            uploadError.classList.remove('hidden');
        }

        function hideUploadError() {
            uploadError.textContent = '';
            uploadError.classList.add('hidden');
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadDropzone.classList.add('border-[#1368CE]', 'bg-white');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadDropzone.classList.remove('border-[#1368CE]', 'bg-white');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadDropzone.classList.remove('border-[#1368CE]', 'bg-white');
            const files = e.dataTransfer.files;
            if (files && files[0]) {
                const input = getOrCreateFileInput(currentIndex);
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                input.files = dt.files;
                onFileSelected(input, currentIndex);
            }
        }

        // Render Thumbnails di Left Sidebar
        function renderThumbnails() {
            thumbContainer.innerHTML = '';
            countBadge.innerText = `${soalList.length} Soal Bank`;

            soalList.forEach((soal, idx) => {
                const card = document.createElement('div');
                card.className = `thumb-card relative bg-white border-2 rounded-xl p-2 cursor-pointer transition select-none ${idx === currentIndex ? 'active border-[#007FBE] shadow-md' : 'border-gray-200 hover:border-gray-300'}`;
                card.onclick = () => switchSoal(idx);

                const hasPreview = Boolean(fotoPreviews[idx]);
                const previewThumbHtml = hasPreview
                    ? `<img src="${fotoPreviews[idx]}" class="w-full h-8 object-cover rounded mb-1 border border-gray-100">`
                    : '';

                let typeLabel = 'Pilihan Ganda';
                if (soal.jenis_soal === 'true_false') typeLabel = 'Benar/Salah';
                if (soal.jenis_soal === 'isian_singkat') typeLabel = 'Isian Singkat';

                const displayTingkat = (soal.tingkat_soal || 'sedang').toUpperCase();
                const tingkatBadgeColor = displayTingkat === 'MUDAH' ? 'text-emerald-700 bg-emerald-50' : (displayTingkat === 'SULIT' ? 'text-rose-700 bg-rose-50' : 'text-blue-700 bg-blue-50');

                card.innerHTML = `
                    <div class="flex justify-between items-center text-[10px] font-bold text-gray-500 mb-1">
                        <span class="flex items-center gap-1">
                            <span>${idx + 1}.</span>
                            <span class="px-1 py-0.2 rounded text-[9px] font-extrabold ${tingkatBadgeColor}">${displayTingkat}</span>
                        </span>
                        <span>${soal.timer || 20}s</span>
                    </div>
                    ${previewThumbHtml}
                    <div class="h-9 bg-gray-50 border border-gray-100 rounded p-1 mb-1.5 overflow-hidden">
                        <p class="text-[10px] text-gray-700 font-semibold line-clamp-2 leading-tight">
                            ${soal.pertanyaan ? escapeHtml(soal.pertanyaan) : '<span class="text-gray-400 italic">Belum ada pertanyaan</span>'}
                        </p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] text-gray-400 font-bold truncate max-w-[80px]">${typeLabel}</span>
                        <div class="flex gap-1">
                            <button type="button" onclick="duplicateSoal(event, ${idx})" class="p-1 hover:text-[#007FBE] text-gray-400 transition" title="Duplikasi">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                            ${soalList.length > 1 ? `
                            <button type="button" onclick="deleteSoal(event, ${idx})" class="p-1 hover:text-red-500 text-gray-400 transition" title="Hapus">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>` : ''}
                        </div>
                    </div>
                `;
                thumbContainer.appendChild(card);
            });
        }

        function escapeHtml(str) {
            return (str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function saveCurrentState() {
            if (!soalList[currentIndex]) return;
            const current = soalList[currentIndex];
            current.pertanyaan = inputPertanyaan.value;
            current.jenis_soal = selectJenisSoal.value;
            current.tingkat_soal = selectTingkatSoal.value;
            current.timer = selectTimer.value;
            current.poin = parseInt(inputPoin.value) || 10;

            if (current.jenis_soal === 'isian_singkat') {
                current.jawaban_singkat = inputJawabanSingkat.value;
            } else {
                for (let i = 0; i < 4; i++) {
                    const ansInput = document.getElementById(`ans-text-${i}`);
                    if (ansInput && current.pilihan[i]) {
                        current.pilihan[i].teks = ansInput.value;
                    }
                }
            }
        }

        function loadCurrentState() {
            const current = soalList[currentIndex];
            inputPertanyaan.value = current.pertanyaan || '';
            selectJenisSoal.value = current.jenis_soal || 'kuis';
            selectTingkatSoal.value = current.tingkat_soal || 'sedang';
            selectTimer.value = current.timer || '20';
            inputPoin.value = current.poin !== undefined ? current.poin : 10;

            if (fotoPreviews[currentIndex]) {
                showImagePreview(fotoPreviews[currentIndex], current.foto_soal || 'Gambar Soal');
            } else {
                clearImagePreview();
            }

            updateLayoutByJenisSoal(current.jenis_soal);

            if (current.jenis_soal === 'isian_singkat') {
                inputJawabanSingkat.value = current.jawaban_singkat || '';
            } else {
                for (let i = 0; i < 4; i++) {
                    const ansInput = document.getElementById(`ans-text-${i}`);
                    if (ansInput && current.pilihan[i]) {
                        ansInput.value = current.pilihan[i].teks || '';
                    }
                }
                updateCorrectChoiceUI();
            }
        }

        function switchSoal(targetIndex) {
            if (targetIndex === currentIndex) return;
            saveCurrentState();
            currentIndex = targetIndex;
            loadCurrentState();
            renderThumbnails();
        }

        function addSoal() {
            saveCurrentState();
            soalList.push({
                jenis_soal: "kuis",
                tingkat_soal: "sedang",
                pertanyaan: "",
                timer: "20",
                poin: 10,
                jawaban_singkat: "",
                foto_soal: null,
                pilihan: [
                    { label: "A", teks: "", is_correct: 1 },
                    { label: "B", teks: "", is_correct: 0 },
                    { label: "C", teks: "", is_correct: 0 },
                    { label: "D", teks: "", is_correct: 0 },
                ]
            });
            currentIndex = soalList.length - 1;
            loadCurrentState();
            renderThumbnails();
        }

        function deleteSoal(e, idx) {
            e.stopPropagation();
            if (soalList.length <= 1) return;
            if (fotoPreviews[idx] && fotoPreviews[idx].startsWith('blob:')) {
                URL.revokeObjectURL(fotoPreviews[idx]);
            }
            delete fotoFiles[idx];
            delete fotoPreviews[idx];
            soalList.splice(idx, 1);
            if (currentIndex >= soalList.length) currentIndex = soalList.length - 1;
            loadCurrentState();
            renderThumbnails();
        }

        function duplicateSoal(e, idx) {
            e.stopPropagation();
            saveCurrentState();
            const clone = JSON.parse(JSON.stringify(soalList[idx]));
            soalList.splice(idx + 1, 0, clone);
            currentIndex = idx + 1;
            loadCurrentState();
            renderThumbnails();
        }

        function updateLayoutByJenisSoal(jenis) {
            const wrapC = document.getElementById('choice-wrapper-2');
            const wrapD = document.getElementById('choice-wrapper-3');

            if (jenis === 'isian_singkat') {
                choicesGridContainer.classList.add('hidden');
                isianSingkatContainer.classList.remove('hidden');
            } else if (jenis === 'true_false') {
                choicesGridContainer.classList.remove('hidden');
                isianSingkatContainer.classList.add('hidden');
                wrapC.classList.add('hidden');
                wrapD.classList.add('hidden');

                const inp0 = document.getElementById('ans-text-0');
                const inp1 = document.getElementById('ans-text-1');
                if (inp0) { inp0.value = 'Benar'; inp0.readOnly = true; }
                if (inp1) { inp1.value = 'Salah'; inp1.readOnly = true; }
                if (soalList[currentIndex].pilihan[0]) soalList[currentIndex].pilihan[0].teks = 'Benar';
                if (soalList[currentIndex].pilihan[1]) soalList[currentIndex].pilihan[1].teks = 'Salah';
            } else {
                // kuis pilihan ganda
                choicesGridContainer.classList.remove('hidden');
                isianSingkatContainer.classList.add('hidden');
                wrapC.classList.remove('hidden');
                wrapD.classList.remove('hidden');

                const inp0 = document.getElementById('ans-text-0');
                const inp1 = document.getElementById('ans-text-1');
                if (inp0) inp0.readOnly = false;
                if (inp1) inp1.readOnly = false;
            }
        }

        function updateCorrectChoiceUI() {
            const current = soalList[currentIndex];
            if (!current.pilihan) return;

            document.querySelectorAll('.btn-toggle-correct').forEach(btn => {
                const idx = parseInt(btn.dataset.index);
                const isCorrect = current.pilihan[idx] && current.pilihan[idx].is_correct === 1;
                const card = btn.closest('.answer-card');
                const checkIcon = btn.querySelector('.check-icon');

                if (isCorrect) {
                    btn.classList.add('bg-[#26890C]', 'border-[#26890C]');
                    btn.classList.remove('border-gray-300');
                    if (checkIcon) checkIcon.classList.remove('opacity-0');
                    if (card) card.classList.add('is-correct-card');
                } else {
                    btn.classList.remove('bg-[#26890C]', 'border-[#26890C]');
                    btn.classList.add('border-gray-300');
                    if (checkIcon) checkIcon.classList.add('opacity-0');
                    if (card) card.classList.remove('is-correct-card');
                }
            });
        }

        // Toggle Jawaban Benar
        document.querySelectorAll('.btn-toggle-correct').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idx = parseInt(this.dataset.index);
                const current = soalList[currentIndex];

                // Radio single correct choice
                current.pilihan.forEach((p, i) => {
                    p.is_correct = (i === idx) ? 1 : 0;
                });

                updateCorrectChoiceUI();
            });
        });

        // Event Listener Perubahan Inputs
        inputPertanyaan.addEventListener('input', () => {
            soalList[currentIndex].pertanyaan = inputPertanyaan.value;
            renderThumbnails();
        });

        selectJenisSoal.addEventListener('change', () => {
            const jenis = selectJenisSoal.value;
            soalList[currentIndex].jenis_soal = jenis;
            updateLayoutByJenisSoal(jenis);
            renderThumbnails();
        });

        selectTingkatSoal.addEventListener('change', () => {
            soalList[currentIndex].tingkat_soal = selectTingkatSoal.value;
            renderThumbnails();
        });

        selectTimer.addEventListener('change', () => {
            soalList[currentIndex].timer = selectTimer.value;
            renderThumbnails();
        });

        inputPoin.addEventListener('input', () => {
            soalList[currentIndex].poin = parseInt(inputPoin.value) || 0;
        });

        inputJawabanSingkat.addEventListener('input', () => {
            soalList[currentIndex].jawaban_singkat = inputJawabanSingkat.value;
        });

        for (let i = 0; i < 4; i++) {
            const ansInput = document.getElementById(`ans-text-${i}`);
            if (ansInput) {
                ansInput.addEventListener('input', () => {
                    if (soalList[currentIndex].pilihan[i]) {
                        soalList[currentIndex].pilihan[i].teks = ansInput.value;
                    }
                });
            }
        }

        document.getElementById('btn-add-soal').addEventListener('click', addSoal);

        // Submit Handler Form
        document.getElementById('form-soal-bank').addEventListener('submit', function(e) {
            saveCurrentState();

            const selectMapel = document.getElementById('select-mapel');
            if (!selectMapel.value) {
                alert('Harap pilih Mata Pelajaran untuk Bank Soal terlebih dahulu!');
                selectMapel.focus();
                e.preventDefault();
                return;
            }

            let valid = true;
            let firstErrorMsg = '';

            for (let i = 0; i < soalList.length; i++) {
                const s = soalList[i];
                const no = i + 1;

                if (!s.pertanyaan || !s.pertanyaan.trim()) {
                    valid = false;
                    firstErrorMsg = `⚠️ Soal #${no}: Teks pertanyaan wajib diisi!`;
                    currentIndex = i;
                    loadCurrentState();
                    renderThumbnails();
                    break;
                }

                if (s.jenis_soal === 'isian_singkat') {
                    if (!s.jawaban_singkat || !s.jawaban_singkat.trim()) {
                        valid = false;
                        firstErrorMsg = `⚠️ Soal #${no} (Isian Singkat): Kunci jawaban wajib diisi!`;
                        currentIndex = i;
                        loadCurrentState();
                        renderThumbnails();
                        break;
                    }
                } else if (s.jenis_soal === 'kuis') {
                    const hasCorrect = s.pilihan.some(p => p.is_correct === 1);
                    if (!hasCorrect) {
                        valid = false;
                        firstErrorMsg = `⚠️ Soal #${no}: Harap pilih minimal satu kunci jawaban yang benar!`;
                        currentIndex = i;
                        loadCurrentState();
                        renderThumbnails();
                        break;
                    }

                    const opt0 = (s.pilihan[0] && s.pilihan[0].teks || '').trim();
                    const opt1 = (s.pilihan[1] && s.pilihan[1].teks || '').trim();
                    if (!opt0 || !opt1) {
                        valid = false;
                        firstErrorMsg = `⚠️ Soal #${no}: Pilihan jawaban 1 dan 2 wajib diisi!`;
                        currentIndex = i;
                        loadCurrentState();
                        renderThumbnails();
                        break;
                    }
                }
            }

            if (!valid) {
                alert(firstErrorMsg);
                e.preventDefault();
                return;
            }

            // Bangun serialisasi hidden inputs
            hiddenInputs.innerHTML = '';
            soalList.forEach((soal, sIdx) => {
                const addHidden = (name, val) => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = name;
                    inp.value = val;
                    hiddenInputs.appendChild(inp);
                };

                addHidden(`soal[${sIdx}][pertanyaan]`, soal.pertanyaan);
                addHidden(`soal[${sIdx}][jenis_soal]`, soal.jenis_soal);
                addHidden(`soal[${sIdx}][tingkat_soal]`, soal.tingkat_soal || 'sedang');
                addHidden(`soal[${sIdx}][poin]`, soal.poin || 10);
                addHidden(`soal[${sIdx}][durasi_detik]`, soal.timer || 20);

                if (soal.jenis_soal === 'isian_singkat') {
                    addHidden(`soal[${sIdx}][jawaban_singkat]`, soal.jawaban_singkat || '');
                } else {
                    soal.pilihan.forEach((pil, pIdx) => {
                        addHidden(`soal[${sIdx}][pilihan][${pIdx}][label]`, pil.label);
                        addHidden(`soal[${sIdx}][pilihan][${pIdx}][teks_pilihan]`, pil.teks || '');
                        addHidden(`soal[${sIdx}][pilihan][${pIdx}][is_correct]`, pil.is_correct ? 1 : 0);
                    });
                }
            });
        });

        // Filter Mapel berdasarkan Jenjang
        function applyJenjangMapelFilter(jenjangSelect, mapelSelect) {
            if (!jenjangSelect || !mapelSelect) return;
            const jenjangId = parseInt(jenjangSelect.value) || 0;
            const currentVal = mapelSelect.value;
            let currentValid = false;
            const smaOnlyIds = [11, 12, 13];
            const ipaUmumId = 4;

            Array.from(mapelSelect.options).forEach(opt => {
                if (!opt.value) {
                    opt.hidden = false;
                    return;
                }
                const mapelId = parseInt(opt.value);
                const mapelJenjang = opt.getAttribute('data-jenjang') ? parseInt(opt.getAttribute('data-jenjang')) : null;
                const mapelName = (opt.getAttribute('data-name') || opt.text || '').toLowerCase();
                let visible = true;

                const isSmaOnly = mapelJenjang === 3 || smaOnlyIds.includes(mapelId) ||
                    mapelName.includes('fisika') || mapelName.includes('kimia') || mapelName.includes('biologi');
                const isIpaIpsUmum = mapelId === 4 || mapelId === 5 ||
                    mapelName.includes('ilmu pengetahuan alam') || mapelName.includes('ilmu pengetahuan sosial');

                if (jenjangId === 1 || jenjangId === 2) {
                    if (isSmaOnly) visible = false;
                } else if (jenjangId === 3) {
                    if (isIpaIpsUmum) visible = false;
                }

                opt.hidden = !visible;
                opt.disabled = !visible;

                if (opt.value === currentVal && visible) {
                    currentValid = true;
                }
            });

            if (!currentValid && currentVal) {
                mapelSelect.value = '';
            }
        }

        const soalJenjangSelect = document.getElementById('select-jenjang');
        const soalMapelSelect = document.getElementById('select-mapel');
        if (soalJenjangSelect && soalMapelSelect) {
            soalJenjangSelect.addEventListener('change', () => applyJenjangMapelFilter(soalJenjangSelect, soalMapelSelect));
            applyJenjangMapelFilter(soalJenjangSelect, soalMapelSelect);
        }

        // Inisialisasi awal
        loadCurrentState();
        renderThumbnails();
    </script>
</body>

</html>
