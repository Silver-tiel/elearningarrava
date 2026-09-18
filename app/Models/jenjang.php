<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model custom untuk tabel jenjang yang digunakan pada form pendaftaran.
class jenjang extends Model
{
    // Menentukan nama tabel database karena model tidak mengikuti konvensi Laravel default.
    protected $table = 'jenjang';

    // Primary key pada tabel jenjang adalah id_jenjang.
    protected $primaryKey = 'id_jenjang';
}
