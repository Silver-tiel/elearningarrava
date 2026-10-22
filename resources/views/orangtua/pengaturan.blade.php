@extends('layouts.orangtua')
@include('components.page-loader')
@section('title', 'Pengaturan Akun - Portal Orang Tua')
@section('breadcrumb', 'Pengaturan')

@section('content')
<div class="mx-auto max-w-[900px] px-4 py-6 sm:px-6">

    {{-- PAGE HEADER --}}
    <div class="mb-6">
        <nav class="mb-2 flex items-center gap-1.5 text-sm text-slate-400">
            <span class="font-medium text-slate-600">Portal Orang Tua</span>
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>Pengaturan</span>
        </nav>
        <h1 class="text-[22px] font-extrabold text-slate-900">Pengaturan Akun &amp; Preferensi</h1>
        <p class="mt-1 text-sm text-slate-500">
            Kelola profil data diri wali murid, preferensi notifikasi pemantauan belajar anak, integrasi kontak, serta keamanan akun.
        </p>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    {{-- ALERT VALIDATION ERRORS --}}
    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <ul class="space-y-0.5 text-sm text-red-700">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('orangtua.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="formPengaturan">
        @csrf
        @method('PUT')

        {{-- PROFIL CARD --}}
        <div class="mb-5 rounded-2xl border border-slate-200 bg-white p-6">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                {{-- Avatar --}}
                <div id="avatarWrap" class="relative inline-block shrink-0">
                    @if($user->foto_profil)
                    <img
                        src="{{ asset('storage/'.$user->foto_profil) }}"
                        alt="Foto Profil"
                        class="h-[72px] w-[72px] rounded-2xl border-2 border-slate-100 object-cover shadow-sm"
                    >
                    @else
                    <div class="flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-indigo-600 text-2xl font-extrabold text-white shadow-md shadow-indigo-500/20">
                        {{ strtoupper(substr($user->nama ?? 'O', 0, 2)) }}
                    </div>
                    @endif
                    <span class="absolute bottom-0.5 right-0.5 h-3.5 w-3.5 rounded-full border-2 border-white bg-green-500"></span>
                </div>

                {{-- Info --}}
                <div class="min-w-0 flex-1">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <h2 class="text-[17px] font-bold leading-tight text-slate-900">{{ $user->nama }}</h2>
                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-600">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Wali Murid Terverifikasi
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">
                        Wali Murid &bull; Terdaftar sejak
                        {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}
                    </p>

                    <div class="mt-2 flex flex-wrap gap-4 text-[12px] text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Arrava E-Learning
                        </span>

                        <span class="flex items-center gap-1">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Sinkronisasi Otomatis
                        </span>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="shrink-0">
                    <label
                        for="foto_profil_input"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border border-slate-200 bg-slate-100 px-[22px] py-2.5 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-slate-200"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Ganti Foto
                    </label>

                    <input
                        type="file"
                        id="foto_profil_input"
                        name="foto_profil"
                        accept="image/*"
                        class="hidden"
                        onchange="previewFoto(this)"
                    >
                </div>
            </div>
        </div>

        {{-- INFORMASI PRIBADI & KONTAK --}}
        <div class="mb-5 rounded-2xl border border-slate-200 bg-white p-6">
            <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-[15px] font-bold text-slate-900">Informasi Pribadi &amp; Kontak Resmi</h3>
                    <p class="mt-0.5 text-[12px] text-slate-400">
                        Data ini digunakan sekolah untuk pelaporan resmi, buku rapor, dan kontak keadaan mendesak.
                    </p>
                </div>

                <div class="mt-1 whitespace-nowrap text-[11px] font-semibold uppercase tracking-wide text-slate-400 sm:mt-0">
                    TERAKHIR DIPERBARUI:
                    {{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d M Y') }}
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama" class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Nama Lengkap Beserta Gelar
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="w-full rounded-[10px] border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/10"
                            value="{{ old('nama', $user->nama) }}"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    @error('nama')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NISN / ID Akun --}}
                <div>
                    <label class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        NISN / ID Akun
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>

                        <input
                            type="text"
                            class="w-full cursor-not-allowed rounded-[10px] border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-28 text-sm text-slate-400 outline-none"
                            value="{{ $user->nisn ?? '-' }}"
                            readonly
                        >

                        <span class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full border border-green-200 bg-green-50 px-[7px] py-px text-[10px] font-semibold text-green-500">
                            Terverifikasi
                        </span>
                    </div>

                    <p class="mt-1 text-[11px] text-slate-400">
                        ID akun tidak dapat diubah sendiri, hubungi admin.
                    </p>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Alamat Surel (Email Utama)

                        <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-600">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Terverifikasi
                        </span>
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full rounded-[10px] border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/10"
                            value="{{ old('email', $user->email) }}"
                            placeholder="email@contoh.com"
                        >
                    </div>

                    <p class="mt-1 text-[11px] text-slate-400">
                        Digunakan untuk menerima rekap rapor digital bulanan &amp; akses reset login.
                    </p>

                    @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label for="nomor_hp" class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Nomor WhatsApp Aktif
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>

                        <input
                            type="text"
                            id="nomor_hp"
                            name="nomor_hp"
                            class="w-full rounded-[10px] border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/10"
                            value="{{ old('nomor_hp', $user->nomor_hp) }}"
                            placeholder="+62 8xx-xxxx-xxxx"
                        >
                    </div>

                    <p class="mt-1 text-[11px] text-slate-400">
                        Tujuan pengiriman notifikasi instan kehadiran &amp; presensi pagi anak.
                    </p>

                    @error('nomor_hp')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Akun --}}
                <div>
                    <label class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Status Kependudukan / NIK
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>

                        <input
                            type="text"
                            class="w-full cursor-not-allowed rounded-[10px] border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-28 text-sm text-slate-400 outline-none"
                            value="{{ $user->status_akun ?? 'Aktif' }} (Terverifikasi)"
                            readonly
                        >

                        <span class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full border border-green-200 bg-green-50 px-[7px] py-px text-[10px] font-semibold text-green-500">
                            Terverifikasi
                        </span>
                    </div>

                    <p class="mt-1 text-[11px] text-slate-400">
                        Untuk pembaruan NIK resmi, silakan lampirkan Kartu Keluarga ke Tata Usaha.
                    </p>
                </div>

            </div>
        </div>

        {{-- KEAMANAN AKUN --}}
        <div class="mb-5 rounded-2xl border border-slate-200 bg-white p-6">
            <h3 class="mb-1 text-[15px] font-bold text-slate-900">Keamanan Akun</h3>
            <p class="mb-5 text-[12px] text-slate-400">
                Kosongkan jika tidak ingin mengubah kata sandi. Isi keduanya untuk mengganti password.
            </p>

            <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Kata Sandi Baru
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full rounded-[10px] border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/10"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                        >
                    </div>

                    @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-[13px] font-semibold text-slate-600">
                        Konfirmasi Kata Sandi
                    </label>

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full rounded-[10px] border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/10"
                            placeholder="Ulangi kata sandi baru"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="mt-2 flex items-center justify-end gap-3 pb-8">
            <button
                type="reset"
                class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border border-slate-200 bg-slate-100 px-[22px] py-2.5 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-slate-200"
                onclick="return confirm('Reset semua perubahan yang belum disimpan?')"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Batal / Reset
            </button>

            <button
                type="submit"
                id="btnSimpan"
                class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border-0 bg-indigo-600 px-[22px] py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-indigo-700 active:-translate-y-px disabled:cursor-not-allowed disabled:opacity-60"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const avatarEl = document.querySelector('#avatarWrap > img, #avatarWrap > div');

            if (avatarEl) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Foto Profil';
                img.className = 'h-[72px] w-[72px] rounded-2xl border-2 border-slate-100 object-cover shadow-sm';
                avatarEl.replaceWith(img);
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Tombol simpan loading state
document.getElementById('formPengaturan').addEventListener('submit', function() {
    const btn = document.getElementById('btnSimpan');

    btn.disabled = true;
    btn.innerHTML = '<svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Menyimpan...';
});
</script>
@endpush
