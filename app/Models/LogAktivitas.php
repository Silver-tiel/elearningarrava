<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'logaktivitas';
    protected $primaryKey = 'id_logaktivitas';
    public $timestamps = true;

    protected $fillable = [
        'waktu_kegiataan',
        'id_user',
        'kegiatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
