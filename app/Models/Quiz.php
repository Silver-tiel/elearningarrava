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
 * @property int|null $id_tingkat_kelas
 * @property int|null $id_mapel
 * @property int|null $id_pembuat
 * @property Carbon|null $waktu_kadaluarsa
 * @property Carbon|null $waktu_mulai
 * @property string|null $mode_pengerjaan
 * @property int|null $durasi_total_menit
 * @property string|null $token
 * @property string|null $hasil_quiz
 * @property string|null $proggressQuiz
 * @property string|null $foto_quiz
 * @property string|null $opsi_preview
 * @property bool $acak_soal
 * @property int|null $batas_percobaan
 * @property bool $tampilkan_hasil_ujian
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
 * @method static Builder<Quiz> bukanDungeon()
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
        'waktu_mulai' => 'datetime',
        'durasi_total_menit' => 'integer',
        'acak_soal' => 'boolean',
        'batas_percobaan' => 'integer',
        'tampilkan_hasil_ujian' => 'boolean',
    ];

    protected $fillable = [
        'kode_quiz',
        'judul',
        'deskripsi',
        'id_tipequiz',
        'id_tingkatquiz',
        'id_jenjang',
        'id_tingkat_kelas',
        'id_mapel',
        'id_pembuat',
        'waktu_kadaluarsa',
        'waktu_mulai',
        'mode_pengerjaan',
        'durasi_total_menit',
        'token',
        'hasil_quiz',
        'proggressQuiz',
        'foto_quiz',
        'opsi_preview',
        'acak_soal',
        'batas_percobaan',
        'tampilkan_hasil_ujian',
    ];

    public function isPreviewLengkap(): bool
    {
        if ($this->isModeUjian()) {
            return false;
        }

        return ($this->opsi_preview ?? 'lengkap') === 'lengkap';
    }

    public function perluToken(): bool
    {
        return !empty($this->token);
    }

    /**
     * Kuis bertoken atau bertipe Ulangan/Ujian otomatis diperlakukan sebagai Mode Ujian.
     */
    public function isModeUjian(): bool
    {
        if ($this->perluToken()) {
            return true;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('tipequiz')) {
            return false;
        }

        $namaTipe = $this->relationLoaded('tipeQuiz') && $this->tipeQuiz
            ? $this->tipeQuiz->nama_tipe
            : $this->tipeQuiz()->value('nama_tipe');

        return in_array(strtolower(trim((string) $namaTipe)), ['ulangan', 'ujian', 'evaluasi'], true);
    }

    public function belumDimulai(): bool
    {
        if (empty($this->waktu_mulai)) {
            return false;
        }

        return now()->lt($this->waktu_mulai);
    }

    public function getBatasPercobaanEfektif(): ?int
    {
        if ($this->batas_percobaan !== null) {
            return (int) $this->batas_percobaan > 0 ? (int) $this->batas_percobaan : null;
        }

        return $this->isModeUjian() ? 1 : null;
    }

    public function jumlahPercobaanUser(?User $user): int
    {
        if (!$user || !\Illuminate\Support\Facades\Schema::hasTable('hasilquizmodul')) {
            return 0;
        }

        if ($this->relationLoaded('hasil')) {
            return $this->hasil->where('id_user', $user->id_user)->count();
        }

        return HasilQuizModul::where('id_quiz', $this->id_quiz)
            ->where('id_user', $user->id_user)
            ->count();
    }

    public function bolehDikerjakanLagiOleh(?User $user): bool
    {
        if (!$user) {
            return true;
        }

        $batas = $this->getBatasPercobaanEfektif();
        if ($batas === null) {
            return true;
        }

        return $this->jumlahPercobaanUser($user) < $batas;
    }

    public function shouldAcakSoal(): bool
    {
        if ($this->acak_soal) {
            return true;
        }

        return $this->isModeUjian();
    }

    public function tampilkanEvaluasiUntuk(?User $user): bool
    {
        if (!$user || !$user->isSiswa()) {
            return true;
        }

        if (($this->tampilkan_hasil_ujian ?? true) === false && $this->isModeUjian() && $this->waktu_kadaluarsa !== null) {
            return now()->greaterThanOrEqualTo($this->waktu_kadaluarsa);
        }

        return true;
    }

    /**
     * Mengembalikan koleksi soal dengan pengacakan deterministik per (quiz, user) saat Mode Ujian / acak aktif.
     */
    public function getOrderedSoalForUser(?int $userId = null): Collection
    {
        $soalList = $this->soal->values();
        if (!$this->shouldAcakSoal() || $soalList->count() <= 1) {
            return $soalList;
        }

        $seed = crc32('quiz-' . $this->id_quiz . '-user-' . ($userId ?? 0));
        $items = $soalList->all();

        usort($items, function (Soal $a, Soal $b) use ($seed) {
            $hashA = crc32($seed . '-' . $a->id_soal);
            $hashB = crc32($seed . '-' . $b->id_soal);
            return $hashA <=> $hashB;
        });

        return new Collection($items);
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

    public function tingkatKelas()
    {
        return $this->belongsTo(TingkatKelas::class, 'id_tingkat_kelas', 'id_tingkat');
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

    public function scopeBukanDungeon(Builder $query): Builder
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('tipequiz')) {
            return $query;
        }

        return $query->where(function (Builder $sub) {
            $sub->whereNull('id_tipequiz')
                ->orWhereDoesntHave('tipeQuiz', function (Builder $q) {
                    $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = ?", ['dungeon']);
                });
        });
    }

    public function isDungeon(): bool
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('tipequiz')) {
            return false;
        }

        if ($this->relationLoaded('tipeQuiz') && $this->tipeQuiz) {
            return strtolower((string) $this->tipeQuiz->nama_tipe) === 'dungeon';
        }

        return strtolower((string) ($this->tipeQuiz()->value('nama_tipe') ?? '')) === 'dungeon';
    }

    public function scopeBelumKadaluarsa(Builder $query): Builder
    {
        return $query->where(function (Builder $sub) {
            $sub->whereNull('waktu_kadaluarsa')
                ->orWhere('waktu_kadaluarsa', '>', now());
        });
    }

    public function sudahKadaluarsa(): bool
    {
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
