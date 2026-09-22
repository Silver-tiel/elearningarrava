<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Modul</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<div class="mx-auto max-w-7xl p-6 md:p-8">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-blue-600">Pembelajaran</p>
            <h1 class="text-3xl font-bold text-slate-900">Modul Pembelajaran</h1>
            <p class="mt-1 text-slate-500">Pilih materi yang ingin kamu pelajari.</p>
        </div>
        <a href="{{ route('siswa.dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">← Dashboard</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($moduls as $modul)
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @if($modul->foto_modul)
                    <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-40 w-full object-cover">
                @else
                    <div class="flex h-40 items-center justify-center bg-blue-50 text-4xl">📚</div>
                @endif
                <div class="p-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">{{ $modul->tipeModul->nama_tipe ?? 'Materi' }}</p>
                    <h2 class="mt-2 text-lg font-bold text-slate-900">{{ $modul->judul_modul }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $modul->jenjang->nama_jenjang ?? 'Semua jenjang' }}</p>
                    @if($modul->file_materi)
                        @if($modul->tipe_file === 'link')
                            <a href="{{ $modul->file_materi }}" target="_blank" rel="noopener" class="mt-4 inline-block text-sm font-semibold text-blue-600">Buka materi →</a>
                        @else
                            <a href="{{ asset('storage/'.$modul->file_materi) }}" target="_blank" class="mt-4 inline-block text-sm font-semibold text-blue-600">Buka materi →</a>
                        @endif
                    @else
                        <span class="mt-4 inline-block text-sm text-slate-400">Materi belum tersedia</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">Belum ada modul yang tersedia.</div>
        @endforelse
    </div>
</div>
</body>
</html>
