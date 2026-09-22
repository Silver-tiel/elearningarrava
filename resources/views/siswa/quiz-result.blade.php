@extends('layouts.siswa')
@php($active = 'quiz')

@section('content')
<div class="flex h-[calc(100vh-72px)] items-center justify-center p-8">
    <div class="w-full max-w-md overflow-hidden rounded-2xl border border-[#dfe6ef] bg-white text-center shadow-lg">
        <div class="bg-gradient-to-b from-[#eef6ff] to-white px-8 pb-6 pt-10">
            <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full {{ $hasil->poin_didapat >= 75 ? 'bg-[#e7f8f2] text-4xl text-[#10a879]' : 'bg-[#fff0f0] text-4xl text-red-500' }}">
                {{ $hasil->poin_didapat >= 75 ? '🏆' : '😥' }}
            </div>
            <h1 class="text-[22px] font-bold text-[#172033]">{{ $hasil->poin_didapat >= 75 ? 'Luar Biasa!' : 'Tetap Semangat!' }}</h1>
            <p class="mt-2 text-[14px] text-[#687892]">Kamu telah menyelesaikan quiz <strong>{{ $quiz->judul }}</strong></p>
        </div>
        
        <div class="border-t border-[#edf0f4] px-8 py-6">
            <div class="mb-6 flex items-center justify-between rounded-xl bg-[#f5f8fc] px-6 py-4">
                <div class="text-left">
                    <p class="text-[12px] font-medium text-[#718098]">Skor Kamu</p>
                    <p class="text-[28px] font-bold {{ $hasil->poin_didapat >= 75 ? 'text-[#10a879]' : 'text-red-500' }}">{{ $hasil->poin_didapat }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[12px] font-medium text-[#718098]">Total Poin</p>
                    <p class="text-[28px] font-bold text-[#172033]">{{ $hasil->total_poin }}</p>
                </div>
            </div>
            
            <a href="{{ route('siswa.quiz') }}" class="block w-full rounded-xl bg-[#3d82f6] py-3.5 text-[14px] font-semibold text-white transition hover:bg-[#3172e2]">
                Kembali ke Daftar Quiz
            </a>
        </div>
    </div>
</div>
@endsection
