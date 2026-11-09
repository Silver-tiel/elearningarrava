@extends('layouts.siswa')

@section('title', 'Papan Peringkat (Leaderboard) — Arrava')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('siswa.dashboard') }}"
           class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#DCEFFF] bg-white text-[#465673] shadow-[0_2px_0_#DCEFFF] transition hover:border-[#007FBE] hover:text-[#007FBE] active:translate-y-0.5"
           title="Kembali ke Dashboard">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="min-w-0">
            <h1 class="text-base sm:text-lg font-heading font-black text-[#082765] truncate flex items-center gap-2">
                <span>🏆</span> Papan Peringkat
            </h1>
            <p class="text-xs font-bold text-[#72839E] truncate">Top Pelajar &amp; Perolehan EXP Arrava</p>
        </div>
    </div>
@endsection

@section('content')
@php
    /**
     * @var \Illuminate\Support\Collection<int, array<string, mixed>> $leaderboard
     * @var array<string, mixed>|null $myRank
     * @var int|null $activeJenjangId
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Jenjang> $jenjangList
     * @var \App\Models\User|null $user
     */
    $top1 = $leaderboard->firstWhere('rank', 1);
    $top2 = $leaderboard->firstWhere('rank', 2);
    $top3 = $leaderboard->firstWhere('rank', 3);
    $restList = $leaderboard->slice(3);
@endphp

