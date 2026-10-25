@extends('layouts.siswa')

@section('title', 'Preview: ' . $quiz->judul . ' — Arrava E-Learning')

@section('header')
<div class="flex items-center gap-2 text-sm text-[#687892]">
    <a href="{{ route('siswa.quiz') }}" class="hover:text-[#172033] transition flex items-center gap-1 font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Daftar Quiz
    </a>
    <span>/</span>
    <span class="text-[#172033] font-semibold truncate max-w-[240px]">{{ $quiz->judul }}</span>
</div>
@endsection

@section('content')
@php
    $expired = $quiz->sudahKadaluarsa();
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-8 py-8 space-y-6">

    @if(isset($errors) && $errors->has('quiz'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ $errors->first('quiz') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->has('token'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center gap-2">
            <span>🔒</span>
            <span>{{ $errors->first('token') }}</span>
        </div>
    @endif

    {{-- Hero Preview Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0B4FB3] via-[#1368CE] to-[#46178F] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 bg-cover bg-center opacity-15 pointer-events-none" style="background-image: url('{{ $quiz->cover_url }}');"></div>
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -right-4 -bottom-6 w-56 h-56 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex-1">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur text-white">
                    📈 {{ $quiz->tingkatQuiz->nama_tingkat ?? 'Umum' }}
                </span>
                @if(isset($hasilSiswa) && $hasilSiswa->poin_didapat > 0)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-300 text-slate-900 shadow-sm">
                        ✅ Selesai (+{{ $hasilSiswa->poin_didapat }} Poin)
                    </span>
                @endif
                @if($quiz->perluToken())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-200 text-purple-950">
                        🔒 Perlu Token
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-950">
                        🔓 Terbuka
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-2 leading-tight">
                {{ $quiz->judul }}
            </h1>

            <p class="text-sm sm:text-base text-blue-100/90 leading-relaxed max-w-2xl">
                {{ $quiz->deskripsi ?: 'Kuis interaktif ini dirancang untuk menguji pemahaman materi yang sudah dipelajari. Periksa informasi di bawah ini sebelum memulai.' }}
            </p>
        </div>

        <div class="relative z-10 shrink-0 w-full md:w-60 aspect-video md:aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20">
            <img src="{{ $quiz->cover_url }}" alt="{{ $quiz->judul }}" class="w-full h-full object-cover">
            @if($expired && !$quiz->perluToken())
                <div class="absolute inset-0 z-10 pointer-events-none select-none flex items-center justify-center bg-black/40 backdrop-blur-[0.5px]">
                    <img src="{{ asset('assets/widget/expiredQuiz.webp') }}"
                         alt="Kuis Kadaluarsa"
                         class="w-full h-full object-cover [image-rendering:pixelated] opacity-90 drop-shadow-md">
                </div>
            @endif
            @if(isset($hasilSiswa) && $hasilSiswa->poin_didapat > 0)
                <div class="absolute top-2 right-2 z-10 pointer-events-none select-none">
                    <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}"
                         alt="Stempel Selesai"
                         class="w-20 h-20 sm:w-24 sm:h-24 object-contain drop-shadow-2xl transform -rotate-12">
                </div>
            @endif
        </div>
    </div>

    {{-- Ringkasan Spesifikasi Kuis --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1">
                <span>📋</span> Jumlah Soal
            </div>
            <div class="text-xl sm:text-2xl font-black text-slate-800">
                {{ $totalSoal ?? $quiz->soal->count() }} <span class="text-xs font-semibold text-slate-400">Soal</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1">
                <span>⏱️</span> Waktu Kuis
            </div>
            <div class="text-lg sm:text-xl font-black text-slate-800">
                {{ $quiz->durasi_total_menit ? ($quiz->durasi_total_menit . ' Menit') : 'Fleksibel' }}
                <span class="block text-[11px] font-semibold text-slate-400">Total estimasi</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1">
                <span>🏆</span> Poin Maksimal
            </div>
            <div class="text-xl sm:text-2xl font-black text-indigo-600">
                {{ $totalPoin ?? $quiz->soal->sum('poin') }} <span class="text-xs font-semibold text-slate-400">Poin</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1">
                <span>⏳</span> Batas Waktu
            </div>
            <div class="text-xs font-bold {{ $expired ? 'text-rose-600' : 'text-slate-700' }}">
                @if($quiz->waktu_kadaluarsa)
                    {{ $quiz->waktu_kadaluarsa->translatedFormat('d M Y, H:i') }}
                    <span class="block text-[10px] {{ $expired ? 'text-rose-500 font-extrabold' : 'text-slate-400' }}">
                        {{ $expired ? 'Waktu sudah berakhir' : 'Sisa waktu aktif' }}
                    </span>
                @else
                    <span class="text-emerald-600 font-bold">Tanpa Batas</span>
                    <span class="block text-[10px] text-slate-400">Dapat dikerjakan kapan saja</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Deskripsi & Petunjuk Pengerjaan --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
        <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
            <span>📖</span> Petunjuk & Aturan Pengerjaan
        </h2>

        <div class="text-sm text-slate-600 leading-relaxed space-y-2.5">
            <div class="flex items-start gap-2.5">
                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-700 mt-0.5">1</span>
                <span>Pastikan perangkat Anda terhubung dengan internet yang stabil sebelum menekan tombol <strong>Mulai Kerjakan</strong>.</span>
            </div>
            <div class="flex items-start gap-2.5">
                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-700 mt-0.5">2</span>
                <span>Setiap pertanyaan kuis memiliki bobot poin dan batas waktu tertentu. Jawablah dengan fokus dan teliti.</span>
            </div>
            <div class="flex items-start gap-2.5">
                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-700 mt-0.5">3</span>
                <span>Periksa kembali setiap jawaban sebelum menekan kirim atau sebelum waktu pengerjaan habis.</span>
            </div>
            @if($quiz->perluToken())
                <div class="flex items-start gap-2.5">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-purple-100 text-[11px] font-bold text-purple-700 mt-0.5">4</span>
                    <span>Kuis ini dilindungi <strong>Token Masuk</strong>. Dapatkan kode token dari guru atau pengawas Anda sebelum memulai.</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Rincian Soal / Tipe Soal yang Ada di Dalam Quiz --}}
    @if(($quiz->opsi_preview ?? 'lengkap') === 'tipe_saja')
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                    <span>🏷️</span> Tipe Soal yang Ada di Dalam Quiz
                </h2>
                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $quiz->soal->groupBy(fn($s) => $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda')->count() }} Format Soal
                </span>
            </div>

            @if($quiz->soal->isEmpty())
                <p class="text-xs text-slate-400 italic py-3 text-center">Belum ada rincian soal untuk kuis ini.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($quiz->soal->groupBy(fn($s) => $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda') as $namaJenis => $items)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700 text-sm font-bold">
                                    ✓
                                </span>
                                <div>
                                    <p class="text-xs font-extrabold text-slate-800">{{ $namaJenis }}</p>
                                    <p class="text-[11px] text-slate-500 font-medium">Format pertanyaan</p>
                                </div>
                            </div>
                            <span class="text-xs font-black px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $items->count() }} Soal
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="p-3.5 rounded-xl bg-amber-50/90 border border-amber-200/80 text-xs text-amber-900 flex items-center gap-2.5">
                    <span class="text-base">🔒</span>
                    <span>Detail pertanyaan kuis ini dirahasiakan oleh pengajar dan akan ditampilkan langsung begitu Anda menekan tombol <strong>Mulai Kerjakan</strong>.</span>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                    <span>📋</span> Daftar Soal yang Ada di Dalam Quiz
                </h2>
                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $quiz->soal->count() }} Pertanyaan
                </span>
            </div>

            @if($quiz->soal->isEmpty())
                <p class="text-xs text-slate-400 italic py-3 text-center">Belum ada rincian soal untuk kuis ini.</p>
            @else
                <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto pr-1">
                    @foreach($quiz->soal as $idx => $s)
                        <div class="py-3 flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3 min-w-0">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-600 text-xs font-black text-white mt-0.5 shadow-sm">
                                    {{ $idx + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 line-clamp-2 leading-snug">
                                        {{ Str::limit(trim(strip_tags($s->pertanyaan)), 130) ?: ('Pertanyaan #' . ($idx + 1)) }}
                                    </p>
                                    <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            🏷️ {{ $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda' }}
                                        </span>
                                        @if($s->durasi_detik)
                                            <span>• ⏱️ {{ $s->durasi_detik }} detik</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    +{{ $s->poin ?? 10 }} Poin
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Banner Riwayat Penyelesaian Kuis --}}
    @if(isset($hasilSiswa) && $hasilSiswa->poin_didapat > 0)
        <div class="p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/90 shadow-sm flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md text-xl">
                    🏆
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-emerald-950">Anda Telah Berhasil Menyelesaikan Kuis Ini</h3>
                    <p class="text-xs text-emerald-800 mt-0.5 font-medium leading-relaxed">
                        Skor perolehan terbaik: <strong>{{ $hasilSiswa->poin_didapat }} Poin</strong>
                        @if($hasilSiswa->waktu_dapat)
                            <span> • {{ \Carbon\Carbon::parse($hasilSiswa->waktu_dapat)->translatedFormat('d M Y, H:i') }}</span>
                        @endif
                        . Anda tetap dapat mengerjakannya kembali untuk mengasah pemahaman materi.
                    </p>
                </div>
            </div>
            <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}"
                 alt="Stempel Selesai"
                 class="w-16 h-16 object-contain shrink-0 hidden sm:block transform -rotate-6 drop-shadow">
        </div>
    @endif

    {{-- Form Mulai Kuis & Token --}}
    <form action="{{ route('siswa.quiz.mulai', $quiz->id_quiz) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
        @csrf

        @if($quiz->perluToken())
            <div class="p-5 rounded-2xl bg-gradient-to-r from-purple-50 to-indigo-50 border-2 border-purple-200 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-600 text-white shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-purple-950">Masukkan Token Kuis</h3>
                        <p class="text-xs text-purple-700">Token diperlukan untuk membuka lembar soal kuis ini.</p>
                    </div>
                </div>

                <div class="pt-1">
                    <input type="text"
                           name="token"
                           id="token-field"
                           value="{{ old('token') }}"
                           required
                           autofocus
                           placeholder="KETIKKAN TOKEN DISINI..."
                           class="w-full max-w-md uppercase font-mono tracking-widest text-center text-lg sm:text-xl font-black py-3 px-4 rounded-xl border-2 {{ (isset($errors) && $errors->has('token')) ? 'border-rose-400 bg-rose-50 text-rose-900 focus:ring-rose-400' : 'border-purple-300 bg-white text-purple-950 focus:border-purple-500 focus:ring-2 focus:ring-purple-200' }} outline-none transition shadow-sm placeholder:text-purple-300 placeholder:font-sans placeholder:tracking-normal placeholder:text-sm">

                    @if(isset($errors) && $errors->has('token'))
                        <p class="mt-2 text-xs font-bold text-rose-600 flex items-center gap-1">
                            <span>❌</span> {{ $errors->first('token') }}
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-2">
            <a href="{{ route('siswa.quiz') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition">
                ← Kembali ke Daftar Quiz
            </a>

            @if($expired)
                <button type="button" disabled class="w-full sm:w-auto cursor-not-allowed px-8 py-3.5 rounded-xl bg-slate-300 text-slate-500 font-extrabold text-sm shadow">
                    ⏰ Waktu Kuis Sudah Berakhir
                </button>
            @elseif($quiz->soal->isEmpty())
                <button type="button" disabled class="w-full sm:w-auto cursor-not-allowed px-8 py-3.5 rounded-xl bg-slate-300 text-slate-500 font-extrabold text-sm shadow">
                    Belum Ada Soal
                </button>
            @else
                <button type="submit" data-quiz-start class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-extrabold text-sm shadow-lg shadow-blue-500/25 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>Mulai Kerjakan Soal</span>
                    <span class="text-base">🚀</span>
                </button>
            @endif
        </div>
    </form>

</div>
@endsection
