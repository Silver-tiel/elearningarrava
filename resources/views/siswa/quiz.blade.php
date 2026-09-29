@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
    <input type="text" placeholder="Cari quiz, soal, atau materi..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-8 py-8">
    @if($errors->has('quiz'))
        <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ $errors->first('quiz') }}</div>
    @endif
    <div class="mb-6">
        <h1 class="text-[24px] font-bold tracking-tight text-[#172033]">Quiz</h1>
        <p class="mt-1 text-sm text-[#687892]">Uji pemahamanmu dari materi yang sudah dipelajari.</p>
    </div>

    <form method="GET" action="{{ route('siswa.quiz') }}" class="mb-6 grid gap-3 rounded-xl border border-[#dfe6ef] bg-white p-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto_auto] sm:items-end">
        <div>
            <label for="filter-jenjang" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Jenjang</label>
            <select id="filter-jenjang" name="jenjang" class="h-10 w-full rounded-lg border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <option value="">Semua jenjang</option>
                @foreach($jenjangList as $jenjang)
                    <option value="{{ $jenjang->id_jenjang }}" @selected(request('jenjang') == $jenjang->id_jenjang)>{{ $jenjang->nama_tipe }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="filter-tingkat" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Kesulitan</label>
            <select id="filter-tingkat" name="tingkat" class="h-10 w-full rounded-lg border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <option value="">Semua tingkat</option>
                @foreach($tingkatQuizList as $tingkat)
                    <option value="{{ $tingkat->id_tingkatquiz }}" @selected(request('tingkat') == $tingkat->id_tingkatquiz)>{{ $tingkat->nama_tingkat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="h-10 rounded-lg bg-[#3180f7] px-4 text-sm font-semibold text-white transition hover:bg-[#246bd4]">Terapkan</button>
        <a href="{{ route('siswa.quiz') }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#d5deea] px-4 text-sm font-semibold text-[#52627a] transition hover:bg-[#f5f8fc]">Reset</a>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($quizzes as $quiz)
            <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#edf5ff] text-xl text-[#3180f7]">?</div>
                <h2 class="mt-4 text-[16px] font-bold text-[#172033]">{{ $quiz->judul }}</h2>
                <p class="mt-2 text-sm text-[#718098]">{{ $quiz->jenjang->nama_tipe ?? 'Semua jenjang' }} · {{ $quiz->tingkatQuiz->nama_tingkat ?? 'Tingkat umum' }}</p>
                <div class="mt-5 flex items-center justify-between border-t border-[#edf0f4] pt-4">
                    <span class="text-xs text-[#8a97a9]">Quiz tersedia</span>
                    <a href="{{ route('siswa.quiz.kerjakan', $quiz->id_quiz) }}" class="rounded-lg bg-[#3d82f6] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#3172e2]">Mulai</a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Tidak ada quiz yang sesuai dengan filter ini.</div>
        @endforelse
    </div>
</div>
@endsection