{{-- Main Container (Sesuai Dashboard, Modul, dan Quiz: otomatis mengecil mengikuti sidebar) --}}
<div class="px-4 sm:px-8 py-6 sm:py-8 max-w-7xl mx-auto space-y-6">

    <!-- HERO / BANNER SAMUDRA LEADERBOARD -->
    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#007FBE] via-[#0095DE] to-[#38BDF8] p-6 sm:p-7 text-white shadow-[0_6px_0_#005580]">
        <div class="absolute -right-8 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-black text-white border border-white/25 mb-2.5">
                    <span>👑</span> Papan Peringkat Pelajar Berprestasi
                </span>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-heading font-black leading-tight">
                    Papan Peringkat &amp; Prestasi Arrava
                </h2>
                <p class="text-xs sm:text-sm text-white/90 mt-1.5 font-medium leading-relaxed">
                    Kumpulkan EXP sebanyak-banyaknya dengan mempelajari modul materi dan menyelesaikan kuis evaluasi dengan nilai terbaik!
                </p>
            </div>

            @if($myRank)
                <div class="w-full md:w-auto shrink-0 bg-white/15 backdrop-blur-md border border-white/25 rounded-2xl p-4 text-center min-w-[160px] shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-wider text-white/80">Peringkat Kamu</p>
                    <p class="text-2xl sm:text-3xl font-heading font-black text-white mt-0.5">#{{ $myRank['rank'] }}</p>
                    <div class="mt-1 flex items-center justify-center gap-1.5">
                        <span class="text-xs font-black bg-[#FFBE35] text-[#12233F] px-2.5 py-0.5 rounded-full shadow-xs">
                            {{ number_format($myRank['total_poin']) }} EXP
                        </span>
                        <span class="text-[11px] font-bold text-white/90">
                            ({{ $myRank['tier'] }})
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- FILTER JENJANG -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 thin-scroll">
        <a href="{{ route('siswa.leaderboard', ['jenjang' => 'all']) }}"
           class="h-9 px-4 shrink-0 inline-flex items-center gap-1.5 rounded-xl text-xs transition {{ empty($activeJenjangId) ? 'bg-[#007FBE] text-white font-black shadow-[0_3px_0_#005580]' : 'bg-white text-[#465673] font-bold border-2 border-[#DCEFFF] hover:border-[#007FBE] hover:text-[#007FBE] shadow-[0_2px_0_#DCEFFF]' }}">
            <span>🌐</span> Semua Jenjang
        </a>
        @foreach($jenjangList as $j)
            @php $isSelected = (int) $activeJenjangId === (int) $j->id_jenjang; @endphp
            <a href="{{ route('siswa.leaderboard', ['jenjang' => $j->id_jenjang]) }}"
               class="h-9 px-4 shrink-0 inline-flex items-center gap-1.5 rounded-xl text-xs transition {{ $isSelected ? 'bg-[#007FBE] text-white font-black shadow-[0_3px_0_#005580]' : 'bg-white text-[#465673] font-bold border-2 border-[#DCEFFF] hover:border-[#007FBE] hover:text-[#007FBE] shadow-[0_2px_0_#DCEFFF]' }}">
                <span>🏫</span> {{ $j->nama_jenjang ?? $j->nama_tipe }}
            </a>
        @endforeach
    </div>

    @if($leaderboard->isEmpty())
        <!-- STATE JIKA BELUM ADA DATA -->
        <div class="rounded-2xl sm:rounded-3xl border-2 border-dashed border-[#DCEFFF] bg-white p-12 text-center shadow-[0_4px_0_#B2E7FC]">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#DDF3FF] text-[#007FBE] text-2xl">
                🏆
            </div>
            <h3 class="mt-3.5 font-heading font-black text-[#082765] text-base">Belum Ada Data Peringkat</h3>
            <p class="mt-1 text-xs sm:text-sm font-medium text-[#72839E] max-w-sm mx-auto">
                Belum ada siswa yang tercatat memiliki poin pada jenjang ini. Jadilah yang pertama meraih posisi teratas!
            </p>
        </div>
    @else

        <!-- ===================================================================
             1. PODIUM TOP 3 PEMBELAJAR TERBAIK
             =================================================================== -->
        <div class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-7 shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-[#F0F6FF]">
                <div class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#FEF3C7] text-base">👑</span>
                    <div>
                        <h3 class="font-heading font-black text-sm sm:text-base text-[#082765]">
                            Tiga Besar Pembelajar Terbaik
                        </h3>
                        <p class="text-[11px] font-bold text-[#72839E]">Juara peraih EXP tertinggi</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DDF3FF] text-[#007FBE] text-xs font-bold border border-[#B2E7FC]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#007FBE] animate-ping"></span>
                    <span>Real-time</span>
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-6 items-end pt-4 sm:pt-6">

                <!-- PODIUM 2 (JUARA 2 - PERAK) -->
                @if($top2)
                    <div class="flex flex-col items-center text-center order-1">
                        <div class="relative group">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-4 border-[#94A3B8] shadow-md overflow-hidden bg-slate-100 flex items-center justify-center">
                                @if(!empty($top2['foto_profil']))
                                    <img src="{{ $top2['foto_profil'] }}" alt="{{ $top2['nama'] }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-base sm:text-xl font-black text-slate-600">{{ strtoupper(substr($top2['nama'], 0, 1)) }}</span>
                                @endif
                            </div>
                            <span class="absolute -bottom-2 inset-x-0 mx-auto w-6 h-6 rounded-full bg-[#94A3B8] text-white text-xs font-black flex items-center justify-center shadow-md border-2 border-white">
                                2
                            </span>
                        </div>

                        <div class="mt-4 w-full px-1">
                            <h4 class="font-heading font-black text-xs sm:text-sm text-[#082765] truncate max-w-[120px] sm:max-w-[160px] mx-auto" title="{{ $top2['nama'] }}">
                                {{ $top2['nama'] }}
                            </h4>
                            <span class="inline-block mt-0.5 text-[10px] font-bold text-[#72839E] truncate max-w-[120px] mx-auto">
                                {{ $top2['jenjang'] }}
                            </span>
                            <div class="mt-1.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#F1F5F9] text-[#475569] text-[11px] font-black border border-[#CBD5E1]">
                                    <span>🥈</span> {{ number_format($top2['total_poin']) }}
                                </span>
                            </div>
                            <span class="block mt-1 text-[10px] font-black text-[#64748B]">{{ $top2['tier'] }}</span>
                        </div>

                        <!-- Podium Bar -->
                        <div class="w-full h-20 sm:h-28 mt-3 rounded-t-2xl bg-gradient-to-t from-slate-200 to-slate-100 border-2 border-b-0 border-[#CBD5E1] flex items-center justify-center font-heading font-black text-slate-400 text-lg sm:text-2xl shadow-inner">
                            #2
                        </div>
                    </div>
                @else
                    <div class="order-1 flex flex-col items-center opacity-40">
                        <div class="w-16 h-16 rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-xs font-bold">Kosong</div>
                        <div class="w-full h-16 mt-3 rounded-t-2xl bg-slate-100 border border-dashed border-slate-300"></div>
                    </div>
                @endif

                <!-- PODIUM 1 (JUARA 1 - EMAS / TENGAH) -->
                @if($top1)
                    <div class="flex flex-col items-center text-center order-2">
                        <div class="relative group">
                            <!-- Mahkota Juara 1 -->
                            <div class="text-2xl sm:text-3xl animate-bounce -mb-2 select-none">👑</div>
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-[#F59E0B] shadow-[0_0_16px_rgba(245,158,11,0.4)] overflow-hidden bg-amber-50 flex items-center justify-center ring-4 ring-[#FEF3C7]">
                                @if(!empty($top1['foto_profil']))
                                    <img src="{{ $top1['foto_profil'] }}" alt="{{ $top1['nama'] }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-lg sm:text-2xl font-black text-amber-700">{{ strtoupper(substr($top1['nama'], 0, 1)) }}</span>
                                @endif
                            </div>
                            <span class="absolute -bottom-2 inset-x-0 mx-auto w-7 h-7 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 text-white text-xs font-black flex items-center justify-center shadow-md border-2 border-white">
                                1
                            </span>
                        </div>

                        <div class="mt-4 w-full px-1">
                            <h4 class="font-heading font-black text-sm sm:text-base text-[#082765] truncate max-w-[130px] sm:max-w-[180px] mx-auto" title="{{ $top1['nama'] }}">
                                {{ $top1['nama'] }}
                            </h4>
                            <span class="inline-block mt-0.5 text-[10px] font-bold text-[#72839E] truncate max-w-[130px] mx-auto">
                                {{ $top1['jenjang'] }}
                            </span>
                            <div class="mt-1.5">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#FEF3C7] text-[#B45309] text-xs font-black border border-[#FDE68A] shadow-xs">
                                    <span>🥇</span> {{ number_format($top1['total_poin']) }} EXP
                                </span>
                            </div>
                            <span class="block mt-1 text-[11px] font-black text-[#D97706]">{{ $top1['tier'] }} 🏆</span>
                        </div>

                        <!-- Podium Bar -->
                        <div class="w-full h-28 sm:h-36 mt-3 rounded-t-2xl bg-gradient-to-t from-amber-200 to-amber-100 border-2 border-b-0 border-[#FDE68A] flex items-center justify-center font-heading font-black text-amber-500 text-xl sm:text-3xl shadow-inner">
                            #1
                        </div>
                    </div>
                @else
                    <div class="order-2 flex flex-col items-center opacity-40">
                        <div class="w-20 h-20 rounded-full border-2 border-dashed border-amber-300 flex items-center justify-center text-amber-600 text-xs font-bold">Kosong</div>
                        <div class="w-full h-20 mt-3 rounded-t-2xl bg-amber-50 border border-dashed border-amber-300"></div>
                    </div>
                @endif

                <!-- PODIUM 3 (JUARA 3 - PERUNGGU) -->
                @if($top3)
                    <div class="flex flex-col items-center text-center order-3">
                        <div class="relative group">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-4 border-[#D97706] shadow-md overflow-hidden bg-orange-50 flex items-center justify-center">
                                @if(!empty($top3['foto_profil']))
                                    <img src="{{ $top3['foto_profil'] }}" alt="{{ $top3['nama'] }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-base sm:text-xl font-black text-amber-800">{{ strtoupper(substr($top3['nama'], 0, 1)) }}</span>
                                @endif
                            </div>
                            <span class="absolute -bottom-2 inset-x-0 mx-auto w-6 h-6 rounded-full bg-[#D97706] text-white text-xs font-black flex items-center justify-center shadow-md border-2 border-white">
                                3
                            </span>
                        </div>

                        <div class="mt-4 w-full px-1">
                            <h4 class="font-heading font-black text-xs sm:text-sm text-[#082765] truncate max-w-[120px] sm:max-w-[160px] mx-auto" title="{{ $top3['nama'] }}">
                                {{ $top3['nama'] }}
                            </h4>
                            <span class="inline-block mt-0.5 text-[10px] font-bold text-[#72839E] truncate max-w-[120px] mx-auto">
                                {{ $top3['jenjang'] }}
                            </span>
                            <div class="mt-1.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FFEDD5] text-[#C2410C] text-[11px] font-black border border-[#FED7AA]">
                                    <span>🥉</span> {{ number_format($top3['total_poin']) }}
                                </span>
                            </div>
                            <span class="block mt-1 text-[10px] font-black text-[#C2410C]">{{ $top3['tier'] }}</span>
                        </div>

                        <!-- Podium Bar -->
                        <div class="w-full h-16 sm:h-24 mt-3 rounded-t-2xl bg-gradient-to-t from-orange-200 to-orange-100 border-2 border-b-0 border-[#FED7AA] flex items-center justify-center font-heading font-black text-orange-400 text-lg sm:text-2xl shadow-inner">
                            #3
                        </div>
                    </div>
                @else
                    <div class="order-3 flex flex-col items-center opacity-40">
                        <div class="w-16 h-16 rounded-full border-2 border-dashed border-orange-300 flex items-center justify-center text-orange-600 text-xs font-bold">Kosong</div>
                        <div class="w-full h-16 mt-3 rounded-t-2xl bg-orange-50 border border-dashed border-orange-300"></div>
                    </div>
                @endif

            </div>
        </div>

        <!-- ===================================================================
             2. LIST SISWA LAINNYA DI BAWAH 3 PEMBELAJAR TERBAIK (Peringkat #4 dst)
             =================================================================== -->
        <div class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 pb-3 border-b border-[#F0F6FF]">
                <div class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#DDF3FF] text-[#007FBE] text-sm">🎖️</span>
                    <div>
                        <h3 class="font-heading font-black text-sm sm:text-base text-[#082765]">
                            Daftar Peringkat Siswa Lainnya
                        </h3>
                        <p class="text-[11px] font-bold text-[#72839E]">Peringkat #4 ke atas berdasarkan perolehan EXP</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="relative w-full sm:w-60">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[#72839E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke-width="2"/><path d="m20 20-4-4" stroke-width="2"/>
                        </svg>
                        <input type="text"
                               id="search-siswa-rest"
                               placeholder="Cari siswa di daftar..."
                               class="h-8.5 w-full pl-9 pr-3 text-xs rounded-xl bg-[#F0F6FF] border border-[#DCEFFF] text-[#12233F] outline-none placeholder:text-[#72839E] focus:bg-white focus:border-[#007FBE] transition">
                    </div>
                    @if($restList->isNotEmpty())
                        <span class="shrink-0 text-xs font-bold text-[#72839E] bg-[#F0F6FF] px-2.5 py-1 rounded-lg border border-[#DCEFFF]">
                            {{ $restList->count() }} Siswa
                        </span>
                    @endif
                </div>
            </div>

            @if($restList->isNotEmpty())
                <div class="space-y-2.5" id="siswa-rest-list">
                    @foreach($restList as $item)
                        @php
                            $isMe = $user && ((int) $item['id_user'] === (int) $user->id_user);
                        @endphp
                        <div class="siswa-row-item flex items-center justify-between p-3.5 sm:p-4 rounded-2xl transition-all duration-150 {{ $isMe ? 'bg-[#DDF3FF] border-2 border-[#007FBE] shadow-[0_3px_0_#007FBE]' : 'bg-[#F8FAFC] border border-[#DCEFFF] hover:bg-[#F0F6FF] hover:border-[#B2E7FC]' }}"
                             data-nama="{{ strtolower($item['nama']) }}"
                             data-jenjang="{{ strtolower($item['jenjang']) }}">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                                <!-- Rank Number -->
                                <span class="w-8 sm:w-10 text-center font-heading font-black text-sm sm:text-base {{ $isMe ? 'text-[#007FBE]' : 'text-[#72839E]' }}">
                                    #{{ $item['rank'] }}
                                </span>

                                <!-- Avatar -->
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl overflow-hidden bg-white border border-[#DCEFFF] flex items-center justify-center shrink-0 shadow-xs">
                                    @if(!empty($item['foto_profil']))
                                        <img src="{{ $item['foto_profil'] }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs sm:text-sm font-black text-[#007FBE]">{{ strtoupper(substr($item['nama'], 0, 1)) }}</span>
                                    @endif
                                </div>

                                <!-- Nama & Jenjang -->
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-xs sm:text-sm font-heading font-black text-[#082765] truncate">
                                            {{ $item['nama'] }}
                                        </h4>
                                        @if($isMe)
                                            <span class="px-2 py-0.5 rounded-full bg-[#007FBE] text-white text-[9px] font-black uppercase tracking-wider shadow-xs">
                                                Kamu
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] font-bold text-[#72839E] mt-0.5 truncate">
                                        {{ $item['jenjang'] }} &middot; <span class="text-[#007FBE] font-semibold">{{ $item['tier'] }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- EXP Poin -->
                            <div class="text-right shrink-0 pl-3">
                                <span class="font-heading font-black text-xs sm:text-sm text-[#082765] block">
                                    {{ number_format($item['total_poin']) }}
                                </span>
                                <span class="text-[10px] font-extrabold uppercase text-[#72839E]">EXP</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="no-search-results" class="hidden py-8 text-center">
                    <p class="text-xs font-bold text-[#72839E]">Tidak ditemukan siswa dengan nama tersebut.</p>
                </div>
            @else
                <!-- KETIKA HANYA ADA <= 3 SISWA DI FILTER INI -->
                <div class="rounded-2xl border border-dashed border-[#DCEFFF] bg-[#F8FAFC] p-8 text-center">
                    <p class="mt-2 text-xs sm:text-sm font-bold text-[#082765]">Belum Ada Siswa Lain di Peringkat Selanjutnya</p>
                </div>
            @endif
        </div>

    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('search-siswa-rest');
    var list = document.getElementById('siswa-rest-list');
    var emptyMsg = document.getElementById('no-search-results');

    if (searchInput && list) {
        searchInput.addEventListener('input', function (e) {
            var val = (e.target.value || '').toLowerCase().trim();
            var items = list.querySelectorAll('.siswa-row-item');
            var matched = 0;

            items.forEach(function (row) {
                var nama = row.getAttribute('data-nama') || '';
                var jenjang = row.getAttribute('data-jenjang') || '';
                if (nama.indexOf(val) !== -1 || jenjang.indexOf(val) !== -1) {
                    row.style.display = '';
                    matched++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyMsg) {
                emptyMsg.classList.toggle('hidden', matched > 0);
            }
        });
    }
});
</script>
@endpush
@endsection
