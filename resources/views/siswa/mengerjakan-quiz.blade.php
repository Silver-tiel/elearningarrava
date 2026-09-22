@extends('layouts.siswa')

@php
    $active = 'quiz';
    $kahootStyles = [
        'A' => ['bg' => 'bg-[#E21B3C]', 'hover' => 'hover:border-[#E21B3C]', 'icon' => '▲'],
        'B' => ['bg' => 'bg-[#1368CE]', 'hover' => 'hover:border-[#1368CE]', 'icon' => '◆'],
        'C' => ['bg' => 'bg-[#D89E00]', 'hover' => 'hover:border-[#D89E00]', 'icon' => '●'],
        'D' => ['bg' => 'bg-[#26890C]', 'hover' => 'hover:border-[#26890C]', 'icon' => '■'],
    ];
@endphp

@section('header-left')
    <h1 class="text-[20px] font-bold text-slate-800">Ruang Quiz Interaktif</h1>
@endsection

@section('content')
    @if(session('quiz_result'))
        <div id="quizResultModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center border-t-8 border-indigo-600 animate-bounce-in">
                <div class="w-20 h-20 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <span class="text-4xl">🏆</span>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Quiz Selesai!</h2>
                <p class="text-sm text-slate-500 mb-6">Berikut adalah hasil pencapaian Anda</p>
                
                <div class="bg-slate-50 rounded-2xl p-6 mb-6">
                    <div class="text-5xl font-black text-indigo-600 mb-2">{{ session('quiz_result')['poin_didapat'] }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wide">Poin Didapat</div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-left mb-8">
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                        <div class="text-2xl font-bold text-emerald-700">{{ session('quiz_result')['benar'] }}</div>
                        <div class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Jawaban Benar</div>
                    </div>
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                        <div class="text-2xl font-bold text-indigo-700">{{ session('quiz_result')['total_soal'] }}</div>
                        <div class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">Total Soal</div>
                    </div>
                </div>

                <a href="{{ route('siswa.dashboard') }}" class="block w-full py-3.5 rounded-xl font-bold text-white bg-slate-900 hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 mb-3">
                    Kembali ke Dashboard
                </a>
                <button type="button" onclick="document.getElementById('quizResultModal').style.display='none'" class="w-full py-2 rounded-xl font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                    Tutup Modal
                </button>
            </div>
        </div>
        
        <style>
            @keyframes bounce-in {
                0% { transform: scale(0.8); opacity: 0; }
                60% { transform: scale(1.05); opacity: 1; }
                100% { transform: scale(1); opacity: 1; }
            }
            .animate-bounce-in {
                animation: bounce-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }
        </style>
    @endif

    <div class="px-6 py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_300px] gap-6">
            
            {{-- Main Form Kuis --}}
            <form method="POST" action="{{ route('siswa.quiz.submit', $quiz->id_quiz) }}" class="space-y-6">
                @csrf
                
                {{-- Quiz Header Card --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 mb-2">
                            <span>🎮 Mode Kahoot! Interaktif</span>
                        </div>
                        <h1 class="text-xl font-extrabold text-slate-800">{{ $quiz->judul }}</h1>
                        <p class="text-xs text-slate-500 mt-1">Total: {{ $quiz->soal->count() }} Pertanyaan</p>
                    </div>
                </div>

                {{-- Loop Soal --}}
                @if($quiz->soal->count() > 0)
                    @foreach($quiz->soal as $index => $soal)
                        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm overflow-hidden" id="soal-{{ $index + 1 }}">
                            {{-- Top badge --}}
                            <div class="flex items-center justify-between text-xs font-bold mb-3">
                                <span class="text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                                    Pertanyaan No. {{ $index + 1 }} / {{ $quiz->soal->count() }}
                                </span>
                                <span class="text-slate-400">⏱️ Batas Waktu 20s</span>
                            </div>

                            {{-- Pertanyaan --}}
                            <div class="my-4 bg-slate-900 text-white rounded-xl p-5 text-center text-lg font-bold shadow-inner">
                                "{{ $soal->pertanyaan }}"
                            </div>

                            @if(count($soal->pilihanSoal) > 0)
                                {{-- Kahoot Colorful Answer Grid (Pilihan Ganda) --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-5">
                                    @foreach ($soal->pilihanSoal as $pIndex => $pilihan)
                                        @php
                                            $lbl = strtoupper($pilihan->label);
                                            $style = isset($kahootStyles[$lbl]) ? $kahootStyles[$lbl] : ['bg' => 'bg-indigo-600', 'hover' => 'hover:border-indigo-600', 'icon' => '●'];
                                        @endphp
                                        <label class="group relative flex items-center rounded-xl border-2 border-slate-200 bg-white hover:shadow-md cursor-pointer transition overflow-hidden p-2">
                                            <input type="radio" name="jawaban[{{ $soal->id_soal }}]" value="{{ $pilihan->label }}" class="peer sr-only">
                                            
                                            {{-- Shape Badge --}}
                                            <div class="w-10 h-10 {{ $style['bg'] }} text-white rounded-lg flex items-center justify-center font-bold text-base shrink-0 shadow-sm">
                                                {{ $style['icon'] }}
                                            </div>
                                            
                                            {{-- Teks Jawaban --}}
                                            <span class="flex-1 px-3 text-sm font-bold text-slate-800 peer-checked:text-indigo-700">
                                                {{ $pilihan->teks_pilihan }}
                                            </span>

                                            {{-- Selection Indicator --}}
                                            <div class="w-6 h-6 rounded-full border-2 border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center transition mr-2">
                                                <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                {{-- Input Isian Singkat --}}
                                <div class="mt-5 bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                                    <label class="block text-xs font-bold text-indigo-900 mb-2 uppercase tracking-wider">
                                        ✍️ Ketikkan Jawaban Isian Singkat Anda:
                                    </label>
                                    <input type="text" name="jawaban[{{ $soal->id_soal }}]" placeholder="Ketikkan jawaban Anda di sini..."
                                        class="w-full bg-white text-slate-800 font-bold text-sm px-4 py-3 rounded-lg border border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            @endif
                        </section>
                    @endforeach

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-sm px-8 py-3.5 shadow-lg shadow-emerald-600/20 transition transform hover:scale-105">
                            🚀 Kumpulkan Jawaban Saya
                        </button>
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-sm text-slate-500 font-semibold">
                        Belum ada soal untuk quiz ini.
                    </div>
                @endif
            </form>

            {{-- Sidebar Informasional --}}
            <aside class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800">Informasi Quiz</h2>
                    <dl class="mt-3 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <dt>Jumlah Soal</dt>
                            <dd class="font-bold text-slate-800">{{ $quiz->soal->count() }} Pertanyaan</dd>
                        </div>
                    </dl>
                    
                    <h2 class="mt-6 text-xs font-bold uppercase tracking-wider text-slate-400">Navigasi Soal</h2>
                    <div class="mt-3 grid grid-cols-5 gap-2">
                        @foreach ($quiz->soal as $index => $s)
                            <a href="#soal-{{ $index + 1 }}" class="flex h-9 items-center justify-center rounded-lg bg-slate-100 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                {{ $index + 1 }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-5 shadow-sm">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-amber-800">Pencapaian Interaktif 🏆</h2>
                    <div class="mt-3 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-400 text-white text-xl shadow-md">🏅</div>
                        <div>
                            <div class="text-xs font-bold text-amber-900">Kahoot Champion</div>
                            <div class="text-[11px] text-amber-700">Raih skor sempurna untuk mendapatkan poin lebih</div>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
@endsection
