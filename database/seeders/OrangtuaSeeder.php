<?php

namespace Database\Seeders;

use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk membuat 1 akun orang tua contoh
 * dan menautkannya ke siswa yang ada (id_tipeuser=3).
 *
 * Jalankan dengan:
 *   php artisan db:seed --class=OrangtuaSeeder
 */
class OrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat (atau temukan) akun orang tua
        // Cek apakah akun sudah ada
        $existing = \Illuminate\Support\Facades\DB::table('user')->where('email', 'orangtua@gmail.com')->first();

        if (!$existing) {
            // Gunakan DB::table untuk bypass constraint kolom yang tidak ada di fillable / nullable
            \Illuminate\Support\Facades\DB::table('user')->insert([
                'nama'        => 'Budi Santoso',
                'email'       => 'orangtua@gmail.com',
                'password'    => Hash::make('password'),
                'id_tipeuser' => 4,
                'id_jenjang'  => 1,
                'total_poin'  => 0,
                'status_akun' => 'Aktif',
                'nisn'        => 'OT-' . uniqid(),
                'nomor_hp'    => '08000000000',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $existing = \Illuminate\Support\Facades\DB::table('user')->where('email', 'orangtua@gmail.com')->first();
        }

        $orangtua = User::find($existing->id_user);

        // 2. Ambil semua siswa yang ada, tautkan ke orangtua ini
        $siswas = User::where('id_tipeuser', 3)->get();

        foreach ($siswas as $siswa) {
            OrangtuaSiswa::firstOrCreate([
                'id_orangtua' => $orangtua->id_user,
                'id_siswa'    => $siswa->id_user,
            ]);
        }

        $this->command->info('Akun orang tua dibuat: orangtua@gmail.com / password');
        $this->command->info("Ditautkan ke {$siswas->count()} siswa.");
    }
}
