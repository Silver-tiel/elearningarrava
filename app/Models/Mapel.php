<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';
    public $timestamps = true;

    protected $fillable = [
        'nama_mapel',
        'id_jenjang',
        'deskripsi',
        'icon',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'id_mapel', 'id_mapel');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'id_mapel', 'id_mapel');
    }

    /**
     * Scope untuk memfilter mapel berdasarkan jenjang:
     * - SD (1) & SMP (2): Matematika, Bahasa Indonesia, Bahasa Inggris, IPA, IPS, dsb. (Kecualikan Fisika, Kimia, Biologi, Ekonomi, Geografi, Sosiologi)
     * - SMA (3): Matematika, Bahasa Indonesia, Bahasa Inggris, Fisika, Kimia, Biologi, Ekonomi, Geografi, Sosiologi, dsb. (Kecualikan IPA umum)
     */
    public function scopeForJenjang($query, $jenjang)
    {
        if (empty($jenjang)) {
            return $query;
        }

        $jenjangId = (int) $jenjang;

        if ($jenjangId === 1 || $jenjangId === 2) {
            // SD (1) atau SMP (2):
            return $query->where(function ($q) use ($jenjangId) {
                $q->where('id_jenjang', $jenjangId)
                  ->orWhereNull('id_jenjang');
            })->whereNotIn('id_mapel', [11, 12, 13]);
        }

        if ($jenjangId === 3) {
            // SMA (3): Matematika, Bahasa Indonesia, Bahasa Inggris, Fisika, Kimia, Biologi
            // Kecualikan IPA umum (dipecah jadi Fisika, Kimia, Biologi) dan IPS umum (khusus SD/SMP)
            return $query->where(function ($q) {
                $q->where('id_jenjang', 3)
                  ->orWhere(function ($sub) {
                      $sub->whereNull('id_jenjang')
                          ->whereNotIn('id_mapel', [4, 5])
                          ->where('nama_mapel', 'not like', '%Ilmu Pengetahuan Alam%')
                          ->where('nama_mapel', 'not like', '%Ilmu Pengetahuan Sosial%');
                  });
            });
        }

        return $query;
    }
}

