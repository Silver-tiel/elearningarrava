<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilQuizModul extends Model
{
    protected $table = 'hasilquizmodul';
    protected $primaryKey = 'id_hasil';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_quiz',
        'total_poin',
        'poin_didapat',
        'waktu_dapat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }
}
