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
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
