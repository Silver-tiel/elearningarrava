<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulSoalPilihan extends Model
{
    protected $table = 'modul_soal_pilihan';
    protected $primaryKey = 'id_pilihan';
    public $timestamps = true;

    protected $fillable = [
        'id_soal',
        'label',
        'teks_pilihan',
        'is_benar',
    ];

    protected $casts = [
        'is_benar' => 'boolean',
    ];

    public function soal(): BelongsTo
    {
        return $this->belongsTo(ModulSoal::class, 'id_soal', 'id_soal');
    }
}

