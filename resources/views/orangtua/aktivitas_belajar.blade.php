@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Aktivitas Belajar - Portal Orang Tua')
@section('breadcrumb', 'Aktivitas Belajar')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Aktivitas Belajar
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Pantau riwayat aktivitas dan pengerjaan quiz anak.
        </p>
    </div>

    @if ($siswaList->isNotEmpty())

    {{-- Pemilihan siswa --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('orangtua.aktivitas-belajar') }}" method="GET">
            <label for="siswa_id" class="mb-2 block text-sm font-semibold text-slate-700">
                Pilih Siswa
            </label>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select
                    name="siswa_id"
                    id="siswa_id"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 sm:max-w-md">

                    @foreach ($siswaList as $item)
                    <option value="{{ $item->id_user }}"
                        {{ (int) $siswa->id_user === (int) $item->id_user ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Tampilkan Aktivitas
                </button>
            </div>
        </form>
    </div>

    {{-- Informasi siswa --}}
    <div class="flex flex-col gap-3 rounded-2xl border border-indigo-100 bg-indigo-50 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-indigo-600">Aktivitas belajar siswa</p>
            <h2 class="mt-1 text-lg font-bold text-slate-800">
                {{ $siswa->nama }}
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                {{ $siswa->jenjang->nama_jenjang ?? 'Jenjang belum tersedia' }}
            </p>
        </div>

        <div class="rounded-xl bg-white px-4 py-3">
            <p class="text-xs text-slate-500">Total aktivitas tercatat</p>
            <p class="mt-1 text-xl font-bold text-indigo-600">
                {{ $aktivitas->total() }} aktivitas
            </p>
        </div>
    </div>

    {{-- Daftar aktivitas --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800">
                Riwayat Aktivitas Anak
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Daftar pengerjaan quiz berdasarkan waktu terbaru.
            </p>
        </div>

        @if ($aktivitas->isNotEmpty())

        <div class="divide-y divide-slate-100">

            @foreach ($aktivitas as $item)
            @php
            $totalPoin = (float) ($item->total_poin ?? 0);

            $nilai = $totalPoin > 0
            ? round(($item->poin_didapat / $totalPoin) * 100, 1)
            : 0;

            if ($item->is_lulus) {
            $status = 'Tuntas';
            $statusClass = 'bg-emerald-50 text-emerald-700';
            $iconClass = 'bg-emerald-50 text-emerald-600';
            } elseif ($nilai < 50) {
                $status='Remedial' ;
                $statusClass='bg-rose-50 text-rose-700' ;
                $iconClass='bg-rose-50 text-rose-600' ;
                } else {
                $status='Selesai' ;
                $statusClass='bg-amber-50 text-amber-700' ;
                $iconClass='bg-amber-50 text-amber-600' ;
                }
                @endphp

                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                {{-- Informasi aktivitas --}}
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $iconClass }}">
                        <svg class="h-5 w-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 5h8M8 9h8M8 13h5m-8 7h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="font-semibold text-slate-800">
                            {{ $item->quiz?->judul ?? 'Quiz tidak tersedia' }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $item->quiz?->tipeQuiz?->nama_tipe ?? 'Quiz' }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            @if ($item->waktu_dapat)
                            {{ \Carbon\Carbon::parse($item->waktu_dapat)->translatedFormat('d F Y, H:i') }}
                            @else
                            Waktu tidak tersedia
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Hasil pengerjaan --}}
                <div class="flex items-center justify-between gap-4 sm:justify-end">

                    <div class="text-right">
                        <p class="text-lg font-bold text-slate-800">
                            {{ number_format($nilai, 1, ',', '.') }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ $item->poin_didapat ?? 0 }}/{{ $item->total_poin ?? 0 }} poin
                        </p>
                    </div>

                    <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">
                        {{ $status }}
                    </span>
                </div>
        </div>
        @endforeach

    </div>

    {{-- Pagination --}}
    <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

        <p class="text-sm text-slate-500">
            Menampilkan {{ $aktivitas->firstItem() ?? 0 }}
            sampai {{ $aktivitas->lastItem() ?? 0 }}
            dari {{ $aktivitas->total() }} aktivitas.
        </p>

        <div>
            {{ $aktivitas->links() }}
        </div>
    </div>

    @else

    <div class="px-5 py-14 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
            <svg class="h-7 w-7 text-slate-400"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M8 5h8M8 9h8M8 13h5m-8 7h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        <h3 class="mt-4 font-semibold text-slate-800">
            Belum Ada Aktivitas Belajar
        </h3>

        <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">
            Belum ada aktivitas pengerjaan quiz yang tercatat untuk siswa ini.
        </p>
    </div>

    @endif
</div>

@else

{{-- Belum ada siswa terhubung --}}
<div class="rounded-2xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm">
    <h2 class="text-lg font-bold text-slate-800">
        Belum Ada Siswa Terhubung
    </h2>

    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
        Aktivitas belajar belum dapat ditampilkan karena akun orang tua
        belum terhubung dengan akun siswa.
    </p>
</div>

@endif

</div>
@endsection