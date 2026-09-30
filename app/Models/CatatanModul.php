<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanModul extends Model
{
    protected $table = 'catatan_modul';
    protected $primaryKey = 'id_catatan';
    public $timestamps = true;

    protected $fillable = ['id_modul', 'judul', 'isi', 'urutan'];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}
