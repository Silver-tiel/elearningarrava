<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nisn',
        'nomor_hp',
        'id_tipeuser',
        'id_jenjang',
        'total_poin',
        'status_akun',
        'id_modul',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function jenjang(): BelongsTo
    {
        // Hubungkan ke Model Jenjang, bukan User
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }

    public function tipeUser(): BelongsTo
    {
        // Hubungkan ke Model TipeUser (atau nama model tipe user kamu), bukan User
        return $this->belongsTo(TipeUser::class, 'id_tipeuser');
    }

    
}