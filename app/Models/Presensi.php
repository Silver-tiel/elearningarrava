<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';

    protected $fillable = ['id_sesi', 'id_siswa', 'id_guru_pemindai', 'status', 'waktu_scan', 'nilai', 'is_bintang'];

    protected $casts = [
        'waktu_scan' => 'datetime',
        'nilai' => 'decimal:2',
        'is_bintang' => 'boolean',
    ];

    public function sesi()
    {
        return $this->belongsTo(SesiPresensi::class, 'id_sesi', 'id_sesi');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id_user');
    }
}
