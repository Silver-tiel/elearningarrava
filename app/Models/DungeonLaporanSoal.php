<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DungeonLaporanSoal extends Model
{
    protected $table = 'dungeon_laporan_soal';

    protected $fillable = [
        'id_soal',
        'id_user',
        'alasan',
        'status',
    ];

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
