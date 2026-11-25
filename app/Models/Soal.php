<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Soal extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    public $timestamps = true;

    protected $fillable = [
        'id_quiz',
        'id_mapel',
        'parent_soal_id',
        'kode_soal',
        'id_jenjang',
        'id_jenis_soal',
        'tingkat_soal',
        'id_penulis',
        'aktif',
        'nonaktif_alasan',
        'pertanyaan',
        'jawaban_benar',
        'foto_soal',
        'poin',
        'durasi_detik',
    ];

    protected $casts = [
        'durasi_detik' => 'integer',
        'aktif' => 'boolean',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function parentSoal()
    {
        return $this->belongsTo(Soal::class, 'parent_soal_id', 'id_soal');
    }

    public function clonedSoal()
    {
        return $this->hasMany(Soal::class, 'parent_soal_id', 'id_soal');
    }

    public function getIsBankSoalAttribute(): bool
    {
        return is_null($this->id_quiz);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function jenisSoal()
    {
        return $this->belongsTo(JenisSoal::class, 'id_jenis_soal', 'id_jenis_soal');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_penulis', 'id_user');
    }

    // Relasi ke pilihan soal (untuk pilihan ganda)
    public function pilihanSoal()
    {
        return $this->hasMany(PilihanSoal::class, 'id_soal', 'id_soal');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($soal) {
            if (\Illuminate\Support\Facades\Schema::hasTable($soal->getTable()) && !\Illuminate\Support\Facades\Schema::hasColumn($soal->getTable(), 'kode_soal')) {
                return;
            }

            if (empty($soal->kode_soal)) {
                $quizKode = null;
                if ($soal->relationLoaded('quiz') && $soal->quiz && !empty($soal->quiz->kode_quiz)) {
                    $quizKode = $soal->quiz->kode_quiz;
                } elseif (!empty($soal->id_quiz)) {
                    $quiz = Quiz::find($soal->id_quiz);
                    $quizKode = $quiz && !empty($quiz->kode_quiz) ? $quiz->kode_quiz : null;
                }

                $prefix = 'SL-' . ($quizKode ?: ('BNK-' . strtoupper(Str::random(4)))) . '-';
                
                $seq = 1;
                do {
                    $code = $prefix . str_pad($seq, 2, '0', STR_PAD_LEFT);
                    $seq++;
                } while (static::where('kode_soal', $code)->exists());

                $soal->kode_soal = $code;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'kode_soal';
    }
}
