@extends('layouts.app')

@section('header')
    {{-- Header / Topbar Quiz --}}
    <div class="flex items-center gap-3 min-w-0">

        <div class="min-w-0">

            <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
                Kelola Kuis Pembelajaran
            </h1>

            <p class="text-xs text-slate-500 truncate">
                Daftar kuis interaktif yang tersedia di platform
            </p>
        </div>
    </div>

    {{-- Tombol Buat Quiz --}}
    <a href="{{ route('admin.quiz.create') }}"
        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-md shadow-indigo-500/20 transition transform hover:-translate-y-0.5 shrink-0">
        <span class="text-lg">✨</span>
        <span class="hidden sm:inline">
            Buat Quiz
        </span>
        <span class="sm:hidden">
            Buat Quiz
        </span>
    </a>
@endsection
@section('content')
    <main class="px-6 lg:px-8 py-8">

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">
                        🎉
                    </span>
                    <span class="font-semibold text-sm">
                        {{ session('success') }}
                    </span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    ✕
                </button>
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div role="alert" aria-live="assertive" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
                <div>Quiz tidak dapat diproses:</div>
                <ul class="mt-1 list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Hero Banner --}}
        <div
            class="bg-gradient-to-r from-[#46178F] via-[#1368CE] to-[#0B4FB3] rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            {{-- Background Decoration --}}
            <div class="absolute -right-10 -bottom-10 opacity-20 pointer-events-none">
                <svg class="w-72 h-72 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 19h20L12 2z" />
                </svg>
            </div>

            <div class="relative z-10 max-w-2xl">

                <span
                    class="inline-block bg-white/20 backdrop-blur text-yellow-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    Editor Interaktif Kahoot! 360 Style
                </span>

                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                    Buat Pengalaman Belajar Seru untuk Siswa
                </h2>

                <p class="text-white/80 text-sm mb-6">
                    Tambahkan soal pilihan ganda warna-warni,
                    timer detik, serta kunci jawaban langsung
                    dalam satu tampilan visual yang intuitif.
                </p>

                <a href="{{ route('admin.quiz.create') }}"
                    class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-extrabold text-sm px-5 py-3 rounded-xl shadow-lg transition transform hover:scale-105">

                    <span>
                        ⚡ Buka Editor Quiz Baru
                    </span>
                </a>
            </div>
        </div>

        {{-- Card Semua Quiz --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Header Card & Filters --}}
            <div class="p-5 border-b border-slate-100 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-base">
                        Semua Quiz ({{ $quizzes->count() }})
                    </h3>
                </div>
                <form method="GET" action="{{ route('admin.quiz') }}" class="flex flex-col sm:flex-row sm:items-end gap-3">
                    <div class="flex-1">
                        <label for="filter-jenjang" class="mb-1 block text-xs font-semibold text-slate-500">Jenjang</label>
                        <select id="filter-jenjang" name="jenjang" class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">Semua jenjang</option>
                            @foreach($jenjangList as $jenjang)
                                <option value="{{ $jenjang->id_jenjang }}" @selected(request('jenjang') == $jenjang->id_jenjang)>{{ $jenjang->nama_tipe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="filter-tingkat" class="mb-1 block text-xs font-semibold text-slate-500">Kesulitan</label>
                        <select id="filter-tingkat" name="tingkat" class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">Semua tingkat</option>
                            @foreach($tingkatQuizList as $tingkat)
                                <option value="{{ $tingkat->id_tingkatquiz }}" @selected(request('tingkat') == $tingkat->id_tingkatquiz)>{{ $tingkat->nama_tingkat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="filter-sort" class="mb-1 block text-xs font-semibold text-slate-500">Urutkan</label>
                        <select id="filter-sort" name="sort" class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="terbaru" @selected(request('sort') == 'terbaru')>Terbaru</option>
                            <option value="terlama" @selected(request('sort') == 'terlama')>Terlama</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="h-9 rounded-lg bg-indigo-600 px-4 text-sm font-semibold text-white transition hover:bg-indigo-700">Terapkan</button>
                        <a href="{{ route('admin.quiz') }}" class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-200 px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Jika Belum Ada Quiz --}}
            @if ($quizzes->isEmpty())
                <div class="text-center py-16 px-4">
                    <div
                        class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        🧩
                    </div>

                    <h4 class="font-bold text-slate-700 text-base mb-1">
                        Belum Ada Quiz
                    </h4>

                    <p class="text-slate-400 text-sm max-w-sm mx-auto mb-6">
                        Mulai buat quiz pembelajaran interaktif
                        pertama Anda sekarang!
                    </p>

                    <a href="{{ route('admin.quiz.create') }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition">
                        + Buat Quiz Sekarang
                    </a>
                </div>

                {{-- Jika Sudah Ada Quiz --}}
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>

                            <tr
                                class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold text-xs uppercase tracking-wider">

                                <th class="py-3.5 px-6">
                                    Judul Kuis
                                </th>

                                <th class="py-3.5 px-4">
                                    Jumlah Soal
                                </th>

                                <th class="py-3.5 px-4">
                                    Status
                                </th>

                                <th class="py-3.5 px-4 text-right">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 font-medium">
                            @foreach ($quizzes as $quiz)
                                @php
                                    $expired = $quiz->sudahKadaluarsa();
                                    $status = $expired ? 'Kadaluarsa' : ($quiz->proggressQuiz ?: 'Tersedia');
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    {{-- Judul --}}
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg shrink-0">
                                                ❓
                                            </div>

                                            <div>
                                                <div class="font-bold text-slate-800 text-base">
                                                    {{ $quiz->judul }}
                                                </div>

                                                <div class="text-xs text-slate-400">
                                                    ID: #{{ $quiz->id_quiz }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Jumlah Soal --}}
                                    <td class="py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                            {{ $quiz->soal_count ?? 0 }} Soal
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $expired ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.quiz.preview', $quiz->id_quiz) }}" target="_blank"
                                                class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                                👁️ Pratinjau
                                            </a>
                                            <a href="{{ route('admin.quiz.edit', $quiz->id_quiz) }}"
                                                class="px-3 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.quiz.destroy', $quiz->id_quiz) }}" method="POST" onsubmit="return confirm('Hapus quiz beserta seluruh soalnya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>
@endsection
