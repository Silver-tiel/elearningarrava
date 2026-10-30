<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';
    protected $primaryKey = 'id_sesi';

    protected $fillable = [
        'id_kelas', 'id_guru', 'judul', 'pertemuan_ke', 'tanggal', 'batas_tepat_waktu', 'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'batas_tepat_waktu' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id_user');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_sesi', 'id_sesi');
    }

    public function isBuka(): bool
    {
        return $this->status === 'buka';
    }
}
