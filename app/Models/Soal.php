<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model custom untuk tabel soal yang mencakup pertanyaan berdasarkan jenjang dan tipe soal.
class Soal extends Model
{
    // Nama tabel sesuai database project.
    protected $table = 'soal';

    // Primary key tabel soal.
    protected $primaryKey = 'id_soal';

    // Laravel mengelola created_at dan updated_at otomatis.
    public $timestamps = true;

    // Kolom yang dapat diisi saat admin menambah soal.
    protected $fillable = [
        'id_quiz',
        'id_jenjang',
        'id_jenis_soal',
        'pertanyaan',
        'jawaban_benar',
    ];
}
