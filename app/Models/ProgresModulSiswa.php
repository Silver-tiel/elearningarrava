<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgresModulSiswa extends Model
{
    protected $table = 'progres_modul_siswa';
    protected $primaryKey = 'id_progres';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_modul',
        'materi_selesai',
        'quiz_selesai',
        'quiz_lulus',
        'nilai_quiz',
        'is_tuntas',
        'poin_didapat',
        'waktu_materi_selesai',
        'waktu_quiz_selesai',
        'waktu_tuntas',
    ];

    protected $casts = [
        'materi_selesai' => 'boolean',
        'quiz_selesai' => 'boolean',
        'quiz_lulus' => 'boolean',
        'is_tuntas' => 'boolean',
        'waktu_materi_selesai' => 'datetime',
        'waktu_quiz_selesai' => 'datetime',
        'waktu_tuntas' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}

