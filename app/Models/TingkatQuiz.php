<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TingkatQuiz extends Model
{
    protected $table = 'tingkatquiz';
    protected $primaryKey = 'id_tingkatquiz';
    public $timestamps = true;

    protected $fillable = [
        'nama_tingkat',
    ];
}
