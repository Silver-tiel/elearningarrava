<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model custom untuk tabel quiz yang berisi daftar kuis pembelajaran.
class Quiz extends Model
{
    // Nama tabel database sesuai struktur project.
    protected $table = 'quiz';

    // Primary key tabel quiz.
    protected $primaryKey = 'id_quiz';

    // Laravel akan mengelola created_at dan updated_at secara otomatis.
    public $timestamps = true;

    // Kolom yang bisa diisi saat input kuis baru.
    protected $fillable = [
        'judul',
        'id_tipequiz',
        'id_tingkatquiz',
        'hasil_quiz',
        'proggressQuiz',
        'foto_quiz',
    ];
}
