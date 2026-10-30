<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'kode_quiz',
        'judul',
        'deskripsi',
        'id_tipequiz',
        'id_tingkatquiz',
        'id_jenjang',
        'waktu_kadaluarsa',
        'mode_pengerjaan',
        'durasi_total_menit',
        'token',
        'hasil_quiz',
        'proggressQuiz',
        'foto_quiz',
        'opsi_preview',
    ];

    public function isPreviewLengkap(): bool
    {
        return ($this->opsi_preview ?? 'lengkap') === 'lengkap';
    }

    public function perluToken(): bool
    {
        return !empty($this->token);
    }

    public function getCoverUrlAttribute(): string
    {
        if (!empty($this->foto_quiz)) {
            return asset('storage/' . $this->foto_quiz);
        }

        return asset('assets/widget/latarQuizDefault.webp');
    }

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

    public function hasil()
    {
        return $this->hasMany(HasilQuizModul::class, 'id_quiz', 'id_quiz');
    }

    public function isDraft(): bool
    {
        return strtolower((string) ($this->proggressQuiz ?? '')) === 'draft';
    }

    public function isPublished(): bool
    {
        return !$this->isDraft();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $sub) {
            $sub->where('proggressQuiz', '!=', 'Draft')
                ->orWhereNull('proggressQuiz');
        });
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->whereRaw("LOWER(COALESCE(proggressQuiz, '')) = ?", ['draft']);
    }

    public function scopeBelumKadaluarsa(Builder $query): Builder
    {
        $hasTokenCol = \Illuminate\Support\Facades\Schema::hasTable($this->getTable())
            && \Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'token');

        return $query->where(function (Builder $query) use ($hasTokenCol) {
            $query->where(function ($sub) use ($hasTokenCol) {
                if ($hasTokenCol) {
                    $sub->whereNotNull('token')
                        ->where('token', '!=', '');
                } else {
                    $sub->whereRaw('0 = 1');
                }
            })->orWhere(function ($sub) {
                $sub->whereNull('waktu_kadaluarsa')
                    ->orWhere('waktu_kadaluarsa', '>', now());
            });
        });
    }

    public function sudahKadaluarsa(): bool
    {
        if ($this->perluToken()) {
            return false;
        }

        return $this->waktu_kadaluarsa !== null
            && now()->greaterThanOrEqualTo($this->waktu_kadaluarsa);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quiz) {
            if (\Illuminate\Support\Facades\Schema::hasTable($quiz->getTable()) && !\Illuminate\Support\Facades\Schema::hasColumn($quiz->getTable(), 'kode_quiz')) {
                return;
            }

            if (empty($quiz->kode_quiz)) {
                do {
                    $code = 'QZ-' . date('Ymd') . '-' . strtoupper(Str::random(6));
                } while (static::where('kode_quiz', $code)->exists());

                $quiz->kode_quiz = $code;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'kode_quiz';
    }
}
