<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DungeonRiwayatSoal extends Model
{
    protected $table = 'dungeon_riwayat_soal';

    protected $fillable = [
        'id_user',
        'id_soal',
        'ronde_terakhir',
        'times_seen',
        'times_correct',
    ];

    protected $casts = [
        'ronde_terakhir' => 'integer',
        'times_seen' => 'integer',
        'times_correct' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
