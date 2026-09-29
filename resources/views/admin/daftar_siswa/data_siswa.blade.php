@extends('layouts.app')

@section('header')
    <h1 class="text-base font-semibold text-slate-800">Ringkasan Data Siswa</h1>
@endsection

@section('content')
<div class="p-8 space-y-6">

    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Siswa</h1>
        <p class="text-sm text-slate-500">Kelola data siswa yang terdaftar di platform e-learning.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Total Siswa</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Aktif</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalAktif ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Nonaktif</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalNonaktif ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Perlu Ditinjau</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalPerluDitinjau ?? 0 }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('admin.daftar_siswa') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition" 
                    placeholder="Cari nama atau email siswa...">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select name="kelas" onchange="this.form.submit()" class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Semua Kelas</option>
                    @foreach($listKelas ?? [] as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Status: Semua</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Status: Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Status: Nonaktif</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 font-medium border-b border-slate-100 bg-slate-50/50">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Jenjang / Kelas</th>
                        <th class="py-3.5 px-4">No Hp</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($siswas as $index => $siswa)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-4 text-center text-slate-400">
                            {{ method_exists($siswas, 'firstItem') ? $siswas->firstItem() + $index : $index + 1 }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <img class="w-9 h-9 rounded-full object-cover border border-slate-100 shadow-sm" 
                                     src="{{ !empty($siswa->foto) ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&background=EFF6FF&color=2563EB' }}" 
                                     alt="{{ $siswa->nama }}">
                                <span class="font-semibold text-slate-800">{{ $siswa->nama }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->email }}</td>
                        <td class="py-4 px-4 text-slate-600">
                            {{ $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? '-' }}
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->no_hp ?? '-' }}</td>
                        <td class="py-4 px-4 text-center">
                            @php
                                $status = $siswa->status ?? 'Aktif';
                                $badgeClass = match($status) {
                                    'Aktif' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                    'Nonaktif' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                    default => 'bg-amber-50 text-amber-600 border border-amber-100',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->total_poin ?? '-' }}</td>
                    </tr>   
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            Tidak ada data siswa ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer & Pagination --}}
        <div class="p-4 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-400">
            <div>
                @if(method_exists($siswas, 'firstItem'))
                    Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} siswa
                @else
                    Menampilkan {{ count($siswas) }} siswa
                @endif
            </div>
            <div>
                @if(method_exists($siswas, 'links'))
                    {{ $siswas->links() }}
                @endif
            </div>
        </div>
    </div>

</div>
@endsection