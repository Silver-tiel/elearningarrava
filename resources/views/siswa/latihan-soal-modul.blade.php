@extends('layouts.siswa')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
           class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f5f8fc] text-[#52617a] hover:bg-[#e9eef5]">
            ←
        </a>
        <h1 class="text-[18px] font-extrabold text-[#172033]">
            Latihan Soal — {{ $modul->judul_modul }}
        </h1>
    </div>
@endsection

@section('content')
<div class="px-8 py-6">
    <div class="mb-6">
        <h1 class="text-[22px] font-extrabold text-[#172033]">Latihan Soal</h1>
        <p class="mt-1 text-[13px] text-[#687892]">
            Pilih quiz di bawah untuk menguji pemahamanmu dari modul
            <span class="font-semibold">{{ $modul->judul_modul }}</span>.
        </p>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($quizzes as $quiz)
            <a href="{{ route('siswa.quiz.kerjakan', $quiz->id_quiz) }}"
               class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#edf5ff] text-xl font-bold text-[#3180f7]">
                    ?
                </div>
                <h2 class="mt-4 text-[16px] font-bold text-[#172033]">{{ $quiz->judul }}</h2>
                <p class="mt-2 text-[13px] text-[#718098]">
                    {{ $quiz->jenjang->nama_tipe ?? 'Semua jenjang' }} ·
                    {{ $quiz->tingkatQuiz->nama_tingkat ?? 'Tingkat umum' }}
                </p>
                <div class="mt-5 flex items-center justify-between border-t border-[#edf0f4] pt-4">
                    <span class="text-[12px] text-[#8a97a9]">{{ $quiz->soal_count ?? 0 }} soal</span>
                    <span class="rounded-lg bg-[#3d82f6] px-3 py-2 text-[12px] font-semibold text-white">Mulai</span>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
                Belum ada latihan soal untuk modul ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
