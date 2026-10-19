@extends('layouts.app')

@section('content')
<div class="p-8 space-y-6">

    <!-- HEADER & ACTION -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 text-amber-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </span>
                <h1 class="text-2xl font-bold text-slate-800">
                    Penghargaan &amp; Achievement Siswa
                </h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Kelola lencana tanda pencapaian, kriteria minimal poin, dan penghargaan otomatis untuk siswa.
            </p>
        </div>

        <a href="{{ route('admin.achievement.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium text-sm shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>+ Buat Achievement Baru</span>
        </a>
    </div>

    <!-- NOTIFIKASI SUCCESS / ERROR -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- STATS SUMMARY -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Achievement</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-800">{{ number_format($totalAchievement) }}</span>
                <span class="text-xs text-slate-400 ml-1">lencana dibuat</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-emerald-600">{{ number_format($totalAktif) }}</span>
                <span class="text-xs text-slate-400 ml-1">dapat diraih siswa</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Penghargaan Diraih</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-800">{{ number_format($totalDiberikan) }}</span>
                <span class="text-xs text-slate-400 ml-1">klaim penghargaan</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Siswa Berprestasi</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-amber-600">{{ number_format($siswaPenerimaCount) }}</span>
                <span class="text-xs text-slate-400 ml-1">siswa punya lencana</span>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.achievement') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama achievement atau deskripsi..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-44">
                <select name="status"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                </select>
            </div>

            <!-- Sort -->
            <div class="w-full md:w-48">
                <select name="sort"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru Ditambahkan</option>
                    <option value="poin_terendah" @selected(request('sort') === 'poin_terendah')>Minimal Poin Terendah</option>
                    <option value="poin_tertinggi" @selected(request('sort') === 'poin_tertinggi')>Minimal Poin Tertinggi</option>
                    <option value="nama_asc" @selected(request('sort') === 'nama_asc')>Nama (A - Z)</option>
                    <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
                </select>
            </div>

            <!-- Submit & Reset -->
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm rounded-xl transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'sort']))
                    <a href="{{ route('admin.achievement') }}"
                       class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- GRID ACHIEVEMENT CARDS -->
    @if($achievements->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($achievements as $item)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition flex flex-col justify-between overflow-hidden">
                    <div class="p-6">
                        <!-- Top Row: Badge Icon & Status -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="relative">
                                @if($item->gambar_achivement && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->gambar_achivement))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->gambar_achivement) }}"
                                         alt="{{ $item->nama_achivement }}"
                                         class="w-16 h-16 rounded-2xl object-cover ring-4 ring-amber-50 shadow-sm bg-slate-50">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center font-bold text-2xl ring-4 ring-amber-50 shadow-sm">
                                        🏆
                                    </div>
                                @endif
                                
                                @if($item->is_active)
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 ring-2 ring-white" title="Aktif"></span>
                                @else
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-slate-400 ring-2 ring-white" title="Nonaktif"></span>
                                @endif
                            </div>

                            <div class="flex flex-col items-end gap-1.5">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $item->is_active ? '● Aktif' : '○ Nonaktif' }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    ★ {{ number_format($item->minimal_poin_achivement) }} Poin
                                </span>
                            </div>
                        </div>

                        <!-- Info: Nama & Deskripsi -->
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-slate-800 leading-snug">
                                {{ $item->nama_achivement }}
                            </h3>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}
                            </p>
                        </div>

                        <!-- Metadata: Penerima Siswa -->
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center gap-1.5 font-medium text-slate-700">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ number_format($item->pencapaian_users_count ?? 0) }} Siswa telah meraih
                            </span>
                            <span class="text-slate-400">
                                ID: #{{ $item->id_achievement }}
                            </span>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="px-6 py-3.5 bg-slate-50/70 border-t border-gray-100 flex items-center justify-between gap-2">
                        <!-- Tombol Sinkronisasi -->
                        <form action="{{ route('admin.achievement.sync', $item->id_achievement) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    title="Sinkronkan ke seluruh siswa yang memenuhi syarat poin"
                                    class="text-xs font-medium text-slate-600 hover:text-blue-600 inline-flex items-center gap-1 py-1 px-2 rounded-lg hover:bg-white transition">
                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                <span>Sinkron Siswa</span>
                            </button>
                        </form>

                        <div class="flex items-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.achievement.edit', $item->id_achievement) }}"
                               class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-yellow-50 text-yellow-700 hover:bg-yellow-100 border border-yellow-200 transition">
                                Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.achievement.destroy', $item->id_achievement) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus penghargaan &quot;{{ $item->nama_achivement }}&quot;? Data pencapaian siswa yang terhubung juga akan dibersihkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $achievements->links() }}
        </div>
    @else
        <!-- EMPTY STATE -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 mx-auto flex items-center justify-center text-3xl mb-4">
                🏆
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum ada achievement ditemukan</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto mt-1">
                @if(request()->hasAny(['search', 'status']))
                    Tidak ada penghargaan yang sesuai dengan kata kunci atau filter pencarian Anda.
                @else
                    Belum ada data penghargaan/achievement yang dibuat untuk siswa. Silakan buat yang pertama!
                @endif
            </p>
            <div class="mt-6 flex justify-center gap-3">
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.achievement') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                        Reset Filter
                    </a>
                @endif
                <a href="{{ route('admin.achievement.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition">
                    + Tambah Achievement Baru
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
