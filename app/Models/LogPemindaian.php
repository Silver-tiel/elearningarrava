<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPemindaian extends Model
{
    protected $table = 'log_pemindaian';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_sesi', 'id_guru', 'id_siswa', 'token_hash', 'hasil', 'ip', 'user_agent', 'created_at',
    ];

    protected $casts = ['created_at' => 'datetime'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id_user');
    }
}
