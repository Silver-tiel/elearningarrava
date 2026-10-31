@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">QR Siswa</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-4xl">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Kelola QR Siswa</h2>
        <p class="text-sm text-slate-500 mt-1">Buat ulang QR jika bocor atau hilang. QR lama langsung tidak berlaku. Isi QR tidak pernah ditampilkan di halaman ini.</p>
    </div>

    <form method="GET" action="{{ route('admin.qr') }}" class="flex gap-2 mb-4">
        <label for="q" class="sr-only">Cari nama siswa</label>
        <input id="q" name="q" value="{{ $cari }}" placeholder="Cari nama siswa" class="flex-1 h-12 rounded-xl border border-slate-300 px-4">
        <button class="h-12 px-5 rounded-xl bg-slate-800 text-white font-semibold">Cari</button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-left">
                <tr>
                    <th class="px-4 py-3">Siswa</th>
                    <th class="px-4 py-3">QR dibuat</th>
                    <th class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswa as $s)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $s->qr_dibuat_pada ? $s->qr_dibuat_pada->format('d M Y H:i') : 'Belum dibuat' }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.qr.regenerate', $s->id_user) }}"
                                  data-nama="{{ $s->nama }}"
                                  onsubmit="return confirm('Buat ulang QR untuk ' + this.dataset.nama + '? QR lama tidak akan berlaku lagi.')">
                                @csrf
                                <button class="h-10 px-4 rounded-lg border border-amber-300 text-amber-800 font-medium hover:bg-amber-50">Buat ulang QR</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">Siswa tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $siswa->links() }}</div>
</div>
@endsection
