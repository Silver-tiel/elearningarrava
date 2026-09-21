@extends('layouts.auth')

@section('title', 'Masuk - eBooks')

@section('auth_form')
    <div>
        <h1 class="mb-2 text-[26px] font-extrabold leading-tight tracking-[-0.8px] sm:text-[28px]">Selamat Datang!</h1>
        <p class="mb-7 text-[14px] leading-6 text-[#53647D]">
            Silakan masuk ke akun Anda untuk memulai proses belajar terbaik bersama eBooks.
        </p>

        @if (session('success'))
            <div class="mb-5 rounded-[10px] border border-[#C8F3E0] bg-[#EDFCF6] px-3.5 py-3 text-xs leading-5 text-[#08764F]">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-[10px] border border-[#FFD4D4] bg-[#FFF2F2] px-3.5 py-3 text-xs leading-5 text-[#A32929]">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    placeholder="nama@email.com"
                    required
                    class="h-11 w-full rounded-[10px] border border-[#DCE5F1] bg-white px-3.5 text-[13px] text-[#172036] outline-none transition placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10"
                >
                @error('email')
                    <p class="mt-1.5 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Kata Sandi</label>
                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                        required
                        class="h-11 w-full rounded-[10px] border border-[#DCE5F1] bg-white px-3.5 pr-11 text-[13px] text-[#172036] outline-none transition placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10"
                    >
                    <button type="button" data-toggle-password="password" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB]" aria-label="Tampilkan kata sandi">
                        <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-1 text-xs text-[#52647E]">
                <label class="inline-flex cursor-pointer items-center gap-2 font-normal">
                    <input type="checkbox" name="remember" value="1" class="h-[17px] w-[17px] accent-[#3F82F6]">
                    <span>Ingat Saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-bold text-[#3F82F6] hover:underline">Lupa Password?</a>
            </div>

            <button type="submit" class="mt-1 flex h-[46px] w-full items-center justify-center rounded-[11px] bg-[#3F82F6] text-[13px] font-bold text-white shadow-[0_8px_16px_rgba(63,130,246,0.18)] transition hover:-translate-y-px hover:bg-[#3274E9] hover:shadow-[0_10px_20px_rgba(63,130,246,0.22)]">
                Masuk Sekarang
            </button>
        </form>


        <p class="mt-6 text-center text-xs text-[#53647D]">
            Belum punya akun?
            <a href="{{ route('pendaftaran') }}" class="font-bold text-[#3F82F6] hover:underline">Daftar sekarang</a>
        </p>
    </div>
@endsection

@section('illustration')
    <img src="{{ asset('images/auth/login-illustration.png') }}" alt="Siswa sedang belajar" class="mx-auto mb-[31px] block h-[280px] w-full max-w-[380px] rounded-[22px] object-cover">
    <h2 class="mb-2.5 text-[22px] font-extrabold leading-tight tracking-[-0.6px]">Belajar Lebih Seru &amp; Terarah</h2>
    <p class="mx-auto max-w-[430px] text-[13px] leading-6 text-[#53647D]">
        Dapatkan materi bimbel eksklusif, ribuan soal latihan interaktif, dan tutor pendamping terbaik di kelasnya.
    </p>
@endsection
