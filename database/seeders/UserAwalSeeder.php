<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAwalSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
    ['nisn' => '1234567890'],
    [
        'nama' => 'amru',
        'email' => 'a@gmail.com',
        'password' => Hash::make('password123'),
        'id_tipeuser' => 1,
        'id_jenjang' => 1,
        'total_poin' => 0,
        'status_akun' => null,
        'id_modul' => null,
        'foto_profil' => null,
    ]
);

        User::updateOrCreate(
    ['nisn' => '1234567891'],
    [
        'nama' => 'dd',
        'email' => 'dd@gmail.com',
        'password' => Hash::make('password123'),
        'id_tipeuser' => 3,
        'id_jenjang' => 1,
        'total_poin' => 0,
        'status_akun' => null,
        'id_modul' => null,
        'foto_profil' => null,
    ]
);
    }
}
