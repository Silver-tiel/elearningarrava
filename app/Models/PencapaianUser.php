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
        'nama',
        'waktu_pencapaian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
