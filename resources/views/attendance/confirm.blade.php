@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Absen Mentor</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-xl mx-auto space-y-4">
    @include('attendance._flash')

    @if(!$session)
        <div role="alert" class="rounded-2xl border border-red-200 bg-red-50 p-6 text-red-800">
            <p class="font-bold text-lg mb-1">QR tidak dikenali</p>
            <p>Token pada tautan ini tidak valid. Minta admin menampilkan QR yang benar.</p>
        </div>
        <a href="{{ route('attendance.scan') }}" class="block w-full h-14 leading-[3.5rem] text-center rounded-xl bg-blue-600 text-white font-bold">Buka halaman scan</a>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-sm text-slate-500">Sesi absensi</p>
            <h2 class="text-2xl font-bold text-slate-800">{{ $session->title }}</h2>
            <p class="text-slate-500 mt-1">{{ $session->starts_at->format('d M Y, H:i') }} – {{ $session->expires_at->format('H:i') }}</p>

            @if($status === 'active' && $session->hasStarted())
                <form method="POST" action="{{ route('attendance.check-in') }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit" class="w-full h-16 rounded-xl bg-blue-600 text-white text-xl font-bold hover:bg-blue-700">Check-in sekarang</button>
                </form>
                <p class="text-xs text-slate-500 mt-3 text-center">Kehadiran dicatat atas nama akun Anda: <b>{{ auth()->user()->nama }}</b>.</p>
            @elseif($status === 'active')
                <div role="alert" class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-amber-900">Sesi belum dimulai. Mulai pukul {{ $session->starts_at->format('H:i') }}.</div>
            @elseif($status === 'closed')
                <div role="alert" class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">Sesi ini sudah ditutup oleh admin.</div>
            @else
                <div role="alert" class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">Sesi ini sudah berakhir.</div>
            @endif
        </div>
        <a href="{{ route('attendance.scan') }}" class="block text-center text-blue-600 font-medium underline">Kembali ke halaman scan</a>
    @endif
</div>
@endsection
