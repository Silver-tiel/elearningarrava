<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = ['nama', 'id_jenjang', 'tahun_ajaran', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'kelas_siswa', 'id_kelas', 'id_siswa', 'id_kelas', 'id_user')
            ->withTimestamps();
    }

    public function guru()
    {
        return $this->belongsToMany(User::class, 'kelas_guru', 'id_kelas', 'id_guru', 'id_kelas', 'id_user')
            ->withTimestamps();
    }

    public function sesi()
    {
        return $this->hasMany(SesiPresensi::class, 'id_kelas', 'id_kelas');
    }
}
