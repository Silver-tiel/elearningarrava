@extends('layouts.app')

@section('title', 'Manajemen Bank Soal Dungeon')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 font-heading flex items-center gap-2">
                <span>🏰</span> Manajemen Bank Soal Dungeon
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Kelola kuis dan bank soal Dungeon untuk seluruh kombinasi mata pelajaran dan jenjang.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dungeon.admin.laporan') }}" class="px-4 py-2.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-bold text-sm transition flex items-center gap-2">
                <span>🚩</span> Antrean Moderasi Laporan
            </a>
            <a href="{{ route('admin.quiz.create') }}" class="px-4 py-2.5 rounded-xl bg-[#007FBE] hover:bg-[#00689E] text-white font-bold text-sm shadow-[0_3px_0_#005580] transition flex items-center gap-2">
                <span>➕</span> Buat Soal Dungeon
            </a>
        </div>
    </div>

    <!-- Filter Jenjang -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 mb-6 flex items-center gap-2 overflow-x-auto">
        <span class="text-xs uppercase font-extrabold text-slate-400 mr-2 tracking-wider">Jenjang:</span>
        @foreach($jenjangList as $j)
            <a href="{{ route('dungeon.admin.bank', ['jenjang' => $j->id_jenjang]) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ ($selectedJenjang->id_jenjang ?? 1) == $j->id_jenjang ? 'bg-[#007FBE] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $j->nama_tipe ?? $j->nama_jenjang }}
            </a>
        @endforeach
    </div>

    <!-- Grid Bank Soal per Mapel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bankData as $item)
            @php
                $q = $item['quiz'];
                $status = $item['status_dungeon'];
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <h3 class="text-xl font-bold font-heading text-slate-900">
                            {{ $item['mapel']->nama_mapel ?? $q->judul }}
                        </h3>
                        @if($status['terbuka'])
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                🔓 Terbuka (Siap)
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                🔒 Terkunci
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-400 mb-4">
                        Kuis ID: #{{ $q->id_quiz }} • Dibuat oleh Sistem
                    </p>

                    <!-- Breakdown Soal -->
                    <div class="grid grid-cols-3 gap-2 text-center text-xs mb-4">
                        <div class="p-2 rounded-xl bg-emerald-50 border border-emerald-100">
                            <span class="block text-slate-400 text-[10px] font-bold uppercase">Mudah</span>
                            <span class="font-extrabold text-emerald-700 text-base">{{ $item['mudah'] }}</span>
                            <span class="block text-[9px] text-slate-400">min 8</span>
                        </div>
                        <div class="p-2 rounded-xl bg-blue-50 border border-blue-100">
                            <span class="block text-slate-400 text-[10px] font-bold uppercase">Sedang</span>
                            <span class="font-extrabold text-blue-700 text-base">{{ $item['sedang'] }}</span>
                            <span class="block text-[9px] text-slate-400">min 8</span>
                        </div>
                        <div class="p-2 rounded-xl bg-sky-50 border border-sky-100">
                            <span class="block text-slate-400 text-[10px] font-bold uppercase">Sulit</span>
                            <span class="font-extrabold text-sky-700 text-base">{{ $item['sulit'] }}</span>
                            <span class="block text-[9px] text-slate-400">min 8</span>
                        </div>
                    </div>

                    <div class="text-xs text-slate-500 space-y-1 mb-4">
                        <div class="flex justify-between">
                            <span>Total Soal Aktif:</span>
                            <strong class="text-slate-800">{{ $item['total_aktif'] }} / 30 syarat</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Soal Dinonaktifkan:</span>
                            <strong class="{{ $item['total_nonaktif'] > 0 ? 'text-rose-600' : 'text-slate-400' }}">{{ $item['total_nonaktif'] }}</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                    <a href="{{ route('admin.quiz.edit', $q->id_quiz) }}" class="flex-1 text-center py-2 px-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#007FBE] font-bold text-xs border border-[#B2E7FC] transition">
                        Kelola Soal 📝
                    </a>
                    <a href="{{ route('dungeon.show', ['mapel' => $item['mapel']->id_mapel ?? $q->id_quiz, 'uji_coba' => 1]) }}" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition" title="Uji Coba Sesi">
                        🎮 Test
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400">
                <div class="text-5xl mb-3">📭</div>
                <p class="font-bold text-lg">Belum ada Dungeon untuk jenjang ini.</p>
                <p class="text-xs mt-1">Jalankan DungeonSeeder untuk men-generate seluruh kuis dungeon otomatis.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
