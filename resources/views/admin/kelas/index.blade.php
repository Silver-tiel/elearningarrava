@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Kelas</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-7xl pb-24">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-heading font-black text-[#082765]">Kelola Kelas</h2>
        <p class="text-xs sm:text-sm font-medium text-[#72839E] mt-1 leading-relaxed">Buat kelas dan pilih jenjangnya: semua siswa aktif pada jenjang itu otomatis menjadi peserta. Tugaskan guru pengampu; guru hanya bisa presensi di kelas yang ditugaskan.</p>
    </div>

    <form method="POST" action="{{ route('admin.kelas.store') }}" class="bg-white rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] p-4 sm:p-6 mb-8 grid gap-4 sm:grid-cols-4 shadow-[0_4px_0_#B2E7FC]">
        @csrf
        <div class="sm:col-span-2">
                 <label for="nama" class="block text-sm font-bold text-[#465673] mb-1">Nama kelas</label>
            <input id="nama" name="nama" value="{{ old('nama') }}" required maxlength="150" placeholder="Contoh: Kelas X – Matematika"
                     class="w-full h-12 rounded-xl border border-[#B2E7FC] px-4 text-base text-[#082765] focus:ring-2 focus:ring-[#B2E7FC] focus:border-[#007FBE] outline-none transition">
        </div>
        <div>
            <label for="id_jenjang" class="block text-sm font-bold text-[#465673] mb-1">Jenjang</label>
            <select id="id_jenjang" name="id_jenjang" required class="w-full h-12 rounded-xl border border-[#B2E7FC] px-3 text-base text-[#082765] bg-white focus:ring-2 focus:ring-[#B2E7FC] focus:border-[#007FBE] outline-none transition">
                <option value="">— Pilih —</option>
                @foreach($jenjangList as $j)
                    <option value="{{ $j->id_jenjang }}" @selected(old('id_jenjang') == $j->id_jenjang)>{{ $j->nama_tipe }}</option>
                @endforeach
            </select>
        </div>
        <div>
                 <label for="tahun_ajaran" class="block text-sm font-bold text-[#465673] mb-1">Tahun ajaran</label>
            <input id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" maxlength="20" placeholder="2026/2027"
                     class="w-full h-12 rounded-xl border border-[#B2E7FC] px-4 text-base text-[#082765] focus:ring-2 focus:ring-[#B2E7FC] focus:border-[#007FBE] outline-none transition">
        </div>
        @include('admin.kelas._jadwal')
        <div class="sm:col-span-4 flex justify-end">
            <button type="submit" class="h-12 px-6 inline-flex items-center rounded-xl bg-[#007FBE] hover:bg-[#00679A] text-white text-sm font-black shadow-[0_3px_0_#005580] active:translate-y-0.5 active:shadow-none transition">Buat Kelas</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] overflow-x-auto shadow-[0_4px_0_#B2E7FC]">
        <table class="w-full text-sm">
            <thead class="bg-[#F0F6FF] text-[#465673] text-left text-xs font-black">
                <tr>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Jenjang</th>
                    <th class="px-4 py-3 text-center">Peserta</th>
                    <th class="px-4 py-3 text-center">Guru</th>
                    <th class="px-4 py-3">Jadwal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#DCEFFF]">
                @forelse($kelasList as $k)
                    <tr class="hover:bg-[#F0F6FF]/60 transition">
                        <td class="px-4 py-3 font-heading font-black text-[#082765]">{{ $k->nama }}</td>
                        <td class="px-4 py-3 text-[#465673]">{{ $k->jenjang->nama_tipe ?? '—' }}</td>
                        <td class="px-4 py-3 text-center font-bold text-[#082765]">{{ $k->id_jenjang ? ($siswaPerJenjang[$k->id_jenjang] ?? 0) : '—' }}</td>
                        <td class="px-4 py-3 text-center font-bold text-[#082765]">{{ $k->guru_count }}</td>
                        <td class="px-4 py-3 text-[#72839E] text-xs font-medium">{{ $k->ringkasJadwal() }}</td>
                        <td class="px-4 py-3">
                            @if(!$k->aktif)
                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black bg-slate-100 text-slate-600 border border-slate-200">Nonaktif</span>
                            @elseif($k->aktifHariIni())
                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black bg-[#DCFCE7] text-[#059669] border border-[#BBF7D0]">Aktif hari ini</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black bg-amber-50 text-amber-700 border border-amber-200">Di luar jadwal</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.kelas.show', $k->id_kelas) }}" class="inline-flex items-center h-9 px-3.5 rounded-xl border-2 border-[#B2E7FC] bg-white hover:bg-[#F0F6FF] text-[#007FBE] text-xs font-bold shadow-[0_2px_0_#B2E7FC] active:translate-y-0.5 transition">Kelola</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-[#72839E] text-sm font-bold">Belum ada kelas. Buat kelas pertama di atas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
