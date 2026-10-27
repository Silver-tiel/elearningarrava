<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSoal extends Model
{
    protected $table = 'jenis_soal';
    protected $primaryKey = 'id_jenis_soal';
    public $timestamps = true;

    protected $fillable = [
        'nama_jenis_soal',
    ];

    public function getNamaJenisAttribute()
    {
        return $this->attributes['nama_jenis'] ?? $this->attributes['nama_jenis_soal'] ?? null;
    }
}
