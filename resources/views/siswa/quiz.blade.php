<<<<<<< HEAD
@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
    <input type="text" placeholder="Cari quiz, soal, atau materi..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-8 py-8">
    <div class="mb-6">
        <h1 class="text-[24px] font-bold tracking-tight text-[#172033]">Quiz</h1>
        <p class="mt-1 text-sm text-[#687892]">Uji pemahamanmu dari materi yang sudah dipelajari.</p>
=======
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
>>>>>>> 7877a60552d5db3a2a46dbebeaebfa6e882ae319
    </div>
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($quizzes as $quiz)
            <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#edf5ff] text-xl text-[#3180f7]">?</div>
                <h2 class="mt-4 text-[16px] font-bold text-[#172033]">{{ $quiz->judul }}</h2>
                <p class="mt-2 text-sm text-[#718098]">Quiz pembelajaran eBooks.</p>
                <div class="mt-5 flex items-center justify-between border-t border-[#edf0f4] pt-4">
                    <span class="text-xs text-[#8a97a9]">Quiz tersedia</span>
                    <a href="{{ route('siswa.quiz.kerjakan', $quiz->id_quiz) }}" class="rounded-lg bg-[#3d82f6] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#3172e2]">Mulai</a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Belum ada quiz yang tersedia.</div>
        @endforelse
    </div>
</div>
@endsection
