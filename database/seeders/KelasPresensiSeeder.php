<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Data contoh kelas + presensi. Aman dijalankan berulang (idempotent). */
class KelasPresensiSeeder extends Seeder
{
    public function run(): void
    {
        $guru = User::where('email', 'abim@gmail.com')->where('id_tipeuser', 2)->first();

        if (!$guru || !User::where('id_tipeuser', 3)->exists()) {
            $this->command?->warn('UserAwalSeeder belum dijalankan; KelasPresensiSeeder dilewati.');
            return;
        }

        // Peserta kelas = semua siswa aktif pada jenjang kelas (tanpa pendaftaran per siswa).

        // Kelas A (SD): diampu guru "abim".
        $kelasA = Kelas::firstOrCreate(
            ['nama' => 'Kelas 5 SD – Tematik & Berhitung'],
            ['id_jenjang' => 1, 'tahun_ajaran' => '2026/2027', 'aktif' => true, 'jam_batas' => '08:15']
        );
        $kelasA->guru()->syncWithoutDetaching([$guru->id_user]);

        // Kelas B (SMP): TANPA guru pengampu, untuk menguji bahwa guru tidak bisa memindai kelas lain.
        Kelas::firstOrCreate(
            ['nama' => 'Kelas VIII SMP – IPA & Matematika'],
            ['id_jenjang' => 2, 'tahun_ajaran' => '2026/2027', 'aktif' => true]
        );

        // Kelas C (SMA): diampu guru "abim"
        $kelasC = Kelas::firstOrCreate(
            ['nama' => 'Kelas X SMA – Matematika & Fisika'],
            ['id_jenjang' => 3, 'tahun_ajaran' => '2026/2027', 'aktif' => true, 'jam_batas' => '08:30']
        );
        $kelasC->guru()->syncWithoutDetaching([$guru->id_user]);

        // Sesi presensi dibuat otomatis untuk hari ini (jika kelas aktif hari ini).
        SesiPresensi::pastikanUntuk($kelasA, now(), $guru->id_user);
        SesiPresensi::pastikanUntuk($kelasC, now(), $guru->id_user);
    }
}
