@extends('layouts.app')

@section('header')


    {{-- =========================================================
        TOPBAR
        Sidebar sengaja TIDAK dibuat karena sudah tersedia.
    ========================================================== --}}
    {{-- Header / Topbar Quiz --}}
    <h1 class="text-lg font-bold text-gray-900">Pusat Manajemen Modul</h1>

    <div class="flex items-center gap-4">
        <!-- Switch Bahasa -->
        <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
            <span>ID</span>
            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
    @endsection

    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    @section('content')
    <main class="px-6 lg:px-8 py-8">

        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-900">
                    Manajemen Modul
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Buat, distribusikan, dan kelola modul pelajaran digital kelas.
                </p>
            </div>

            <a href="{{ route('admin.modul.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-sm transition hover:-translate-y-0.5">
                <span class="text-lg leading-none">+</span>
                <span>Tambah Modul</span>
            </a>

        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div
                class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✓</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>

                <button onclick="this.parentElement.remove()"
                    class="text-emerald-500 hover:text-emerald-700">
                    ✕
                </button>
            </div>
        @endif

        {{-- =====================================================
            STATISTICS
        ====================================================== --}}
        @php
            $moduleCollection = isset($moduls) ? collect($moduls) : collect();
            $statTotal = $totalModul ?? $moduleCollection->count();
            $statPublished = $totalPublished ?? $moduleCollection->filter(fn($m) => !$m->isDraft())->count();
            $statDraft = $totalDraft ?? $moduleCollection->filter(fn($m) => $m->isDraft())->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- Total --}}
            <div
                class="bg-white border border-slate-100 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-xs">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="m4.5 7.5 7.5 4 7.5-4M12 12v9" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium">Total Modul</p>
                    <p class="text-[22px] font-extrabold text-slate-900 leading-tight">
                        {{ $statTotal }}
                    </p>
                </div>
            </div>

            {{-- Published --}}
            <div
                class="bg-white border border-slate-100 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-xs">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 3a9 9 0 1 0 9 9" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="m8.5 12 2.2 2.2L17 8" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium">Modul Terbit</p>
                    <p class="text-[22px] font-extrabold text-slate-900 leading-tight">
                        {{ $statPublished }}
                    </p>
                </div>
            </div>

            {{-- Draft --}}
            <div
                class="bg-white border border-slate-100 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-xs">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium">Draf Modul</p>
                    <p class="text-[22px] font-extrabold text-slate-900 leading-tight">
                        {{ $statDraft }}
                    </p>
                </div>
            </div>

        </div>

        {{-- =====================================================
            FILTER & SORTIR TOOLBAR (GAYA CHOICE CHIP SISWA)
        ====================================================== --}}
        @php
            $activeStatusTipeChip = 'Semua';
            if (($statusFilter ?? 'all') === 'published') {
                $activeStatusTipeChip = 'Terbit';
            } elseif (($statusFilter ?? 'all') === 'draft') {
                $activeStatusTipeChip = 'Draft';
            } elseif (($tipeFilter ?? 'all') != 'all') {
                $matchedTipe = ($masterTipe ?? collect())->firstWhere('id_tipemodul', $tipeFilter);
                if ($matchedTipe && stripos($matchedTipe->nama_tipe, 'video') !== false) {
                    $activeStatusTipeChip = 'Video';
                } elseif ($matchedTipe && stripos($matchedTipe->nama_tipe, 'pdf') !== false) {
                    $activeStatusTipeChip = 'PDF';
                }
            }

            $activeJenjangChip = 'Semua Jenjang';
            if (($jenjangFilter ?? 'all') !== 'all') {
                $matchedJenjang = ($masterJenjang ?? collect())->firstWhere('id_jenjang', $jenjangFilter);
                if ($matchedJenjang) {
                    $activeJenjangChip = $matchedJenjang->nama_tipe;
                }
            }

            $mapelCollection = collect($masterMapel ?? []);
            if ($mapelCollection->isEmpty()) {
                $mapelCollection = $moduleCollection->pluck('mapel')->filter()->unique('nama_mapel')->sortBy('nama_mapel')->values();
            }

            $activeMapelChip = 'Semua Mapel';
            if (($mapelFilter ?? 'all') !== 'all') {
                $matchedMapel = $mapelCollection->firstWhere('id_mapel', $mapelFilter);
                if ($matchedMapel) {
                    $activeMapelChip = $matchedMapel->nama_mapel;
                }
            }

            $hasServerFilter = (($statusFilter ?? 'all') !== 'all')
                || (($jenjangFilter ?? 'all') !== 'all')
                || (($tipeFilter ?? 'all') !== 'all')
                || (($mapelFilter ?? 'all') !== 'all')
                || trim((string) request('q', $search ?? '')) !== '';
        @endphp

        <div class="mb-6">
            <x-student-style-filter-bar
                title="Modul Pembelajaran"
                icon="📚"
                countId="modul-count-badge"
                countText="{{ $moduleCollection->count() }} Modul"
                searchId="searchModule"
                searchName="q"
                searchValue="{{ request('q', $search ?? '') }}"
                searchPlaceholder="Cari judul, mapel, jenjang, atau tipe modul..."
                resetId="modulResetBtn"
                resetUrl="{{ route('admin.modul') }}"
                :showReset="$hasServerFilter || ($sort ?? 'latest') !== 'latest'">

                <x-slot:headerActions>
                    <select id="modulSortSelect" aria-label="Urutkan modul"
                        class="h-7 rounded-full border border-[#DCEFFF] bg-white px-3 text-[11px] font-extrabold text-[#465673] outline-none focus:border-[#007FBE] transition cursor-pointer shadow-xs">
                        <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Urut: Terbaru</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Urut: Terlama</option>
                        <option value="title_asc" {{ ($sort ?? '') === 'title_asc' ? 'selected' : '' }}>Judul (A - Z)</option>
                        <option value="title_desc" {{ ($sort ?? '') === 'title_desc' ? 'selected' : '' }}>Judul (Z - A)</option>
                        <option value="type_pdf" {{ ($sort ?? '') === 'type_pdf' ? 'selected' : '' }}>Utamakan PDF</option>
                        <option value="type_video" {{ ($sort ?? '') === 'type_video' ? 'selected' : '' }}>Utamakan Video</option>
                    </select>
                </x-slot:headerActions>

                {{-- Chip Status & Tipe --}}
                <x-student-style-filter-chip-bar
                    id="modul-status-tipe-chips"
                    label="Status & Tipe"
                    chipClass="modul-status-chip"
                    dataAttr="data-status-tipe"
                    :chips="[
                        ['value' => 'Semua', 'label' => 'Semua', 'active' => $activeStatusTipeChip === 'Semua'],
                        ['value' => 'Terbit', 'label' => 'Terbit', 'active' => $activeStatusTipeChip === 'Terbit'],
                        ['value' => 'Draft', 'label' => 'Draft', 'active' => $activeStatusTipeChip === 'Draft'],
                        ['value' => 'Video', 'label' => 'Video', 'active' => $activeStatusTipeChip === 'Video'],
                        ['value' => 'PDF', 'label' => 'PDF', 'active' => $activeStatusTipeChip === 'PDF'],
                    ]" />

                {{-- Chip Jenjang --}}
                @php
                    $modulJenjangChips = [
                        ['value' => 'Semua Jenjang', 'label' => 'Semua Jenjang', 'active' => $activeJenjangChip === 'Semua Jenjang'],
                        ['value' => 'SD', 'label' => 'SD', 'active' => strcasecmp($activeJenjangChip, 'SD') === 0],
                        ['value' => 'SMP', 'label' => 'SMP', 'active' => strcasecmp($activeJenjangChip, 'SMP') === 0],
                        ['value' => 'SMA', 'label' => 'SMA', 'active' => strcasecmp($activeJenjangChip, 'SMA') === 0],
                    ];
                @endphp
                <x-student-style-filter-chip-bar
                    id="modul-jenjang-chips"
                    label="Jenjang"
                    chipClass="modul-jenjang-chip"
                    dataAttr="data-jenjang"
                    :chips="$modulJenjangChips" />

                {{-- Chip Mata Pelajaran Dinamis --}}
                @if($mapelCollection->isNotEmpty())
                    @php
                        $modulMapelChips = [
                            ['value' => 'Semua Mapel', 'label' => 'Semua Mapel', 'active' => $activeMapelChip === 'Semua Mapel'],
                        ];
                        foreach ($mapelCollection as $mItem) {
                            $modulMapelChips[] = [
                                'value' => $mItem->nama_mapel,
                                'label' => $mItem->nama_mapel,
                                'active' => strcasecmp($activeMapelChip, $mItem->nama_mapel) === 0,
                            ];
                        }
                    @endphp
                    <x-student-style-filter-chip-bar
                        id="modul-mapel-chips"
                        label="Mapel"
                        chipClass="modul-mapel-chip"
                        dataAttr="data-mapel"
                        :chips="$modulMapelChips" />
                @endif
            </x-student-style-filter-bar>
        </div>

        {{-- =====================================================
            MODULE GRID
        ====================================================== --}}
        <div id="moduleGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse($moduleCollection as $module)

                @php
                    $isDraft = $module->isDraft();
                    $statusClass = $isDraft
                        ? 'bg-amber-500/90'
                        : 'bg-emerald-500/90';
                    $statusText = $isDraft ? 'Draf' : 'Terbit';
                    $moduleType = strtolower($module->tipeModul->nama_tipe ?? '');
                    $isPdf = $module->tipe_file === 'pdf' || str_ends_with(strtolower($module->file_materi ?? ''), '.pdf');
                    $isVideo = $module->youtube_id || $module->tipe_file === 'link' || str_contains($moduleType, 'video');
                    $modulMapelNama = $module->mapel->nama_mapel ?? '';
                    $modulJenjangNama = $module->jenjang->nama_tipe ?? 'Umum';
                    $modulPengajarNama = $module->pembuat?->nama ?? $module->guru ?? $module->pengajar ?? 'Admin';
                @endphp

                <article
                    class="module-card group bg-white border border-gray-100 rounded-2xl shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col"
                    data-status="{{ $isDraft ? 'draft' : 'terbit' }}"
                    data-tipe="{{ $isVideo ? 'video' : ($isPdf ? 'pdf' : 'lainnya') }}"
                    data-jenjang="{{ strtolower($modulJenjangNama) }}"
                    data-mapel="{{ strtolower($modulMapelNama) }}"
                    data-title="{{ strtolower($module->judul_modul ?? '') }}"
                    data-id="{{ (int) $module->id_modul }}"
                    data-created="{{ $module->created_at?->timestamp ?? (int) $module->id_modul }}"
                    data-search="{{ strtolower(($module->judul_modul ?? '') . ' ' . $modulMapelNama . ' ' . ($module->tipeModul->nama_tipe ?? '') . ' ' . $modulJenjangNama . ' ' . $modulPengajarNama . ' ' . ($module->deskripsi ?? '')) }}">

                    <div class="relative flex h-24 items-start justify-between gap-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 p-3.5">
                        <span class="inline-flex min-w-0 items-center gap-2 rounded-full bg-white/20 px-2.5 py-1 text-[11px] font-bold text-white backdrop-blur-xs">
                            @if($isPdf)
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm7 0v5h5M9 13h6m-6 4h6" />
                                </svg>
                            @elseif($isVideo)
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 6 9 6-9 6V6Z" />
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5v-15ZM4 20.5A2.5 2.5 0 0 1 6.5 18H20" />
                                </svg>
                            @endif
                            <span class="truncate">{{ $module->tipeModul->nama_tipe ?? 'Umum' }}</span>
                        </span>

                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full {{ $statusClass }} px-2.5 py-1 text-[11px] font-bold text-white shadow-2xs">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="relative px-5 pt-0 pb-4">
                        <div class="-mt-12 flex justify-center">
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white shadow-md ring-4 ring-white">
                                @if($module->foto_modul && Storage::disk('public')->exists($module->foto_modul))
                                    <img src="{{ Storage::url($module->foto_modul) }}" alt="{{ $module->judul_modul }}"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @elseif($module->youtube_id)
                                    <img src="https://img.youtube.com/vi/{{ $module->youtube_id }}/hqdefault.jpg" alt="{{ $module->judul_modul }}"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @elseif($isPdf)
                                    <div class="flex h-full w-full flex-col items-center justify-center gap-1.5 bg-rose-50 text-rose-600">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm7 0v5h5M9 13h6m-6 4h6" />
                                        </svg>
                                        <span class="text-[10px] font-extrabold tracking-wide">PDF</span>
                                    </div>
                                @elseif($isVideo)
                                    <div class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-600">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 6 9 6-9 6V6Z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-emerald-50 text-emerald-600">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5v-15ZM4 20.5A2.5 2.5 0 0 1 6.5 18H20" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <h3 class="truncate text-base font-bold text-slate-800 transition group-hover:text-indigo-600"
                                title="{{ $module->judul_modul }}">
                                {{ $module->judul_modul ?? 'Judul Modul' }}
                            </h3>
                            <p class="mt-1 line-clamp-2 min-h-10 text-xs leading-5 text-slate-500">
                                {{ $module->deskripsi ?? 'Materi pembelajaran digital untuk membantu siswa memahami pelajaran.' }}
                            </p>
                            <div class="mt-2 flex flex-wrap items-center justify-center gap-1.5">
                                <span class="inline-flex items-center gap-1 rounded-full border border-blue-100 bg-blue-50 px-2.5 py-0.5 text-[11px] font-bold text-blue-700">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    </svg>
                                    {{ $module->jenjang->nama_tipe ?? 'Semua jenjang' }}
                                </span>
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-semibold text-slate-600">
                                    {{ $isPdf ? 'Dokumen' : ($isVideo ? 'Video' : ($module->tipeModul->nama_tipe ?? 'Materi')) }}
                                </span>
                                @if(!empty($modulMapelNama))
                                    <span class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-2.5 py-0.5 text-[11px] font-bold text-indigo-700">
                                        {{ $modulMapelNama }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 space-y-1.5">
                            <div class="flex items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2 text-xs">
                                <span class="text-slate-400 font-medium">Siswa</span>
                                <span class="font-semibold text-slate-700">{{ $module->jumlah_siswa ?? $module->siswa_count ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2 text-xs">
                                <span class="text-slate-400 font-medium">Pengajar</span>
                                <span class="max-w-[65%] truncate font-semibold text-slate-700">{{ $modulPengajarNama }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto flex items-stretch gap-2 border-t border-slate-100 bg-slate-50/70 px-4 py-3">
                        <a href="{{ route('modul.show', $module->id_modul) }}"
                            class="flex h-9 flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-100"
                            title="Baca Modul">
                            <svg class="h-3.5 w-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Baca</span>
                        </a>
                        <a href="{{ route('admin.modul.edit', $module->id_modul) }}"
                            class="flex h-9 flex-1 items-center justify-center gap-1.5 rounded-xl border border-indigo-200 bg-white px-3 text-xs font-semibold text-indigo-700 shadow-2xs transition hover:border-indigo-300 hover:bg-indigo-50"
                            title="Edit Modul">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 3.487 3.65 3.65M4 20h4l10.862-10.862a2.58 2.58 0 0 0 0-3.65l-.35-.35a2.58 2.58 0 0 0-3.65 0L4 15.999V20Z" />
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('admin.modul.destroy', $module->id_modul) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus modul ini?')" class="m-0 flex shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus Modul"
                                class="flex h-9 w-10 items-center justify-center rounded-xl border border-rose-200 bg-white p-0 text-rose-600 shadow-2xs transition hover:border-rose-300 hover:bg-rose-50">
                                <svg class="block h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </article>

            @empty

                {{-- Empty state --}}
                <div class="col-span-full bg-white border border-gray-100 rounded-2xl py-16 text-center shadow-xs">

                    <div
                        class="w-16 h-16 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5" />
                        </svg>
                    </div>

                    <h3 class="font-extrabold text-slate-800">
                        Belum Ada Modul
                    </h3>

                    <p class="text-sm text-slate-400 mt-1 mb-5">
                        Tambahkan modul pembelajaran pertama untuk siswa.
                    </p>

                    <a href="{{ route('admin.modul.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm px-4 py-2.5 rounded-xl">
                        + Tambah Modul
                    </a>

                </div>

            @endforelse

        </div>

        @if($moduleCollection->isNotEmpty())
            <div id="moduleNoResults" class="hidden mt-6 bg-white rounded-2xl border-2 border-[#DCEFFF] p-12 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-[#F0F6FF] text-[#007FBE] flex items-center justify-center mx-auto mb-3 text-2xl">
                    🔍
                </div>
                <p class="text-base font-bold text-[#082765]">Modul tidak ditemukan</p>
                <p class="text-xs font-semibold text-[#465673] mt-1">Coba ubah kata kunci pencarian atau filter chip yang dipilih.</p>
                <button type="button" id="moduleNoResultsReset"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-[#007FBE] hover:bg-[#00679A] px-4 py-2 text-xs font-extrabold text-white shadow-[0_2px_0_#005580] transition cursor-pointer">
                    Reset Filter
                </button>
            </div>
        @endif

    </main>
    @endsection

    @push('scripts')
    <script>
        (function () {
            const filterHelper = window.ArravaStudentFilter;
            const searchInput = document.getElementById('searchModule');
            const searchClear = document.getElementById('searchModuleClear');
            const statusContainer = document.getElementById('modul-status-tipe-chips');
            const jenjangContainer = document.getElementById('modul-jenjang-chips');
            const mapelContainer = document.getElementById('modul-mapel-chips');
            const sortSelect = document.getElementById('modulSortSelect');
            const resetBtn = document.getElementById('modulResetBtn');
            const emptyResetBtn = document.getElementById('moduleNoResultsReset');
            const countBadge = document.getElementById('modul-count-badge');
            const noResultsEl = document.getElementById('moduleNoResults');
            const grid = document.getElementById('moduleGrid');
            const hasServerFilter = @json($hasServerFilter);
            const resetUrl = @json(route('admin.modul'));

            let activeStatusTipe = @json($activeStatusTipeChip);
            let activeJenjang = @json($activeJenjangChip);
            let activeMapel = @json($activeMapelChip);

            function sortModuleCards() {
                if (!grid || !sortSelect) return;
                const mode = sortSelect.value;
                const cards = Array.from(grid.querySelectorAll('.module-card'));
                if (cards.length < 2) return;

                cards.sort((a, b) => {
                    const idA = parseInt(a.dataset.id || '0', 10);
                    const idB = parseInt(b.dataset.id || '0', 10);
                    const titleA = a.dataset.title || '';
                    const titleB = b.dataset.title || '';
                    const tipeA = a.dataset.tipe || '';
                    const tipeB = b.dataset.tipe || '';

                    if (mode === 'oldest') return idA - idB;
                    if (mode === 'title_asc') return titleA.localeCompare(titleB);
                    if (mode === 'title_desc') return titleB.localeCompare(titleA);
                    if (mode === 'type_pdf') {
                        const pA = tipeA === 'pdf' ? 0 : 1;
                        const pB = tipeB === 'pdf' ? 0 : 1;
                        return pA !== pB ? pA - pB : idB - idA;
                    }
                    if (mode === 'type_video') {
                        const vA = tipeA === 'video' ? 0 : 1;
                        const vB = tipeB === 'video' ? 0 : 1;
                        return vA !== vB ? vA - vB : idB - idA;
                    }
                    return idB - idA;
                });

                cards.forEach(card => grid.appendChild(card));
            }

            function applyModuleFilters() {
                const keyword = (searchInput?.value || '').toLowerCase().trim();
                const cards = Array.from(document.querySelectorAll('.module-card'));
                let visibleCount = 0;

                cards.forEach(card => {
                    const status = (card.dataset.status || '').toLowerCase();
                    const tipe = (card.dataset.tipe || '').toLowerCase();
                    const jenjang = (card.dataset.jenjang || '').toLowerCase();
                    const mapel = (card.dataset.mapel || '').toLowerCase();
                    const searchText = (card.dataset.search || '').toLowerCase();

                    const matchSearch = keyword === '' || searchText.includes(keyword);

                    let matchStatusTipe = true;
                    const st = activeStatusTipe.toLowerCase();
                    if (st === 'terbit') matchStatusTipe = status === 'terbit';
                    else if (st === 'draft') matchStatusTipe = status === 'draft';
                    else if (st === 'video') matchStatusTipe = tipe === 'video';
                    else if (st === 'pdf') matchStatusTipe = tipe === 'pdf';

                    const matchJenjang = filterHelper.matchesJenjangFilter(jenjang, activeJenjang);

                    const mp = activeMapel.toLowerCase();
                    const matchMapel = mp === 'semua mapel' || mapel === mp;

                    const visible = matchSearch && matchStatusTipe && matchJenjang && matchMapel;
                    card.classList.toggle('hidden', !visible);
                    if (visible) visibleCount++;
                });

                if (countBadge) {
                    countBadge.textContent = `${visibleCount} Modul`;
                }
                if (noResultsEl && cards.length > 0) {
                    noResultsEl.classList.toggle('hidden', visibleCount > 0);
                }

                const isDirty = keyword !== ''
                    || activeStatusTipe !== 'Semua'
                    || activeJenjang !== 'Semua Jenjang'
                    || activeMapel !== 'Semua Mapel'
                    || (sortSelect && sortSelect.value !== 'latest')
                    || hasServerFilter;

                if (resetBtn) {
                    resetBtn.classList.toggle('hidden', !isDirty);
                    resetBtn.classList.toggle('inline-flex', isDirty);
                }
            }

            function resetAllFilters() {
                if (hasServerFilter) {
                    window.location.href = resetUrl;
                    return;
                }
                activeStatusTipe = 'Semua';
                activeJenjang = 'Semua Jenjang';
                activeMapel = 'Semua Mapel';
                if (searchInput) searchInput.value = '';
                if (searchClear) {
                    searchClear.classList.add('hidden');
                    searchClear.classList.remove('inline-flex');
                }
                if (sortSelect) sortSelect.value = 'latest';
                filterHelper.setActiveChip(statusContainer, activeStatusTipe, 'data-status-tipe');
                filterHelper.setActiveChip(jenjangContainer, activeJenjang, 'data-jenjang');
                if (mapelContainer) filterHelper.setActiveChip(mapelContainer, activeMapel, 'data-mapel');
                sortModuleCards();
                applyModuleFilters();
            }

            if (statusContainer) {
                statusContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-status-tipe]');
                    if (!btn) return;
                    if (hasServerFilter) {
                        window.location.href = resetUrl;
                        return;
                    }
                    activeStatusTipe = btn.getAttribute('data-status-tipe') || 'Semua';
                    filterHelper.setActiveChip(statusContainer, activeStatusTipe, 'data-status-tipe');
                    applyModuleFilters();
                });
            }

            if (jenjangContainer) {
                jenjangContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-jenjang]');
                    if (!btn) return;
                    if (hasServerFilter) {
                        window.location.href = resetUrl;
                        return;
                    }
                    activeJenjang = btn.getAttribute('data-jenjang') || 'Semua Jenjang';
                    filterHelper.setActiveChip(jenjangContainer, activeJenjang, 'data-jenjang');
                    applyModuleFilters();
                });
            }

            if (mapelContainer) {
                mapelContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-mapel]');
                    if (!btn) return;
                    if (hasServerFilter) {
                        window.location.href = resetUrl;
                        return;
                    }
                    activeMapel = btn.getAttribute('data-mapel') || 'Semua Mapel';
                    filterHelper.setActiveChip(mapelContainer, activeMapel, 'data-mapel');
                    applyModuleFilters();
                });
            }

            if (sortSelect) {
                sortSelect.addEventListener('change', () => {
                    sortModuleCards();
                    applyModuleFilters();
                });
            }

            filterHelper.bindSearchClear(searchInput, searchClear, applyModuleFilters);
            if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
            if (emptyResetBtn) emptyResetBtn.addEventListener('click', resetAllFilters);

            applyModuleFilters();
        })();
    </script>
    @endpush
