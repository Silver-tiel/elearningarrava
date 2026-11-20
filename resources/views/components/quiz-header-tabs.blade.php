@php
    $isSiswa = auth()->check() && auth()->user()->isSiswa();
    $quizRoute = $isSiswa ? route('siswa.quiz') : route('admin.quiz');
    $isQuizActive = (request()->routeIs('siswa.quiz*') || request()->routeIs('admin.quiz*') || request()->is('quiz*') || request()->is('siswa/quiz*')) && !request()->is('soal*') && !request()->is('dungeon*');
    $isSoalActive = request()->routeIs('admin.soal*') || request()->routeIs('soal*') || request()->is('soal*') || request()->is('admin/soal*');
    $isDungeonActive = request()->routeIs('dungeon*') || request()->is('dungeon*') || request()->is('admin/dungeon*');
    $bankCount = !$isSiswa ? \App\Models\Soal::whereNull('id_quiz')->count() : 0;
@endphp

<div class="inline-flex items-center p-1 bg-slate-100/90 rounded-2xl border border-slate-200/90 shadow-xs shrink-0">
    {{-- Tab Kuis --}}
    <a href="{{ $quizRoute }}"
        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $isQuizActive ? 'bg-[#007FBE] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        <span>Kuis</span>
    </a>

    {{-- Tab Bank Soal (Khusus Guru/Admin) --}}
    @if(!$isSiswa)
        <a href="{{ route('admin.soal') }}"
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $isSoalActive ? 'bg-[#007FBE] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
            </svg>
            <span>Bank Soal</span>
            @if($bankCount > 0)
                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-black {{ $isSoalActive ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $bankCount }}
                </span>
            @endif
        </a>
    @endif

    {{-- Tab Dungeon Soal (Siswa & Staff) --}}
    <a href="{{ route('dungeon.index') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $isDungeonActive ? 'bg-[#007FBE] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
        <span class="text-sm">🏰</span>
        <span>Dungeon Soal</span>
    </a>
</div>
