<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegistrationOtp
{
    public const COOLDOWN = 60;
    public const LIFETIME = 300;

    public function send(string $email, string $errorField, ?array $previous = null): array
    {
        if (app()->isProduction() && in_array(config('mail.default'), ['log', 'array', 'failover'], true)) {
            throw ValidationException::withMessages([$errorField => 'Pengiriman kode belum tersedia. Hubungi administrator.']);
        }

        $key = 'registration-otp:'.hash('sha256', strtolower($email));
        $allowed = Cache::lock($key.':lock', 10)->block(5, function () use ($key) {
            return RateLimiter::attempt($key, 1, fn () => true, self::COOLDOWN);
        });

        if (!$allowed) {
            throw ValidationException::withMessages([$errorField => 'Tunggu '.RateLimiter::availableIn($key).' detik sebelum meminta kode baru.']);
        }

        do {
            $code = sprintf('%06d', random_int(0, 999999));
        } while ($previous && $this->matches($previous, $code));
        $nonce = bin2hex(random_bytes(16));

        try {
          Mail::html(
                "
                <div style='font-family: Arial, sans-serif; text-align: center;'>
                    <p style='font-size: 16px;'>
                        Kode pendaftaran Arrava Anda:
                    </p>

                    <h1 style='font-size: 40px; letter-spacing: 8px; color: #2563eb; margin: 20px 0;'>
                        {$code}
                    </h1>

                    <p style='font-size: 14px; color: #555;'>
                        Kode berlaku selama 5 menit. Jangan bagikan kode ini kepada siapa pun.
                    </p>
                </div>
                ",
                fn ($message) => $message->to($email)->subject('Kode pendaftaran Arrava'),
            );
        } catch (Throwable $exception) {
            report($exception);

            throw ValidationException::withMessages([$errorField => 'Kode gagal dikirim. Coba lagi dalam satu menit.']);
        }

        return [
            'nonce' => $nonce,
            'hash' => $this->digest($nonce, $code),
            'expires_at' => now()->timestamp + self::LIFETIME,
            'resend_at' => now()->timestamp + self::COOLDOWN,
            'attempts' => 0,
        ];
    }

    public function matches(array $challenge, string $code): bool
    {
        return hash_equals($challenge['hash'], $this->digest($challenge['nonce'], $code));
    }

    private function digest(string $nonce, string $code): string
    {
        return hash_hmac('sha256', $nonce.$code, config('app.key'));
    }
}
