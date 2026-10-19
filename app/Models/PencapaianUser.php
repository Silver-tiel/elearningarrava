<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencapaianUser extends Model
{
    protected $table = 'pencapaianuser';
    protected $primaryKey = 'id_pencapaian';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_achievement',
        'nama',
        'waktu_pencapaian',
    ];

    protected $casts = [
        'waktu_pencapaian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'id_achievement', 'id_achievement');
    }
}
