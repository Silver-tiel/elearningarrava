<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanHarian extends Model
{
    protected $table = 'laporan_harian';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_sesi',
        'id_guru',
        'id_mapel',
        'waktu_mulai',
        'waktu_selesai',
        'kelas_berlaku_dari',
        'kelas_berlaku_sampai',
    ];

    protected $casts = [
        'kelas_berlaku_dari' => 'date',
        'kelas_berlaku_sampai' => 'date',
    ];

    public function sesi(): BelongsTo
    {
        return $this->belongsTo(SesiPresensi::class, 'id_sesi', 'id_sesi');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_guru', 'id_user');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}
