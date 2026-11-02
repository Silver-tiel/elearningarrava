@extends('layouts.app')

@section('header')
<a href="{{ route('admin.kelas') }}" class="text-sm text-blue-600 font-medium">← Semua kelas</a>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-5xl space-y-8">
    @include('guru.presensi._flash')

    <form method="POST" action="{{ route('admin.kelas.update', $kelas->id_kelas) }}" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 grid gap-4 sm:grid-cols-4">
        @csrf @method('PUT')
        <h2 class="sm:col-span-4 text-xl font-bold text-slate-800">{{ $kelas->nama }}</h2>
        <div class="sm:col-span-2">
            <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama kelas</label>
            <input id="nama" name="nama" value="{{ old('nama', $kelas->nama) }}" required maxlength="150" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        <div>
            <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">Jenjang</label>
            <select id="id_jenjang" name="id_jenjang" required class="w-full h-12 rounded-xl border border-slate-300 px-3 text-base bg-white">
                <option value="">— Pilih —</option>
                @foreach($jenjangList as $j)
                    <option value="{{ $j->id_jenjang }}" @selected(old('id_jenjang', $kelas->id_jenjang) == $j->id_jenjang)>{{ $j->nama_tipe }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tahun_ajaran" class="block text-sm font-medium text-slate-700 mb-1">Tahun ajaran</label>
            <input id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}" maxlength="20" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        @include('admin.kelas._jadwal')
        <label class="sm:col-span-2 flex items-center gap-3 text-sm text-slate-700">
            <input type="checkbox" name="aktif" value="1" @checked($kelas->aktif) class="h-5 w-5 rounded border-slate-300"> Kelas aktif
        </label>
        <div class="sm:col-span-2 flex justify-end gap-3">
            <button type="submit" class="h-12 px-6 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">Simpan</button>
        </div>
    </form>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- GURU --}}
        <section class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6" aria-labelledby="judul-guru">
            <h3 id="judul-guru" class="font-bold text-slate-800 mb-3">Guru pengampu ({{ $kelas->guru->count() }})</h3>
            <form method="POST" action="{{ route('admin.kelas.guru.tambah', $kelas->id_kelas) }}" class="flex gap-2 mb-4">
                @csrf
                <label for="id_guru" class="sr-only">Pilih guru</label>
                <select id="id_guru" name="id_guru" required class="flex-1 h-12 rounded-xl border border-slate-300 px-3 bg-white">
                    <option value="">— Pilih guru —</option>
                    @foreach($guruTersedia as $g)
                        <option value="{{ $g->id_user }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
                <button class="h-12 px-4 rounded-xl bg-blue-600 text-white font-semibold">Tugaskan</button>
            </form>
            <ul class="divide-y divide-gray-100">
                @forelse($kelas->guru as $g)
                    <li class="flex items-center justify-between py-2">
                        <span class="text-slate-800">{{ $g->nama }}</span>
                        <form method="POST" action="{{ route('admin.kelas.guru.hapus', [$kelas->id_kelas, $g->id_user]) }}" onsubmit="return confirm('Cabut penugasan guru ini?')">
                            @csrf @method('DELETE')
                            <button class="h-10 px-3 rounded-lg text-red-600 hover:bg-red-50 text-sm font-medium">Cabut</button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-sm text-slate-500">Belum ada guru yang ditugaskan.</li>
                @endforelse
            </ul>
        </section>

        {{-- PESERTA (otomatis per jenjang) --}}
        <section class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6" aria-labelledby="judul-siswa">
            <h3 id="judul-siswa" class="font-bold text-slate-800 mb-1">Peserta ({{ $peserta->count() }})</h3>
            @if($kelas->id_jenjang)
                <p class="text-sm text-slate-500 mb-3">Semua siswa aktif jenjang <b>{{ $kelas->jenjang->nama_tipe ?? '' }}</b> otomatis menjadi peserta kelas ini. Tidak perlu memilih satu per satu.</p>
            @else
                <div role="alert" class="mb-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    Kelas ini belum punya jenjang, sehingga belum ada peserta. Pilih jenjang di formulir atas lalu simpan.
                </div>
            @endif
            <ul class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @forelse($peserta as $s)
                    <li class="py-2 text-slate-800">{{ $s->nama }}</li>
                @empty
                    <li class="py-3 text-sm text-slate-500">Belum ada siswa aktif pada jenjang ini.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <form method="POST" action="{{ route('admin.kelas.destroy', $kelas->id_kelas) }}" onsubmit="return confirm('Hapus kelas ini beserta seluruh riwayat presensinya?')">
        @csrf @method('DELETE')
        <button class="h-11 px-5 rounded-xl border border-red-200 text-red-600 font-medium hover:bg-red-50">Hapus kelas</button>
    </form>
</div>
@endsection
