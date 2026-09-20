<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $table = 'modul';
    protected $primaryKey = 'id_modul';
    public $timestamps = true;

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

    public function tipeModul()
    {
        return $this->belongsTo(TipeModul::class, 'id_tipemodul', 'id_tipemodul');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }
}
