@extends('layouts.app')

@section('header')
    <h1 class="text-lg font-bold text-gray-900">Ringkasan Aktivitas Belajar</h1>

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

@section('content')
<div class="p-8 space-y-6">

    <!-- GREETING SECTION -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            Selamat datang kembali, {{ Auth::user()->nama ?? 'Admin' }} 👋
        </h2>
        <p class="text-sm text-gray-500 mt-1">Berikut ringkasan aktivitas dan statistik platform hari ini.</p>
    </div>

    <!-- STATS CARDS (DATA DINAMIS DATABASE) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-xs font-medium text-gray-400">Total Siswa</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($siswaCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Guru -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-xs font-medium text-gray-400">Total Guru</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($guruCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Modul -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-xs font-medium text-gray-400">Total Modul</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($modulCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 4: Total Quiz -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-xs font-medium text-gray-400">Total Quiz</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($quizCount ?? 0) }}</h3>
            </div>
        </div>

    </div>

    <!-- MIDDLE SECTION: SISWA TERBARU & MODUL TERBARU -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- List Siswa Terbaru -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-sm">Siswa Pendaftaran Terbaru</h3>
            </div>

            <div class="space-y-4">
                @forelse($siswaTerbaru ?? [] as $siswa)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 leading-tight">{{ $siswa->nama }}</h4>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $siswa->email ?? 'Siswa' }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] text-gray-400">{{ $siswa->created_at ? $siswa->created_at->diffForHumans() : '-' }}</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>

        <!-- List Modul Terbaru / Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-sm">Modul Terbaru</h3>
                <a href="{{ route('admin.modul') }}" class="text-xs font-semibold text-blue-600 hover:underline">Kelola Modul</a>
            </div>

            <div class="space-y-4">
                @forelse($modulTerbaru ?? [] as $modul)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 leading-tight">{{ $modul->judul_modul }}</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $modul->jenjang->nama_jenjang ?? 'Semua Jenjang' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada modul tersedia.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection