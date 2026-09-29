@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Siswa</h1>
        <p class="text-sm text-gray-500">Kelola data siswa yang terdaftar di platform e-learning.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Siswa</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Aktif</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $totalAktif }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                <i class="fas fa-user-minus text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Nonaktif</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $totalNonaktif }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Perlu Ditinjau</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $totalPerluDitinjau }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-t-xl border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('admin.daftar_siswa') }}" class="w-full flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                    placeholder="Cari nama atau email siswa...">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select name="kelas" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-lg px-3 py-2 focus:outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach($listKelas as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-lg px-3 py-2 focus:outline-none">
                    <option value="">Status: Semua</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Status: Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Status: Nonaktif</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-b-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs text-gray-400 font-medium border-b border-gray-100 bg-white">
                    <th class="py-3 px-4 w-12 text-center">No</th>
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Jenjang / Kelas</th>
                    <th class="py-3 px-4">No Hp</th>
                    <th class="py-3 px-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-50">
                @forelse($siswas as $index => $siswa)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-4 px-4 text-center text-gray-400">{{ $siswas->firstItem() + $index }}</td>
                    <td class="py-4 px-4">
                        <div class="flex items-center space-x-3">
                            <img class="w-9 h-9 rounded-full object-cover" 
                                 src="{{ !empty($siswa->foto) ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) }}" 
                                 alt="{{ $siswa->nama }}">
                            <span class="font-semibold text-gray-800">{{ $siswa->nama }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-gray-400">{{ $siswa->email }}</td>
                    <td class="py-4 px-4 text-gray-600">
                        {{ $siswa->jenjang->nama_jenjang ?? $siswa->kelas ?? '-' }}
                    </td>
                    <td class="py-4 px-4 text-gray-400">{{ $siswa->no_hp ?? '-' }}</td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600">
                            {{ $siswa->status ?? 'Aktif' }}
                        </span>
                    </td>
                </tr>   
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-400">
                        Tidak ada data siswa ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer & Pagination --}}
        <div class="p-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-400">
            <div>
                Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} siswa
            </div>
            <div>
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection