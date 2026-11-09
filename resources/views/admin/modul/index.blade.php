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
            FILTER & SORTIR TOOLBAR
        ====================================================== --}}
        <div class="bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm mb-6">
            <form action="{{ route('admin.modul') }}" method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3 xl:flex xl:items-center mb-0git">
                {{-- Pencarian --}}
                <div class="relative min-w-0 xl:flex-[1.5]">
                    <input type="text" name="q" id="searchModule" value="{{ request('q', $search ?? '') }}"
                        placeholder="Cari judul modul..."
                        class="box-border h-10 w-full rounded-xl border border-slate-300 py-2 pl-9 pr-4 text-sm transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                {{-- Filter Status --}}
                <div class="min-w-0 xl:flex-1">
                    <select name="status" onchange="this.form.submit()"
                        class="box-border h-10 w-full min-w-0 rounded-xl border border-slate-300 bg-white px-3 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ ($statusFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="published" {{ ($statusFilter ?? '') === 'published' ? 'selected' : '' }}>✓ Terbit</option>
                        <option value="draft" {{ ($statusFilter ?? '') === 'draft' ? 'selected' : '' }}>📝 Draf</option>
                    </select>
                </div>

                {{-- Filter Jenjang --}}
                <div class="min-w-0 xl:flex-1">
                    <select name="jenjang" onchange="this.form.submit()"
                        class="box-border h-10 w-full min-w-0 rounded-xl border border-slate-300 bg-white px-3 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ ($jenjangFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Jenjang</option>
                        @foreach(($masterJenjang ?? \App\Models\Jenjang::whereIn('id_jenjang', [1,2,3])->get()) as $j)
                            <option value="{{ $j->id_jenjang }}" {{ ($jenjangFilter ?? '') == $j->id_jenjang ? 'selected' : '' }}>Jenjang {{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Jenis Modul (PDF, Video, Artikel) --}}
                <div class="min-w-0 xl:flex-1">
                    <select name="tipe" onchange="this.form.submit()"
                        class="box-border h-10 w-full min-w-0 rounded-xl border border-slate-300 bg-white px-3 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ ($tipeFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Jenis</option>
                        @foreach(($masterTipe ?? \App\Models\TipeModul::all()) as $t)
                            <option value="{{ $t->id_tipemodul }}" {{ ($tipeFilter ?? '') == $t->id_tipemodul ? 'selected' : '' }}>
                                @if(stripos($t->nama_tipe, 'pdf') !== false) 📄
                                @elseif(stripos($t->nama_tipe, 'video') !== false) 🎬
                                @elseif(stripos($t->nama_tipe, 'artikel') !== false) 📰
                                @endif
                                {{ $t->nama_tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sortir --}}
                <div class="min-w-0 xl:flex-1">
                    <select name="sort" onchange="this.form.submit()"
                        class="box-border h-10 w-full min-w-0 rounded-xl border border-slate-300 bg-white px-3 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <optgroup label="Urutan Waktu & Judul">
                            <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Urut: Terbaru</option>
                            <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Urut: Terlama</option>
                            <option value="title_asc" {{ ($sort ?? '') === 'title_asc' ? 'selected' : '' }}>Judul (A - Z)</option>
                            <option value="title_desc" {{ ($sort ?? '') === 'title_desc' ? 'selected' : '' }}>Judul (Z - A)</option>
                        </optgroup>
                        <optgroup label="Urutan Berdasarkan Jenis Modul">
                            <option value="type_pdf" {{ ($sort ?? '') === 'type_pdf' ? 'selected' : '' }}>📄 Utamakan: PDF</option>
                            <option value="type_video" {{ ($sort ?? '') === 'type_video' ? 'selected' : '' }}>🎬 Utamakan: Video</option>
                            <option value="type_artikel" {{ ($sort ?? '') === 'type_artikel' ? 'selected' : '' }}>📰 Utamakan: Artikel</option>
                            <option value="type_asc" {{ ($sort ?? '') === 'type_asc' ? 'selected' : '' }}>Jenis Modul (A - Z)</option>
                        </optgroup>
                    </select>
                </div>

                {{-- Aksi Filter & Reset --}}
                <div class="flex h-10 items-center gap-1.5 xl:w-24 xl:shrink-0">
                    <button type="submit" title="Terapkan Filter"
                        class="box-border h-full flex-1 rounded-xl bg-blue-600 px-3 text-center text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Filter
                    </button>
                    @if(request()->hasAny(['q', 'status', 'jenjang', 'tipe', 'sort']))
                        <a href="{{ route('admin.modul') }}"
                            title="Reset Filter"
                            class="box-border inline-flex h-full w-10 shrink-0 items-center justify-center rounded-xl border border-slate-300 text-slate-500 transition hover:bg-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
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
                @endphp

                <article
                    class="module-card group bg-white border border-gray-100 rounded-2xl shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col"
                    data-search="{{ strtolower(($module->judul_modul ?? '') . ' ' . ($module->tipeModul->nama_tipe ?? '') . ' ' . ($module->jenjang->nama_tipe ?? '')) }}">

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
                            </div>
                        </div>

                        <div class="mt-4 space-y-1.5">
                            <div class="flex items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2 text-xs">
                                <span class="text-slate-400 font-medium">Siswa</span>
                                <span class="font-semibold text-slate-700">{{ $module->jumlah_siswa ?? $module->siswa_count ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2 text-xs">
                                <span class="text-slate-400 font-medium">Pengajar</span>
                                <span class="max-w-[65%] truncate font-semibold text-slate-700">{{ $module->guru ?? $module->pengajar ?? 'Admin' }}</span>
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

    </main>
    @endsection

    {{-- Search sederhana --}}
    <script>
        const searchInput = document.getElementById('searchModule');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const keyword = this.value.toLowerCase().trim();

                document.querySelectorAll('.module-card').forEach(card => {
                    const data = card.dataset.search || '';
                    card.classList.toggle('hidden', keyword !== '' && !data.includes(keyword));
                });
            });
        }
    </script>

</body>

</html>
