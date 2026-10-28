@extends('layouts.auth')

@section('title', 'Daftar - Arrava')

@section('auth_form')
<div>
    {{-- Heading --}}
    <div class="mb-4 flex items-start justify-between gap-3">
        <div>
            <h1 class="mb-1 text-center text-[21px] font-extrabold leading-tight tracking-[-0.5px] text-[#092663] sm:text-[22px]">
                Buat Akun Baru
            </h1>

            <p class="text-center text-[11px] leading-[17px] text-[#536da1]">
                Bergabunglah dengan Arrava dan mulai perjalanan belajar Anda sekarang.
            </p>
        </div>

        <span class="hidden h-8 w-8 shrink-0 place-items-center rounded-full bg-[#EEF5FF] text-[#3F82F6] sm:grid">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="8.5" />
                <path d="m9 9 6 6m0-6-6 6" />
            </svg>
        </span>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
    <div class="shake mb-3 rounded-[10px] border border-[#FFD4D4] bg-[#FFF2F2] px-3 py-2 text-xs leading-5 text-[#A32929]">
        <p class="font-bold">Silakan perbaiki data berikut.</p>

        <ul class="ml-4 list-disc">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Registration form --}}
    <form
        action="{{ route('pendaftaranBaru') }}"
        method="POST"
        class="space-y-2.5 {{ $errors->any() ? 'shake' : '' }}">
        @csrf

        {{-- Nama lengkap --}}
        <div>
            <label for="nama" class="auth-label">Nama Lengkap</label>

            <input
                id="nama"
                name="nama"
                type="text"
                value="{{ old('nama') }}"
                placeholder="Masukkan nama lengkap Anda"
                required
                class="auth-field">

            @error('nama')
            <p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="auth-label">Alamat Email</label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                class="auth-field">

            @error('email')
            <p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
            @enderror
        </div>

        {{-- NISN --}}
        <div>
            <label for="nisn" class="auth-label">NISN</label>

            <input
                id="nisn"
                name="nisn"
                type="tel"
                value="{{ old('nisn') }}"
                placeholder="Contoh: 0012345678"
                class="auth-field">

            @error('nisn')
            <p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor handphone --}}
        <div>
            <label for="nomor_hp" class="auth-label">Nomor Handphone</label>

            <input
                id="nomor_hp"
                name="nomor_hp"
                type="tel"
                value="{{ old('nomor_handphone') }}"
                placeholder="Contoh: 08123456789"
                class="auth-field">
        </div>

        {{-- Password and confirmation --}}
        <div class="grid grid-cols-2 gap-3">
            <div class="min-w-0">
                <label for="password" class="auth-label">Kata Sandi</label>

                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Min. 8 karakter"
                        required
                        class="auth-field pr-9">

                    <button
                        type="button"
                        data-toggle-password="password"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB]"
                        aria-label="Tampilkan kata sandi">
                        <svg viewBox="0 0 24 24" class="h-[17px] w-[17px]" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                    </button>
                </div>

                @error('password')
                <p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            <div class="min-w-0">
                <label for="password_confirmation" class="auth-label">Konfirmasi Sandi</label>

                <div class="relative">
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Ulangi sandi"
                        required
                        class="auth-field pr-9">

                    <button
                        type="button"
                        data-toggle-password="password_confirmation"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB]"
                        aria-label="Tampilkan kata sandi">
                        <svg viewBox="0 0 24 24" class="h-[17px] w-[17px]" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Jenjang pendidikan --}}
        <div>
            <label for="id_jenjang" class="auth-label">Jenjang Pendidikan</label>

            <select
                id="id_jenjang"
                name="id_jenjang"
                required
                class="auth-field">
                <option value="">Pilih jenjang</option>

                @foreach ($jenjang as $tipe_jenjang)
                <option
                    value="{{ $tipe_jenjang->id_jenjang }}"
                    {{ old('id_jenjang') == $tipe_jenjang->id_jenjang ? 'selected' : '' }}>
                    {{ $tipe_jenjang->nama_tipe }}
                </option>
                @endforeach
            </select>

            @error('id_jenjang')
            <p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="auth-submit mt-1 flex h-[40px] w-full items-center justify-center gap-2 rounded-[8px] text-[12px] font-bold text-white transition hover:-translate-y-px">
            Daftar sekarang<span aria-hidden="true"></span>
        </button>
    </form>

    {{-- Login link --}}
    <p class="mt-3 text-center text-[11px] text-[#536da1]">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-bold text-[#3F82F6] hover:underline">
            Masuk di sini
        </a>
    </p>
</div>
@endsection