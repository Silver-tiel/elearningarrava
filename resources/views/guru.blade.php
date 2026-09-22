<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Dashboard Guru</title>
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
                <a href="{{ route('guru.dashboard') }}" class="block rounded-xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-600">Dashboard</a>
                <a href="{{ route('guru.modul') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">Modul</a>
                <a href="{{ route('guru.quiz') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">Quiz</a>
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">Dashboard Utama</a>
            </nav>
        </aside>
        <main class="min-w-0 flex-1 p-6 md:p-8">
            @if(session('error'))
                <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif
            <div class="mb-8">
                <p class="text-sm font-medium text-blue-600">Dashboard Guru</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-900">Selamat datang, {{ $user->nama }} 👋</h1>
                <p class="mt-2 text-slate-500">Kelola materi dan quiz pembelajaran dari halaman ini.</p>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Modul</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $modulCount }}</p>
                    <a href="{{ route('guru.modul') }}" class="mt-4 inline-block text-sm font-semibold text-blue-600">Lihat modul →</a>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Quiz</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $quizCount }}</p>
                    <a href="{{ route('guru.quiz') }}" class="mt-4 inline-block text-sm font-semibold text-blue-600">Lihat quiz →</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
