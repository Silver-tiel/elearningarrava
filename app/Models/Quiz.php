<?php

namespace App\Models;

use App\Models\Concerns\MemilikiPembuat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

#[\AllowDynamicProperties]
/**
 * Class Quiz
 *
 * @property int $id_quiz
 * @property string $kode_quiz
 * @property string $judul
 * @property string|null $deskripsi
 * @property int|null $id_tipequiz
 * @property int|null $id_tingkatquiz
 * @property int|null $id_jenjang
 * @property int|null $id_mapel
 * @property int|null $id_pembuat
 * @property Carbon|null $waktu_kadaluarsa
 * @property string|null $mode_pengerjaan
 * @property int|null $durasi_total_menit
 * @property string|null $token
 * @property string|null $hasil_quiz
 * @property string|null $proggressQuiz
 * @property string|null $foto_quiz
 * @property string|null $opsi_preview
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $cover_url
 * @property-read Jenjang|null $jenjang
 * @property-read Mapel|null $mapel
 * @property-read TipeQuiz|null $tipeQuiz
 * @property-read TingkatQuiz|null $tingkatQuiz
 * @property-read User|null $pembuat
 * @property-read Collection<int, Soal> $soal
 * @property-read Collection<int, HasilQuizModul> $hasil
 *
 * @method static Builder<Quiz> published()
 * @method static Builder<Quiz> draft()
 * @method static Builder<Quiz> belumKadaluarsa()
 * @mixin Builder<Quiz>
 */
class Quiz extends Model
{
    use MemilikiPembuat;

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
        'id_mapel',
        'id_pembuat',
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
        if (!empty($this->foto_quiz) && !str_starts_with($this->foto_quiz, 'soal/foto/')) {
            return asset('storage/' . $this->foto_quiz);
        }

        return asset('assets/widget/latarQuizDefault.webp');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
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
        return $query->where(function (Builder $query) {
            $table = $query->getModel()->getTable();
            $hasToken = \Illuminate\Support\Facades\Schema::hasTable($table) 
                && \Illuminate\Support\Facades\Schema::hasColumn($table, 'token');

            if ($hasToken) {
                $query->where(function ($sub) {
                    $sub->whereNotNull('token')
                        ->where('token', '!=', '');
                })->orWhere(function ($sub) {
                    $sub->whereNull('waktu_kadaluarsa')
                        ->orWhere('waktu_kadaluarsa', '>', now());
                });
            } else {
                $query->where(function ($sub) {
                    $sub->whereNull('waktu_kadaluarsa')
                        ->orWhere('waktu_kadaluarsa', '>', now());
                });
            }
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
