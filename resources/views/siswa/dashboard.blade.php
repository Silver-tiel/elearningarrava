<<<<<<< HEAD
@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" placeholder="Cari modul, soal, tutor, atau siswa..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm text-[#526078] outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-8 py-8">
    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="mb-7">
        <p class="text-sm font-medium text-[#3180f7]">Dashboard Siswa</p>
        <h1 class="mt-1 text-[28px] font-bold tracking-tight text-[#172033]">Halo, {{ $user->nama }} 👋</h1>
        <p class="mt-1.5 text-sm text-[#687892]">Lanjutkan belajar dan kerjakan quiz yang tersedia.</p>
=======
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Dashboard Siswa</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white p-5 md:flex md:flex-col">
            <div class="flex items-center gap-3 px-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 font-bold text-white">eB</div>
                <span class="text-xl font-bold text-slate-900">eBooks</span>
            </div>
            <nav class="mt-8 space-y-2">
                <a href="{{ route('siswa.dashboard') }}" class="block rounded-xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-600">Dashboard</a>
                <a href="{{ route('siswa.modul') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">Modul</a>
                <a href="{{ route('siswa.quiz') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">Quiz</a>
            </nav>
        </aside>
        <main class="min-w-0 flex-1 p-6 md:p-8">
            @if(session('error'))
                <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif
            <div class="mb-8">
                <p class="text-sm font-medium text-blue-600">Dashboard Siswa</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-900">Halo, {{ $user->nama }} 👋</h1>
                <p class="mt-2 text-slate-500">Lanjutkan belajar dan kerjakan quiz yang tersedia.</p>
            </div>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('siswa.modul') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm text-slate-500">Materi Tersedia</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $modulCount }}</p>
                    <p class="mt-4 text-sm font-semibold text-blue-600">Buka modul →</p>
                </a>
                <a href="{{ route('siswa.quiz') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm text-slate-500">Quiz Tersedia</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $quizCount }}</p>
                    <p class="mt-4 text-sm font-semibold text-blue-600">Buka quiz →</p>
                </a>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Poin Saya</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $user->total_poin ?? 0 }}</p>
                    <p class="mt-4 text-sm text-slate-400">Terus belajar untuk menambah poin.</p>
                </div>
            </div>
        </main>
>>>>>>> 7877a60552d5db3a2a46dbebeaebfa6e882ae319
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <a href="{{ route('siswa.modul') }}" class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Materi Tersedia</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">📚</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $modulCount }}</p>
            <p class="mt-4 text-sm font-semibold text-[#3180f7]">Buka modul →</p>
        </a>

        <a href="{{ route('siswa.quiz') }}" class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Quiz Tersedia</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">✎</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $quizCount }}</p>
            <p class="mt-4 text-sm font-semibold text-[#3180f7]">Buka quiz →</p>
        </a>

        <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Poin Saya</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">★</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $user->total_poin ?? 0 }}</p>
            <p class="mt-4 text-sm text-[#8b98aa]">Terus belajar untuk menambah poin.</p>
        </div>
    </div>

    <div class="mt-8 flex items-center justify-between">
        <div>
            <h2 class="text-[19px] font-bold text-[#172033]">Lanjutkan Belajar</h2>
            <p class="mt-1 text-sm text-[#718098]">Pilih materi yang ingin kamu lanjutkan.</p>
        </div>
        <a href="{{ route('siswa.modul') }}" class="text-sm font-semibold text-[#3180f7]">Lihat Semua</a>
    </div>

    <div class="mt-4 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        @forelse($moduls ?? [] as $modul)
            <a href="{{ route('siswa.modul') }}" class="overflow-hidden rounded-2xl border border-[#dfe6ef] bg-white transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="h-36 bg-[#eef3f8]">
                    @if($modul->foto_modul)
                        <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full items-center justify-center text-4xl">📚</div>
                    @endif
                </div>
                <div class="p-4">
                    <span class="rounded-md bg-[#eef6ff] px-2 py-1 text-[11px] font-semibold text-[#3180f7]">{{ $modul->tipeModul->nama_tipe ?? 'Materi' }}</span>
                    <h3 class="mt-3 line-clamp-2 text-[15px] font-bold text-[#172033]">{{ $modul->judul_modul }}</h3>
                    <p class="mt-1 text-xs text-[#718098]">{{ $modul->jenjang->nama_jenjang ?? 'Semua jenjang' }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-10 text-center text-sm text-[#7c899c]">Belum ada materi.</div>
        @endforelse
    </div>
</div>
@endsection
