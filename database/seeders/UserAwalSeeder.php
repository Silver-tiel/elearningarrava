<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAwalSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['nisn' => '1234567890'],
            [
                'nama'        => 'amru',
                'email'       => 'a@gmail.com',
                'password'    => Hash::make('password123'),
                'id_tipeuser' => 1,
                'nomor_hp'    => '08123456789',
                'id_jenjang'  => null,
                'total_poin'  => 0,
                'status_akun' => 'Aktif',
                'id_modul'    => null,
                'foto_profil' => null,
            ]
        );

        // SISWA 1
        User::updateOrCreate(
            ['nisn' => '1234567891'],
            [
                'nama'        => 'dd',
                'email'       => 'dd@gmail.com',
                'password'    => Hash::make('password123'),
                'id_tipeuser' => 1,
                'id_jenjang'  => null,
                'nomor_hp'    => '081212121212',
                'total_poin'  => 0,
                'status_akun' => 'Aktif',
                'id_modul'    => null,
                'foto_profil' => null,
            ]
        );

        // SISWA 2
        User::updateOrCreate(
            ['nisn' => '1234567892'],
            [
                'nama'        => 'rolan',
                'email'       => 'rolan@gmail.com',
                'password'    => Hash::make('password123'),
                'id_tipeuser' => 3,
                'id_jenjang'  => 1,
                'nomor_hp'    => '081212121213',
                'total_poin'  => 150,
                'status_akun' => 'Aktif',
                'id_modul'    => null,
                'foto_profil' => null,
            ]
        );

        // SISWA 3
        User::updateOrCreate(
            ['nisn' => '1234567893'],
            [
                'nama'        => 'alip',
                'email'       => 'alip@gmail.com',
                'password'    => Hash::make('password123'),
                'id_tipeuser' => 3,
                'id_jenjang'  => 2,
                'nomor_hp'    => '081212121214',
                'total_poin'  => 120,
                'status_akun' => 'Aktif',
                'id_modul'    => null,
                'foto_profil' => null,
            ]
        );

        // SISWA 4
        User::updateOrCreate(
            ['nisn' => '1234567894'],
            [
                'nama'        => 'alim',
                'email'       => 'alim@gmail.com',
                'password'    => Hash::make('password123'),
                'id_tipeuser' => 3,
                'id_jenjang'  => 3,
                'nomor_hp'    => '081212121215',
                'total_poin'  => 100,
                'status_akun' => 'Nonaktif',
                'id_modul'    => null,
                'foto_profil' => null,
            ]
        );
    }
}