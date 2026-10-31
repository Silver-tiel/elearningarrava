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
        $siswa = User::where('id_tipeuser', 3)->whereIn('email', [
            'dd@gmail.com', 'rolan@gmail.com', 'alip@gmail.com', 'alim@gmail.com',
        ])->get()->keyBy('email');

        if (!$guru || $siswa->isEmpty()) {
            $this->command?->warn('UserAwalSeeder belum dijalankan; KelasPresensiSeeder dilewati.');
            return;
        }

        // Kelas A: diampu guru "abim", beranggota 3 siswa.
        $kelasA = Kelas::firstOrCreate(
            ['nama' => 'Kelas X – Matematika'],
            ['id_jenjang' => 1, 'tahun_ajaran' => '2026/2027', 'aktif' => true]
        );
        $kelasA->guru()->syncWithoutDetaching([$guru->id_user]);
        $kelasA->siswa()->syncWithoutDetaching(
            $siswa->only(['dd@gmail.com', 'rolan@gmail.com', 'alim@gmail.com'])->pluck('id_user')->all()
        );

        // Kelas B: TANPA guru pengampu, untuk menguji bahwa guru tidak bisa memindai kelas lain.
        $kelasB = Kelas::firstOrCreate(
            ['nama' => 'Kelas XI – Fisika'],
            ['id_jenjang' => 2, 'tahun_ajaran' => '2026/2027', 'aktif' => true]
        );
        if ($siswa->has('alip@gmail.com')) {
            $kelasB->siswa()->syncWithoutDetaching([$siswa['alip@gmail.com']->id_user]);
        }

        SesiPresensi::firstOrCreate(
            ['id_kelas' => $kelasA->id_kelas, 'judul' => 'Pertemuan 3'],
            [
                'id_guru' => $guru->id_user,
                'pertemuan_ke' => 3,
                'tanggal' => now()->toDateString(),
                'batas_tepat_waktu' => now()->setTime(8, 15),
                'status' => 'buka',
            ]
        );
    }
}
