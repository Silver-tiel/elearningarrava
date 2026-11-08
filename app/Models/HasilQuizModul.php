<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class HasilQuizModul
 *
 * @property int $id_hasil
 * @property int $id_user
 * @property int $id_quiz
 * @property int|null $total_poin
 * @property int|null $poin_didapat
 * @property bool|int $is_lulus
 * @property Carbon|null $waktu_dapat
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User|null $user
 * @property-read Quiz|null $quiz
 */
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
        'is_lulus',
        'waktu_dapat',
    ];

    protected $casts = [
        'waktu_dapat' => 'datetime',
        'is_lulus' => 'boolean',
        'total_poin' => 'integer',
        'poin_didapat' => 'integer',
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
