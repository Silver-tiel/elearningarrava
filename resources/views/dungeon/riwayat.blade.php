@extends(auth()->user()->isSiswa() ? 'layouts.siswa' : 'layouts.app')

@section('title', 'Riwayat Petualangan Dungeon')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-0 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📜</span> Riwayat Petualangan Saya
                </h1>
                <p class="text-slate-500 text-sm mt-1">Catatan seluruh ekspedisi Dungeon yang telah kamu selesaikan</p>
            </div>
            <a href="{{ route('dungeon.index') }}"
                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition">
                ← Kembali
            </a>
        </div>

        {{-- 1. TAMPILAN KHUSUS HP (Tampil di HP, Sembunyi di Laptop: block md:hidden) --}}
        <div class="block md:hidden space-y-3">
            @forelse($riwayat as $sesi)
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-slate-800 dark:text-white">
                            {{ $sesi->mapel->nama_mapel ?? 'Dungeon' }}
                        </span>
                        {{-- Status Badge --}}
                        @if($sesi->alasan_selesai === 'tuntas')
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-600">Tuntas</span>
                        @elseif($sesi->alasan_selesai === 'nyawa_habis')
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-rose-100 text-rose-600">Nyawa Habis</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700">Keluar</span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-400 mb-3">
                        🕒 {{ $sesi->selesai ? $sesi->selesai->format('d M Y, H:i') : '-' }}
                    </div>
                    {{-- Ringkasan Skor & Lantai --}}
                    <div
                        class="grid grid-cols-4 gap-2 pt-2 border-t border-slate-100 dark:border-slate-700 text-center text-xs">
                        <div>
                            <div class="text-slate-400 text-[10px]">Jawaban</div>
                            <div class="font-bold text-emerald-600">{{ $sesi->jumlah_benar }}<span
                                    class="text-slate-300">/</span><span class="text-rose-500">{{ $sesi->jumlah_salah }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-slate-400 text-[10px]">Lantai</div>
                            <div class="font-bold text-[#007FBE]">Lt. {{ $sesi->lantai_tertinggi }}</div>
                        </div>
                        <div>
                            <div class="text-slate-400 text-[10px]">Skor</div>
                            <div class="font-black text-amber-600">{{ number_format($sesi->skor_dungeon) }}</div>
                        </div>
                        <div>
                            <div class="text-slate-400 text-[10px]">Poin</div>
                            <div class="font-extrabold text-emerald-600">+{{ $sesi->poin_profil_didapat }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-2xl text-center text-slate-400 text-sm">
                    Belum ada riwayat petualangan.
                </div>
            @endforelse
        </div>
        {{-- 2. TAMPILAN TABEL KHUSUS LAPTOP (Sembunyi di HP, Tampil di Laptop: hidden md:block) --}}
        <div
            class="hidden md:block bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-900/60 text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                        <th class="py-4 px-6">Waktu</th>
                        <th class="py-4 px-6">Mata Pelajaran</th>
                        <th class="py-4 px-6 text-center">Hasil / Alasan</th>
                        <th class="py-4 px-6 text-center">Benar / Salah</th>
                        <th class="py-4 px-6 text-center">Lantai Max</th>
                        <th class="py-4 px-6 text-right">Skor Dungeon</th>
                        <th class="py-4 px-6 text-right">Poin Profil</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-sm">
                    @forelse($riwayat as $sesi)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition">
                            <td class="py-4 px-6 text-xs text-slate-500 whitespace-nowrap">
                                {{ $sesi->selesai ? $sesi->selesai->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800 dark:text-white whitespace-nowrap">
                                {{ $sesi->mapel->nama_mapel ?? 'Dungeon' }}
                            </td>
                            <td class="py-4 px-800 text-center">
                                @if($sesi->alasan_selesai === 'tuntas')
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-600 border border-emerald-300">
                                        Tuntas
                                    </span>
                                @elseif($sesi->alasan_selesai === 'nyawa_habis')
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-600 border border-rose-300">
                                        Nyawa Habis
                                    </span>
                                @elseif($sesi->alasan_selesai === 'timeout')
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-600 border border-amber-300">
                                        Waktu Habis
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-700">
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="text-emerald-600 font-bold">{{ $sesi->jumlah_benar }}</span> /
                                <span class="text-rose-500 font-bold">{{ $sesi->jumlah_salah }}</span>
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-[#007FBE]">
                                Lt. {{ $sesi->lantai_tertinggi }}
                            </td>
                            <td class="py-4 px-6 text-right font-black text-amber-600">
                                {{ number_format($sesi->skor_dungeon) }}
                            </td>
                            <td class="py-4 px-6 text-right font-extrabold text-emerald-600">
                                +{{ $sesi->poin_profil_didapat }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                Belum ada riwayat petualangan. Mulai ekspedisi pertamamu sekarang!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($riwayat->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection