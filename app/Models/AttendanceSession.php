<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class AttendanceSession extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_EXPIRED = 'expired';

    protected $table = 'attendance_sessions';

    protected $fillable = [
        'title',
        'token',
        'created_by',
        'starts_at',
        'expires_at',
        'late_after_minutes',
        'status',
    ];

    /** Token tidak boleh ikut terserialisasi (JSON/array) ke tampilan yang tidak berhak. */
    protected $hidden = ['token'];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'late_after_minutes' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_session_id');
    }

    /** Sesi yang sedang bisa dipakai check-in: status active dan berada di dalam jendela waktunya. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>', now());
    }

    /** Sesi yang sudah lewat waktu berakhirnya (belum ditutup manual) atau sudah ditandai expired. */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('status', self::STATUS_EXPIRED)
                ->orWhere(function (Builder $q2) {
                    $q2->where('status', self::STATUS_ACTIVE)->where('expires_at', '<=', now());
                });
        });
    }

    /** Status efektif saat ini: closed > expired > active. */
    public function effectiveStatus(): string
    {
        if ($this->status === self::STATUS_CLOSED) {
            return self::STATUS_CLOSED;
        }

        if ($this->status === self::STATUS_EXPIRED || $this->expires_at->lte(now())) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_ACTIVE;
    }

    public function hasStarted(): bool
    {
        return $this->starts_at->lte(now());
    }

    /** Batas waktu hadir; check-in setelahnya berstatus terlambat. Null = tidak ada batas. */
    public function lateThreshold(): ?Carbon
    {
        if ($this->late_after_minutes === null) {
            return null;
        }

        return $this->starts_at->copy()->addMinutes($this->late_after_minutes);
    }

    /** URL yang dikodekan ke dalam QR. Halaman ini hanya meminta konfirmasi (tidak mengubah data). */
    public function checkInUrl(): string
    {
        return route('attendance.check-in.link', ['token' => $this->token]);
    }
}
