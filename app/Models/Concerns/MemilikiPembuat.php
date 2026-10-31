<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * Mengisi id_pembuat otomatis dengan user yang sedang login saat konten dibuat.
 * Dicek keberadaan kolomnya agar tetap aman pada skema minimal (mis. test lama).
 */
trait MemilikiPembuat
{
    public static function bootMemilikiPembuat(): void
    {
        static::creating(function ($model) {
            if (empty($model->id_pembuat) && Auth::check() && Schema::hasColumn($model->getTable(), 'id_pembuat')) {
                $model->id_pembuat = Auth::id();
            }
        });
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'id_pembuat', 'id_user');
    }
}
