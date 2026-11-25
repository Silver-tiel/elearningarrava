@extends('layouts.app')

@section('header')
<a href="{{ route('admin.attendance.index') }}" class="text-sm text-blue-600 font-medium">← Absensi Mentor</a>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-2xl">
    @include('attendance._flash')

    <h2 class="text-2xl font-bold text-slate-800 mb-1">Buat Sesi Absensi</h2>
    <p class="text-sm text-slate-500 mb-6">Setelah disimpan, QR sesi langsung ditampilkan.</p>

    <form method="POST" action="{{ route('admin.attendance.store') }}" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="sm:col-span-2">
            <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Judul sesi</label>
            <input id="title" name="title" value="{{ old('title') }}" required maxlength="150" placeholder="Contoh: Absensi Mentor Senin Pagi"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
        </div>
        <div>
            <label for="starts_at" class="block text-sm font-medium text-slate-700 mb-1">Jam mulai</label>
            <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at', $defaultMulai) }}" required
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        <div>
            <label for="expires_at" class="block text-sm font-medium text-slate-700 mb-1">Jam berakhir</label>
            <input id="expires_at" name="expires_at" type="datetime-local" value="{{ old('expires_at', $defaultBerakhir) }}" required
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        <div class="sm:col-span-2">
            <label for="late_after_minutes" class="block text-sm font-medium text-slate-700 mb-1">Batas keterlambatan (menit, opsional)</label>
            <input id="late_after_minutes" name="late_after_minutes" type="number" min="0" max="1440" inputmode="numeric" value="{{ old('late_after_minutes') }}" placeholder="Contoh: 15"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
            <p class="text-xs text-slate-500 mt-1">Check-in setelah jam mulai + menit ini dicatat "terlambat". Kosongkan jika tidak ada batas.</p>
        </div>
        <div class="sm:col-span-2 flex justify-end gap-3">
            <a href="{{ route('admin.attendance.index') }}" class="h-12 px-5 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium">Batal</a>
            <button type="submit" class="h-12 px-6 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">Buat Sesi &amp; Tampilkan QR</button>
        </div>
    </form>
</div>
@endsection
