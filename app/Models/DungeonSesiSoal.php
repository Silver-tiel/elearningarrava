<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DungeonSesiSoal extends Model
{
    protected $table = 'dungeon_sesi_soal';

    protected $fillable = [
        'id_sesi',
        'id_soal',
        'urutan',
        'urutan_pilihan',
        'waktu_tampil',
        'batas_waktu',
        'jawaban_user',
        'is_benar',
        'poin_didapat',
    ];

    protected $casts = [
        'urutan_pilihan' => 'array',
        'waktu_tampil' => 'datetime',
        'batas_waktu' => 'datetime',
        'is_benar' => 'boolean',
        'poin_didapat' => 'integer',
        'urutan' => 'integer',
    ];

    public function sesi(): BelongsTo
    {
        return $this->belongsTo(DungeonSesi::class, 'id_sesi', 'id');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
