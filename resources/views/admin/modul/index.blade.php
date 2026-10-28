@extends('layouts.app')

@section('header')


    {{-- =========================================================
        TOPBAR
        Sidebar sengaja TIDAK dibuat karena sudah tersedia.
    ========================================================== --}}
    {{-- Header / Topbar Quiz --}}
    <h1 class="text-lg font-bold text-gray-900">Pusat Manajemen Modul</h1>

    <div class="flex items-center gap-4">
        <!-- Icon Notifikasi -->
        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
        </button>
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
                class="bg-white border border-slate-200 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-sm">
                <div
                    class="w-11 h-11 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                class="bg-white border border-slate-200 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-sm">
                <div
                    class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                class="bg-white border border-slate-200 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-sm">
                <div
                    class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm mb-6">
            <form action="{{ route('admin.modul') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                {{-- Pencarian --}}
                <div class="lg:col-span-4 relative">
                    <input type="text" name="q" id="searchModule" value="{{ request('q', $search ?? '') }}"
                        placeholder="Cari judul modul..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                {{-- Filter Status --}}
                <div class="lg:col-span-2">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="all" {{ ($statusFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="published" {{ ($statusFilter ?? '') === 'published' ? 'selected' : '' }}>✓ Terbit</option>
                        <option value="draft" {{ ($statusFilter ?? '') === 'draft' ? 'selected' : '' }}>📝 Draf</option>
                    </select>
                </div>

                {{-- Filter Jenjang --}}
                <div class="lg:col-span-2">
                    <select name="jenjang" onchange="this.form.submit()"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="all" {{ ($jenjangFilter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Jenjang</option>
                        @foreach(($masterJenjang ?? \App\Models\Jenjang::whereIn('id_jenjang', [1,2,3])->get()) as $j)
                            <option value="{{ $j->id_jenjang }}" {{ ($jenjangFilter ?? '') == $j->id_jenjang ? 'selected' : '' }}>Jenjang {{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sortir --}}
                <div class="lg:col-span-2">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Urut: Terbaru</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Urut: Terlama</option>
                        <option value="title_asc" {{ ($sort ?? '') === 'title_asc' ? 'selected' : '' }}>Judul (A - Z)</option>
                        <option value="title_desc" {{ ($sort ?? '') === 'title_desc' ? 'selected' : '' }}>Judul (Z - A)</option>
                    </select>
                </div>

                {{-- Aksi Filter & Reset --}}
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit"
                        class="flex-1 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm text-center">
                        Terapkan
                    </button>
                    @if(request()->hasAny(['q', 'status', 'jenjang', 'tipe', 'sort']))
                        <a href="{{ route('admin.modul') }}"
                            title="Reset Filter"
                            class="p-2 rounded-xl border border-slate-300 text-slate-500 hover:bg-slate-100 transition">
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
        <div id="moduleGrid" class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            @forelse($moduleCollection as $module)

                @php
                    $isDraft = $module->isDraft();
                    $statusClass = $isDraft
                        ? 'bg-amber-100 text-amber-700 border border-amber-200'
                        : 'bg-emerald-100 text-emerald-700 border border-emerald-200';
                    $statusText = $isDraft ? '📝 Draf' : '✓ Terbit';
                    $image = $module->foto_url ?? 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=700&q=80';
                @endphp

                <article
                    class="module-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200"
                    data-search="{{ strtolower(($module->judul_modul ?? '') . ' ' . ($module->tipeModul->nama_tipe ?? '') . ' ' . ($module->jenjang->nama_tipe ?? '')) }}">

                    <div class="flex gap-4">

                        {{-- Thumbnail BARU (Otomatis Mendeteksi YouTube / Cover / PDF) --}}
                        <div class="w-[160px] h-[200px] rounded-xl overflow-hidden shrink-0 bg-slate-100 flex items-center justify-center relative group">
                            @if($module->foto_modul && Storage::disk('public')->exists($module->foto_modul))
                                {{-- Jika ada foto sampul yang diunggah --}}
                                <img src="{{ Storage::url($module->foto_modul) }}"
                                    alt="{{ $module->judul_modul }}"
                                    class="w-full h-full object-cover">
                            @elseif($module->youtube_id)
                                {{-- Sampul Otomatis dari Video YouTube (Sama seperti implementasi di Siswa) --}}
                                <img src="https://img.youtube.com/vi/{{ $module->youtube_id }}/hqdefault.jpg"
                                    alt="{{ $module->judul_modul }}"
                                    class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center shadow-lg text-sm font-bold pl-0.5">
                                        ▶
                                    </div>
                                </div>
                            @elseif($module->tipe_file === 'pdf' || str_ends_with(strtolower($module->file_materi ?? ''), '.pdf'))
                                {{-- Tampilan Sampul Dokumen PDF Elegan --}}
                                <div class="w-full h-full bg-gradient-to-b from-rose-50 to-red-100 border border-red-200 p-3 flex flex-col justify-between items-center text-center">
                                    <span class="px-2 py-0.5 rounded bg-red-600 text-white font-extrabold text-[10px] tracking-wider uppercase shadow-sm">
                                        PDF
                                    </span>
                                    <div class="my-auto flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-red-500 mb-2 border border-red-100">
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM13 3.5L18.5 9H13V3.5zM6 20V4h5v6h6v10H6z"/>
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-800 line-clamp-2 leading-tight px-1">
                                            {{ $module->judul_modul }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-semibold text-red-700 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">
                                        Dokumen Materi
                                    </span>
                                </div>
                            @elseif($module->tipe_file === 'link' || ($module->tipeModul && strtolower($module->tipeModul->nama_tipe) === 'video'))
                                {{-- Tampilan Sampul Materi Video Non-YouTube --}}
                                <div class="w-full h-full bg-gradient-to-b from-blue-50 to-indigo-100 border border-blue-200 p-3 flex flex-col justify-between items-center text-center">
                                    <span class="px-2 py-0.5 rounded bg-blue-600 text-white font-extrabold text-[10px] tracking-wider uppercase shadow-sm">
                                        VIDEO
                                    </span>
                                    <div class="my-auto flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center mb-2 shadow-md">
                                            <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-800 line-clamp-2 leading-tight px-1">
                                            {{ $module->judul_modul }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                                        Video Materi
                                    </span>
                                </div>
                            @else
                                {{-- Default Placeholder Materi --}}
                                <div class="w-full h-full bg-slate-50 border border-slate-200 p-4 flex flex-col items-center justify-center text-slate-400 text-center">
                                    <svg class="w-10 h-10 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-[11px] font-semibold text-slate-500 line-clamp-2">{{ $module->judul_modul }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Information --}}
                        <div class="min-w-0 flex-1 flex flex-col">

                            <div class="flex items-start justify-between gap-3">

                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-[11px] font-bold
                                    {{ str_contains(strtolower($module->tipeModul->nama_tipe ?? ''), 'matematika')
                                        ? 'bg-amber-100 text-amber-600'
                                        : (str_contains(strtolower($module->tipeModul->nama_tipe ?? ''), 'bahasa')
                                            ? 'bg-blue-50 text-blue-600'
                                            : 'bg-emerald-50 text-emerald-600') }}">
                                    {{ $module->tipeModul->nama_tipe ?? 'Umum' }}
                                </span>

                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-[10px] font-bold {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>

                            </div>

                            <h3 class="font-extrabold text-[16px] text-slate-900 mt-3 leading-tight flex items-center gap-2">
                                <span>{{ $module->judul_modul ?? 'Judul Modul' }}</span>
                                @if($isDraft)
                                    <span class="inline-flex items-center text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full shrink-0">
                                        Draf
                                    </span>
                                @endif
                            </h3>

                            <p class="text-xs text-slate-500 leading-relaxed mt-1.5 line-clamp-2">
                                {{ $module->deskripsi ?? 'Deskripsi modul pembelajaran digital untuk membantu siswa memahami materi dengan lebih mudah.' }}
                            </p>

                            {{-- Meta --}}
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-3 text-xs text-slate-500">

                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5v-15Z" />
                                        <path stroke-linecap="round" stroke-width="1.8" d="M4 20.5A2.5 2.5 0 0 1 6.5 18H20" />
                                    </svg>
                                    Jenjang {{ $module->jenjang->nama_tipe ?? '-' }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6.5-6a3 3 0 0 1 0 5.8" />
                                    </svg>
                                    {{ $module->jumlah_siswa ?? $module->siswa_count ?? 0 }} Siswa
                                </span>

                            </div>

                            {{-- Bottom action --}}
                            <div class="border-t border-slate-200 mt-auto pt-3 flex items-center justify-between gap-3">

                                <p class="text-[11px] text-slate-500 truncate">
                                    Oleh:
                                    <span class="font-medium">
                                        {{ $module->guru ?? $module->pengajar ?? 'Admin' }}
                                    </span>
                                </p>

                                <div class="flex items-center gap-3 shrink-0">

                                    {{-- Baca --}}
                                    <a href="{{ route('modul.show', $module->id_modul) }}"
                                        title="Baca Modul"
                                        class="inline-flex items-center justify-center text-emerald-500 hover:text-emerald-700 transition">
                                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.modul.edit', $module->id_modul) }}"
                                        title="Edit Modul"
                                        class="inline-flex items-center justify-center text-blue-500 hover:text-blue-700 transition">
                                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m16.862 3.487 3.65 3.65M4 20h4l10.862-10.862a2.58 2.58 0 0 0 0-3.65l-.35-.35a2.58 2.58 0 0 0-3.65 0L4 15.999V20Z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.modul.destroy', $module->id_modul) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus modul ini?')"
                                        class="inline-flex items-center m-0">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="Hapus Modul"
                                            class="inline-flex items-center justify-center text-red-500 hover:text-red-600 transition">
                                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 7h12M10 11v6m4-6v6M9 7V4h6v3m-9 0 1 13h10l1-13" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

            @empty

                {{-- Empty state --}}
                <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl py-16 text-center">

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
