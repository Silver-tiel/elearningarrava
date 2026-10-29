<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModulSoal extends Model
{
    protected $table = 'modul_soal';
    protected $primaryKey = 'id_soal';
    public $timestamps = true;

    protected $fillable = [
        'id_modul',
        'pertanyaan',
        'poin',
        'urutan',
    ];

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    public function pilihan(): HasMany
    {
        return $this->hasMany(ModulSoalPilihan::class, 'id_soal', 'id_soal');
    }

    public function pilihanBenar(): ?ModulSoalPilihan
    {
        return $this->pilihan->firstWhere('is_benar', true);
    }
}
