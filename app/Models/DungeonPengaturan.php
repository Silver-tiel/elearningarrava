<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DungeonPengaturan extends Model
{
    protected $table = 'dungeon_pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'json',
    ];

    /**
     * Ambil nilai pengaturan dengan fallback default.
     */
    public static function getNilai(string $kunci, mixed $default = null): mixed
    {
        $setting = static::where('kunci', $kunci)->first();
        if ($setting) {
            return $setting->nilai;
        }

        return $default;
    }

    /**
     * Set nilai pengaturan (idempoten).
     */
    public static function setNilai(string $kunci, mixed $nilai): void
    {
        static::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai]
        );
    }
}
