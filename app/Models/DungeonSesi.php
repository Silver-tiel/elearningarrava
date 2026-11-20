<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DungeonSesi extends Model
{
    protected $table = 'dungeon_sesi';

    protected $fillable = [
        'id_user',
        'id_jenjang',
        'id_mapel',
        'ronde_ke',
        'mulai',
        'selesai',
        'alasan_selesai',
        'jumlah_benar',
        'jumlah_salah',
        'nyawa',
        'lantai_tertinggi',
        'skor_dungeon',
        'multiplier_akhir',
        'poin_profil_didapat',
        'poin_sudah_diberikan',
        'kunci_aktif',
        'is_uji_coba',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
        'jumlah_benar' => 'integer',
        'jumlah_salah' => 'integer',
        'nyawa' => 'integer',
        'lantai_tertinggi' => 'integer',
        'skor_dungeon' => 'integer',
        'multiplier_akhir' => 'float',
        'poin_profil_didapat' => 'integer',
        'poin_sudah_diberikan' => 'boolean',
        'is_uji_coba' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function sesiSoal(): HasMany
    {
        return $this->hasMany(DungeonSesiSoal::class, 'id_sesi', 'id');
    }

    public function isAktif(): bool
    {
        return $this->selesai === null && $this->kunci_aktif !== null;
    }
}
