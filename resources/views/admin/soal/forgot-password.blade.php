@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - eBooks')

@section('auth_form')
    <div>
        <h1 class="mb-2 text-[26px] font-extrabold leading-tight tracking-[-0.8px]">Lupa Kata Sandi?</h1>
        <p class="mb-7 text-[14px] leading-6 text-[#53647D]">
            Jangan khawatir! Masukkan alamat email yang terdaftar pada akun eBooks Anda.
        </p>

        @if (session('status'))
            <div class="mb-5 rounded-[10px] border border-[#C8F3E0] bg-[#EDFCF6] px-3.5 py-3 text-xs leading-5 text-[#08764F]">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-[10px] border border-[#FFD4D4] bg-[#FFF2F2] px-3.5 py-3 text-xs leading-5 text-[#A32929]">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Alamat Email Terdaftar</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="nama@email.com" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                @error('email')<p class="mt-1.5 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="mt-8 flex h-[46px] w-full items-center justify-center rounded-[11px] bg-[#3F82F6] text-[13px] font-bold text-white shadow-[0_8px_16px_rgba(63,130,246,0.18)] transition hover:-translate-y-px hover:bg-[#3274E9] hover:shadow-[0_10px_20px_rgba(63,130,246,0.22)]">
                Kirim Tautan Atur Ulang
            </button>
        </form>

        <a href="{{ route('login') }}" class="mt-7 inline-flex w-full items-center justify-center gap-2 text-xs font-bold text-[#3F82F6] hover:underline">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="m11 18-6-6 6-6"/></svg>
            Kembali ke halaman masuk
        </a>
    </div>
@endsection

@section('illustration')
    <img src="{{ asset('images/auth/forgot-illustration.png') }}" alt="Ilustrasi pengaturan ulang kata sandi" class="mx-auto mb-[31px] block h-[280px] w-full max-w-[380px] rounded-[22px] object-cover">
    <h2 class="mb-2.5 text-[22px] font-extrabold leading-tight tracking-[-0.6px]">Kami Siap Membantu Anda</h2>
    <p class="mx-auto max-w-[430px] text-[13px] leading-6 text-[#53647D]">
        Akses akun Anda akan segera kembali. Tim eBooks selalu memastikan keamanan dan kenyamanan data belajar Anda.
    </p>
@endsection
