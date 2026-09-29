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

    // Relasi ke materi video
    public function materiVideo()
    {
        return $this->hasMany(MateriVideo::class, 'id_modul', 'id_modul');
    }
    // Helper accessor untuk mendapatkan URL lengkap file materi
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
}