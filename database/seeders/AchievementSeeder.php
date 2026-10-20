<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceDirectory = database_path('assets/foto_achivement');

        // Daftar tier achievement berurutan dari terendah (Lower Beginner) sampai tertinggi (Advance)
        $achievements = [
            [
                'nama_achivement' => 'Lower Beginner',
                'minimal_poin_achivement' => 20,
                'source_filenames' => ['beginner .png', 'beginner.png', 'lower_beginner.png'],
                'target_filename' => 'lower_beginner.png',
                'deskripsi' => 'Tanda penghargaan tingkat awal untuk siswa yang memulai langkah pertama dalam belajar dan menyelesaikan kuis.',
            ],
            [
                'nama_achivement' => 'Upper Beginner',
                'minimal_poin_achivement' => 100,
                'source_filenames' => ['upper_beginner.png', 'upper beginner.png'],
                'target_filename' => 'upper_beginner.png',
                'deskripsi' => 'Tanda penghargaan untuk siswa yang telah menguasai materi-materi dasar dan konsisten mengumpulkan poin kuis.',
            ],
            [
                'nama_achivement' => 'Lower Intermediate',
                'minimal_poin_achivement' => 250,
                'source_filenames' => ['lower_Intermediate.png', 'lower_intermediate.png'],
                'target_filename' => 'lower_intermediate.png',
                'deskripsi' => 'Tanda penghargaan tingkat menengah awal atas dedikasi dan pemahaman belajar yang terus berkembang.',
            ],
            [
                'nama_achivement' => 'Upper Intermediate',
                'minimal_poin_achivement' => 450,
                'source_filenames' => ['upper_Intermediate.png', 'upper_intermediate.png'],
                'target_filename' => 'upper_intermediate.png',
                'deskripsi' => 'Tanda penghargaan bagi siswa yang menunjukkan performa belajar yang solid dan nilai kuis yang memuaskan.',
            ],
            [
                'nama_achivement' => 'Lower Advance',
                'minimal_poin_achivement' => 700,
                'source_filenames' => ['lower_advance.png', 'lower advance.png'],
                'target_filename' => 'lower_advance.png',
                'deskripsi' => 'Tanda penghargaan prestisius yang mendekati tingkat kemahiran lanjutan dalam penguasaan modul dan materi.',
            ],
            [
                'nama_achivement' => 'Advance',
                'minimal_poin_achivement' => 1000,
                'source_filenames' => ['advance.png', 'advance .png'],
                'target_filename' => 'advance.png',
                'deskripsi' => 'Tanda penghargaan tingkat tertinggi atas dedikasi, keunggulan akademik, dan penguasaan materi yang luar biasa.',
            ],
        ];

        // Pastikan direktori storage public/achievements siap
        if (!Storage::disk('public')->exists('achievements')) {
            Storage::disk('public')->makeDirectory('achievements');
        }

        foreach ($achievements as $data) {
            $storedPath = null;

            // Cari file foto dari folder database/assets/foto_achivement
            foreach ($data['source_filenames'] as $candidate) {
                $fullSourcePath = $sourceDirectory . DIRECTORY_SEPARATOR . $candidate;
                if (File::exists($fullSourcePath)) {
                    $targetPath = 'achievements/' . $data['target_filename'];
                    Storage::disk('public')->put($targetPath, File::get($fullSourcePath));
                    $storedPath = $targetPath;
                    break;
                }
            }

            // Simpan atau perbarui achievement ke database
            $achievement = Achievement::updateOrCreate(
                ['nama_achivement' => $data['nama_achivement']],
                [
                    'minimal_poin_achivement' => $data['minimal_poin_achivement'],
                    'gambar_achivement' => $storedPath,
                    'deskripsi' => $data['deskripsi'],
                    'is_active' => true,
                ]
            );

            // Sinkronkan ke siswa yang sudah memenuhi syarat minimal poin
            $jumlahPenerima = $achievement->syncToEligibleUsers();

            $this->command?->info("Achievement '{$achievement->nama_achivement}' ({$achievement->minimal_poin_achivement} poin) berhasil disimpan. Terdistribusi ke {$jumlahPenerima} siswa.");
        }
    }
}
