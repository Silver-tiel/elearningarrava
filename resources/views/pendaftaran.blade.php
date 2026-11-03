@extends('layouts.auth')

@section('title', 'Daftar - Arrava')

@section('styles')
<style>
    /* Styling khusus multi-step wizard pendaftaran */
    .step-active-badge {
        background-color: #0875F9 !important;
        color: #ffffff !important;
        border-color: #0875F9 !important;
        box-shadow: 0 2px 6px rgba(8, 117, 249, 0.25);
    }

    .step-done-badge {
        background-color: #10B981 !important;
        color: #ffffff !important;
        border-color: #10B981 !important;
    }

    .step-active-text {
        color: #082765 !important;
        font-weight: 700 !important;
    }

    .step-fade-in {
        animation: fadeInStep 0.22s ease-out forwards;
    }

    @keyframes fadeInStep {
        from {
            opacity: 0;
            transform: translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('auth_form')
<div>
    {{-- Stepper Progress Bar (2 Halaman / 2 Langkah) --}}
    <div class="mb-4">
        <div class="flex items-center justify-between mb-2 px-2">
            {{-- Step 1 Button/Pill --}}
            <button type="button" id="tabStep1" class="flex items-center gap-1.5 focus:outline-none transition group text-left">
                <span id="badgeStep1" class="h-6 w-6 rounded-full flex items-center justify-center text-[11px] font-bold text-white bg-[#0875F9] shadow-sm transition">
                    1
                </span>
                <span id="textStep1" class="text-[11px] font-bold text-[#082765] transition">
                    1. Data Siswa
                </span>
            </button>

            {{-- Connector Bar --}}
            <div class="flex-1 mx-2.5 h-1 bg-[#E2EDF9] rounded-full relative overflow-hidden">
                <div id="stepProgressBar" class="h-full bg-[#0875F9] transition-all duration-300" style="width: 50%;"></div>
            </div>

            {{-- Step 2 Button/Pill --}}
            <button type="button" id="tabStep2" class="flex items-center gap-1.5 focus:outline-none transition group text-left">
                <span id="badgeStep2" class="h-6 w-6 rounded-full flex items-center justify-center text-[11px] font-semibold text-[#647BA7] bg-[#EEF5FF] border border-[#DCE7F7] transition">
                    2
                </span>
                <span id="textStep2" class="text-[11px] font-medium text-[#647BA7] transition">
                    2. Orang Tua
                </span>
            </button>
        </div>

        {{-- Subtitle Indikator --}}
        <div class="text-center pt-0.5">
            <h1 id="stepHeading" class="text-[19px] font-extrabold text-[#082765] leading-tight">
                Informasi Akun Siswa
            </h1>
            <p id="stepDescription" class="text-[11px] text-[#536da1] mt-0.5">
                Langkah 1 dari 2 &bull; Masukkan identitas siswa untuk mulai belajar
            </p>
        </div>
    </div>

    {{-- Validation errors summary (jika ada error dari server) --}}
    @if ($errors->any())
    <div class="shake mb-3 rounded-[9px] border border-[#FFD4D4] bg-[#FFF2F2] px-3 py-2 text-[11px] leading-4 text-[#A32929]">
        <p class="font-bold mb-1">Mohon periksa data yang belum sesuai:</p>
        <ul class="ml-4 list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form Registrasi (2 Langkah) --}}
    <form
        id="formPendaftaran"
        action="{{ route('pendaftaranBaru') }}"
        method="POST"
        novalidate>
        @csrf

        {{-- =================================================================== --}}
        {{-- LANGKAH 1: DATA SISWA --}}
        {{-- =================================================================== --}}
        <div id="step1Content" class="space-y-2.5 step-fade-in">
            {{-- Nama Lengkap Siswa --}}
            <div>
                <label for="nama" class="auth-label">
                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                </label>
                <input
                    id="nama"
                    name="nama"
                    type="text"
                    value="{{ old('nama') }}"
                    placeholder="Contoh: Budi Pratama"
                    required
                    autocomplete="name"
                    class="auth-field">
                <p id="err_nama" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('nama')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Siswa --}}
            <div>
                <label for="email" class="auth-label">
                    Alamat Email Siswa <span class="text-red-500">*</span>
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="siswa@email.com"
                    required
                    autocomplete="email"
                    class="auth-field">
                <p id="err_email" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('email')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Grid 2 Kolom: NISN & Jenjang Pendidikan --}}
            <div class="grid grid-cols-2 gap-2.5">
                <div class="min-w-0">
                    <label for="nisn" class="auth-label">
                        NISN (10 Digit) <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="nisn"
                        name="nisn"
                        type="text"
                        maxlength="10"
                        value="{{ old('nisn') }}"
                        placeholder="Contoh: 0012345678"
                        required
                        inputmode="numeric"
                        class="auth-field">
                    <p id="err_nisn" class="client-err mt-1 text-[10px] font-semibold text-[#C52D2D] hidden"></p>
                    @error('nisn')
                    <p class="server-err mt-1 text-[10px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="min-w-0">
                    <label for="id_jenjang" class="auth-label">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
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
                    <p id="err_id_jenjang" class="client-err mt-1 text-[10px] font-semibold text-[#C52D2D] hidden"></p>
                    @error('id_jenjang')
                    <p class="server-err mt-1 text-[10px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nomor Handphone Siswa --}}
            <div>
                <label for="nomor_handphone" class="auth-label">
                    Nomor WhatsApp / HP Siswa <span class="text-red-500">*</span>
                </label>
                <input
                    id="nomor_handphone"
                    name="nomor_handphone"
                    type="tel"
                    value="{{ old('nomor_handphone', old('nomor_hp')) }}"
                    placeholder="Contoh: 081234567890"
                    required
                    inputmode="tel"
                    class="auth-field">
                <p id="err_nomor_handphone" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('nomor_handphone')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Grid 2 Kolom: Kata Sandi & Konfirmasi Sandi --}}
            <div class="grid grid-cols-2 gap-2.5">
                <div class="min-w-0">
                    <label for="password" class="auth-label">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Min. 8 karakter"
                            required
                            class="auth-field pr-8">
                        <button
                            type="button"
                            data-toggle-password="password"
                            class="absolute right-1 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB] hover:text-[#3F82F6] transition"
                            aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5Z" />
                                <circle cx="12" cy="12" r="2.5" />
                            </svg>
                        </button>
                    </div>
                    <p id="err_password" class="client-err mt-1 text-[10px] font-semibold text-[#C52D2D] hidden"></p>
                    @error('password')
                    <p class="server-err mt-1 text-[10px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="min-w-0">
                    <label for="password_confirmation" class="auth-label">
                        Konfirmasi Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Ulangi sandi"
                            required
                            class="auth-field pr-8">
                        <button
                            type="button"
                            data-toggle-password="password_confirmation"
                            class="absolute right-1 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB] hover:text-[#3F82F6] transition"
                            aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5Z" />
                                <circle cx="12" cy="12" r="2.5" />
                            </svg>
                        </button>
                    </div>
                    <p id="err_password_confirmation" class="client-err mt-1 text-[10px] font-semibold text-[#C52D2D] hidden"></p>
                </div>
            </div>

            {{-- Tombol Lanjut ke Langkah 2 --}}
            <div class="pt-1.5">
                <button
                    type="button"
                    id="btnNextStep"
                    class="auth-submit flex h-[38px] w-full items-center justify-center gap-2 rounded-[8px] text-[12px] font-bold text-white transition hover:-translate-y-px">
                    <span>Lanjut: Data Orang Tua</span>
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- =================================================================== --}}
        {{-- LANGKAH 2: DATA ORANG TUA / WALI --}}
        {{-- =================================================================== --}}
        <div id="step2Content" class="space-y-2.5 hidden step-fade-in">
            {{-- Info Banner Manfaat Akun Orang Tua --}}
            <div class="flex items-start gap-2.5 rounded-[8px] border border-[#CDE1FE] bg-[#EEF5FF] p-2.5 text-[#103A8A]">
                <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 text-[#0875F9] mt-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="16" x2="12" y2="12" />
                    <line x1="12" y1="8" x2="12.01" y2="8" />
                </svg>
                <p class="text-[10.5px] leading-[15px]">
                    <strong>Akun Monitoring Orang Tua:</strong> Dibuat otomatis untuk memantau kehadiran harian siswa, presensi QR, tugas, dan nilai akademik.
                </p>
            </div>

            {{-- Nama Lengkap Orang Tua --}}
            <div>
                <label for="nama_orangtua" class="auth-label">
                    Nama Lengkap Orang Tua / Wali <span class="text-red-500">*</span>
                </label>
                <input
                    id="nama_orangtua"
                    name="nama_orangtua"
                    type="text"
                    value="{{ old('nama_orangtua') }}"
                    placeholder="Contoh: Hendra Pratama / Siti Aminah"
                    autocomplete="name"
                    class="auth-field">
                <p id="err_nama_orangtua" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('nama_orangtua')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Orang Tua --}}
            <div>
                <label for="email_orangtua" class="auth-label">
                    Alamat Email Orang Tua / Wali <span class="text-red-500">*</span>
                </label>
                <input
                    id="email_orangtua"
                    name="email_orangtua"
                    type="email"
                    value="{{ old('email_orangtua') }}"
                    placeholder="orangtua@email.com"
                    autocomplete="email"
                    class="auth-field">
                <p class="mt-0.5 text-[9.5px] text-[#647BA7]">Harus berbeda dengan alamat email siswa.</p>
                <p id="err_email_orangtua" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('email_orangtua')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Handphone Orang Tua --}}
            <div>
                <label for="nomor_hp_orangtua" class="auth-label">
                    Nomor WhatsApp / HP Orang Tua <span class="text-red-500">*</span>
                </label>
                <input
                    id="nomor_hp_orangtua"
                    name="nomor_hp_orangtua"
                    type="tel"
                    value="{{ old('nomor_hp_orangtua') }}"
                    placeholder="Contoh: 081298765432"
                    inputmode="tel"
                    class="auth-field">
                <p id="err_nomor_hp_orangtua" class="client-err mt-1 text-[10.5px] font-semibold text-[#C52D2D] hidden"></p>
                @error('nomor_hp_orangtua')
                <p class="server-err mt-1 text-[10.5px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pengaturan Kata Sandi Orang Tua --}}
            <div class="rounded-[7px] border border-[#DCE7F7] bg-white/70 p-2.5">
                <label class="flex items-start gap-2 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        id="same_password"
                        name="same_password"
                        value="1"
                        {{ old('password_orangtua') ? '' : 'checked' }}
                        class="mt-0.5 h-3.5 w-3.5 rounded border-[#C9D7F5] text-[#0875F9] focus:ring-[#0875F9]">
                    <div>
                        <span class="text-[11px] font-semibold text-[#102B69] block leading-tight">
                            Gunakan kata sandi yang sama dengan siswa
                        </span>
                        <span class="text-[10px] text-[#647BA7] block mt-0.5">
                            Dianjurkan agar orang tua dan siswa mudah mengingat kata sandi.
                        </span>
                    </div>
                </label>

                {{-- Input kata sandi khusus (muncul bila checkbox tidak dicentang) --}}
                <div id="parentPasswordWrap" class="{{ old('password_orangtua') ? '' : 'hidden' }} mt-2 pt-2 border-t border-[#E8F0FE]">
                    <label for="password_orangtua" class="auth-label">Kata Sandi Khusus Orang Tua</label>
                    <div class="relative">
                        <input
                            id="password_orangtua"
                            name="password_orangtua"
                            type="password"
                            value="{{ old('password_orangtua') }}"
                            placeholder="Min. 8 karakter"
                            class="auth-field pr-8">
                        <button
                            type="button"
                            data-toggle-password="password_orangtua"
                            class="absolute right-1 top-1/2 -translate-y-1/2 p-1.5 text-[#92A3BB] hover:text-[#3F82F6] transition"
                            aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5Z" />
                                <circle cx="12" cy="12" r="2.5" />
                            </svg>
                        </button>
                    </div>
                    <p id="err_password_orangtua" class="client-err mt-1 text-[10px] font-semibold text-[#C52D2D] hidden"></p>
                    @error('password_orangtua')
                    <p class="server-err mt-1 text-[10px] font-semibold text-[#C52D2D]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tombol Navigasi: Kembali & Submit --}}
            <div class="flex items-center gap-2 pt-1.5">
                <button
                    type="button"
                    id="btnPrevStep"
                    class="flex h-[38px] items-center justify-center gap-1.5 px-3.5 rounded-[8px] border border-[#DCE7F7] bg-white text-[12px] font-semibold text-[#3F82F6] hover:bg-[#F1F7FD] transition">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </button>

                <button
                    type="submit"
                    id="btnSubmitRegister"
                    class="auth-submit flex-1 flex h-[38px] items-center justify-center gap-2 rounded-[8px] text-[12px] font-bold text-white transition hover:-translate-y-px">
                    <span>Daftar Akun Sekarang</span>
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
    </form>

    {{-- Link Masuk --}}
    <p class="mt-3.5 text-center text-[11px] text-[#536da1]">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-bold text-[#3F82F6] hover:underline">
            Masuk di sini
        </a>
    </p>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formPendaftaran');
        const step1Content = document.getElementById('step1Content');
        const step2Content = document.getElementById('step2Content');

        const tabStep1 = document.getElementById('tabStep1');
        const tabStep2 = document.getElementById('tabStep2');
        const badgeStep1 = document.getElementById('badgeStep1');
        const badgeStep2 = document.getElementById('badgeStep2');
        const textStep1 = document.getElementById('textStep1');
        const textStep2 = document.getElementById('textStep2');
        const stepProgressBar = document.getElementById('stepProgressBar');

        const stepHeading = document.getElementById('stepHeading');
        const stepDescription = document.getElementById('stepDescription');

        const btnNextStep = document.getElementById('btnNextStep');
        const btnPrevStep = document.getElementById('btnPrevStep');

        const samePasswordCheckbox = document.getElementById('same_password');
        const parentPasswordWrap = document.getElementById('parentPasswordWrap');
        const parentPasswordInput = document.getElementById('password_orangtua');

        let currentStep = 1;

        // Tampilkan/sembunyikan input kata sandi orang tua sesuai checkbox
        if (samePasswordCheckbox && parentPasswordWrap) {
            samePasswordCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    parentPasswordWrap.classList.add('hidden');
                    if (parentPasswordInput) parentPasswordInput.value = '';
                    clearClientError('password_orangtua');
                } else {
                    parentPasswordWrap.classList.remove('hidden');
                    if (parentPasswordInput) parentPasswordInput.focus();
                }
            });
        }

        function setClientError(inputId, message) {
            const errEl = document.getElementById('err_' + inputId);
            const inputEl = document.getElementById(inputId);
            if (errEl) {
                errEl.textContent = message;
                errEl.classList.remove('hidden');
            }
            if (inputEl) {
                inputEl.classList.add('!border-red-400', '!bg-red-50/30');
            }
        }

        function clearClientError(inputId) {
            const errEl = document.getElementById('err_' + inputId);
            const inputEl = document.getElementById(inputId);
            if (errEl) {
                errEl.textContent = '';
                errEl.classList.add('hidden');
            }
            if (inputEl) {
                inputEl.classList.remove('!border-red-400', '!bg-red-50/30');
            }
        }

        // Hapus highlight error saat input diisi
        ['nama', 'email', 'nisn', 'id_jenjang', 'nomor_handphone', 'password', 'password_confirmation', 'nama_orangtua', 'email_orangtua', 'nomor_hp_orangtua', 'password_orangtua'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => clearClientError(id));
                el.addEventListener('change', () => clearClientError(id));
            }
        });

        // Validasi client-side untuk Langkah 1
        function validateStep1() {
            let isValid = true;
            let firstInvalidEl = null;

            // 1. Nama Siswa
            const nama = (document.getElementById('nama')?.value || '').trim();
            if (!nama) {
                setClientError('nama', 'Nama lengkap siswa wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nama');
            } else if (nama.length < 2) {
                setClientError('nama', 'Nama siswa minimal 2 karakter.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nama');
            } else if (!/^[a-zA-Z\s]+$/.test(nama)) {
                setClientError('nama', 'Nama siswa hanya boleh berisi huruf dan spasi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nama');
            } else {
                clearClientError('nama');
            }

            // 2. Email Siswa
            const email = (document.getElementById('email')?.value || '').trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                setClientError('email', 'Alamat email siswa wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('email');
            } else if (!emailRegex.test(email)) {
                setClientError('email', 'Format alamat email tidak valid.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('email');
            } else {
                clearClientError('email');
            }

            // 3. NISN (10 Digit)
            const nisn = (document.getElementById('nisn')?.value || '').trim();
            if (!nisn) {
                setClientError('nisn', 'NISN wajib diisi (10 digit).');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nisn');
            } else if (!/^\d{10}$/.test(nisn)) {
                setClientError('nisn', 'NISN harus terdiri dari 10 digit angka.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nisn');
            } else {
                clearClientError('nisn');
            }

            // 4. Jenjang Pendidikan
            const idJenjang = document.getElementById('id_jenjang')?.value || '';
            if (!idJenjang) {
                setClientError('id_jenjang', 'Pilih salah satu jenjang.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('id_jenjang');
            } else {
                clearClientError('id_jenjang');
            }

            // 5. Nomor HP Siswa
            const noHp = (document.getElementById('nomor_handphone')?.value || '').trim();
            if (!noHp) {
                setClientError('nomor_handphone', 'Nomor handphone siswa wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nomor_handphone');
            } else if (noHp.length < 10) {
                setClientError('nomor_handphone', 'Nomor handphone minimal 10 digit.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nomor_handphone');
            } else {
                clearClientError('nomor_handphone');
            }

            // 6. Password Siswa
            const password = document.getElementById('password')?.value || '';
            const passwordConfirmation = document.getElementById('password_confirmation')?.value || '';
            if (!password) {
                setClientError('password', 'Kata sandi wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('password');
            } else if (password.length < 8) {
                setClientError('password', 'Kata sandi minimal 8 karakter.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('password');
            } else {
                clearClientError('password');
            }

            // 7. Konfirmasi Sandi
            if (!passwordConfirmation) {
                setClientError('password_confirmation', 'Ulangi kata sandi Anda.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('password_confirmation');
            } else if (password !== passwordConfirmation) {
                setClientError('password_confirmation', 'Konfirmasi kata sandi tidak cocok.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('password_confirmation');
            } else {
                clearClientError('password_confirmation');
            }

            if (!isValid && firstInvalidEl) {
                firstInvalidEl.focus();
                firstInvalidEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return isValid;
        }

        // Validasi client-side untuk Langkah 2
        function validateStep2() {
            let isValid = true;
            let firstInvalidEl = null;

            // 1. Nama Orang Tua
            const namaOt = (document.getElementById('nama_orangtua')?.value || '').trim();
            if (!namaOt) {
                setClientError('nama_orangtua', 'Nama lengkap orang tua wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nama_orangtua');
            } else if (namaOt.length < 2) {
                setClientError('nama_orangtua', 'Nama orang tua minimal 2 karakter.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nama_orangtua');
            } else {
                clearClientError('nama_orangtua');
            }

            // 2. Email Orang Tua
            const emailOt = (document.getElementById('email_orangtua')?.value || '').trim();
            const emailSiswa = (document.getElementById('email')?.value || '').trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailOt) {
                setClientError('email_orangtua', 'Alamat email orang tua wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('email_orangtua');
            } else if (!emailRegex.test(emailOt)) {
                setClientError('email_orangtua', 'Format email orang tua tidak valid.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('email_orangtua');
            } else if (emailOt.toLowerCase() === emailSiswa.toLowerCase()) {
                setClientError('email_orangtua', 'Email orang tua tidak boleh sama dengan email siswa.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('email_orangtua');
            } else {
                clearClientError('email_orangtua');
            }

            // 3. Nomor HP Orang Tua
            const noHpOt = (document.getElementById('nomor_hp_orangtua')?.value || '').trim();
            if (!noHpOt) {
                setClientError('nomor_hp_orangtua', 'Nomor handphone orang tua wajib diisi.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nomor_hp_orangtua');
            } else if (noHpOt.length < 10) {
                setClientError('nomor_hp_orangtua', 'Nomor handphone minimal 10 digit.');
                isValid = false;
                if (!firstInvalidEl) firstInvalidEl = document.getElementById('nomor_hp_orangtua');
            } else {
                clearClientError('nomor_hp_orangtua');
            }

            // 4. Kata Sandi Khusus Orang Tua (hanya bila checkbox tidak dicentang)
            if (samePasswordCheckbox && !samePasswordCheckbox.checked) {
                const passOt = document.getElementById('password_orangtua')?.value || '';
                if (!passOt) {
                    setClientError('password_orangtua', 'Kata sandi khusus orang tua wajib diisi.');
                    isValid = false;
                    if (!firstInvalidEl) firstInvalidEl = document.getElementById('password_orangtua');
                } else if (passOt.length < 8) {
                    setClientError('password_orangtua', 'Kata sandi orang tua minimal 8 karakter.');
                    isValid = false;
                    if (!firstInvalidEl) firstInvalidEl = document.getElementById('password_orangtua');
                } else {
                    clearClientError('password_orangtua');
                }
            }

            if (!isValid && firstInvalidEl) {
                firstInvalidEl.focus();
                firstInvalidEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return isValid;
        }

        // Pindah ke Langkah tertentu (1 atau 2)
        function goToStep(step) {
            if (step === 2) {
                if (!validateStep1()) {
                    return;
                }
                currentStep = 2;
                step1Content.classList.add('hidden');
                step2Content.classList.remove('hidden');

                // Update UI Stepper
                badgeStep1.innerHTML = '&#10003;';
                badgeStep1.className = 'h-6 w-6 rounded-full flex items-center justify-center text-[12px] font-bold text-white bg-[#10B981] shadow-sm transition';
                textStep1.className = 'text-[11px] font-semibold text-[#10B981] transition';

                badgeStep2.innerHTML = '2';
                badgeStep2.className = 'h-6 w-6 rounded-full flex items-center justify-center text-[11px] font-bold text-white bg-[#0875F9] shadow-sm transition';
                textStep2.className = 'text-[11px] font-bold text-[#082765] transition';

                if (stepProgressBar) stepProgressBar.style.width = '100%';

                if (stepHeading) stepHeading.textContent = 'Informasi Akun Orang Tua';
                if (stepDescription) stepDescription.textContent = 'Langkah 2 dari 2 • Akun pendamping untuk memantau kehadiran & nilai siswa';

                // Fokus ke input nama orang tua
                const inputNamaOt = document.getElementById('nama_orangtua');
                if (inputNamaOt) inputNamaOt.focus();
            } else {
                currentStep = 1;
                step2Content.classList.add('hidden');
                step1Content.classList.remove('hidden');

                // Update UI Stepper
                badgeStep1.innerHTML = '1';
                badgeStep1.className = 'h-6 w-6 rounded-full flex items-center justify-center text-[11px] font-bold text-white bg-[#0875F9] shadow-sm transition';
                textStep1.className = 'text-[11px] font-bold text-[#082765] transition';

                badgeStep2.innerHTML = '2';
                badgeStep2.className = 'h-6 w-6 rounded-full flex items-center justify-center text-[11px] font-semibold text-[#647BA7] bg-[#EEF5FF] border border-[#DCE7F7] transition';
                textStep2.className = 'text-[11px] font-medium text-[#647BA7] transition';

                if (stepProgressBar) stepProgressBar.style.width = '50%';

                if (stepHeading) stepHeading.textContent = 'Informasi Akun Siswa';
                if (stepDescription) stepDescription.textContent = 'Langkah 1 dari 2 • Masukkan identitas siswa untuk mulai belajar';
            }
        }

        // Event listener navigasi
        if (btnNextStep) {
            btnNextStep.addEventListener('click', () => goToStep(2));
        }

        if (btnPrevStep) {
            btnPrevStep.addEventListener('click', () => goToStep(1));
        }

        if (tabStep1) {
            tabStep1.addEventListener('click', () => goToStep(1));
        }

        if (tabStep2) {
            tabStep2.addEventListener('click', () => {
                if (currentStep === 1) {
                    goToStep(2);
                }
            });
        }

        // Submit form validation
        if (form) {
            form.addEventListener('submit', function(e) {
                if (currentStep === 1) {
                    e.preventDefault();
                    goToStep(2);
                    return;
                }

                const s1Ok = validateStep1();
                const s2Ok = validateStep2();

                if (!s1Ok) {
                    e.preventDefault();
                    goToStep(1);
                    return;
                }

                if (!s2Ok) {
                    e.preventDefault();
                    return;
                }

                // Berikan feedback visual pada tombol submit saat memproses
                const submitBtn = document.getElementById('btnSubmitRegister');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Mendaftarkan Akun...</span>
                    `;
                }
            });
        }

        // Deteksi apakah server mengembalikan error khusus orang tua
        const parentServerErrors = document.querySelectorAll('#step2Content .server-err');
        const studentServerErrors = document.querySelectorAll('#step1Content .server-err');

        if (parentServerErrors.length > 0 && studentServerErrors.length === 0) {
            // Jika hanya data orang tua yang error di server, langsung buka Langkah 2
            goToStep(2);
        }
    });
</script>
@endsection
