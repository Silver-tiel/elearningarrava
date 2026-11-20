<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilihanSoal extends Model
{
    protected $table = 'pilihan_soal';
    protected $primaryKey = 'id_pilihan';
    public $timestamps = true;

    protected $fillable = [
        'id_soal',
        'label',
        'teks_pilihan',
        'is_correct',
        'tetap_di_bawah',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'tetap_di_bawah' => 'boolean',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
