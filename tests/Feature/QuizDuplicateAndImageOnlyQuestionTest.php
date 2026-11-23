<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class QuizDuplicateAndImageOnlyQuestionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        $this->admin = User::create([
            'nama' => 'Admin Penguji Duplikat',
            'email' => 'admin-dup@example.com',
            'nisn' => '8887776665',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);
    }

    public function test_soal_bisa_hanya_gambar_tanpa_teks_pertanyaan(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Khusus Gambar',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => '',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => 0],
                    ],
                ],
            ],
            'soal_foto' => [
                0 => UploadedFile::fake()->image('diagram_soal.png', 300, 300),
            ],
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $soal = Soal::firstOrFail();
        $this->assertNull($soal->pertanyaan);
        $this->assertNotNull($soal->foto_soal);
        Storage::disk('public')->assertExists($soal->foto_soal);
    }

    public function test_soal_tanpa_teks_dan_tanpa_gambar_ditolak(): void
    {
        $response = $this->actingAs($this->admin)->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Soal Kosong',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => '',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertSessionHasErrors('soal.0.pertanyaan');
    }

    public function test_pencegahan_duplikat_teks_dalam_satu_kuis(): void
    {
        $response = $this->actingAs($this->admin)->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Duplikat Teks',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Apa ibukota Indonesia?',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Jakarta', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Bandung', 'is_correct' => 0],
                    ],
                ],
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'apa ibukota indonesia?', // Sama teks (case-insensitive)
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Jakarta', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Surabaya', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertSessionHasErrors('soal');
        $errorMessage = session('errors')->first('soal');
        $this->assertStringContainsString('Soal no. 1, 2 memiliki teks pertanyaan yang sama persis', $errorMessage);
    }

    public function test_pencegahan_duplikat_gambar_dalam_satu_kuis(): void
    {
        Storage::fake('public');
        $imageFileA = UploadedFile::fake()->create('foto1.png', 100);
        $imageFileB = UploadedFile::fake()->createWithContent('foto2.png', file_get_contents($imageFileA->getRealPath()));

        $response = $this->actingAs($this->admin)->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Duplikat Gambar',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Hitung luas gambar ini',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => '10', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => '20', 'is_correct' => 0],
                    ],
                ],
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Hitung keliling gambar ini', // Teks beda
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => '30', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => '40', 'is_correct' => 0],
                    ],
                ],
            ],
            'soal_foto' => [
                0 => $imageFileA,
                1 => $imageFileB,
            ],
        ]);

        $response->assertSessionHasErrors('soal');
        $errorMessage = session('errors')->first('soal');
        $this->assertStringContainsString('memiliki gambar yang sama persis', $errorMessage);
    }

    public function test_pencegahan_duplikat_identik_teks_dan_gambar_dalam_satu_kuis(): void
    {
        Storage::fake('public');
        $imageFileA = UploadedFile::fake()->create('foto_identik1.png', 100);
        $imageFileB = UploadedFile::fake()->createWithContent('foto_identik2.png', file_get_contents($imageFileA->getRealPath()));

        $response = $this->actingAs($this->admin)->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Duplikat Identik Penuh',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Perhatikan diagram di bawah!',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Opsi 1', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Opsi 2', 'is_correct' => 0],
                    ],
                ],
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Perhatikan diagram di bawah!', // Teks sama
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Opsi 1', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Opsi 2', 'is_correct' => 0],
                    ],
                ],
            ],
            'soal_foto' => [
                0 => $imageFileA,
                1 => $imageFileB, // Gambar sama
            ],
        ]);

        $response->assertSessionHasErrors('soal');
        $errorMessage = session('errors')->first('soal');
        $this->assertStringContainsString('benar-benar IDENTIK (teks & gambar sama persis)!', $errorMessage);
    }

    public function test_pencegahan_duplikat_antar_kuis_pada_jenjang_dan_mapel_sama(): void
    {
        // 1. Buat Kuis Pertama
        $kuisPertama = Quiz::create([
            'judul' => 'Kuis Sejarah SD Bagian 1',
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'proggressQuiz' => 'Tersedia',
        ]);
        Soal::create([
            'id_quiz' => $kuisPertama->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => 'Kapan proklamasi kemerdekaan Indonesia dibacakan?',
            'jawaban_benar' => '17 Agustus 1945',
            'poin' => 10,
        ]);

        // 2. Coba buat kuis kedua dengan mapel & jenjang yang sama dan soal yang sama
        $response = $this->actingAs($this->admin)->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Kuis Sejarah SD Bagian 2',
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'kapan proklamasi kemerdekaan indonesia dibacakan?', // Sama dengan kuis pertama
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => '17 Agustus 1945', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => '18 Agustus 1945', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertSessionHasErrors('soal');
        $errorMessage = session('errors')->first('soal');
        $this->assertStringContainsString("sudah pernah digunakan pada Kuis 'Kuis Sejarah SD Bagian 1'", $errorMessage);
    }

    public function test_edit_kuis_tidak_salah_mendeteksi_duplikat_terhadap_dirinya_sendiri(): void
    {
        // Kuis dan soal yang sudah ada
        $quiz = Quiz::create([
            'judul' => 'Kuis Mandiri Matematika',
            'id_jenjang' => 1,
            'id_mapel' => 2,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'proggressQuiz' => 'Tersedia',
        ]);
        Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => 'Berapakah 5 + 5?',
            'jawaban_benar' => '10',
            'poin' => 10,
        ]);

        // Kirim update kuis yang sama dengan pertanyaan yang tetap
        $response = $this->actingAs($this->admin)->put(route('admin.quiz.update', $quiz->id_quiz), [
            'action_type' => 'publish',
            'judul' => 'Kuis Mandiri Matematika Diperbarui',
            'id_jenjang' => 1,
            'id_mapel' => 2,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 30,
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Berapakah 5 + 5?',
                    'poin' => 10,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => '10', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => '20', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('admin.quiz'));
    }
}
