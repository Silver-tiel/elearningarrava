@extends('layouts.app')

@section('header')
<a href="{{ route('guru.laporan-harian.index') }}" class="text-sm font-semibold text-sky-700">← Pelaporan Harian</a>
@endsection

@section('content')
<div class="mx-auto max-w-4xl p-4 sm:p-6 lg:p-8">
    @include('guru.presensi._flash')

    @php
        $hariKelas = $sesi->kelas->hariAktif();
        $labelHariKelas = empty($hariKelas)
            ? 'Setiap hari'
            : collect($hariKelas)->map(fn ($hari) => \App\Models\Kelas::HARI[$hari])->join(', ');
        $siswaBintang = old('id_siswa_bintang') ?? $hadir->firstWhere('is_bintang', true)?->id_siswa;
    @endphp

    <div class="mb-6">
        <p class="text-sm font-bold text-sky-700">Laporan sesi presensi</p>
        <h2 class="mt-1 text-2xl font-black text-[#082765]">{{ $sesi->kelas->nama }}</h2>
        <p class="mt-1 text-sm text-slate-500">{{ $sesi->tanggal?->locale('id')->translatedFormat('l, d F Y') }}</p>
    </div>

    <form method="POST" action="{{ route('guru.laporan-harian.update', $sesi->id_sesi) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <section class="rounded-2xl border border-[#DCEFFF] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-slate-800">Informasi pembelajaran</h3>
            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-400">Kelas / jenjang</dt>
                    <dd class="mt-1 font-bold text-slate-800">{{ $sesi->kelas->nama }} · {{ $sesi->kelas->jenjang?->nama_tipe ?? 'Jenjang tidak tersedia' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-400">Guru</dt>
                    <dd class="mt-1 font-bold text-slate-800">{{ auth()->user()->nama }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-400">Hari jadwal kelas</dt>
                    <dd class="mt-1 font-bold text-slate-800">{{ $labelHariKelas }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-400">Masa berlaku kelas</dt>
                    <dd class="mt-1 font-bold text-slate-800">
                        {{ $sesi->kelas->berlaku_dari?->format('d M Y') ?? 'Tidak dibatasi' }}
                        <span class="px-1 text-slate-400">s.d.</span>
                        {{ $sesi->kelas->berlaku_sampai?->format('d M Y') ?? 'Tidak dibatasi' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-400">Hari dan tanggal laporan</dt>
                    <dd class="mt-1 font-bold text-slate-800">{{ $sesi->tanggal?->locale('id')->translatedFormat('l, d F Y') }}</dd>
                </div>
            </dl>
        </section>

        <section class="space-y-4 rounded-2xl border border-[#DCEFFF] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-slate-800">Jam pelajaran dan mata pelajaran</h3>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="waktu_mulai" class="mb-1 block text-sm font-semibold text-slate-700">Berlaku dari</label>
                    <input id="waktu_mulai" name="waktu_mulai" type="time" required
                        value="{{ old('waktu_mulai', $laporan?->waktu_mulai ? substr($laporan->waktu_mulai, 0, 5) : '') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-600 focus:ring-sky-600">
                    @error('waktu_mulai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="waktu_selesai" class="mb-1 block text-sm font-semibold text-slate-700">Berlaku sampai</label>
                    <input id="waktu_selesai" name="waktu_selesai" type="time" required
                        value="{{ old('waktu_selesai', $laporan?->waktu_selesai ? substr($laporan->waktu_selesai, 0, 5) : '') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-600 focus:ring-sky-600">
                    @error('waktu_selesai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label for="id_mapel" class="mb-1 block text-sm font-semibold text-slate-700">Mata pelajaran</label>
                <select id="id_mapel" name="id_mapel" required class="w-full rounded-lg border-slate-300 focus:border-sky-600 focus:ring-sky-600">
                    <option value="">Pilih mata pelajaran</option>
                    @foreach($mapel as $mataPelajaran)
                        <option value="{{ $mataPelajaran->id_mapel }}" @selected((string) old('id_mapel', $laporan?->id_mapel) === (string) $mataPelajaran->id_mapel)>
                            {{ $mataPelajaran->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                @if($mapel->isEmpty())
                    <p class="mt-1 text-xs text-amber-700">Belum ada mata pelajaran yang tersedia untuk jenjang kelas ini.</p>
                @endif
                @error('id_mapel')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-[#DCEFFF] bg-white shadow-sm">
            <div class="border-b border-slate-100 p-5">
                <h3 class="font-bold text-slate-800">Siswa bintang</h3>
                <p class="mt-1 text-sm text-slate-500">Pilih satu siswa yang paling aktif dari siswa yang tercatat hadir atau terlambat.</p>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($hadir as $presensi)
                    <label class="flex cursor-pointer items-center gap-3 px-5 py-3 hover:bg-amber-50/60">
                        <input type="radio" name="id_siswa_bintang" value="{{ $presensi->id_siswa }}"
                            @checked((string) $siswaBintang === (string) $presensi->id_siswa)
                            class="h-4 w-4 border-slate-300 text-amber-500 focus:ring-amber-500">
                        <span class="font-semibold text-slate-800">{{ $presensi->siswa?->nama ?? 'Siswa' }}</span>
                        <span class="ml-auto text-xs text-slate-500">{{ $presensi->status === 'terlambat' ? 'Terlambat' : 'Hadir' }}</span>
                    </label>
                @empty
                    <p class="p-5 text-sm font-medium text-amber-800">Belum ada siswa yang hadir pada sesi ini. Catat presensi siswa terlebih dahulu sebelum mengirim laporan.</p>
                @endforelse
            </div>
            @error('id_siswa_bintang')<p class="px-5 pb-3 text-xs text-red-600">{{ $message }}</p>@enderror
        </section>

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('guru.laporan-harian.index') }}" class="inline-flex h-10 items-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700">Batal</a>
            <button type="submit" @disabled($hadir->isEmpty() || $mapel->isEmpty())
                class="inline-flex h-10 items-center rounded-lg bg-sky-700 px-5 text-sm font-bold text-white hover:bg-sky-800 disabled:cursor-not-allowed disabled:opacity-50">
                Simpan laporan
            </button>
        </div>
    </form>
</div>
@endsection
