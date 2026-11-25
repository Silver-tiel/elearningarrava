<?php

namespace App\Http\Requests;

use App\Models\AttendanceSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreAttendanceSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', AttendanceSession::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:starts_at'],
            'late_after_minutes' => ['nullable', 'integer', 'min:0', 'max:1440'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul sesi wajib diisi.',
            'title.max' => 'Judul sesi maksimal 150 karakter.',
            'starts_at.required' => 'Jam mulai wajib diisi.',
            'starts_at.date' => 'Jam mulai tidak valid.',
            'expires_at.required' => 'Jam berakhir wajib diisi.',
            'expires_at.date' => 'Jam berakhir tidak valid.',
            'expires_at.after' => 'Jam berakhir harus setelah jam mulai.',
            'late_after_minutes.integer' => 'Batas keterlambatan harus berupa angka menit.',
            'late_after_minutes.min' => 'Batas keterlambatan tidak boleh negatif.',
            'late_after_minutes.max' => 'Batas keterlambatan maksimal 1440 menit (24 jam).',
        ];
    }

    /** Batas keterlambatan tidak boleh melewati jam berakhir sesi. */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty() || $this->input('late_after_minutes') === null) {
                return;
            }

            $mulai = Carbon::parse($this->input('starts_at'));
            $akhir = Carbon::parse($this->input('expires_at'));

            if ($mulai->copy()->addMinutes((int) $this->input('late_after_minutes'))->greaterThan($akhir)) {
                $validator->errors()->add('late_after_minutes', 'Batas keterlambatan tidak boleh melewati jam berakhir sesi.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('late_after_minutes') === '') {
            $this->merge(['late_after_minutes' => null]);
        }
    }
}
