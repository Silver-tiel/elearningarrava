<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Modul extends Model
{
    //menentukan nama tabel
    protected $table = 'modul';
    //menentukan primary key
    protected $primaryKey = 'id_modul';
    public $timestamps = true;
    //menentukan kolom yang bisa diisi
    protected $fillable = [
        'judul_modul',
        'file_materi',
        'tipe_file',
        'id_tipemodul',
        'id_jenjang',
        'id_quiz',
        'progressModul',
        'foto_modul',
        'kkm_quiz',
        'poin_modul',
    ];

    // Relasi ke tabel tipe modul (1: Video, 2: PDF, 3: Artikel)
    public function tipeModul()
    {
        return $this->belongsTo(TipeModul::class, 'id_tipemodul', 'id_tipemodul');
    }
    // Relasi ke tabel jenjang (SD, SMP, SMA)
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }
    // Relasi opsional ke kuis terkait
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }

    public function isDraft(): bool
    {
        return strcasecmp((string) $this->progressModul, 'Draft') === 0;
    }

    public function isPublished(): bool
    {
        return !$this->isDraft();
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('progressModul')
              ->orWhere('progressModul', '!=', 'Draft');
        });
    }

    public function scopeDraft($query)
    {
        return $query->where('progressModul', 'Draft');
    }

    // Helper accessor untuk mendapatkan URL lengkap file materi

    public function catatan()
    {
        return $this->hasMany(CatatanModul::class, 'id_modul', 'id_modul')->orderBy('urutan');
    }

    public function soalModul()
    {
        return $this->hasMany(ModulSoal::class, 'id_modul', 'id_modul')->orderBy('urutan');
    }

    public function progresSiswa()
    {
        return $this->hasMany(ProgresModulSiswa::class, 'id_modul', 'id_modul');
    }

    public function progresUser(?int $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->hasOne(ProgresModulSiswa::class, 'id_modul', 'id_modul')->where('id_user', $userId);
    }

    public function hasQuizModul(): bool
    {
        return $this->soalModul()->count() > 0;
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file_materi) {
            return null;
        }
        // Jika berupa link eksternal (misal URL video youtube)
        if (filter_var($this->file_materi, FILTER_VALIDATE_URL)) {
            return $this->file_materi;
        }
        // Jika file diupload lokal di storage
        return Storage::url($this->file_materi);
    }
    // Helper accessor untuk mendapatkan URL lengkap foto cover
    public function getFotoUrlAttribute()
    {
        if ($this->foto_modul && Storage::disk('public')->exists($this->foto_modul)) {
            return Storage::url($this->foto_modul);
        }

        // Gambar placeholder jika cover tidak diunggah
        return asset('images/default-cover.jpg');
    }

    // Helper accessor untuk mengekstrak YouTube Video ID dari berbagai format link
    public function getYoutubeIdAttribute()
    {
        $raw = $this->file_materi ?? null;
        if (!$raw) return null;
        $raw = trim($raw);

        // Jika terdapat tag iframe dari copy-paste embed code, ambil nilai atribut src
        if (preg_match('/src=["\']([^"\']+)["\']/', $raw, $srcMatch)) {
            $raw = $srcMatch[1];
        }

        // Ekstraksi 11 karakter YouTube video ID (watch, youtu.be, embed, live, shorts)
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?|live|shorts)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $raw, $match)) {
            return $match[1];
        }

        // Jika user hanya menginput ID 11 karakter langsung
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $raw)) {
            return $raw;
        }

        return null;
    }

    // Helper accessor untuk mendapatkan URL YouTube Embed
    public function getYoutubeEmbedUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }

    // Helper accessor pengecekan apakah materi ini berformat video
    public function getIsVideoAttribute(): bool
    {
        return $this->id_tipemodul == 1 
            || !empty($this->youtube_id) 
            || in_array(strtolower($this->tipe_file ?? ''), ['mp4', 'webm', 'video']);
    }

    // Helper accessor pengecekan apakah materi ini berformat PDF/Dokumen
    public function getIsPdfAttribute(): bool
    {
        return $this->id_tipemodul == 2 
            || strtolower($this->tipe_file ?? '') === 'pdf'
            || str_ends_with(strtolower($this->file_materi ?? ''), '.pdf');
    }

    // Helper accessor pengecekan apakah materi ini berupa tautan eksternal
    public function getIsLinkAttribute(): bool
    {
        return $this->tipe_file === 'link' && !$this->is_video;
    }
}
