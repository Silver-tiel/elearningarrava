<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Quiz Baru — Arrava Editor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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

    <form id="form-quiz" action="{{ route('admin.quiz.store') }}" method="POST" class="h-full flex flex-col">
        @csrf

        {{-- Hidden fields for form submissions --}}
        <input type="hidden" name="id_tipequiz" value="1">
        <input type="hidden" name="id_tingkatquiz" value="1">

        {{-- ==================== TOP BAR ==================== --}}
        <header
            class="h-16 bg-white border-b border-gray-200 px-4 flex items-center justify-between shrink-0 z-30 shadow-sm">
            {{-- Kiri: Logo + Judul --}}
            <div class="flex items-center gap-3">
                <div
                    class="flex items-center bg-[#46178F] text-white px-3 py-1.5 rounded-lg font-black tracking-tight text-lg shadow-sm">
                    <span>Arrava</span>
                    <span
                        class="text-xs bg-yellow-400 text-black px-1.5 py-0.5 rounded ml-1.5 font-bold uppercase">360</span>
                </div>

                <div class="flex items-center bg-gray-100 rounded-lg p-1 border border-gray-200">
                    <input type="text" id="judul-quiz" name="judul" required placeholder="Masukkan judul kuis..."
                        class="bg-transparent px-3 py-1 text-sm font-semibold text-gray-800 placeholder-gray-400 w-48 sm:w-64">
                </div>

                <div class="hidden md:flex items-center gap-1.5 text-xs text-gray-500 ml-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Draf tersimpan</span>
                </div>
            </div>

            {{-- Kanan: Aksi --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.quiz') }}"
                    class="px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    Keluar
                </a>
                <button type="submit" id="btn-submit-form"
                    class="px-5 py-2 text-sm font-bold text-white bg-[#1368CE] hover:bg-[#0B4FB3] rounded-lg shadow-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Quiz
                </button>
            </div>
        </header>

        {{-- ==================== WORKSPACE 3-COLUMN ==================== --}}
        <div class="flex-1 flex overflow-hidden">

            {{-- ===== LEFT SIDEBAR: QUESTION LIST ===== --}}
            <aside class="w-48 bg-white border-r border-gray-200 flex flex-col shrink-0">
                <div
                    class="p-3 text-xs font-bold text-gray-500 border-b border-gray-100 flex justify-between items-center">
                    <span id="total-soal-count">1 Kuis</span>
                </div>

                {{-- Scrollable List Thumbnail --}}
                <div id="thumb-container" class="flex-1 overflow-y-auto p-3 space-y-3">
                    {{-- Generated via JavaScript --}}
                </div>

                {{-- Bottom Buttons --}}
                <div class="p-3 border-t border-gray-200 space-y-2 bg-gray-50">
                    <button type="button" id="btn-add-soal"
                        class="w-full py-2.5 bg-[#1368CE] hover:bg-[#0B4FB3] text-white font-bold text-xs rounded-lg shadow transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Tambahkan Soal
                    </button>
                </div>
            </aside>

            {{-- ===== CENTER CANVAS: QUESTION EDITOR ===== --}}
            <main
                class="flex-1 bg-gradient-to-br from-[#0B4FB3] to-[#1368CE] p-6 flex flex-col justify-between overflow-y-auto relative">

                {{-- Top Question Input Card --}}
                <div class="max-w-4xl w-full mx-auto mb-4">
                    <div class="bg-white rounded-xl shadow-xl p-3 border border-white/20">
                        <input type="text" id="input-pertanyaan" placeholder="Ketikkan pertanyaan Anda di sini..."
                            class="w-full text-center text-lg sm:text-xl font-bold text-gray-800 placeholder-gray-400 py-3 px-4 bg-gray-50 rounded-lg focus:bg-white transition border border-transparent focus:border-blue-400">
                    </div>
                </div>

                {{-- Center Media Upload Card --}}
                <div class="max-w-md w-full mx-auto my-auto py-4">
                    <div
                        class="bg-white/80 backdrop-blur rounded-2xl p-6 border-2 border-dashed border-white/60 flex flex-col items-center justify-center shadow-2xl hover:bg-white transition group cursor-pointer">
                        <div
                            class="w-16 h-16 bg-white rounded-xl shadow-md flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-[#1368CE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-[#0A3875] underline hover:text-[#1368CE]">Unggah file
                            gambar/media</span>
                        <span class="text-xs text-gray-500 mt-1">atau tarik file ke sini</span>
                    </div>
                </div>

                {{-- Bottom Area: Pilihan Ganda OR Isian Singkat Container --}}
                <div class="max-w-5xl w-full mx-auto">
                    
                    {{-- 1. Container Pilihan Ganda (Kahoot 4 Choices) --}}
                    <div id="choices-grid-container">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">

                            {{-- Choice 1: Red Triangle --}}
                            <div
                                class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div
                                    class="w-12 h-12 bg-[#E21B3C] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2L2 19h20L12 2z" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-0" placeholder="Tambahkan jawaban 1"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                {{-- Correct Radio Toggle --}}
                                <button type="button" data-index="0"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 2: Blue Diamond --}}
                            <div
                                class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div
                                    class="w-12 h-12 bg-[#1368CE] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="4" y="4" width="16" height="16" transform="rotate(45 12 12)" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-1" placeholder="Tambahkan jawaban 2"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="1"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 3: Yellow Circle --}}
                            <div id="choice-wrapper-2"
                                class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div
                                    class="w-12 h-12 bg-[#D89E00] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-2" placeholder="Tambahkan jawaban 3 (opsional)"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="2"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Choice 4: Green Square --}}
                            <div id="choice-wrapper-3"
                                class="answer-card bg-white rounded-xl shadow-lg overflow-hidden flex items-center border-2 border-transparent p-1.5 relative group">
                                <div
                                    class="w-12 h-12 bg-[#26890C] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="4" y="4" width="16" height="16" />
                                    </svg>
                                </div>
                                <input type="text" id="ans-text-3" placeholder="Tambahkan jawaban 4 (opsional)"
                                    class="flex-1 px-3 py-2 text-sm font-bold text-gray-800 placeholder-gray-400 bg-transparent">

                                <button type="button" data-index="3"
                                    class="btn-toggle-correct w-8 h-8 rounded-full border-2 border-gray-300 hover:border-[#26890C] flex items-center justify-center transition mr-1 shrink-0">
                                    <svg class="w-5 h-5 text-white opacity-0 check-icon" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- 2. Container Isian Singkat (Short Answer Input) --}}
                    <div id="isian-singkat-container" class="hidden bg-white rounded-2xl p-5 shadow-2xl border-2 border-emerald-400">
                        <label class="block text-xs font-extrabold text-emerald-800 mb-2 flex items-center gap-1.5 uppercase tracking-wider">
                            <span>✏️</span> Kunci Jawaban Isian Singkat:
                        </label>
                        <input type="text" id="input-jawaban-singkat" placeholder="Ketikkan kunci jawaban yang benar di sini..."
                            class="w-full bg-emerald-50 text-emerald-950 font-bold text-base px-4 py-3 rounded-xl border border-emerald-300 focus:bg-white focus:border-emerald-500 transition">
                        <p class="text-xs text-slate-500 mt-2 font-medium">Siswa akan menjawab dengan mengetikkan teks. Jawaban akan dinilai berdasarkan kecocokan teks ini.</p>
                    </div>

                </div>

            </main>

            {{-- ===== RIGHT SIDEBAR: PROPERTIES PANEL ===== --}}
            <aside class="w-80 bg-white border-l border-gray-200 flex flex-col justify-between shrink-0">
                <div class="overflow-y-auto flex-1">
                    {{-- Header panel --}}
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#1368CE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Properti Quiz & Soal
                        </h3>
                    </div>

                    {{-- Form Controls --}}
                    <div class="p-4 space-y-5">

                        {{-- 1. JENJANG QUIZ (WAJIB) --}}
                        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
                            <label class="block text-xs font-bold text-indigo-900 mb-1.5 flex items-center gap-1.5">
                                <span>🎓</span> Jenjang Quiz <span class="text-red-500 font-extrabold">*</span>
                            </label>
                            <select name="id_jenjang" id="select-jenjang" required
                                class="w-full bg-white border border-indigo-200 rounded-lg px-3 py-2 text-xs font-bold text-indigo-950 focus:ring-2 focus:ring-indigo-500">
                                <option value="" disabled selected>-- Pilih Jenjang (Wajib) --</option>
                                @if(isset($jenjangList) && count($jenjangList) > 0)
                                    @foreach($jenjangList as $j)
                                        <option value="{{ $j->id_jenjang }}">{{ $j->nama_tipe }}</option>
                                    @endforeach
                                @else
                                    <option value="1">SD / Sederajat</option>
                                    <option value="2">SMP / Sederajat</option>
                                    <option value="3">SMA / SMK / Sederajat</option>
                                    <option value="4">Umum / Perguruan Tinggi</option>
                                @endif
                            </select>
                        </div>

                        {{-- 2. WAKTU KADALUARSA (BISA TIDAK PERNAH) --}}
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <span>⏳</span> Waktu Kadaluarsa Quiz
                            </label>
                            
                            <div class="flex items-center gap-2 mb-2">
                                <input type="checkbox" id="check-no-expiry" checked class="w-4 h-4 text-blue-600 rounded">
                                <label for="check-no-expiry" class="text-xs font-semibold text-slate-700 cursor-pointer">
                                    Tidak Pernah Kadaluarsa
                                </label>
                            </div>

                            <div id="expiry-input-wrapper" class="hidden">
                                <input type="datetime-local" id="input-expiry" name="waktu_kadaluarsa"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-800">
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        {{-- 3. JENIS SOAL (Kuis, Benar/Salah, Isian Singkat) --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center gap-1.5">
                                <span>❓</span> Jenis soal
                            </label>
                            <select id="select-jenis-soal"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800">
                                <option value="kuis">Kuis (Pilihan Ganda)</option>
                                <option value="true_false">Benar atau Salah</option>
                                <option value="isian_singkat">Isian Singkat</option>
                            </select>
                        </div>

                        {{-- Batas Waktu --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center gap-1.5">
                                <span>⏱️</span> Batas waktu
                            </label>
                            <select id="select-timer"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800">
                                <option value="10">10 detik</option>
                                <option value="20" selected>20 detik</option>
                                <option value="30">30 detik</option>
                                <option value="60">1 menit</option>
                            </select>
                        </div>

                        {{-- Poin --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center gap-1.5">
                                <span>🎖️</span> Poin
                            </label>
                            <select
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800">
                                <option value="standard">Standar</option>
                                <option value="double">Ganda</option>
                                <option value="zero">Tanpa Poin</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Action Footer Buttons --}}
                <div class="p-4 border-t border-gray-200 grid grid-cols-2 gap-2 bg-gray-50">
                    <button type="button" id="btn-delete-soal"
                        class="py-2 px-3 bg-gray-200 hover:bg-red-100 hover:text-red-700 text-gray-700 font-bold text-xs rounded-lg transition text-center">
                        Hapus Soal
                    </button>
                    <button type="button" id="btn-duplicate-soal"
                        class="py-2 px-3 bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-bold text-xs rounded-lg transition text-center shadow-sm">
                        Gandakan
                    </button>
                </div>
            </aside>

        </div>

        {{-- Container tersembunyi untuk input soal yang akan dikirim saat submit form --}}
        <div id="hidden-inputs-container"></div>
    </form>

    {{-- ==================== JAVASCRIPT STATE & EVENT LOGIC ==================== --}}
    <script>
        // Data State Soal
        let soalList = [
            {
                jenis_soal: "kuis",
                pertanyaan: "",
                timer: "20",
                jawaban_singkat: "",
                pilihan: [
                    { label: "A", teks: "", is_correct: 0 },
                    { label: "B", teks: "", is_correct: 0 },
                    { label: "C", teks: "", is_correct: 0 },
                    { label: "D", teks: "", is_correct: 0 },
                ]
            }
        ];
        let currentIndex = 0;

        // Element references
        const thumbContainer = document.getElementById('thumb-container');
        const inputPertanyaan = document.getElementById('input-pertanyaan');
        const selectJenisSoal = document.getElementById('select-jenis-soal');
        const selectTimer = document.getElementById('select-timer');
        const countBadge = document.getElementById('total-soal-count');
        const hiddenInputs = document.getElementById('hidden-inputs-container');

        const choicesGridContainer = document.getElementById('choices-grid-container');
        const isianSingkatContainer = document.getElementById('isian-singkat-container');
        const inputJawabanSingkat = document.getElementById('input-jawaban-singkat');
        
        const checkNoExpiry = document.getElementById('check-no-expiry');
        const expiryInputWrapper = document.getElementById('expiry-input-wrapper');
        const inputExpiry = document.getElementById('input-expiry');

        // Toggle Expiry Input
        checkNoExpiry.addEventListener('change', () => {
            if (checkNoExpiry.checked) {
                expiryInputWrapper.classList.add('hidden');
                inputExpiry.value = '';
            } else {
                expiryInputWrapper.classList.remove('hidden');
            }
        });

        // Render Thumbnails pada sidebar
        function renderThumbnails() {
            thumbContainer.innerHTML = '';
            countBadge.innerText = `${soalList.length} Kuis`;

            soalList.forEach((soal, idx) => {
                const isActive = idx === currentIndex;
                const card = document.createElement('div');
                card.className = `thumb-card p-2 rounded-lg bg-gray-50 border border-gray-200 cursor-pointer relative group transition ${isActive ? 'active' : 'hover:bg-gray-100'}`;

                let badgeJenis = 'Kuis';
                if (soal.jenis_soal === 'true_false') badgeJenis = 'B/S';
                if (soal.jenis_soal === 'isian_singkat') badgeJenis = 'Isian';

                card.innerHTML = `
                    <div class="flex items-center justify-between text-[10px] font-bold text-gray-500 mb-1">
                        <span>${idx + 1}. ${badgeJenis}</span>
                        <span>⏱️ ${soal.timer}s</span>
                    </div>
                    <div class="h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded p-1.5 flex flex-col justify-between shadow-inner">
                        <div class="bg-white/90 rounded text-[9px] font-bold text-gray-700 px-1 truncate">
                            ${soal.pertanyaan || 'Pertanyaan...'}
                        </div>
                        <div class="grid grid-cols-4 gap-0.5">
                            <div class="h-1 rounded-sm ${soal.pilihan[0] && soal.pilihan[0].is_correct ? 'bg-emerald-400' : 'bg-red-400'}"></div>
                            <div class="h-1 rounded-sm ${soal.pilihan[1] && soal.pilihan[1].is_correct ? 'bg-emerald-400' : 'bg-blue-400'}"></div>
                            <div class="h-1 rounded-sm ${soal.pilihan[2] && soal.pilihan[2].is_correct ? 'bg-emerald-400' : 'bg-yellow-400'}"></div>
                            <div class="h-1 rounded-sm ${soal.pilihan[3] && soal.pilihan[3].is_correct ? 'bg-emerald-400' : 'bg-green-400'}"></div>
                        </div>
                    </div>
                `;

                card.addEventListener('click', () => {
                    saveCurrentState();
                    currentIndex = idx;
                    loadCurrentState();
                    renderThumbnails();
                });

                thumbContainer.appendChild(card);
            });
        }

        // Simpan state aktif dari form ke array JS
        function saveCurrentState() {
            if (!soalList[currentIndex]) return;

            soalList[currentIndex].pertanyaan = inputPertanyaan.value;
            soalList[currentIndex].timer = selectTimer.value;
            soalList[currentIndex].jenis_soal = selectJenisSoal.value;
            soalList[currentIndex].jawaban_singkat = inputJawabanSingkat.value;

            for (let i = 0; i < 4; i++) {
                const ansInput = document.getElementById(`ans-text-${i}`);
                if (ansInput && soalList[currentIndex].pilihan[i]) {
                    soalList[currentIndex].pilihan[i].teks = ansInput.value;
                }
            }
        }

        // Load data state aktif ke UI form
        function loadCurrentState() {
            const currentSoal = soalList[currentIndex];
            if (!currentSoal) return;

            inputPertanyaan.value = currentSoal.pertanyaan || '';
            selectTimer.value = currentSoal.timer || '20';
            selectJenisSoal.value = currentSoal.jenis_soal || 'kuis';
            inputJawabanSingkat.value = currentSoal.jawaban_singkat || '';

            // Handle UI per Jenis Soal
            if (currentSoal.jenis_soal === 'isian_singkat') {
                choicesGridContainer.classList.add('hidden');
                isianSingkatContainer.classList.remove('hidden');
            } else if (currentSoal.jenis_soal === 'true_false') {
                choicesGridContainer.classList.remove('hidden');
                isianSingkatContainer.classList.add('hidden');
                document.getElementById('choice-wrapper-2').classList.add('hidden');
                document.getElementById('choice-wrapper-3').classList.add('hidden');
                document.getElementById('ans-text-0').value = 'Benar';
                document.getElementById('ans-text-1').value = 'Salah';
            } else {
                choicesGridContainer.classList.remove('hidden');
                isianSingkatContainer.classList.add('hidden');
                document.getElementById('choice-wrapper-2').classList.remove('hidden');
                document.getElementById('choice-wrapper-3').classList.remove('hidden');
            }

            if (currentSoal.jenis_soal !== 'isian_singkat') {
                currentSoal.pilihan.forEach((pil, i) => {
                    const ansInput = document.getElementById(`ans-text-${i}`);
                    const btnToggle = document.querySelector(`.btn-toggle-correct[data-index="${i}"]`);
                    if (!btnToggle) return;
                    const card = btnToggle.closest('.answer-card');
                    const checkIcon = btnToggle.querySelector('.check-icon');

                    if (ansInput) ansInput.value = pil.teks || '';

                    if (pil.is_correct === 1) {
                        card.classList.add('is-correct-card');
                        btnToggle.classList.add('bg-[#26890C]', 'border-[#26890C]');
                        checkIcon.classList.remove('opacity-0');
                    } else {
                        card.classList.remove('is-correct-card');
                        btnToggle.classList.remove('bg-[#26890C]', 'border-[#26890C]');
                        checkIcon.classList.add('opacity-0');
                    }
                });
            }
        }

        // Toggle Jenis Soal
        selectJenisSoal.addEventListener('change', () => {
            const val = selectJenisSoal.value;
            soalList[currentIndex].jenis_soal = val;
            if (val === 'true_false') {
                soalList[currentIndex].pilihan[0].teks = 'Benar';
                soalList[currentIndex].pilihan[1].teks = 'Salah';
            }
            loadCurrentState();
            renderThumbnails();
        });

        // Toggle Jawaban Benar
        document.querySelectorAll('.btn-toggle-correct').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const idx = parseInt(btn.dataset.index);

                // Set only this answer as correct
                soalList[currentIndex].pilihan.forEach((p, i) => {
                    p.is_correct = (i === idx) ? (p.is_correct === 1 ? 0 : 1) : 0;
                });

                loadCurrentState();
                renderThumbnails();
            });
        });

        // Event listeners input real-time sync to thumbnail
        inputPertanyaan.addEventListener('input', () => {
            soalList[currentIndex].pertanyaan = inputPertanyaan.value;
            renderThumbnails();
        });

        selectTimer.addEventListener('change', () => {
            soalList[currentIndex].timer = selectTimer.value;
            renderThumbnails();
        });

        inputJawabanSingkat.addEventListener('input', () => {
            soalList[currentIndex].jawaban_singkat = inputJawabanSingkat.value;
        });

        for (let i = 0; i < 4; i++) {
            const el = document.getElementById(`ans-text-${i}`);
            if (el) {
                el.addEventListener('input', (e) => {
                    soalList[currentIndex].pilihan[i].teks = e.target.value;
                });
            }
        }

        // Tombol Tambah Soal
        document.getElementById('btn-add-soal').addEventListener('click', () => {
            saveCurrentState();
            soalList.push({
                jenis_soal: "kuis",
                pertanyaan: "",
                timer: "20",
                jawaban_singkat: "",
                pilihan: [
                    { label: "A", teks: "", is_correct: 0 },
                    { label: "B", teks: "", is_correct: 0 },
                    { label: "C", teks: "", is_correct: 0 },
                    { label: "D", teks: "", is_correct: 0 },
                ]
            });
            currentIndex = soalList.length - 1;
            loadCurrentState();
            renderThumbnails();
        });

        // Tombol Hapus Soal
        document.getElementById('btn-delete-soal').addEventListener('click', () => {
            if (soalList.length <= 1) {
                alert('Quiz minimal harus memiliki 1 soal!');
                return;
            }
            soalList.splice(currentIndex, 1);
            if (currentIndex >= soalList.length) {
                currentIndex = soalList.length - 1;
            }
            loadCurrentState();
            renderThumbnails();
        });

        // Tombol Gandakan Soal
        document.getElementById('btn-duplicate-soal').addEventListener('click', () => {
            saveCurrentState();
            const copy = JSON.parse(JSON.stringify(soalList[currentIndex]));
            soalList.splice(currentIndex + 1, 0, copy);
            currentIndex++;
            loadCurrentState();
            renderThumbnails();
        });

        // Prepare Submit Form (Populate hidden inputs)
        document.getElementById('form-quiz').addEventListener('submit', (e) => {
            saveCurrentState();

            // Check Jenjang
            const selectJenjang = document.getElementById('select-jenjang');
            if (!selectJenjang.value) {
                alert('Harap pilih Jenjang Quiz terlebih dahulu!');
                selectJenjang.focus();
                e.preventDefault();
                return;
            }

            // Check Judul
            const judul = document.getElementById('judul-quiz').value.trim();
            if (!judul) {
                alert('Harap isi judul kuis!');
                e.preventDefault();
                return;
            }

            let valid = true;
            soalList.forEach((s, i) => {
                if (!s.pertanyaan.trim()) {
                    alert(`Soal #${i + 1} belum memiliki teks pertanyaan!`);
                    valid = false;
                    return;
                }
                if (s.jenis_soal === 'isian_singkat') {
                    if (!s.jawaban_singkat.trim()) {
                        alert(`Soal #${i + 1} (Isian Singkat) belum diisi kunci jawabannya!`);
                        valid = false;
                        return;
                    }
                } else {
                    const hasCorrect = s.pilihan.some(p => p.is_correct === 1);
                    if (!hasCorrect) {
                        alert(`Soal #${i + 1} belum memilih jawaban yang benar! Klik tombol lingkaran hijau pada pilihan jawaban.`);
                        valid = false;
                        return;
                    }
                }
            });

            if (!valid) {
                e.preventDefault();
                return;
            }

            // Generate hidden input fields
            hiddenInputs.innerHTML = '';
            soalList.forEach((soal, sIdx) => {
                // Input Jenis Soal
                const inputJenis = document.createElement('input');
                inputJenis.type = 'hidden';
                inputJenis.name = `soal[${sIdx}][jenis_soal]`;
                inputJenis.value = soal.jenis_soal;
                hiddenInputs.appendChild(inputJenis);

                // Input Pertanyaan
                const inputP = document.createElement('input');
                inputP.type = 'hidden';
                inputP.name = `soal[${sIdx}][pertanyaan]`;
                inputP.value = soal.pertanyaan;
                hiddenInputs.appendChild(inputP);

                if (soal.jenis_soal === 'isian_singkat') {
                    const inputSingkat = document.createElement('input');
                    inputSingkat.type = 'hidden';
                    inputSingkat.name = `soal[${sIdx}][jawaban_singkat]`;
                    inputSingkat.value = soal.jawaban_singkat;
                    hiddenInputs.appendChild(inputSingkat);
                } else {
                    // Input Pilihan
                    soal.pilihan.forEach((pil, pIdx) => {
                        const inputLabel = document.createElement('input');
                        inputLabel.type = 'hidden';
                        inputLabel.name = `soal[${sIdx}][pilihan][${pIdx}][label]`;
                        inputLabel.value = pil.label;
                        hiddenInputs.appendChild(inputLabel);

                        const inputTeks = document.createElement('input');
                        inputTeks.type = 'hidden';
                        inputTeks.name = `soal[${sIdx}][pilihan][${pIdx}][teks_pilihan]`;
                        inputTeks.value = pil.teks;
                        hiddenInputs.appendChild(inputTeks);

                        const inputCorrect = document.createElement('input');
                        inputCorrect.type = 'hidden';
                        inputCorrect.name = `soal[${sIdx}][pilihan][${pIdx}][is_correct]`;
                        inputCorrect.value = pil.is_correct;
                        hiddenInputs.appendChild(inputCorrect);
                    });
                }
            });
        });

        // Init
        loadCurrentState();
        renderThumbnails();
    </script>
</body>

</html>