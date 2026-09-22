<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Quiz</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<div class="mx-auto max-w-7xl p-6 md:p-8">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-blue-600">Latihan</p>
            <h1 class="text-3xl font-bold text-slate-900">Quiz</h1>
            <p class="mt-1 text-slate-500">Pilih quiz yang ingin kamu kerjakan.</p>
        </div>
        <a href="{{ route('siswa.dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">← Dashboard</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($quizzes as $quiz)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl">📝</div>
                <h2 class="mt-4 text-lg font-bold text-slate-900">{{ $quiz->judul }}</h2>
                <p class="mt-2 text-sm text-slate-500">Quiz pembelajaran eBooks.</p>
                <div class="mt-5 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-400">Quiz tersedia</span>
                    <span class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white">Mulai</span>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">Belum ada quiz yang tersedia.</div>
        @endforelse
    </div>
</div>
</body>
</html>
