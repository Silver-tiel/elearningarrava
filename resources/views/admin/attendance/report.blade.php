@extends('layouts.app')

@section('header')
<a href="{{ route('admin.attendance.index') }}" class="text-sm text-blue-600 font-medium">← Absensi Mentor</a>
@endsection

@section('content')
@php
    $st = $session->effectiveStatus();
    $label = ['active' => 'Aktif', 'closed' => 'Ditutup', 'expired' => 'Berakhir'];
@endphp
<div class="p-4 sm:p-8 max-w-4xl">
    @include('attendance._flash')

    <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Rekap: {{ $session->title }}</h2>
            <p class="text-sm text-slate-500">
                {{ $session->starts_at->format('d M Y, H:i') }} – {{ $session->expires_at->format('d M Y, H:i') }} · {{ $label[$st] }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" id="auto-muat" class="h-5 w-5 rounded border-slate-300"> Muat ulang otomatis (15 dtk)
            </label>
            <a href="{{ route('admin.attendance.export', $session) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Unduh CSV</a>
            @if($st === 'active')
                <a href="{{ route('admin.attendance.qr', $session) }}" class="h-11 px-4 inline-flex items-center rounded-xl bg-blue-600 text-white font-semibold">QR</a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 text-center mb-6">
        <div class="rounded-xl bg-green-50 border border-green-200 p-3"><p class="text-2xl font-bold text-green-800">{{ $ringkasan['hadir'] }}</p><p class="text-xs text-green-800">Hadir</p></div>
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3"><p class="text-2xl font-bold text-amber-800">{{ $ringkasan['terlambat'] }}</p><p class="text-xs text-amber-800">Terlambat</p></div>
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-3"><p class="text-2xl font-bold text-slate-700">{{ $ringkasan['belum'] }}</p><p class="text-xs text-slate-700">Belum check-in</p></div>
    </div>

    <h3 class="font-bold text-slate-800 mb-2">Sudah check-in</h3>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto mb-8">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-left">
                <tr><th class="px-4 py-3">Mentor/Guru</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Waktu check-in</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $r)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $r->user->nama ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $r->status === 'terlambat' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">{{ $r->status === 'terlambat' ? 'Terlambat' : 'Hadir' }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $r->checked_in_at->format('d M Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">Belum ada mentor/guru yang check-in.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h3 class="font-bold text-slate-800 mb-2">Belum check-in</h3>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-100">
                @forelse($belum as $u)
                    <tr><td class="px-4 py-3 text-slate-800">{{ $u->nama }}</td><td class="px-4 py-3 text-slate-500">{{ $u->email }}</td></tr>
                @empty
                    <tr><td class="px-4 py-6 text-center text-slate-500">Semua mentor/guru sudah check-in.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    (function () {
        var kotak = document.getElementById('auto-muat');
        var timer = null;
        try { kotak.checked = sessionStorage.getItem('attendance-auto') === '1'; } catch (e) {}
        function atur() {
            clearInterval(timer);
            try { sessionStorage.setItem('attendance-auto', kotak.checked ? '1' : '0'); } catch (e) {}
            if (kotak.checked) { timer = setInterval(function () { location.reload(); }, 15000); }
        }
        kotak.addEventListener('change', atur);
        atur();
    })();
</script>
@endsection
