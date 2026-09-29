<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAwalSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
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

        // SISWA SD
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

        // SISWA SMP
        User::updateOrCreate(
            ['nisn' => '1234567892'],
            [
                'nama' => 'Budi',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('password123'),
                'id_tipeuser' => 3,
                'id_jenjang' => 2,
                'total_poin' => 0,
                'status_akun' => null,
                'id_modul' => null,
                'foto_profil' => null,
            ]
        );

        // SISWA SMA
        User::updateOrCreate(
            ['nisn' => '1234567893'],
            [
                'nama' => 'Siti',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('password123'),
                'id_tipeuser' => 3,
                'id_jenjang' => 3,
                'total_poin' => 0,
                'status_akun' => null,
                'id_modul' => null,
                'foto_profil' => null,
            ]
        );
    }
}