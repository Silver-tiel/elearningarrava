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
}
