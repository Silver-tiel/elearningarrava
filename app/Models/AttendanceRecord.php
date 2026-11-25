<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    public const STATUS_HADIR = 'hadir';
    public const STATUS_TERLAMBAT = 'terlambat';

    protected $table = 'attendance_records';

    protected $fillable = [
        'attendance_session_id',
        'user_id',
        'checked_in_at',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
