@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Kelas</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-5xl">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Kelola Kelas</h2>
        <p class="text-sm text-slate-500 mt-1">Buat kelas, masukkan siswa, dan tugaskan guru. Guru hanya bisa melakukan presensi di kelas yang ditugaskan.</p>
    </div>

    <form method="POST" action="{{ route('admin.kelas.store') }}" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 mb-8 grid gap-4 sm:grid-cols-4">
        @csrf
        <div class="sm:col-span-2">
            <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama kelas</label>
            <input id="nama" name="nama" value="{{ old('nama') }}" required maxlength="150" placeholder="Contoh: Kelas X – Matematika"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
        </div>
        <div>
            <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">Jenjang</label>
            <select id="id_jenjang" name="id_jenjang" class="w-full h-12 rounded-xl border border-slate-300 px-3 text-base bg-white">
                <option value="">— Pilih —</option>
                @foreach($jenjangList as $j)
                    <option value="{{ $j->id_jenjang }}" @selected(old('id_jenjang') == $j->id_jenjang)>{{ $j->nama_tipe }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tahun_ajaran" class="block text-sm font-medium text-slate-700 mb-1">Tahun ajaran</label>
            <input id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" maxlength="20" placeholder="2026/2027"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        <div class="sm:col-span-4 flex justify-end">
            <button type="submit" class="h-12 px-6 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">Buat Kelas</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-left">
                <tr>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Jenjang</th>
                    <th class="px-4 py-3 text-center">Siswa</th>
                    <th class="px-4 py-3 text-center">Guru</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kelasList as $k)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $k->nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $k->jenjang->nama_tipe ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">{{ $k->siswa_count }}</td>
                        <td class="px-4 py-3 text-center">{{ $k->guru_count }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $k->aktif ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700' }}">{{ $k->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.kelas.show', $k->id_kelas) }}" class="inline-flex items-center h-10 px-4 rounded-lg border border-blue-200 text-blue-700 font-medium hover:bg-blue-50">Kelola</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada kelas. Buat kelas pertama di atas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
