<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeUser extends Model
{
    protected $table = 'tipeuser';
    protected $primaryKey = 'id_tipeUser';
    public $timestamps = true;

    protected $fillable = [
        'nama_tipe',
    ];
}
