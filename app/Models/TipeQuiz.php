<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeQuiz extends Model
{
    protected $table = 'tipequiz';
    protected $primaryKey = 'id_tipequiz';
    public $timestamps = true;

    protected $fillable = [
        'nama_tipe',
    ];
}
