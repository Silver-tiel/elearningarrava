<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Dashboard Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    </div>
</body>
</html>
