<?php

namespace App\Http\Requests;

use App\Models\AttendanceSession;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Hanya menerima `token`. Identitas pelaku SELALU diambil dari sesi login (auth),
 * sehingga field seperti user_id yang dikirim klien diabaikan sepenuhnya.
 */
class CheckInAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('checkIn', AttendanceSession::class) ?? false;
    }

    public function rules(): array
    {
        // Format token yang ketat dicek di service agar setiap token salah ikut dihitung rate limiter.
        return [
            'token' => ['required', 'string', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'Token atau QR wajib diisi.',
            'token.string' => 'Token tidak valid.',
            'token.max' => 'Token terlalu panjang.',
        ];
    }

    /** Menerima token murni maupun tautan lengkap hasil scan QR (…/attendance/check-in?token=XXXX). */
    protected function prepareForValidation(): void
    {
        $nilai = trim((string) $this->input('token', ''));

        if (str_contains($nilai, 'token=')) {
            $query = parse_url($nilai, PHP_URL_QUERY);
            if (is_string($query)) {
                parse_str($query, $param);
                $nilai = trim((string) ($param['token'] ?? $nilai));
            }
        }

        $this->merge(['token' => $nilai]);
    }
}
