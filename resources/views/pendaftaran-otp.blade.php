@extends('layouts.auth')

@section('title', 'Verifikasi email siswa | Arrava')

@section('auth_form')
    <h1 class="text-2xl font-bold text-[#082765]">Verifikasi email siswa</h1>
    <p class="mt-2 break-words text-sm text-[#536DA1]">
        Kode OTP dikirim ke <strong>{{ $email }}</strong> dan berlaku selama 5 menit.
        apabila tidak masuk kode coba cek dulu di menu email Spam
    </p>

    <form class="mt-5 space-y-4" method="POST" action="{{ route('pendaftaran.otp.verify') }}">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-[#082765]" for="code">Kode OTP</label>
            <input class="mt-1 w-full rounded-xl border border-[#8AB9FF] px-4 py-3 text-[#082765]"
                id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                maxlength="6" pattern="[0-9]{6}" required autofocus
                @error('code') aria-invalid="true" aria-describedby="code-error" @enderror>
            @error('code')
                <p id="code-error" role="alert" class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>
        <button class="w-full rounded-xl bg-[#082765] px-4 py-3 font-bold text-white" type="submit">
            Verifikasi dan buat akun
        </button>
    </form>

    <form class="mt-4" method="POST" action="{{ route('pendaftaran.otp.resend') }}">
        @csrf
        @if (session('status'))
            <p class="mb-2 text-sm text-green-700" role="status">{{ session('status') }}</p>
        @endif
        @error('resend')
            <p class="mb-2 text-sm text-red-700" role="alert">{{ $message }}</p>
        @enderror
        <button id="resend-otp" class="rounded-lg border border-[#082765] px-3 py-2 text-sm font-semibold text-[#082765] disabled:cursor-not-allowed disabled:opacity-60"
            type="submit" data-wait="{{ $resendIn }}" aria-describedby="resend-countdown" @disabled($resendIn > 0)>
            Kirim ulang kode
        </button>
        <p id="resend-countdown" class="mt-2 text-sm text-[#536DA1]">
            @if ($resendIn > 0)
                Kirim ulang tersedia dalam {{ $resendIn }} detik.
            @endif
        </p>
        <noscript><p class="text-sm">Muat ulang halaman setelah waktu tunggu selesai.</p></noscript>
    </form>

    <a class="mt-4 inline-block text-sm font-semibold text-[#082765] underline" href="{{ route('pendaftaran') }}">
        Kembali ke pendaftaran
    </a>
@endsection

@section('scripts')
    <script>
        (() => {
            const button = document.getElementById('resend-otp');
            const countdown = document.getElementById('resend-countdown');
            const availableAt = Date.now() + Number(button.dataset.wait) * 1000;

            function updateCountdown() {
                const remaining = Math.max(0, Math.ceil((availableAt - Date.now()) / 1000));
                button.disabled = remaining > 0;
                countdown.textContent = remaining > 0 ? `Kirim ulang tersedia dalam ${remaining} detik.` : '';
                if (remaining > 0) window.setTimeout(updateCountdown, 250);
            }

            updateCountdown();
            button.form.addEventListener('submit', () => { button.disabled = true; });
        })();
    </script>
@endsection
