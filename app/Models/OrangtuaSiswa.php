<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangtuaSiswa extends Model
{
    protected $table    = 'orangtua_siswa';
    protected $primaryKey = 'id';
    public $timestamps  = true;

    protected $fillable = [
        'id_orangtua',
        'id_siswa',
    ];

    public function orangtua()
    {
        return $this->belongsTo(User::class, 'id_orangtua', 'id_user');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id_user');
    }
}
