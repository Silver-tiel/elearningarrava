<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Modul — Arrava</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .module-image {
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen text-slate-800">

    {{-- =========================================================
        TOPBAR
        Sidebar sengaja TIDAK dibuat karena sudah tersedia.
    ========================================================== --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="h-[72px] px-6 lg:px-8 flex items-center justify-between">

            <div>
                <h1 class="font-extrabold text-[20px] text-slate-900 leading-tight">
                    Pusat Manajemen Modul
                </h1>
            </div>

            <div class="flex items-center gap-5">

                {{-- Search --}}
                <div class="hidden md:flex items-center w-[280px] h-9 bg-slate-50 rounded-xl px-3 gap-2">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
                    </svg>
                    <input type="text" id="searchModule"
                        placeholder="Cari data, laporan, kelas..."
                        class="w-full bg-transparent outline-none text-xs text-slate-600 placeholder:text-slate-400">
                </div>

                {{-- Notification --}}
                <button
                    class="w-9 h-9 rounded-full bg-slate-50 flex items-center justify-center text-slate-700 hover:bg-slate-100 transition">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 0 0-13 0v4.5L4 17h5m6 0a3 3 0 0 1-6 0m6 0H9" />
                    </svg>
                </button>

                {{-- Account --}}
                <button class="flex items-center gap-2 text-sm font-bold text-slate-700">
                    <span>ID</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m6 9 6 6 6-6" />
                    </svg>
                </button>

            </div>
        </div>
    </header>

    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
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

            $totalModul = $moduleCollection->count();

            $totalPublished = $moduleCollection->where('status', 'published')->count();

            $totalReview = $moduleCollection->whereIn('status', ['draft', 'review', 'ditinjau'])->count();
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
                        {{ $totalModul ?: 128 }}
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
                    <p class="text-xs text-slate-400 font-medium">Publish</p>
                    <p class="text-[22px] font-extrabold text-slate-900 leading-tight">
                        {{ $totalPublished ?: 96 }}
                    </p>
                </div>
            </div>

            {{-- Review --}}
            <div
                class="bg-white border border-slate-200 rounded-2xl px-4 py-4 flex items-center gap-4 shadow-sm">
                <div
                    class="w-11 h-11 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="8.5" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M12 7.5v5l3 1.5" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium">Perlu Ditinjau</p>
                    <p class="text-[22px] font-extrabold text-slate-900 leading-tight">
                        {{ $totalReview ?: 18 }}
                    </p>
                </div>
            </div>

        </div>

        {{-- =====================================================
            MODULE GRID
        ====================================================== --}}
        <div id="moduleGrid" class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            @forelse($moduleCollection as $module)

                @php
                    $status = strtolower($module->status ?? 'published');

                    $statusClass = match ($status) {
                        'published', 'publish' =>
                            'bg-emerald-100 text-emerald-600',
                        'draft' =>
                            'bg-amber-100 text-amber-600',
                        'review', 'ditinjau' =>
                            'bg-orange-100 text-orange-600',
                        default =>
                            'bg-slate-100 text-slate-600',
                    };

                    $statusText = match ($status) {
                        'published', 'publish' => 'Published',
                        'draft' => 'Draft',
                        'review', 'ditinjau' => 'Review',
                        default => ucfirst($status),
                    };

                    $image = $module->gambar
                        ?? $module->image
                        ?? $module->thumbnail
                        ?? 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=700&q=80';
                @endphp

                <article
                    class="module-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200"
                    data-search="{{ strtolower(($module->judul ?? '') . ' ' . ($module->kategori ?? '') . ' ' . ($module->guru ?? '')) }}">

                    <div class="flex gap-4">

                        {{-- Thumbnail --}}
                        <div class="w-[160px] h-[200px] rounded-xl overflow-hidden shrink-0 bg-slate-100">
                            <img src="{{ $image }}"
                                alt="{{ $module->judul ?? 'Modul' }}"
                                class="module-image w-full h-full"
                                onerror="this.src='https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=700&q=80'">
                        </div>

                        {{-- Information --}}
                        <div class="min-w-0 flex-1 flex flex-col">

                            <div class="flex items-start justify-between gap-3">

                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-[11px] font-bold
                                    {{ str_contains(strtolower($module->kategori ?? ''), 'matematika')
                                        ? 'bg-amber-100 text-amber-600'
                                        : (str_contains(strtolower($module->kategori ?? ''), 'bahasa')
                                            ? 'bg-blue-50 text-blue-600'
                                            : 'bg-emerald-50 text-emerald-600') }}">
                                    {{ $module->kategori ?? 'Umum' }}
                                </span>

                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-[10px] font-bold {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>

                            </div>

                            <h3 class="font-extrabold text-[16px] text-slate-900 mt-3 leading-tight">
                                {{ $module->judul ?? 'Judul Modul' }}
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
                                    Kelas {{ $module->kelas ?? '-' }}
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

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.modul.edit', $module->id_modul ?? $module->id) }}"
                                        title="Edit Modul"
                                        class="text-blue-500 hover:text-blue-700 transition">
                                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m16.862 3.487 3.65 3.65M4 20h4l10.862-10.862a2.58 2.58 0 0 0 0-3.65l-.35-.35a2.58 2.58 0 0 0-3.65 0L4 15.999V20Z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.modul.destroy', $module->id_modul ?? $module->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="Hapus Modul"
                                            class="text-red-500 hover:text-red-600 transition">
                                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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
