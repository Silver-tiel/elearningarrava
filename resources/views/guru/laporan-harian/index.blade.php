@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Pelaporan Harian</h1>
@endsection

@section('content')
<div class="mx-auto max-w-6xl p-4 sm:p-6 lg:p-8">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-black text-[#082765]">Pelaporan Harian Guru</h2>
        <p class="mt-1 text-sm text-[#72839E]">Lengkapi laporan berdasarkan sesi presensi yang Anda ampu. Data kelas, jenjang, hari, dan tanggal mengikuti pengaturan kelas serta sesi presensi.</p>
    </div>

    <section class="overflow-hidden rounded-2xl border border-[#DCEFFF] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-[#F0F6FF] text-xs font-bold uppercase tracking-wide text-[#465673]">
                    <tr>
                        <th class="px-4 py-3">Hari / tanggal</th>
                        <th class="px-4 py-3">Kelas / jenjang</th>
                        <th class="px-4 py-3">Presensi</th>
                        <th class="px-4 py-3">Laporan</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sesi as $item)
                        @php
                            $jumlahHadir = $item->presensi->whereIn('status', ['hadir', 'terlambat'])->count();
                            $laporan = $item->laporanHarian;
                        @endphp
                        <tr>
                            <td class="px-4 py-4 font-semibold text-slate-800">
                                {{ $item->tanggal?->locale('id')->translatedFormat('l') ?? '—' }}<br>
                                <span class="text-xs font-medium text-slate-500">{{ $item->tanggal?->format('d M Y') ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-slate-800">
                                {{ $item->kelas?->nama ?? '—' }}<br>
                                <span class="text-xs font-medium text-slate-500">{{ $item->kelas?->jenjang?->nama_tipe ?? 'Jenjang tidak tersedia' }}</span>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ $jumlahHadir }} siswa</td>
                            <td class="px-4 py-4">
                                @if($laporan)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Terkirim · {{ $laporan->mapel?->nama_mapel ?? '—' }}</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Belum dilaporkan</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('guru.laporan-harian.edit', $item->id_sesi) }}"
                                    class="inline-flex h-9 items-center rounded-lg bg-sky-700 px-3 text-xs font-bold text-white hover:bg-sky-800">
                                    {{ $laporan ? 'Ubah laporan' : 'Isi laporan' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center font-semibold text-slate-500">Belum ada sesi presensi pada kelas yang Anda ampu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sesi->hasPages())
            <div class="border-t border-slate-100 px-4 py-3">{{ $sesi->links() }}</div>
        @endif
    </section>
</div>
@endsection
