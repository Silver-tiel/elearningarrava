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
        'kategori_bank',
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

    public function isKhususUjian(): bool
    {
        return strtolower((string) ($this->kategori_bank ?? 'umum')) === 'ujian';
    }

    public static function normalizeQuestionText(?string $text): string
    {
        $clean = trim((string) preg_replace('/\s+/', ' ', strip_tags((string) $text)));
        return mb_strtolower($clean);
    }

    /**
     * Memeriksa kelengkapan kualitas soal (Quality Gate) sebelum dipakai ke Kuis/Ujian/Dungeon.
     *
     * @return array{layak: bool, masalah: array<int, string>}
     */
    public function cekKelayakan(): array
    {
        $masalah = [];

        if (empty($this->id_mapel) && empty($this->quiz?->id_mapel)) {
            $masalah[] = 'Mata pelajaran belum diatur';
        }

        $hasText = trim((string) $this->pertanyaan) !== '';
        $hasPhoto = !empty($this->foto_soal);
        if (!$hasText && !$hasPhoto) {
            $masalah[] = 'Pertanyaan dan gambar kosong';
        }

        $jenis = (int) ($this->id_jenis_soal ?? 1);
        $pilihan = $this->relationLoaded('pilihanSoal') ? $this->pilihanSoal : $this->pilihanSoal()->get();

        if ($jenis === 1) {
            $nonEmptyChoices = $pilihan->filter(fn($p) => trim((string) $p->teks_pilihan) !== '');
            if ($nonEmptyChoices->count() < 2) {
                $masalah[] = 'Pilihan ganda minimal memiliki 2 opsi jawaban';
            }
            $correctCount = $pilihan->where('is_correct', true)->count();
            if ($correctCount !== 1) {
                $masalah[] = $correctCount === 0 ? 'Belum ada kunci jawaban benar' : 'Terdapat lebih dari 1 kunci jawaban';
            }
        } elseif ($jenis === 3) {
            if ($pilihan->count() < 2) {
                $masalah[] = 'Opsi Benar/Salah tidak lengkap';
            }
            if ($pilihan->where('is_correct', true)->count() !== 1) {
                $masalah[] = 'Kunci Benar/Salah belum ditentukan';
            }
        } elseif ($jenis === 2) {
            if (trim((string) $this->jawaban_benar) === '') {
                $masalah[] = 'Kunci jawaban isian singkat masih kosong';
            }
        }

        return [
            'layak' => count($masalah) === 0,
            'masalah' => $masalah,
        ];
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
            if (is_null($soal->id_jenjang) && \Illuminate\Support\Facades\Schema::hasColumn($soal->getTable(), 'id_jenjang')) {
                $soal->id_jenjang = ($soal->id_quiz && \Illuminate\Support\Facades\Schema::hasColumn('quiz', 'id_jenjang')
                    ? Quiz::where('id_quiz', $soal->id_quiz)->value('id_jenjang')
                    : null) ?? 2;
            }

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
