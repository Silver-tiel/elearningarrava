@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Rekap Laporan Harian Guru</h1>
@endsection

@section('content')
<div class="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-black text-[#082765]">Rekap Laporan Harian Guru</h2>
        <p class="mt-1 text-sm text-[#72839E]">Rekap pembelajaran guru yang terhubung dengan sesi presensi.</p>
    </div>

    <form method="GET" action="{{ route('admin.laporan-harian') }}" class="mb-5 flex flex-wrap items-end gap-3 rounded-2xl border border-[#DCEFFF] bg-white p-4">
        <div>
            <label for="tanggal" class="mb-1 block text-xs font-bold text-slate-600">Tanggal</label>
            <input id="tanggal" name="tanggal" type="date" value="{{ request('tanggal') }}" class="rounded-lg border-slate-300 text-sm focus:border-sky-600 focus:ring-sky-600">
        </div>
        <div>
            <label for="id_guru" class="mb-1 block text-xs font-bold text-slate-600">Guru</label>
            <select id="id_guru" name="id_guru" class="min-w-52 rounded-lg border-slate-300 text-sm focus:border-sky-600 focus:ring-sky-600">
                <option value="">Semua guru</option>
                @foreach($guruList as $guru)
                    <option value="{{ $guru->id_user }}" @selected((string) request('id_guru') === (string) $guru->id_user)>{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>
        <button class="h-10 rounded-lg bg-sky-700 px-4 text-sm font-bold text-white hover:bg-sky-800">Terapkan</button>
        <a href="{{ route('admin.laporan-harian') }}" class="inline-flex h-10 items-center rounded-lg border border-slate-300 px-4 text-sm font-semibold text-slate-700">Reset</a>
    </form>

    <section class="overflow-hidden rounded-2xl border border-[#DCEFFF] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] text-left text-sm">
                <thead class="bg-[#F0F6FF] text-xs font-bold uppercase tracking-wide text-[#465673]">
                    <tr>
                        <th class="px-4 py-3">Hari / tanggal</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3">Kelas / jenjang</th>
                        <th class="px-4 py-3">Mata pelajaran</th>
                        <th class="px-4 py-3">Jam pelajaran</th>
                        <th class="px-4 py-3">Siswa bintang</th>
                        <th class="px-4 py-3">Masa berlaku kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporan as $item)
                        @php $bintang = $item->sesi?->presensi?->first(fn ($presensi) => $presensi->is_bintang); @endphp
                        <tr>
                            <td class="px-4 py-4 font-semibold text-slate-800">
                                {{ $item->sesi?->tanggal?->locale('id')->translatedFormat('l') ?? '—' }}<br>
                                <span class="text-xs font-medium text-slate-500">{{ $item->sesi?->tanggal?->format('d M Y') ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-slate-800">{{ $item->guru?->nama ?? '—' }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-800">
                                {{ $item->sesi?->kelas?->nama ?? '—' }}<br>
                                <span class="text-xs font-medium text-slate-500">{{ $item->sesi?->kelas?->jenjang?->nama_tipe ?? 'Jenjang tidak tersedia' }}</span>
                            </td>
                            <td class="px-4 py-4 text-slate-700">{{ $item->mapel?->nama_mapel ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ substr($item->waktu_mulai, 0, 5) }}–{{ substr($item->waktu_selesai, 0, 5) }}</td>
                            <td class="px-4 py-4 font-semibold text-amber-700">{{ $bintang?->siswa?->nama ?? 'Belum dipilih' }}</td>
                            <td class="px-4 py-4 text-xs text-slate-600">
                                {{ $item->kelas_berlaku_dari?->format('d M Y') ?? 'Tidak dibatasi' }}
                                – {{ $item->kelas_berlaku_sampai?->format('d M Y') ?? 'Tidak dibatasi' }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center font-semibold text-slate-500">Belum ada laporan harian yang sesuai filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporan->hasPages())
            <div class="border-t border-slate-100 px-4 py-3">{{ $laporan->links() }}</div>
        @endif
    </section>
</div>
@endsection
