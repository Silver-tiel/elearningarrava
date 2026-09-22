@extends('layouts.siswa')
@php($active = 'quiz')
@section('header-left')
    <h1 class="text-[20px] font-bold">
        Ruang Quiz Interaktif</h1>
@endsection
@section('content')
    <div class="px-8 py-8">
        <div class="grid grid-cols-[minmax(0,1fr)_320px] gap-6">
            <form method="POST" action="{{ route('siswa.quiz.submit', $quiz->id_quiz) }}" class="space-y-5">
                @csrf
                <div class="flex items-center justify-between rounded-2xl border border-[#dfe6ef] bg-white px-5 py-4">
                    <div>
                        <h1 class="text-[17px] font-bold">{{ $quiz->judul }}</h1>
                        <p class="mt-1 text-[13px] text-[#8b9ab0]">{{ $quiz->tipeQuiz->nama_tipe ?? '' }} • {{ $quiz->tingkatQuiz->nama_tingkat ?? '' }}</p>
                    </div>
                </div>

                @forelse($quiz->soal as $index => $soal)
                <section class="rounded-2xl border border-[#dfe6ef] bg-white p-7" id="soal-{{ $index + 1 }}">
                    <div class="flex items-center justify-between text-[13px] mb-4">
                        <span class="font-semibold text-[#3f82f6]">Soal No. {{ $index + 1 }} dari {{ $quiz->soal->count() }}</span>
                    </div>
                    <h2 class="text-[16px] font-medium leading-7">{{ $soal->pertanyaan }}</h2>
                    <div class="mt-6 space-y-3">
                        @foreach ($soal->pilihanSoal as $pilihan)
                            <label class="flex cursor-pointer items-center gap-4 rounded-xl border border-[#dfe6ef] hover:bg-[#edf4ff] hover:border-[#3f82f6] px-4 py-3.5 text-[13px] font-medium transition">
                                <input type="radio" name="jawaban[{{ $soal->id_soal }}]" value="{{ $pilihan->label }}" class="h-4 w-4 text-[#3f82f6]">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#9eb0c8] text-[#70819a]">{{ $pilihan->label }}</span>
                                <span class="flex-1">{{ $pilihan->teks_pilihan }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Belum ada soal untuk quiz ini.</div>
                @endforelse

                @if($quiz->soal->count() > 0)
                <div class="flex justify-end pt-4">
                    <button type="submit" class="rounded-lg bg-[#3f82f6] px-8 py-3 text-[14px] font-semibold text-white transition hover:bg-[#3172e2]">Kumpulkan Jawaban</button>
                </div>
                @endif
            </form>
            <aside class="space-y-5">
                <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5">
                    <h2 class="text-[15px] font-bold">Informasi Quiz</h2>
                    <dl class="mt-4 space-y-3 text-[13px]">
                        <div class="flex justify-between gap-4">
                            <dt class="text-[#9aabc0]">Jumlah Soal</dt>
                            <dd class="font-semibold">{{ $quiz->soal->count() }} Butir</dd>
                        </div>
                    </dl>
                    
                    <h2 class="mt-6 text-[15px] font-bold">Navigasi Soal</h2>
                    <div class="mt-4 grid grid-cols-5 gap-2">
                        @foreach ($quiz->soal as $index => $s)
                            <a href="#soal-{{ $index + 1 }}" class="flex h-10 items-center justify-center rounded-lg bg-[#f3f7fb] text-[13px] font-medium text-[#6f7e95] hover:bg-[#e2eaf4]">{{ $index + 1 }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5">
                    <h2 class="text-[15px] font-bold">Potensi Penghargaan</h2>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fff1bf] text-xl">🏅</div>
                        <div>
                            <div class="text-[13px] font-semibold">Master Kuadrat 🏆</div>
                            <div class="text-[11px] text-[#9aa8bb]">Selesaikan nilai 100 berturut-turut</div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
