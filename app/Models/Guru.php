<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * Model Guru (Biodata & Profil Pendidik)
 *
 * @property int $id_guru
 * @property string $nama
 * @property string $nik
 * @property string $no_telepon
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read string|null $email
 * @property-read string|null $foto_url
 */
class Guru extends Model
{
    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nama',
        'nik',
        'no_telepon',
        'foto',
    ];

    /**
     * Relasi ke akun User (autentikasi login) berdasarkan NIK (disimpan di kolom nisn User).
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nisn', 'nik');
    }

    /**
     * Modul yang dibuat oleh akun guru ini (melalui User::id_user -> Modul::id_pembuat).
     */
    public function moduls(): HasManyThrough
    {
        return $this->hasManyThrough(Modul::class, User::class, 'nisn', 'id_pembuat', 'nik', 'id_user');
    }

    /**
     * Quiz yang dibuat oleh akun guru ini (melalui User::id_user -> Quiz::id_pembuat).
     */
    public function quizzes(): HasManyThrough
    {
        return $this->hasManyThrough(Quiz::class, User::class, 'nisn', 'id_pembuat', 'nik', 'id_user');
    }

    /**
     * Helper accessor untuk mendapatkan email akun login guru.
     */
    public function getEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    /**
     * Helper accessor untuk URL foto profil guru.
     */
    public function getFotoUrlAttribute(): ?string
    {
        $path = $this->foto ?: $this->user?->foto_profil;
        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        return null;
    }
}
