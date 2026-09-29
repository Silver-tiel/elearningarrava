<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'jenjang';
    protected $primaryKey = 'id_jenjang';
    public $timestamps = true;

    protected $fillable = [
        'nama_tipe',
    ];

    public function getNamaJenjangAttribute()
    {
        return $this->nama_tipe;
    }
}
