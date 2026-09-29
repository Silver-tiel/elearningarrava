<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    public $timestamps = true;

    protected $casts = [
        'waktu_kadaluarsa' => 'datetime',
        'durasi_total_menit' => 'integer',
    ];

    protected $fillable = [
        'judul',
        'id_tipequiz',
        'id_tingkatquiz',
        'id_jenjang',
        'waktu_kadaluarsa',
        'mode_pengerjaan',
        'durasi_total_menit',
        'hasil_quiz',
        'proggressQuiz',
        'foto_quiz',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

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

    public function scopeBelumKadaluarsa(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereNull('waktu_kadaluarsa')
                ->orWhere('waktu_kadaluarsa', '>', now());
        });
    }

    public function sudahKadaluarsa(): bool
    {
        return $this->waktu_kadaluarsa !== null
            && now()->greaterThanOrEqualTo($this->waktu_kadaluarsa);
    }
}
