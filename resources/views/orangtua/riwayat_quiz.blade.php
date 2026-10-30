@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Riwayat Quiz - Portal Orang Tua')
@section('breadcrumb', 'Riwayat Quiz')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto space-y-6">

    {{-- Header halaman --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Quiz</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pantau hasil dan perkembangan pengerjaan quiz siswa.
            </p>
        </div>
    </div>

    {{-- Pemilihan siswa --}}
    @if ($siswaList->isNotEmpty())
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('orangtua.riwayat-quiz') }}" method="GET">
            <label for="siswa_id" class="mb-2 block text-sm font-semibold text-slate-700">
                Pilih Siswa
            </label>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select
                    name="siswa_id"
                    id="siswa_id"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 sm:max-w-md">
                    @foreach ($siswaList as $item)
                    <option
                        value="{{ $item->id_user }}"
                        {{ $siswa && (int) $siswa->id_user === (int) $item->id_user ? 'selected' : '' }}>
                        {{ $item->nama }}
                        @if ($item->jenjang)
                        - {{ $item->jenjang->nama_jenjang ?? 'Jenjang' }}
                        @endif
                    </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Tampilkan Riwayat
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Informasi siswa --}}
    @if ($siswa)
    <div class="flex flex-col gap-3 rounded-2xl border border-indigo-100 bg-indigo-50 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-indigo-600">Riwayat quiz siswa</p>
            <h2 class="mt-1 text-lg font-bold text-slate-800">
                {{ $siswa->nama }}
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                {{ $siswa->jenjang->nama_jenjang ?? 'Jenjang belum tersedia' }}
            </p>
        </div>

        <div class="rounded-xl bg-white px-4 py-3">
            <p class="text-xs text-slate-500">Total pengerjaan tercatat</p>
            <p class="mt-1 text-xl font-bold text-indigo-600">
                {{ $hasilQuiz->total() }} quiz
            </p>
        </div>
    </div>


    {{-- Statistik hasil quiz --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Rata-rata Nilai</p>
                <span class="rounded-xl bg-blue-50 p-2 text-blue-600">%</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-800">
                {{ number_format($stats['rata_rata'], 1, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-slate-500">Dari seluruh pengerjaan quiz</p>
        </div>

        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Quiz Lulus</p>
                <span class="rounded-xl bg-emerald-50 p-2 text-emerald-600">✓</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-emerald-600">
                {{ $stats['kuis_lulus'] }}
            </p>
            <p class="mt-1 text-xs text-slate-500">Quiz berhasil dilewati</p>
        </div>

        <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Belum Lulus</p>
                <span class="rounded-xl bg-amber-50 p-2 text-amber-600">!</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-amber-600">
                {{ $stats['kuis_belum_lulus'] }}
            </p>
            <p class="mt-1 text-xs text-slate-500">Perlu ditinjau kembali</p>
        </div>

        <div class="rounded-2xl border border-violet-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Nilai Tertinggi</p>
                <span class="rounded-xl bg-violet-50 p-2 text-violet-600">★</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-violet-600">
                {{ number_format($stats['nilai_tertinggi'], 1, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-slate-500">Nilai terbaik yang dicapai</p>
        </div>
    </div>

{{-- Quiz yang perlu diperhatikan --}}
<div class="overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-sm">
    <div class="border-b border-amber-100 bg-amber-50/70 px-5 py-4">
        <h2 class="font-bold text-slate-800">Quiz yang Perlu Diperhatikan</h2>
        <p class="mt-1 text-sm text-slate-600">
            Quiz dengan nilai di bawah 70 atau status belum lulus.
        </p>
    </div>

    @if ($kuisPerluPerhatian->isNotEmpty())
        <div class="divide-y divide-slate-100">
            @foreach ($kuisPerluPerhatian as $quiz)
                @php
                    $totalPoin = (float) ($quiz->total_poin ?? 0);
                    $nilai = $totalPoin > 0
                        ? round(($quiz->poin_didapat / $totalPoin) * 100, 1)
                        : 0;
                @endphp

                <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-semibold text-slate-800">
                            {{ $quiz->quiz?->judul ?? 'Quiz tidak tersedia' }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500">
                            Skor {{ $quiz->poin_didapat ?? 0 }}/{{ $quiz->total_poin ?? 0 }}
                            @if ($quiz->waktu_dapat)
                                · {{ \Carbon\Carbon::parse($quiz->waktu_dapat)->translatedFormat('d M Y') }}
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-lg font-bold {{ $nilai < 70 ? 'text-rose-600' : 'text-amber-600' }}">
                            {{ number_format($nilai, 1, ',', '.') }}
                        </span>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                            {{ $quiz->is_lulus ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $quiz->is_lulus ? 'Nilai Perlu Ditingkatkan' : 'Belum Lulus' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="px-5 py-8 text-center">
            <p class="font-semibold text-emerald-700">Semua hasil quiz terlihat baik!</p>
            <p class="mt-1 text-sm text-slate-500">
                Tidak ada hasil quiz yang masuk daftar perhatian berdasarkan kriteria saat ini.
            </p>
        </div>
    @endif
</div>


    {{-- Tabel riwayat --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800">Daftar Hasil Quiz</h2>
            <p class="mt-1 text-sm text-slate-500">
                Hasil pengerjaan diurutkan dari yang terbaru.
            </p>
        </div>

        @if ($hasilQuiz->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold">No.</th>
                        <th class="px-5 py-4 font-semibold">Nama Quiz</th>
                        <th class="px-5 py-4 font-semibold">Jenis</th>
                        <th class="px-5 py-4 text-center font-semibold">Skor</th>
                        <th class="px-5 py-4 text-center font-semibold">Nilai</th>
                        <th class="px-5 py-4 text-center font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold">Waktu Pengerjaan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach ($hasilQuiz as $index => $hasil)
                    @php
                    $nilai = $hasil->total_poin > 0
                    ? round(($hasil->poin_didapat / $hasil->total_poin) * 100, 1)
                    : 0;

                    if ($hasil->is_lulus) {
                    $status = 'Lulus';
                    $statusClass = 'bg-emerald-100 text-emerald-700';
                    } elseif ($nilai < 50) {
                        $status='Remedial' ;
                        $statusClass='bg-rose-100 text-rose-700' ;
                        } else {
                        $status='Belum Lulus' ;
                        $statusClass='bg-amber-100 text-amber-700' ;
                        }
                        @endphp

                        <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                            {{ $hasilQuiz->firstItem() + $index }}
                        </td>

                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-800">
                                {{ $hasil->quiz?->judul ?? 'Quiz tidak tersedia' }}
                            </p>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                            {{ $hasil->quiz?->tipeQuiz?->nama_tipe ?? 'Quiz' }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-center text-slate-600">
                            {{ $hasil->poin_didapat ?? 0 }}
                            /
                            {{ $hasil->total_poin ?? 0 }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-center">
                            <span class="font-bold text-slate-800">
                                {{ number_format($nilai, 1, ',', '.') }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-center">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                            @if ($hasil->waktu_dapat)
                            {{ \Carbon\Carbon::parse($hasil->waktu_dapat)->translatedFormat('d M Y, H:i') }}
                            @else
                            -
                            @endif
                        </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $hasilQuiz->firstItem() ?? 0 }}
                sampai {{ $hasilQuiz->lastItem() ?? 0 }}
                dari {{ $hasilQuiz->total() }} data.
            </p>

            <div>
                {{ $hasilQuiz->links() }}
            </div>
        </div>
        @else
        <div class="px-5 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                <svg class="h-7 w-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6m-6 4h6M9 8h6m-9 12h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-800">
                Belum Ada Riwayat Quiz
            </h3>
            <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">
                Belum ada hasil pengerjaan quiz yang tercatat untuk siswa ini.
                Riwayat akan ditampilkan setelah siswa mengerjakan quiz.
            </p>
        </div>
        @endif
    </div>

    @else
    {{-- Kondisi orang tua belum terhubung dengan siswa --}}
    <div class="rounded-2xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50">
            <svg class="h-7 w-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 9v4m0 4h.01M10.3 3.9L2.5 17.4A1.8 1.8 0 004.1 20h15.8a1.8 1.8 0 001.6-2.6L13.7 3.9a1.9 1.9 0 00-3.4 0z" />
            </svg>
        </div>

        <h2 class="mt-4 text-lg font-bold text-slate-800">
            Belum Ada Siswa Terhubung
        </h2>
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            Data riwayat quiz belum dapat ditampilkan karena akun orang tua
            belum terhubung dengan akun siswa.
        </p>
    </div>
    @endif

</div>
@endsection