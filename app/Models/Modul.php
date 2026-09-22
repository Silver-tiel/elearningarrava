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
}