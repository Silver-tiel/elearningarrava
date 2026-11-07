<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';
    public $timestamps = true;

    protected $fillable = [
        'nama_mapel',
        'id_jenjang',
        'deskripsi',
        'icon',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'id_mapel', 'id_mapel');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'id_mapel', 'id_mapel');
    }
}

