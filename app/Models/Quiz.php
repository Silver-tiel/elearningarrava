<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'id_tipequiz',
        'id_tingkatquiz',
        'hasil_quiz',
        'proggressQuiz',
        'foto_quiz',
    ];

    public function tipeQuiz()
    {
        return $this->belongsTo(TipeQuiz::class, 'id_tipequiz', 'id_tipequiz');
    }

    public function tingkatQuiz()
    {
        return $this->belongsTo(TingkatQuiz::class, 'id_tingkatquiz', 'id_tingkatquiz');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'id_quiz', 'id_quiz');
    }
}
