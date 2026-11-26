@extends('layouts.app')

@section('title', 'Bank Soal - Arrava')

@section('header')
    {{-- Header / Topbar Quiz & Bank Soal --}}
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="min-w-0 hidden md:block">
            <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
                Bank Soal Pembelajaran
            </h1>
            <p class="text-xs text-slate-500 truncate">
                Koleksi dan repositori soal mandiri untuk kuis dan evaluasi
            </p>
        </div>

        <x-quiz-header-tabs />
    </div>
@endsection

@section('content')
    <main class="px-6 lg:px-8 py-8">
        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-[#007FBE] border border-[#B2E7FC] text-xs font-extrabold mb-2">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Repositori Soal & Dungeon</span>
                </div>
                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-900">
                    Bank Soal
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola soal mandiri (Bank Soal) dan soal pada kuis. Anda dapat menyalin soal bank ke kuis atau menyalin soal kuis ke bank soal kapan saja.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" id="openImportCsvModalBtn"
                    class="inline-flex items-center justify-center gap-1.5 bg-white hover:bg-emerald-50 text-emerald-700 border-2 border-emerald-200 font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-[0_2px_0_#a7f3d0] transition hover:-translate-y-0.5 cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3" />
                    </svg>
                    <span>Impor CSV</span>
                </button>
                <button type="button" id="openExportPreviewModalBtn"
                    class="inline-flex items-center justify-center gap-1.5 bg-white hover:bg-sky-50 text-[#007FBE] border-2 border-[#B2E7FC] font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-[0_2px_0_#B2E7FC] transition hover:-translate-y-0.5 cursor-pointer"
                    title="Pratinjau data dan unduh soal ke Excel/CSV">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M17 8l-5-5m0 0L7 8m5-5v12" />
                    </svg>
                    <span>Ekspor CSV</span>
                </button>
                <a href="{{ route('soal.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-[#007FBE] hover:bg-[#00689E] text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-[0_3px_0_#005580] transition hover:-translate-y-0.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Soal Baru</span>
                </a>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg cursor-pointer" aria-label="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />
                    </svg>
                    <span class="font-semibold text-sm">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg cursor-pointer" aria-label="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if(isset($bankStats))
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="bg-white rounded-2xl border-2 border-[#E6F1FC] p-4 shadow-2xs flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bank Mandiri</div>
                        <div class="text-xl font-black text-slate-900 leading-tight">{{ $bankStats['bank_mandiri'] ?? 0 }}</div>
                        <div class="text-[11px] font-semibold text-slate-500 truncate">{{ $bankStats['bank_umum'] ?? 0 }} soal umum</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border-2 border-[#E6F1FC] p-4 shadow-2xs flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Khusus Ujian</div>
                        <div class="text-xl font-black text-amber-700 leading-tight">{{ $bankStats['bank_ujian'] ?? 0 }}</div>
                        <div class="text-[11px] font-semibold text-slate-500 truncate">Terpisah dari Dungeon</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border-2 border-[#E6F1FC] p-4 shadow-2xs flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-[#007FBE] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Dipakai</div>
                        <div class="text-xl font-black text-[#007FBE] leading-tight">{{ $bankStats['belum_dipakai'] ?? 0 }}</div>
                        <div class="text-[11px] font-semibold text-slate-500 truncate">Siap dipilih ke kuis</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border-2 border-[#E6F1FC] p-4 shadow-2xs flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sebaran Tingkat</div>
                        <div class="flex items-center gap-2 text-[11px] font-extrabold text-slate-700 flex-wrap">
                            <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>{{ $bankStats['mudah'] ?? 0 }}</span>
                            <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span>{{ $bankStats['sedang'] ?? 0 }}</span>
                            <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span>{{ $bankStats['sulit'] ?? 0 }}</span>
                        </div>
                        <div class="text-[10px] font-semibold text-slate-400 mt-0.5 truncate">Mudah · Sedang · Sulit</div>
                    </div>
                </div>
            </section>
        @endif

        @php
            $currentSumber = request('sumber', 'all');
            $currentMapel = request('mapel_id', 'all');
            $currentJenis = request('jenis_soal', 'all');
            $currentTingkat = request('tingkat_soal', 'all');
            $currentJenjang = request('jenjang_id', 'all');
            $currentKategori = request('kategori_bank', 'all');
            $currentStatusPakai = request('status_pakai', 'all');
            $currentQuery = request('q', '');

            $isFiltered = $currentSumber !== 'all'
                || ($currentMapel !== 'all' && !empty($currentMapel))
                || $currentJenis !== 'all'
                || $currentTingkat !== 'all'
                || ($currentJenjang !== 'all' && !empty($currentJenjang))
                || $currentKategori !== 'all'
                || $currentStatusPakai !== 'all'
                || $currentQuery !== '';

            // Filter Chips Sumber
            $sourceFilterChips = [
                ['value' => 'all', 'label' => 'Semua Sumber', 'active' => $currentSumber === 'all'],
                ['value' => 'bank', 'label' => 'Bank Soal Saja', 'active' => $currentSumber === 'bank'],
                ['value' => 'quiz', 'label' => 'Terkait Kuis', 'active' => $currentSumber === 'quiz'],
            ];

            // Filter Chips Peruntukan Bank
            $kategoriFilterChips = [
                ['value' => 'all', 'label' => 'Semua Peruntukan', 'active' => $currentKategori === 'all'],
                ['value' => 'umum', 'label' => 'Umum / Latihan', 'active' => $currentKategori === 'umum'],
                ['value' => 'ujian', 'label' => 'Khusus Ujian', 'active' => $currentKategori === 'ujian'],
            ];

            // Filter Chips Pemakaian
            $pakaiFilterChips = [
                ['value' => 'all', 'label' => 'Semua Status', 'active' => $currentStatusPakai === 'all'],
                ['value' => 'unused', 'label' => 'Belum Dipakai', 'active' => $currentStatusPakai === 'unused'],
                ['value' => 'used', 'label' => 'Sudah Dipakai', 'active' => $currentStatusPakai === 'used'],
            ];

            // Filter Chips Tipe Soal
            $soalFilterChips = [
                ['value' => 'all', 'label' => 'Semua Tipe', 'active' => $currentJenis === 'all'],
                ['value' => 'pilihan_ganda', 'label' => 'Pilihan Ganda', 'active' => $currentJenis === 'pilihan_ganda'],
                ['value' => 'benar_salah', 'label' => 'Benar/Salah', 'active' => $currentJenis === 'benar_salah'],
                ['value' => 'isian', 'label' => 'Isian Singkat', 'active' => $currentJenis === 'isian'],
                ['value' => 'bergambar', 'label' => 'Bergambar', 'active' => $currentJenis === 'bergambar'],
            ];

            // Filter Chips Tingkat Kesulitan
            $tingkatFilterChips = [
                ['value' => 'all', 'label' => 'Semua Tingkat', 'active' => $currentTingkat === 'all'],
                ['value' => 'mudah', 'label' => 'Mudah', 'active' => $currentTingkat === 'mudah'],
                ['value' => 'sedang', 'label' => 'Sedang', 'active' => $currentTingkat === 'sedang'],
                ['value' => 'sulit', 'label' => 'Sulit', 'active' => $currentTingkat === 'sulit'],
            ];

            // Filter Chips Jenjang
            $jenjangChips = [
                ['value' => 'all', 'label' => 'Semua Jenjang', 'active' => $currentJenjang === 'all']
            ];
            if (isset($jenjangList)) {
                foreach ($jenjangList as $j) {
                    $jenjangChips[] = [
                        'value' => (string) $j->id_jenjang,
                        'label' => $j->nama_tipe ?? $j->nama_jenjang,
                        'active' => (string) $currentJenjang === (string) $j->id_jenjang,
                    ];
                }
            }

            $countDisplay = isset($totalFiltered) ? $totalFiltered : $soals->total();
        @endphp

        {{-- FORM FILTER & SEARCH GAYA SISWA ARRAVA --}}
        <form method="GET" action="{{ route('admin.soal') }}" id="soalFilterForm">
            {{-- Hidden inputs to store active filter chip values --}}
            <input type="hidden" name="sumber" id="filterInputSumber" value="{{ $currentSumber }}">
            <input type="hidden" name="jenis_soal" id="filterInputJenis" value="{{ $currentJenis }}">
            <input type="hidden" name="tingkat_soal" id="filterInputTingkat" value="{{ $currentTingkat }}">
            <input type="hidden" name="jenjang_id" id="filterInputJenjang" value="{{ $currentJenjang }}">
            <input type="hidden" name="kategori_bank" id="filterInputKategori" value="{{ $currentKategori }}">
            <input type="hidden" name="status_pakai" id="filterInputStatusPakai" value="{{ $currentStatusPakai }}">

            <x-student-style-filter-bar
                class="mb-6"
                title="Filter & Pencarian Bank Soal"
                count-id="soal-count-badge"
                :count-text="'Menampilkan ' . $soals->count() . ' dari ' . $countDisplay . ' soal'"
                search-id="soalSearchInput"
                search-name="q"
                search-value="{{ $currentQuery }}"
                search-placeholder="Cari pertanyaan, kode soal, mapel, atau kunci jawaban..."
                reset-id="soalResetBtn"
                reset-url="{{ route('admin.soal') }}"
                :show-reset="$isFiltered">

                {{-- Row Filter 1: Dropdown Mapel & Chips Sumber --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1 border-t border-sky-100/60">
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-[#465673] shrink-0">Mapel:</span>
                        <select name="mapel_id" id="soalMapelSelect"
                            class="px-3 py-1.5 rounded-xl border border-[#DCEFFF] bg-white text-xs font-bold text-slate-700 focus:outline-none focus:border-[#007FBE] shadow-2xs cursor-pointer">
                            <option value="all" @selected($currentMapel === 'all' || empty($currentMapel))>-- Semua Mata Pelajaran --</option>
                            @if(isset($mapelList))
                                @foreach($mapelList as $mpl)
                                    <option value="{{ $mpl->id_mapel }}" @selected((string)$currentMapel === (string)$mpl->id_mapel)>
                                        {{ $mpl->nama_mapel }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <x-student-style-filter-chip-bar
                        id="soalSourceFilterChips"
                        label="Sumber"
                        :chips="$sourceFilterChips" />
                </div>

                {{-- Row Filter 2: Chips Tipe Soal & Tingkat Kesulitan --}}
                <div class="space-y-2 pt-1 border-t border-sky-100/60">
                    <x-student-style-filter-chip-bar
                        id="soalTypeFilterChips"
                        label="Tipe Soal"
                        :chips="$soalFilterChips" />

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-wrap">
                        <x-student-style-filter-chip-bar
                            id="soalTingkatFilterChips"
                            label="Tingkat"
                            :chips="$tingkatFilterChips" />

                        <x-student-style-filter-chip-bar
                            id="soalKategoriFilterChips"
                            label="Peruntukan"
                            :chips="$kategoriFilterChips" />

                        <x-student-style-filter-chip-bar
                            id="soalStatusPakaiFilterChips"
                            label="Pemakaian"
                            :chips="$pakaiFilterChips" />

                        @if(count($jenjangChips) > 1)
                            <x-student-style-filter-chip-bar
                                id="soalJenjangFilterChips"
                                label="Jenjang"
                                :chips="$jenjangChips" />
                        @endif
                    </div>
                </div>
            </x-student-style-filter-bar>
        </form>

        @if($soals->isEmpty())
            <div class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center shadow-xs">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-sky-50 text-[#007FBE] flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-800">
                    {{ $isFiltered ? 'Tidak ada soal yang cocok dengan filter' : 'Belum Ada Soal di Bank Soal' }}
                </h3>
                <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                    {{ $isFiltered ? 'Silakan ubah filter atau kata kunci pencarian Anda untuk melihat pertanyaan lainnya.' : 'Tambahkan pertanyaan baru ke Bank Soal agar siap digunakan dalam kuis siswa maupun tantangan dungeon.' }}
                </p>
                <div class="mt-5 flex items-center justify-center gap-3">
                    @if($isFiltered)
                        <a href="{{ route('admin.soal') }}"
                            class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>Reset Semua Filter</span>
                        </a>
                    @endif
                    <a href="{{ route('soal.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#007FBE] text-white font-bold text-sm hover:bg-[#00689E] transition">
                        <span>+ Tambah Soal Baru</span>
                    </a>
                </div>
            </div>
        @else
            {{-- Select All & Ringkasan Halaman --}}
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2 px-1">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none text-xs font-extrabold text-slate-600 hover:text-[#007FBE] transition">
                    <input type="checkbox" id="selectAllSoalCheckbox" class="rounded text-[#007FBE] focus:ring-0 w-4 h-4 cursor-pointer">
                    <span>Pilih Semua di Halaman Ini ({{ $soals->count() }} soal)</span>
                </label>
                <span class="text-xs font-semibold text-slate-400">
                    Menampilkan {{ $soals->firstItem() ?? 0 }}–{{ $soals->lastItem() ?? 0 }} dari {{ $soals->total() }} total soal
                </span>
            </div>

            {{-- Batch Actions Bar (Muncul saat ada checkbox dicentang) --}}
            <div id="batchActionBar" class="hidden mb-4 p-4 rounded-2xl bg-gradient-to-r from-sky-600 to-[#007FBE] text-white flex flex-wrap items-center justify-between gap-3 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold" id="batchCountText">0 soal dipilih</p>
                        <p class="text-xs text-sky-100">Pilih aksi massal untuk soal-soal terpilih</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" id="openBatchCopyToBankBtn"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        <span>Salin ke Bank</span>
                    </button>
                    <button type="button" id="openBatchAssignModalBtn"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white text-[#007FBE] hover:bg-sky-50 font-extrabold text-xs shadow transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Masukkan ke Kuis</span>
                    </button>
                    <button type="button" id="openBatchUpdateModalBtn"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-xs shadow transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>Ubah Mapel / Tingkat</span>
                    </button>
                    <button type="button" id="openBatchDeleteBtn"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-extrabold text-xs shadow transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Terpilih</span>
                    </button>
                    <button type="button" id="clearBatchSelectionBtn"
                        class="px-3 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>

            <div id="soalCardsContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach ($soals as $soal)
                    @php
                        $isBank = is_null($soal->id_quiz);
                        $rawJenis = strtolower(trim((string) ($soal->jenisSoal?->nama_jenis ?? '')));
                        $idJenis = (int) ($soal->id_jenis_soal ?? 0);

                        if (str_contains($rawJenis, 'benar') || str_contains($rawJenis, 'true_false') || str_contains($rawJenis, 'salah') || $idJenis === 3) {
                            $jenisSlug = 'benar_salah';
                            $jenisLabel = 'Benar/Salah';
                            $jenisBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                        } elseif (str_contains($rawJenis, 'isian') || str_contains($rawJenis, 'essay') || $idJenis === 2) {
                            $jenisSlug = 'isian';
                            $jenisLabel = 'Isian Singkat';
                            $jenisBadgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                        } else {
                            $jenisSlug = 'pilihan_ganda';
                            $jenisLabel = 'Pilihan Ganda';
                            $jenisBadgeClass = 'bg-sky-50 text-[#007FBE] border-[#B2E7FC]';
                        }

                        $tingkatSlug = (!empty($soal->tingkat_soal)) ? strtolower(trim($soal->tingkat_soal)) : 'sedang';
                        $tingkatLabel = match ($tingkatSlug) {
                            'mudah' => 'Mudah',
                            'sulit' => 'Sulit',
                            default => 'Sedang',
                        };
                        $tingkatDotClass = match ($tingkatSlug) {
                            'mudah' => 'bg-emerald-500',
                            'sulit' => 'bg-rose-500',
                            default => 'bg-amber-500',
                        };

                        $hasImage = !empty($soal->foto_soal);
                        $mapelObj = $soal->mapel ?? $soal->quiz?->mapel;
                        $mapelId = (string) ($soal->id_mapel ?? $soal->quiz?->id_mapel ?? '');
                        $mapelLabel = $mapelObj?->nama_mapel ?? 'Semua Mapel';

                        $jenjangObj = $soal->jenjang ?? $soal->quiz?->jenjang;
                        $jenjangId = (string) ($soal->id_jenjang ?? $soal->quiz?->id_jenjang ?? '');
                        $jenjangLabel = $jenjangObj?->nama_tipe ?? $jenjangObj?->nama_jenjang ?? 'Umum';

                        $quizLabel = $soal->quiz?->judul ?? $soal->quiz?->judul_quiz ?? 'Bank Soal';
                        $penulisLabel = $soal->penulis?->nama ?? 'Admin';
                        $isKhususUjian = method_exists($soal, 'isKhususUjian') && $soal->isKhususUjian();
                        $clonedCount = (int) ($soal->cloned_soal_count ?? 0);
                        $kelayakan = method_exists($soal, 'cekKelayakan') ? $soal->cekKelayakan() : ['layak' => true, 'masalah' => []];
                    @endphp

                    <article
                        class="soal-card bg-white rounded-2xl border-2 border-[#E6F1FC] p-5 shadow-xs hover:border-[#B2E7FC] transition flex flex-col justify-between gap-4">

                        <div class="space-y-3">
                            {{-- Top Header Row: Checkbox, Badges & Code --}}
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-1.5 flex-1 min-w-0">
                                    {{-- Checkbox untuk batch assign/copy --}}
                                    <label class="inline-flex items-center mr-1 cursor-pointer" title="Pilih soal ini">
                                        <input type="checkbox"
                                            class="soal-select-checkbox rounded text-[#007FBE] focus:ring-0 w-4 h-4 cursor-pointer"
                                            value="{{ $soal->id_soal }}"
                                            data-is-bank="{{ $isBank ? '1' : '0' }}"
                                            data-question-title="{{ Str::limit($soal->pertanyaan, 40) }}">
                                    </label>

                                    {{-- Badge Sumber: Bank Soal vs Kuis --}}
                                    @if($isBank)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-2xs">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            <span>Bank Soal</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-sky-50 text-[#007FBE] border border-[#B2E7FC] shadow-2xs"
                                            title="Terkait kuis: {{ $quizLabel }}">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>{{ Str::limit($quizLabel, 18) }}</span>
                                        </span>
                                    @endif

                                    {{-- Jenis Soal --}}
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border {{ $jenisBadgeClass }}">
                                        {{ $jenisLabel }}
                                    </span>

                                    {{-- Tingkat Kesulitan --}}
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-50 text-slate-700 border border-slate-200">
                                        <span class="w-2 h-2 rounded-full {{ $tingkatDotClass }}"></span>
                                        <span>{{ $tingkatLabel }}</span>
                                    </span>

                                    {{-- Foto badge --}}
                                    @if($hasImage)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>Foto</span>
                                        </span>
                                    @endif

                                    {{-- Peruntukan Khusus Ujian --}}
                                    @if($isKhususUjian)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200"
                                            title="Soal ini dikhususkan untuk Mode Ujian dan tidak muncul di pilihan Dungeon">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            <span>Khusus Ujian</span>
                                        </span>
                                    @endif

                                    {{-- Status Pemakaian untuk Bank Soal --}}
                                    @if($isBank)
                                        @if($clonedCount > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-800 border border-cyan-200"
                                                title="Sudah disalin ke {{ $clonedCount }} kuis/ujian">
                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2"/></svg>
                                                <span>Dipakai ({{ $clonedCount }})</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Belum Dipakai
                                            </span>
                                        @endif
                                    @endif

                                    {{-- Quality Gate Peringatan --}}
                                    @if(!$kelayakan['layak'])
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200"
                                            title="{{ implode(' · ', $kelayakan['masalah']) }}">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z"/></svg>
                                            <span>Perlu Perbaikan</span>
                                        </span>
                                    @endif
                                </div>

                                @if(!empty($soal->kode_soal))
                                    <span class="text-[11px] font-mono font-semibold text-slate-400 shrink-0">
                                        {{ $soal->kode_soal }}
                                    </span>
                                @endif
                            </div>

                            {{-- Sub Meta: Mapel, Jenjang, Skor, Timer --}}
                            <div class="text-xs font-semibold text-slate-500 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1 text-slate-800 font-bold">
                                    <svg class="w-3.5 h-3.5 text-[#007FBE] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span>{{ $mapelLabel }}</span>
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    <span>{{ $jenjangLabel }}</span>
                                </span>
                                @if(!is_null($soal->poin))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->poin }} Poin</span>
                                @endif
                                @if(!is_null($soal->durasi_detik))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->durasi_detik }}d</span>
                                @endif
                            </div>

                            {{-- Pertanyaan + Thumbnail --}}
                            <div class="flex items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 leading-relaxed break-words">
                                        {{ $soal->pertanyaan }}
                                    </p>
                                </div>

                                @if($hasImage)
                                    <img
                                        src="{{ asset('storage/' . $soal->foto_soal) }}"
                                        alt="Foto soal"
                                        class="w-20 h-16 rounded-xl object-cover border border-[#DCEFFF] shrink-0 bg-slate-50">
                                @endif
                            </div>
                        </div>

                        {{-- Footer: Jawaban Benar, Penulis & Aksi --}}
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="text-xs text-slate-600 min-w-0 flex-1">
                                <span class="font-semibold text-slate-400">Kunci:</span>
                                <span class="font-extrabold text-emerald-700 break-words">
                                    {{ $soal->jawaban_benar ?: '-' }}
                                </span>
                                <span class="text-slate-300 mx-1">|</span>
                                <span class="text-[11px] text-slate-400">Oleh: {{ $penulisLabel }}</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-1.5 shrink-0">
                                {{-- Tombol Pratinjau Tampilan Siswa --}}
                                <button type="button"
                                    class="single-preview-btn inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold transition cursor-pointer"
                                    data-id="{{ $soal->id_soal }}"
                                    title="Pratinjau soal seperti tampilan siswa">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>

                                {{-- Tombol Duplikat Cepat --}}
                                <form action="{{ route('soal.duplicate', $soal->id_soal) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition cursor-pointer"
                                        title="Duplikat cepat soal ini untuk membuat variasi baru">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </form>

                                {{-- Jika Soal Kuis: Tombol Salin ke Bank Soal --}}
                                @if(!$isBank)
                                    <form action="{{ route('soal.copy.to.bank') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="soal_ids[]" value="{{ $soal->id_soal }}">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition cursor-pointer"
                                            title="Salin soal kuis ini ke Bank Soal">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                            <span>Bank</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Masukkan ke Kuis --}}
                                <button type="button"
                                    class="single-assign-btn inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-[#007FBE] border border-[#B2E7FC] text-xs font-bold transition cursor-pointer"
                                    data-id="{{ $soal->id_soal }}"
                                    data-title="{{ Str::limit($soal->pertanyaan, 50) }}"
                                    title="Salin soal ini ke kuis atau dungeon tujuan">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    <span>Kuis</span>
                                </button>

                                @can('update', $soal)
                                    <a href="{{ route('soal.edit', $soal->id_soal) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-bold transition">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', $soal)
                                    <form action="{{ route('soal.destroy', $soal->id_soal) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination Bar --}}
            <div class="mt-8">
                {{ $soals->links() }}
            </div>
        @endif
    </main>

    {{-- MODAL ASSIGN KE KUIS --}}
    <div id="assignQuizModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#DCEFFF] max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#007FBE] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Masukkan Soal ke Kuis</h3>
                </div>
                <button type="button" id="closeAssignModalBtn" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-slate-500" id="assignModalDesc">
                Soal yang dipilih akan disalin ke kuis tujuan. Soal yang sudah ada di kuis tersebut akan otomatis dilewati.
            </p>

            <form action="{{ route('soal.assign') }}" method="POST" id="assignQuizForm">
                @csrf
                <div id="assignHiddenInputs"></div>

                <div class="mb-4">
                    <label for="assign_id_quiz" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Pilih Kuis / Dungeon Tujuan <span class="text-rose-500">*</span>
                    </label>
                    <select id="assign_id_quiz" name="id_quiz" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="">-- Pilih Kuis Tujuan --</option>
                        @if(isset($quizList))
                            @foreach($quizList as $q)
                                @php $isDng = $q->isDungeon(); @endphp
                                <option value="{{ $q->id_quiz }}">
                                    {{ $q->judul }} {{ $isDng ? '[Dungeon]' : '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" id="cancelAssignModalBtn"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#007FBE] hover:bg-[#00689E] text-white font-extrabold text-xs shadow-[0_3px_0_#005580] transition cursor-pointer">
                        Konfirmasi & Masukkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form tersembunyi untuk Batch Copy to Bank Soal --}}
    <form id="batchCopyForm" action="{{ route('soal.copy.to.bank') }}" method="POST" class="hidden">
        @csrf
        <div id="batchCopyHiddenInputs"></div>
    </form>

    {{-- Form tersembunyi untuk Batch Delete --}}
    <form id="batchDeleteForm" action="{{ route('soal.batch.delete') }}" method="POST" class="hidden">
        @csrf
        <div id="batchDeleteHiddenInputs"></div>
    </form>

    {{-- MODAL PRATINJAU SOAL (TAMPILAN SISWA) --}}
    <div id="previewSoalModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#DCEFFF] max-w-xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Pratinjau Tampilan Siswa</h3>
                        <p class="text-[11px] font-semibold text-slate-400" id="previewMetaInfo">-</p>
                    </div>
                </div>
                <button type="button" id="closePreviewModalBtn" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center cursor-pointer" aria-label="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div id="previewImageWrap" class="hidden rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 max-h-56 flex items-center justify-center">
                <img id="previewSoalImage" src="" alt="Gambar soal" class="max-h-56 object-contain">
            </div>

            <div class="p-4 rounded-2xl bg-[#F8FBFF] border border-[#DCEFFF]">
                <p id="previewSoalText" class="text-sm sm:text-base font-bold text-slate-800 leading-relaxed whitespace-pre-line"></p>
            </div>

            <div id="previewOptionsContainer" class="space-y-2"></div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" id="previewShowAnswerToggle" checked class="rounded text-emerald-600 focus:ring-0 w-4 h-4">
                    <span>Sorot Kunci Jawaban</span>
                </label>
                <button type="button" id="cancelPreviewModalBtn"
                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL UBAH MASSAL (MAPEL, JENJANG, TINGKAT) --}}
    <div id="batchUpdateModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#DCEFFF] max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Ubah Atribut Massal</h3>
                </div>
                <button type="button" id="closeBatchUpdateModalBtn" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-xs text-slate-500" id="batchUpdateDesc">Biarkan kosong jika tidak ingin mengubah atribut tersebut.</p>

            <form action="{{ route('soal.batch.update') }}" method="POST" id="batchUpdateForm" class="space-y-3">
                @csrf
                <div id="batchUpdateHiddenInputs"></div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Mata Pelajaran</label>
                    <select name="id_mapel" class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800">
                        <option value="">-- Tidak Diubah --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang</label>
                    <select name="id_jenjang" class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800">
                        <option value="">-- Tidak Diubah --</option>
                        @foreach($jenjangList as $j)
                            <option value="{{ $j->id_jenjang }}">{{ $j->nama_tipe ?? $j->nama_jenjang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Kesulitan</label>
                    <select name="tingkat_soal" class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800">
                        <option value="">-- Tidak Diubah --</option>
                        <option value="mudah">Mudah (10 Poin · 20d)</option>
                        <option value="sedang">Sedang (20 Poin · 30d)</option>
                        <option value="sulit">Sulit (30 Poin · 60d)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peruntukan Bank Soal</label>
                    <select name="kategori_bank" class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800">
                        <option value="">-- Tidak Diubah --</option>
                        <option value="umum">Umum / Latihan &amp; Dungeon</option>
                        <option value="ujian">Khusus Ujian / Evaluasi</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" id="cancelBatchUpdateModalBtn" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-xs shadow transition cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL PRATINJAU EKSPOR CSV / EXCEL --}}
    <div id="exportPreviewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#B2E7FC] max-w-4xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#007FBE] border border-[#B2E7FC] flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M17 8l-5-5m0 0L7 8m5-5v12" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Pratinjau Data Ekspor Soal</h3>
                        <p class="text-xs text-slate-500" id="exportPreviewFilterSummary">Memuat ringkasan data...</p>
                    </div>
                </div>
                <button type="button" id="closeExportPreviewModalBtn" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex items-center justify-between bg-sky-50/70 border border-[#B2E7FC] rounded-2xl px-4 py-2.5">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-[#007FBE] text-white" id="exportPreviewTotalBadge">0 Soal</span>
                    <span class="text-xs text-slate-600">siap diekspor ke file CSV (dapat dibuka rapi di Microsoft Excel &amp; Google Spreadsheet).</span>
                </div>
                <span class="text-[11px] font-bold text-[#007FBE]">Menampilkan 10 baris pertama</span>
            </div>

            {{-- Table area with scroll --}}
            <div class="flex-1 overflow-auto border border-slate-200 rounded-2xl min-h-[220px] max-h-[360px] relative bg-white">
                <div id="exportPreviewLoading" class="absolute inset-0 bg-white/90 backdrop-blur-2xs flex flex-col items-center justify-center gap-2 z-10">
                    <div class="w-8 h-8 border-3 border-sky-200 border-t-[#007FBE] rounded-full animate-spin"></div>
                    <p class="text-xs font-bold text-slate-600">Menyiapkan pratinjau data...</p>
                </div>

                <table class="w-full text-left text-xs text-slate-700 border-collapse">
                    <thead class="bg-slate-50 sticky top-0 border-b border-slate-200 text-slate-600 font-extrabold text-[11px] uppercase tracking-wider">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3">Kode Soal</th>
                            <th class="py-2.5 px-3">Mapel / Jenjang</th>
                            <th class="py-2.5 px-3">Jenis &amp; Tingkat</th>
                            <th class="py-2.5 px-3">Pertanyaan</th>
                            <th class="py-2.5 px-3 text-center">Kunci</th>
                            <th class="py-2.5 px-3 text-center">Poin</th>
                        </tr>
                    </thead>
                    <tbody id="exportPreviewTableBody" class="divide-y divide-slate-100">
                        {{-- Injected via JS --}}
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between pt-2">
                <p class="text-[11px] text-slate-400">Format file hasil ekspor: <strong>UTF-8 BOM (.csv)</strong> terstruktur untuk backup atau pengolahan data.</p>
                <div class="flex items-center gap-2.5">
                    <button type="button" id="cancelExportPreviewModalBtn" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 cursor-pointer">Batal</button>
                    <a id="exportPreviewDownloadBtn" href="#" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#007FBE] hover:bg-[#00689E] text-white font-extrabold text-xs shadow-[0_3px_0_#005580] transition hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M17 8l-5-5m0 0L7 8m5-5v12" /></svg>
                        <span>Unduh CSV Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL IMPOR CSV / EXCEL --}}
    <div id="importCsvModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#DCEFFF] max-w-2xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Impor Massal Soal ke Bank Soal</h3>
                        <p class="text-[11px] text-slate-400">Unggah file CSV dari Excel untuk menambahkan puluhan soal sekaligus</p>
                    </div>
                </div>
                <button type="button" id="closeImportCsvModalBtn" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Box Template Download --}}
            <div class="p-3.5 rounded-2xl bg-sky-50 border border-[#B2E7FC] flex items-center justify-between gap-3">
                <div class="text-xs text-slate-700">
                    <p class="font-extrabold text-[#007FBE]">Gunakan Template Resmi Siap Isi</p>
                    <p class="text-[11px] text-slate-500">Unduh template CSV yang sudah dilengkapi baris contoh untuk Pilihan Ganda, Benar/Salah, dan Isian.</p>
                </div>
                <a href="{{ route('soal.template.csv') }}"
                    class="inline-flex items-center gap-1.5 shrink-0 px-3.5 py-2.5 rounded-xl bg-white hover:bg-sky-100 text-[#007FBE] border border-[#B2E7FC] font-extrabold text-xs transition shadow-2xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                    <span>Download Template CSV</span>
                </a>
            </div>

            {{-- Format Table Guide inside Modal --}}
            <div class="space-y-1.5">
                <p class="text-xs font-extrabold text-slate-700 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#007FBE]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Struktur Kolom CSV yang Benar:</span>
                </p>
                <div class="border border-slate-200 rounded-xl overflow-hidden text-[11px]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                                <tr>
                                    <th class="p-2 border-r border-slate-200">Kolom</th>
                                    <th class="p-2 border-r border-slate-200">Status</th>
                                    <th class="p-2 border-r border-slate-200">Nilai yang Diterima</th>
                                    <th class="p-2">Contoh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">pertanyaan</td>
                                    <td class="p-1.5 px-2 text-rose-600 font-bold border-r border-slate-100">Wajib</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100">Teks soal yang diujikan</td>
                                    <td class="p-1.5 px-2">Berapakah hasil 12 x 8?</td>
                                </tr>
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">jenis</td>
                                    <td class="p-1.5 px-2 text-rose-600 font-bold border-r border-slate-100">Wajib</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100"><code>pilihan_ganda</code>, <code>benar_salah</code>, <code>isian</code></td>
                                    <td class="p-1.5 px-2 font-mono text-purple-700">pilihan_ganda</td>
                                </tr>
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">tingkat</td>
                                    <td class="p-1.5 px-2 text-rose-600 font-bold border-r border-slate-100">Wajib</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100"><code>mudah</code>, <code>sedang</code>, <code>sulit</code></td>
                                    <td class="p-1.5 px-2">mudah</td>
                                </tr>
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">opsi_a s/d d</td>
                                    <td class="p-1.5 px-2 text-amber-600 font-bold border-r border-slate-100">Wajib PG</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100">Teks pilihan jawaban A, B, C, D</td>
                                    <td class="p-1.5 px-2">opsi_a: 84, opsi_b: 96</td>
                                </tr>
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">kunci</td>
                                    <td class="p-1.5 px-2 text-rose-600 font-bold border-r border-slate-100">Wajib</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100">Huruf A/B/C/D, Benar/Salah, atau Teks Isian</td>
                                    <td class="p-1.5 px-2 font-bold text-emerald-700">B</td>
                                </tr>
                                <tr>
                                    <td class="p-1.5 px-2 font-mono font-bold text-slate-800 border-r border-slate-100">poin, durasi, peruntukan</td>
                                    <td class="p-1.5 px-2 text-slate-400 font-bold border-r border-slate-100">Opsional</td>
                                    <td class="p-1.5 px-2 border-r border-slate-100">Poin angka (10-30), durasi detik, <code>umum</code>/<code>ujian</code></td>
                                    <td class="p-1.5 px-2">poin: 10, durasi: 20</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <form action="{{ route('soal.import.csv') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 pt-1">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mata Pelajaran Tujuan <span class="text-rose-500">*</span></label>
                        <select name="id_mapel" required class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800 focus:border-[#007FBE] focus:outline-hidden">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang Tujuan <span class="text-rose-500">*</span></label>
                        <select name="id_jenjang" required class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800 focus:border-[#007FBE] focus:outline-hidden">
                            <option value="">-- Pilih Jenjang (SD/SMP/SMA) --</option>
                            @foreach($jenjangList as $j)
                                <option value="{{ $j->id_jenjang }}">{{ $j->nama_tipe ?? $j->nama_jenjang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peruntukan Default</label>
                    <select name="kategori_bank" class="w-full px-3.5 py-2.5 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-800 focus:border-[#007FBE] focus:outline-hidden">
                        <option value="umum">Umum (Latihan Bebas &amp; Mode Dungeon)</option>
                        <option value="ujian">Khusus Ujian (Mode Token &amp; Ulangan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih File CSV (.csv / .txt) <span class="text-rose-500">*</span></label>
                    <input type="file" name="csv_file" accept=".csv,.txt" required
                        class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border-2 border-dashed border-slate-200 rounded-2xl p-2 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                    <button type="button" id="cancelImportCsvModalBtn" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-[0_3px_0_#047857] transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                        <span>Mulai Impor Soal</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@php
    $soalPreviewPayload = $soals->getCollection()->mapWithKeys(function ($s) {
        return [
            $s->id_soal => [
                'pertanyaan' => $s->pertanyaan,
                'foto' => !empty($s->foto_soal) ? asset('storage/' . $s->foto_soal) : null,
                'mapel' => $s->mapel?->nama_mapel ?? $s->quiz?->mapel?->nama_mapel ?? 'Umum',
                'jenjang' => $s->jenjang?->nama_tipe ?? $s->quiz?->jenjang?->nama_tipe ?? 'Umum',
                'tingkat' => strtoupper((string) ($s->tingkat_soal ?: 'sedang')),
                'poin' => $s->poin ?? 10,
                'durasi' => $s->durasi_detik ?? 20,
                'jenis' => (int) $s->id_jenis_soal,
                'jawaban_benar' => $s->jawaban_benar,
                'opsi' => $s->pilihanSoal->map(fn($p) => [
                    'label' => $p->label,
                    'teks' => $p->teks_pilihan,
                    'is_correct' => (bool) $p->is_correct,
                ])->values()->all(),
            ],
        ];
    });
@endphp

@push('scripts')
    <script>
        const soalPreviewMap = @json($soalPreviewPayload);

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('soalFilterForm');
            const mapelSelect = document.getElementById('soalMapelSelect');
            const sourceChipBar = document.getElementById('soalSourceFilterChips');
            const typeChipBar = document.getElementById('soalTypeFilterChips');
            const tingkatChipBar = document.getElementById('soalTingkatFilterChips');
            const kategoriChipBar = document.getElementById('soalKategoriFilterChips');
            const statusPakaiChipBar = document.getElementById('soalStatusPakaiFilterChips');
            const jenjangChipBar = document.getElementById('soalJenjangFilterChips');

            const inputSumber = document.getElementById('filterInputSumber');
            const inputJenis = document.getElementById('filterInputJenis');
            const inputTingkat = document.getElementById('filterInputTingkat');
            const inputKategori = document.getElementById('filterInputKategori');
            const inputStatusPakai = document.getElementById('filterInputStatusPakai');
            const inputJenjang = document.getElementById('filterInputJenjang');

            const batchActionBar = document.getElementById('batchActionBar');
            const batchCountText = document.getElementById('batchCountText');
            const selectAllCheckbox = document.getElementById('selectAllSoalCheckbox');
            const openBatchAssignBtn = document.getElementById('openBatchAssignModalBtn');
            const openBatchCopyBtn = document.getElementById('openBatchCopyToBankBtn');
            const openBatchUpdateBtn = document.getElementById('openBatchUpdateModalBtn');
            const openBatchDeleteBtn = document.getElementById('openBatchDeleteBtn');
            const clearBatchBtn = document.getElementById('clearBatchSelectionBtn');
            const checkboxes = Array.from(document.querySelectorAll('.soal-select-checkbox'));

            const modal = document.getElementById('assignQuizModal');
            const closeModalBtn = document.getElementById('closeAssignModalBtn');
            const cancelModalBtn = document.getElementById('cancelAssignModalBtn');
            const assignHiddenInputs = document.getElementById('assignHiddenInputs');
            const assignModalDesc = document.getElementById('assignModalDesc');

            // 1. CHIP FILTER CLICK HANDLER (Submits form to filter instantly)
            function bindChipFilter(container, hiddenInput) {
                if (!container || !hiddenInput) return;
                container.addEventListener('click', function (e) {
                    const btn = e.target.closest('[data-value]');
                    if (!btn) return;
                    const val = btn.getAttribute('data-value') || 'all';
                    hiddenInput.value = val;
                    if (form) form.submit();
                });
            }

            bindChipFilter(sourceChipBar, inputSumber);
            bindChipFilter(typeChipBar, inputJenis);
            bindChipFilter(tingkatChipBar, inputTingkat);
            bindChipFilter(kategoriChipBar, inputKategori);
            bindChipFilter(statusPakaiChipBar, inputStatusPakai);
            bindChipFilter(jenjangChipBar, inputJenjang);

            if (mapelSelect && form) {
                mapelSelect.addEventListener('change', function () {
                    form.submit();
                });
            }

            // 2. BATCH SELECTION + SELECT ALL LOGIC
            function getCheckedIds() {
                return checkboxes.filter(cb => cb.checked).map(cb => cb.value);
            }

            function appendHiddenIds(container, ids) {
                container.innerHTML = '';
                ids.forEach(id => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = 'soal_ids[]';
                    inp.value = id;
                    container.appendChild(inp);
                });
            }

            function updateBatchUI() {
                const count = getCheckedIds().length;
                if (batchActionBar) {
                    if (count > 0) {
                        batchActionBar.classList.remove('hidden');
                        batchCountText.textContent = `${count} soal dipilih`;
                    } else {
                        batchActionBar.classList.add('hidden');
                    }
                }
                if (selectAllCheckbox && checkboxes.length > 0) {
                    selectAllCheckbox.checked = count === checkboxes.length;
                    selectAllCheckbox.indeterminate = count > 0 && count < checkboxes.length;
                }
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBatchUI));

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function () {
                    const targetState = selectAllCheckbox.checked;
                    checkboxes.forEach(cb => cb.checked = targetState);
                    updateBatchUI();
                });
            }

            if (clearBatchBtn) {
                clearBatchBtn.addEventListener('click', function () {
                    checkboxes.forEach(cb => cb.checked = false);
                    updateBatchUI();
                });
            }

            // Batch Copy to Bank Soal
            if (openBatchCopyBtn) {
                openBatchCopyBtn.addEventListener('click', function () {
                    const checkedIds = getCheckedIds();
                    if (!checkedIds.length) return;
                    if (!confirm(`Salin ${checkedIds.length} soal terpilih ke Bank Soal?`)) return;

                    appendHiddenIds(document.getElementById('batchCopyHiddenInputs'), checkedIds);
                    document.getElementById('batchCopyForm').submit();
                });
            }

            // Batch Delete
            if (openBatchDeleteBtn) {
                openBatchDeleteBtn.addEventListener('click', function () {
                    const checkedIds = getCheckedIds();
                    if (!checkedIds.length) return;
                    if (!confirm(`Yakin ingin menghapus ${checkedIds.length} soal terpilih secara permanen?`)) return;

                    appendHiddenIds(document.getElementById('batchDeleteHiddenInputs'), checkedIds);
                    document.getElementById('batchDeleteForm').submit();
                });
            }

            // 3. MODAL ASSIGN TO QUIZ LOGIC
            function openAssignModal(soalIds, titleText) {
                appendHiddenIds(assignHiddenInputs, soalIds);
                assignModalDesc.textContent = titleText
                    ? `${titleText} akan disalin ke kuis tujuan. Duplikasi akan dilewati otomatis.`
                    : `${soalIds.length} soal akan disalin ke kuis tujuan. Duplikasi akan dilewati otomatis.`;
                modal.classList.remove('hidden');
            }

            function closeAssignModal() {
                modal.classList.add('hidden');
            }

            if (openBatchAssignBtn) {
                openBatchAssignBtn.addEventListener('click', function () {
                    const checkedIds = getCheckedIds();
                    if (!checkedIds.length) return;
                    openAssignModal(checkedIds, `${checkedIds.length} soal terpilih`);
                });
            }

            document.querySelectorAll('.single-assign-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    openAssignModal([btn.getAttribute('data-id')], `Soal: "${btn.getAttribute('data-title')}"`);
                });
            });

            if (closeModalBtn) closeModalBtn.addEventListener('click', closeAssignModal);
            if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeAssignModal);
            modal?.addEventListener('click', e => { if (e.target === modal) closeAssignModal(); });

            // 4. MODAL BATCH UPDATE LOGIC
            const batchUpdateModal = document.getElementById('batchUpdateModal');
            const closeBatchUpdateBtn = document.getElementById('closeBatchUpdateModalBtn');
            const cancelBatchUpdateBtn = document.getElementById('cancelBatchUpdateModalBtn');

            if (openBatchUpdateBtn && batchUpdateModal) {
                openBatchUpdateBtn.addEventListener('click', function () {
                    const checkedIds = getCheckedIds();
                    if (!checkedIds.length) return;
                    appendHiddenIds(document.getElementById('batchUpdateHiddenInputs'), checkedIds);
                    document.getElementById('batchUpdateDesc').textContent = `Ubah atribut untuk ${checkedIds.length} soal terpilih. Biarkan kosong jika tidak ingin diubah.`;
                    batchUpdateModal.classList.remove('hidden');
                });
            }
            closeBatchUpdateBtn?.addEventListener('click', () => batchUpdateModal.classList.add('hidden'));
            cancelBatchUpdateBtn?.addEventListener('click', () => batchUpdateModal.classList.add('hidden'));
            batchUpdateModal?.addEventListener('click', e => { if (e.target === batchUpdateModal) batchUpdateModal.classList.add('hidden'); });

            // 5. MODAL IMPOR CSV LOGIC
            const importCsvModal = document.getElementById('importCsvModal');
            const openImportCsvBtn = document.getElementById('openImportCsvModalBtn');
            const closeImportCsvBtn = document.getElementById('closeImportCsvModalBtn');
            const cancelImportCsvBtn = document.getElementById('cancelImportCsvModalBtn');

            openImportCsvBtn?.addEventListener('click', () => importCsvModal?.classList.remove('hidden'));
            closeImportCsvBtn?.addEventListener('click', () => importCsvModal?.classList.add('hidden'));
            cancelImportCsvBtn?.addEventListener('click', () => importCsvModal?.classList.add('hidden'));
            importCsvModal?.addEventListener('click', e => { if (e.target === importCsvModal) importCsvModal.classList.add('hidden'); });

            // 5b. MODAL PRATINJAU EKSPOR CSV LOGIC
            const exportPreviewModal = document.getElementById('exportPreviewModal');
            const openExportPreviewBtn = document.getElementById('openExportPreviewModalBtn');
            const closeExportPreviewBtn = document.getElementById('closeExportPreviewModalBtn');
            const cancelExportPreviewBtn = document.getElementById('cancelExportPreviewModalBtn');
            const exportLoading = document.getElementById('exportPreviewLoading');
            const exportTableBody = document.getElementById('exportPreviewTableBody');
            const exportFilterSummary = document.getElementById('exportPreviewFilterSummary');
            const exportTotalBadge = document.getElementById('exportPreviewTotalBadge');
            const exportDownloadBtn = document.getElementById('exportPreviewDownloadBtn');

            function closeExportModal() {
                exportPreviewModal?.classList.add('hidden');
            }

            openExportPreviewBtn?.addEventListener('click', async () => {
                if (!exportPreviewModal) return;
                exportPreviewModal.classList.remove('hidden');
                if (exportLoading) exportLoading.classList.remove('hidden');
                if (exportTableBody) exportTableBody.innerHTML = '';

                const currentSearch = window.location.search;
                const previewUrl = `{{ route('soal.export.preview') }}${currentSearch}`;

                try {
                    const res = await fetch(previewUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await res.json();

                    if (exportLoading) exportLoading.classList.add('hidden');
                    if (exportFilterSummary) exportFilterSummary.textContent = data.filter_summary || 'Semua Data Soal';
                    if (exportTotalBadge) exportTotalBadge.textContent = `${data.total || 0} Soal`;
                    if (exportDownloadBtn) exportDownloadBtn.href = data.download_url || '#';

                    if (!data.preview || data.preview.length === 0) {
                        exportTableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-semibold">
                                    Tidak ada data soal yang sesuai dengan filter yang aktif.
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    exportTableBody.innerHTML = data.preview.map(row => `
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2.5 px-3 text-center font-bold text-slate-400 text-[11px]">${row.no}</td>
                            <td class="py-2.5 px-3 font-mono font-bold text-[#007FBE] text-[11px]">${row.kode_soal}</td>
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-800">${row.mapel}</span>
                                <span class="inline-block ml-1 px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 font-bold text-[10px]">${row.jenjang}</span>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="font-bold text-slate-700">${row.jenis}</span>
                                <span class="block text-[10px] text-slate-400 font-semibold">${row.tingkat} • ${row.peruntukan}</span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-700 max-w-xs truncate" title="${row.pertanyaan}">${row.pertanyaan}</td>
                            <td class="py-2.5 px-3 text-center font-bold text-emerald-700">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 border border-emerald-200">${row.kunci}</span>
                            </td>
                            <td class="py-2.5 px-3 text-center font-bold text-slate-700">${row.poin}</td>
                        </tr>
                    `).join('');

                } catch (err) {
                    if (exportLoading) exportLoading.classList.add('hidden');
                    if (exportTableBody) {
                        exportTableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="py-8 text-center text-rose-500 font-bold">
                                    Gagal memuat pratinjau data. Silakan coba kembali atau unduh langsung.
                                </td>
                            </tr>
                        `;
                    }
                    if (exportDownloadBtn) {
                        exportDownloadBtn.href = `{{ route('soal.export.csv') }}${currentSearch}`;
                    }
                }
            });

            closeExportPreviewBtn?.addEventListener('click', closeExportModal);
            cancelExportPreviewBtn?.addEventListener('click', closeExportModal);
            exportPreviewModal?.addEventListener('click', e => {
                if (e.target === exportPreviewModal) closeExportModal();
            });

            // 6. MODAL PRATINJAU TAMPILAN SISWA
            const previewModal = document.getElementById('previewSoalModal');
            const previewShowAnswer = document.getElementById('previewShowAnswerToggle');
            let currentPreviewData = null;

            function renderPreviewOptions() {
                if (!currentPreviewData) return;
                const container = document.getElementById('previewOptionsContainer');
                const showAns = previewShowAnswer ? previewShowAnswer.checked : true;
                container.innerHTML = '';

                if (currentPreviewData.jenis === 2 || !currentPreviewData.opsi.length) {
                    const box = document.createElement('div');
                    box.className = 'p-3.5 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 text-xs font-semibold text-slate-600';
                    box.textContent = showAns
                        ? `Kunci Jawaban Isian: ${currentPreviewData.jawaban_benar || '-'}`
                        : 'Kolom isian singkat siswa...';
                    container.appendChild(box);
                    return;
                }

                currentPreviewData.opsi.forEach(opt => {
                    const isTrue = showAns && opt.is_correct;
                    const row = document.createElement('div');
                    row.className = isTrue
                        ? 'flex items-center gap-3 p-3 rounded-2xl border-2 border-emerald-400 bg-emerald-50 text-emerald-900 font-bold text-xs sm:text-sm'
                        : 'flex items-center gap-3 p-3 rounded-2xl border-2 border-slate-200 bg-white text-slate-700 font-semibold text-xs sm:text-sm';

                    const badge = document.createElement('span');
                    badge.className = isTrue
                        ? 'w-7 h-7 rounded-xl bg-emerald-500 text-white font-extrabold flex items-center justify-center shrink-0 text-xs'
                        : 'w-7 h-7 rounded-xl bg-slate-100 text-slate-600 font-extrabold flex items-center justify-center shrink-0 text-xs';
                    badge.textContent = opt.label || '-';

                    const teks = document.createElement('span');
                    teks.className = 'flex-1';
                    teks.textContent = opt.teks;

                    row.appendChild(badge);
                    row.appendChild(teks);
                    if (isTrue) {
                        const check = document.createElement('span');
                        check.className = 'text-emerald-600 font-extrabold text-xs';
                        check.textContent = '✓ Kunci';
                        row.appendChild(check);
                    }
                    container.appendChild(row);
                });
            }

            document.querySelectorAll('.single-preview-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = btn.getAttribute('data-id');
                    const data = soalPreviewMap[id];
                    if (!data || !previewModal) return;
                    currentPreviewData = data;

                    document.getElementById('previewMetaInfo').textContent = `${data.mapel} • ${data.jenjang} • ${data.tingkat} (${data.poin} Poin · ${data.durasi}d)`;
                    document.getElementById('previewSoalText').textContent = data.pertanyaan;

                    const imgWrap = document.getElementById('previewImageWrap');
                    const imgEl = document.getElementById('previewSoalImage');
                    if (data.foto) {
                        imgEl.src = data.foto;
                        imgWrap.classList.remove('hidden');
                    } else {
                        imgEl.src = '';
                        imgWrap.classList.add('hidden');
                    }

                    renderPreviewOptions();
                    previewModal.classList.remove('hidden');
                });
            });

            previewShowAnswer?.addEventListener('change', renderPreviewOptions);
            document.getElementById('closePreviewModalBtn')?.addEventListener('click', () => previewModal.classList.add('hidden'));
            document.getElementById('cancelPreviewModalBtn')?.addEventListener('click', () => previewModal.classList.add('hidden'));
            previewModal?.addEventListener('click', e => { if (e.target === previewModal) previewModal.classList.add('hidden'); });
        });
    </script>
@endpush
