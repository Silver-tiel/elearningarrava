@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Absensi Mentor</h1>
@endsection

@section('content')
@php
    $badge = [
        'active' => ['Aktif', 'bg-green-100 text-green-800'],
        'closed' => ['Ditutup', 'bg-slate-200 text-slate-700'],
        'expired' => ['Berakhir', 'bg-amber-100 text-amber-800'],
    ];
@endphp
<div class="p-4 sm:p-8 max-w-6xl">
    @include('attendance._flash')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Absensi Mentor</h2>
            <p class="text-sm text-slate-500 mt-1">Buat sesi absensi, tampilkan QR di layar, lalu mentor/guru memindainya untuk check-in.</p>
        </div>
        <a href="{{ route('admin.attendance.create') }}" class="h-12 px-6 inline-flex items-center rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">Buat Sesi Baru</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-left">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Terlambat setelah</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Hadir</th>
                    <th class="px-4 py-3 text-center">Terlambat</th>
                    <th class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sessions as $s)
                    @php $st = $s->effectiveStatus(); @endphp
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->title }}</td>
                        <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                            {{ $s->starts_at->format('d M Y H:i') }}<br>
                            <span class="text-xs text-slate-500">s/d {{ $s->expires_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $s->late_after_minutes !== null ? $s->late_after_minutes . ' menit' : '—' }}</td>
                        <td class="px-4 py-3"><span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $badge[$st][1] }}">{{ $badge[$st][0] }}</span></td>
                        <td class="px-4 py-3 text-center">{{ $s->hadir_count }}</td>
                        <td class="px-4 py-3 text-center">{{ $s->terlambat_count }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center justify-end gap-2">
                                <a href="{{ route('admin.attendance.qr', $s) }}" class="h-10 px-3 inline-flex items-center rounded-lg border border-blue-200 text-blue-700 font-medium hover:bg-blue-50">QR</a>
                                <a href="{{ route('admin.attendance.report', $s) }}" class="h-10 px-3 inline-flex items-center rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Rekap</a>
                                @if($st === 'active')
                                    <form method="POST" action="{{ route('admin.attendance.close', $s) }}" data-judul="{{ $s->title }}"
                                          onsubmit="return confirm('Tutup sesi &quot;' + this.dataset.judul + '&quot;? Mentor tidak bisa check-in lagi.')">
                                        @csrf @method('PATCH')
                                        <button class="h-10 px-3 rounded-lg text-red-600 hover:bg-red-50 font-medium">Tutup</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-slate-500">Belum ada sesi absensi. Klik "Buat Sesi Baru".</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $sessions->links() }}</div>
</div>
@endsection
