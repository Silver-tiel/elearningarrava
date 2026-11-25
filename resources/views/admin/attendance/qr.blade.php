@extends('layouts.app')

@section('header')
<a href="{{ route('admin.attendance.index') }}" class="text-sm text-blue-600 font-medium">← Absensi Mentor</a>
@endsection

@section('content')
@php
    $st = $session->effectiveStatus();
    $badge = [
        'active' => ['Aktif', 'bg-green-100 text-green-800'],
        'closed' => ['Ditutup', 'bg-slate-200 text-slate-700'],
        'expired' => ['Berakhir', 'bg-amber-100 text-amber-800'],
    ];
@endphp
<style>
    #qr-besar svg { width: 100%; height: auto; display: block; }
</style>
<div class="p-4 sm:p-8 max-w-3xl mx-auto">
    @include('attendance._flash')

    <div id="area-qr" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10 text-center">
        <div class="flex flex-wrap items-center justify-center gap-2 mb-2">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $session->title }}</h2>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $badge[$st][1] }}">{{ $badge[$st][0] }}</span>
        </div>
        <p class="text-slate-500">
            {{ $session->starts_at->format('d M Y, H:i') }} – {{ $session->expires_at->format('d M Y, H:i') }}
            @if($session->late_after_minutes !== null) · terlambat setelah {{ $session->late_after_minutes }} menit @endif
        </p>

        @if($st === 'active')
            <div id="qr-besar" class="mx-auto my-6 w-full max-w-[520px] bg-white p-2" role="img" aria-label="QR check-in absensi mentor">{!! $svg !!}</div>
            <p class="text-lg font-semibold text-slate-700">Mentor/guru: pindai QR ini untuk check-in</p>
        @else
            <div role="alert" class="my-6 rounded-2xl border border-amber-200 bg-amber-50 p-6 text-amber-900">
                Sesi ini {{ $st === 'closed' ? 'sudah ditutup' : 'sudah berakhir' }}, sehingga QR tidak dapat dipakai lagi.
            </div>
        @endif
    </div>

    {{-- Khusus admin: token & tautan untuk input manual (jangan dibagikan ke publik) --}}
    @if($st === 'active')
        <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 space-y-4">
            <div>
                <p class="text-sm font-semibold text-slate-700 mb-1">Token (untuk input manual jika kamera tidak tersedia)</p>
                <div class="flex gap-2">
                    <input id="token-teks" readonly value="{{ $session->token }}" class="flex-1 h-12 rounded-xl border border-slate-300 bg-slate-50 px-3 font-mono text-xs sm:text-sm">
                    <button type="button" data-salin="token-teks" class="h-12 px-4 rounded-xl border border-slate-300 font-semibold text-slate-700 hover:bg-slate-50">Salin</button>
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-700 mb-1">Tautan check-in</p>
                <div class="flex gap-2">
                    <input id="tautan-teks" readonly value="{{ $session->checkInUrl() }}" class="flex-1 h-12 rounded-xl border border-slate-300 bg-slate-50 px-3 font-mono text-xs">
                    <button type="button" data-salin="tautan-teks" class="h-12 px-4 rounded-xl border border-slate-300 font-semibold text-slate-700 hover:bg-slate-50">Salin</button>
                </div>
            </div>
            <p class="text-xs text-slate-500">Halaman ini hanya bisa dibuka admin. Jangan menyebarkan token ke orang di luar mentor/guru.</p>
        </div>
    @endif

    <div class="mt-6 grid grid-cols-2 gap-3">
        @if($st === 'active')
            <button type="button" id="btn-layar-penuh" class="h-14 rounded-xl bg-slate-800 text-white font-bold">Layar penuh</button>
        @endif
        <a href="{{ route('admin.attendance.report', $session) }}" class="h-14 inline-flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold {{ $st === 'active' ? '' : 'col-span-2' }}">Lihat rekap</a>
    </div>
</div>

<script>
    (function () {
        document.querySelectorAll('[data-salin]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var el = document.getElementById(btn.dataset.salin);
                el.select();
                if (navigator.clipboard) { navigator.clipboard.writeText(el.value); } else { document.execCommand('copy'); }
                var awal = btn.textContent; btn.textContent = 'Tersalin'; setTimeout(function () { btn.textContent = awal; }, 1500);
            });
        });
        var layar = document.getElementById('btn-layar-penuh');
        if (layar) {
            layar.addEventListener('click', function () {
                var area = document.getElementById('area-qr');
                if (area.requestFullscreen) { area.requestFullscreen(); }
            });
        }
    })();
</script>
@endsection
