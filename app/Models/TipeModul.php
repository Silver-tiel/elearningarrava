<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeModul extends Model
{
    protected $table = 'tipemodul';
    protected $primaryKey = 'id_tipemodul';
    public $timestamps = true;

    protected $fillable = [
        'nama_tipe',
    ];
}
