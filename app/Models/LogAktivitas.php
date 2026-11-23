<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class LogAktivitas extends Model
{
    protected $table = 'logaktivitas';
    protected $primaryKey = 'id_logaktivitas';
    public $timestamps = true;

    protected $fillable = [
        'waktu_kegiataan',
        'id_user',
        'kegiatan',
    ];

    protected $casts = [
        'waktu_kegiataan' => 'datetime',
    ];

    public static function catat(?User $user, string $kegiatan): ?self
    {
        if (!$user) {
            Log::warning('Aktivitas tidak dapat dicatat karena tidak ada pengguna yang terautentikasi.');

            return null;
        }

        if (!Schema::hasTable('logaktivitas')) {
            Log::warning('Aktivitas tidak dapat dicatat karena tabel logaktivitas belum tersedia.');

            return null;
        }

        return static::create([
            'waktu_kegiataan' => now(),
            'id_user' => $user->id_user,
            'kegiatan' => $kegiatan,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
