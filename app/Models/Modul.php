<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model custom untuk tabel modul yang menampung materi pembelajaran.
class Modul extends Model
{
    // Nama tabel database sesuai struktur project.
    protected $table = 'modul';

    // Primary key tabel modul.
    protected $primaryKey = 'id_modul';

    // Laravel akan otomatis mengisi created_at dan updated_at sesuai kolom di tabel.
    public $timestamps = true;

    // Kolom yang boleh diisi saat proses tambah atau edit modul.
    protected $fillable = [
        'judul_modul',
        'file_materi',
        'tipe_file',
        'id_tipemodul',
        'id_jenjang',
        'id_quiz',
        'progressModul',
        'foto_modul',
    ];
}
