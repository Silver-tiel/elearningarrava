<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Format isi QR: ARV1.<uuid-v4>.<sig>
 *  - uuid : token acak, dipetakan ke siswa di database (kolom user.qr_token)
 *  - sig  : 16 hex pertama HMAC-SHA256(uuid, APP_KEY)
 *
 * Isi QR tidak memuat data pribadi. Tanda tangan memungkinkan server menolak
 * token palsu/acak SEBELUM menyentuh database.
 */
class QrToken
{
    private const PREFIX = 'ARV1';

    public static function baru(): string
    {
        return (string) Str::uuid();
    }

    public static function payload(string $uuid): string
    {
        return self::PREFIX . '.' . $uuid . '.' . self::tandatangan($uuid);
    }

    /**
     * Kembalikan UUID jika payload valid (format + tanda tangan), selain itu null.
     * Menerima juga UUID polos (input manual) hanya jika berformat UUID v4;
     * tetap divalidasi terhadap database oleh pemanggil.
     */
    public static function uuidDariPayload(?string $input): ?string
    {
        $input = trim((string) $input);
        if ($input === '' || strlen($input) > 80) {
            return null;
        }

        if (preg_match('/^' . self::PREFIX . '\.([0-9a-f\-]{36})\.([0-9a-f]{16})$/i', $input, $m)) {
            $uuid = strtolower($m[1]);
            if (!self::uuidV4Valid($uuid)) {
                return null;
            }
            return hash_equals(self::tandatangan($uuid), strtolower($m[2])) ? $uuid : null;
        }

        // Input manual: UUID polos.
        $uuid = strtolower($input);
        return self::uuidV4Valid($uuid) ? $uuid : null;
    }

    public static function hash(string $input): string
    {
        return hash('sha256', trim($input));
    }

    private static function tandatangan(string $uuid): string
    {
        return substr(hash_hmac('sha256', $uuid, (string) config('app.key')), 0, 16);
    }

    private static function uuidV4Valid(string $uuid): bool
    {
        return (bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid);
    }
}
