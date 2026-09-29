<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriVideo extends Model
{
    protected $table = 'materi_video';
    protected $primaryKey = 'id_materi';
    public $timestamps = true;

    protected $fillable = [
        'id_modul',
        'judul',
        'deskripsi',
        'file_video',
        'durasi',
        'urutan',
        'status',
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    // Helper accessor untuk mengekstrak YouTube Video ID dari berbagai format link
    public function getYoutubeIdAttribute()
    {
        $raw = $this->file_video ?? null;
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
