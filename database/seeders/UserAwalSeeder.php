<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAwalSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'a@gmail.com'],
            [
                'nama' => 'amru',
                'password' => Hash::make('password123'),
                'id_tipeuser' => 1,
                'id_jenjang' => 1,
                'total_poin' => 0,
                'status_akun' => null,
                'id_modul' => null,
                'foto_profil' => null,
            ]
        );

        User::firstOrCreate(
            ['email' => 'dd@gmail.com'],
            [
                'nama' => 'dd',
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
