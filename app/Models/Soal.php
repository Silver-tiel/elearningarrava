<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    public $timestamps = true;

    protected $fillable = [
        'id_quiz',
        'id_jenjang',
        'id_jenis_soal',
        'pertanyaan',
        'jawaban_benar',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function jenisSoal()
    {
        return $this->belongsTo(JenisSoal::class, 'id_jenis_soal', 'id_jenis_soal');
    }

    // Relasi ke pilihan soal (untuk pilihan ganda)
    public function pilihanSoal()
    {
        return $this->hasMany(PilihanSoal::class, 'id_soal', 'id_soal');
    }
}
