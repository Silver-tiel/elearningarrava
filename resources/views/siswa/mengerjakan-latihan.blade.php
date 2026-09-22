@extends('layouts.siswa')
@php($active = 'latihan')
@section('header-left')
    <h1 class="text-[20px] font-bold">
        Latihan Soal</h1>
@endsection
@section('content')
    <div class="px-8 py-8">
        <div class="mb-8">
            <h1 class="text-[28px] font-bold">{{ $quiz->judul }}</h1>
            <p class="mt-1 text-[14px] text-[#71809a]">{{ $quiz->tipeQuiz->nama_tipe ?? '' }} • {{ $quiz->soal->count() }} soal • {{ $quiz->tingkatQuiz->nama_tingkat ?? '' }}</p>
        </div>
        <form method="POST" action="{{ route('siswa.quiz.submit', $quiz->id_quiz) }}" class="grid grid-cols-[minmax(0,1fr)_300px] gap-5">
            @csrf
            <div class="space-y-5">
                @forelse($quiz->soal as $index => $soal)
                <section class="rounded-2xl border border-[#dfe6ef] bg-white p-7" id="soal-{{ $index + 1 }}">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[13px] font-semibold text-[#3180f7]">Soal {{ $index + 1 }} dari {{ $quiz->soal->count() }}</span>
                    </div>
                    <h2 class="mt-2 text-[20px] font-bold">{{ $soal->pertanyaan }}</h2>
                    <div class="mt-6 space-y-4">
                        @foreach ($soal->pilihanSoal as $pilihan)
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-[#dfe6ef] hover:border-[#3f82f6] hover:bg-[#edf4ff] px-4 py-4 text-[14px] transition">
                                <input type="radio" name="jawaban[{{ $soal->id_soal }}]" value="{{ $pilihan->label }}" class="h-4 w-4 text-[#3f82f6]">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#9eb0c8] text-[#70819a]">{{ $pilihan->label }}</span>
                                <span class="flex-1">{{ $pilihan->teks_pilihan }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Belum ada soal untuk latihan ini.</div>
                @endforelse

                @if($quiz->soal->count() > 0)
                <div class="flex justify-end pt-2">
                    <button type="submit" class="rounded-lg bg-[#3f82f6] px-8 py-3 text-[14px] font-semibold text-white transition hover:bg-[#3172e2]">Kumpulkan Jawaban</button>
                </div>
                @endif
            </div>
            
            <aside class="h-fit rounded-2xl border border-[#dfe6ef] bg-white p-5">
                <h2 class="text-[16px] font-bold">Navigasi Soal</h2>
                <div class="mt-4 grid grid-cols-5 gap-2">
                    @foreach ($quiz->soal as $index => $soal)
                        <a href="#soal-{{ $index + 1 }}" class="flex h-11 items-center justify-center rounded-lg bg-[#f3f7fb] text-[12px] font-medium text-[#6f7e95] hover:bg-[#e2eaf4]">{{ $index + 1 }}</a>
                    @endforeach
                </div>
            </aside>
        </form>
    </div>
@endsection
