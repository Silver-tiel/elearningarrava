@extends('layouts.auth')

@section('title', 'Buat Akun - eBooks')

@section('auth_form')
    <div>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="mb-1 text-[25px] font-extrabold leading-tight tracking-[-0.8px] sm:text-[26px]">Buat Akun Baru</h1>
                <p class="mb-4 text-[13px] leading-5 text-[#53647D]">Gabunglah bersama jutaan siswa lainnya di platform bimbel eBooks.</p>
            </div>
            <span class="hidden h-8 w-8 shrink-0 place-items-center rounded-full bg-[#EEF5FF] text-[#3F82F6] sm:grid">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="8.5"/><path d="m9 9 6 6m0-6-6 6"/>
                </svg>
            </span>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-[10px] border border-[#FFD4D4] bg-[#FFF2F2] px-3.5 py-2.5 text-xs leading-5 text-[#A32929]">
                <p class="font-bold">Silakan perbaiki data berikut.</p>
                <ul class="ml-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('pendaftaranBaru') }}" method="POST" class="space-y-3.5">
            @csrf

            <div>
                <label for="nama" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Nama Lengkap</label>
                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap Anda" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                @error('nama')<p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                @error('email')<p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="nisn" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">NISN</label>
                <input id="nisn" name="nomor_handphone" type="tel" value="{{ old('nisn') }}" placeholder="Contoh: 0012345678" class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
            </div>

            <div>
                <label for="nomor_handphone" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Nomor Handphone</label>
                <input id="nomor_handphone" name="nomor_handphone" type="tel" value="{{ old('nomor_handphone') }}" placeholder="Contoh: 08123456789" class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="Min. 8 Karakter" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 pr-11 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                        <button type="button" data-toggle-password="password" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB]" aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Konfirmasi Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi sandi" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] px-3.5 pr-11 text-[13px] outline-none placeholder:text-[#96A7C0] focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                        <button type="button" data-toggle-password="password_confirmation" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB]" aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label for="id_jenjang" class="mb-1.5 block text-[13px] font-bold text-[#4C5E78]">Jenjang Pendidikan</label>
                <select id="id_jenjang" name="id_jenjang" required class="h-11 w-full rounded-[10px] border border-[#DCE5F1] bg-white px-3.5 text-[13px] text-[#53647D] outline-none focus:border-[#75A7F8] focus:ring-4 focus:ring-[#3F82F6]/10">
                    <option value="">Pilih jenjang</option>
                    @foreach($jenjang as $tipe_jenjang)
                        <option value="{{ $tipe_jenjang->id_jenjang }}" {{ old('id_jenjang') == $tipe_jenjang->id_jenjang ? 'selected' : '' }}>{{ $tipe_jenjang->nama_tipe }}</option>
                    @endforeach
                </select>
                @error('id_jenjang')<p class="mt-1 text-[11px] font-semibold text-[#C52D2D]">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="mt-1 flex h-[46px] w-full items-center justify-center rounded-[11px] bg-[#12B981] text-[13px] font-bold text-white shadow-[0_8px_16px_rgba(18,185,129,0.18)] transition hover:-translate-y-px hover:bg-[#0EAA76]">
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-5 text-center text-xs text-[#53647D]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-[#3F82F6] hover:underline">Masuk di sini</a>
        </p>
    </div>
@endsection

@section('illustration')
    <img src="{{ asset('images/auth/register-illustration.png') }}" alt="Siswa merayakan kelulusan" class="mx-auto mb-[31px] block h-[280px] w-full max-w-[380px] rounded-[22px] object-cover">
    <h2 class="mb-2.5 text-[22px] font-extrabold leading-tight tracking-[-0.6px]">Mulai Perjalanan Prestasimu</h2>
    <p class="mx-auto max-w-[430px] text-[13px] leading-6 text-[#53647D]">
        Nikmati kemudahan mengakses video pembelajaran berkualitas tinggi, bank soal lengkap, dan konsultasi PR gratis.
    </p>
@endsection
