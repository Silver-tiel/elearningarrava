<?php

namespace Tests\Feature;

use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DungeonQuestionFormAndValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $guru1;
    protected User $guru2;
    protected Quiz $dungeonQuiz;
    protected Quiz $ujianQuiz;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        $tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tipeUlangan = TipeQuiz::firstOrCreate(['nama_tipe' => 'Ulangan']);
        $tingkatMudah = TingkatQuiz::firstOrCreate(['nama_tingkat' => 'Mudah']);

        $sd = Jenjang::where('id_jenjang', 1)->first() ?? Jenjang::create(['nama_tipe' => 'SD']);
        $mapel = Mapel::first() ?? Mapel::create(['nama_mapel' => 'Matematika', 'id_jenjang' => 1]);

        $this->admin = User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin-q@example.com',
            'nisn' => 'ADM001',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru1 = User::create([
            'nama' => 'Guru Penulis Satu',
            'email' => 'guru1-q@example.com',
            'nisn' => 'GRU001',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru2 = User::create([
            'nama' => 'Guru Penulis Dua',
            'email' => 'guru2-q@example.com',
            'nisn' => 'GRU002',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        // Kuis Dungeon SD Matematika (pembuat adalah admin)
        $this->dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon Matematika SD',
            'deskripsi' => 'Dungeon Soal Matematika SD',
            'id_tipequiz' => $tipeDungeon->id_tipequiz,
            'id_tingkatquiz' => $tingkatMudah->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $mapel->id_mapel,
            'id_pembuat' => $this->admin->id_user,
            'durasi_total_menit' => 0,
            'proggressQuiz' => 'Tersedia',
        ]);

        // Kuis Ulangan SD Matematika
        $this->ujianQuiz = Quiz::create([
            'judul' => 'Ulangan Harian Matematika SD',
            'deskripsi' => 'Kuis ulangan harian',
            'id_tipequiz' => $tipeUlangan->id_tipequiz,
            'id_tingkatquiz' => $tingkatMudah->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $mapel->id_mapel,
            'id_pembuat' => $this->guru1->id_user,
            'durasi_total_menit' => 30,
            'proggressQuiz' => 'Tersedia',
        ]);

        // Buat satu soal di kuis ulangan
        Soal::create([
            'id_quiz' => $this->ujianQuiz->id_quiz,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Berapa luas persegi dengan sisi 4 cm?',
            'jawaban_benar' => 'A',
            'poin' => 10,
            'durasi_detik' => 20,
        ]);
    }

    public function test_tingkat_soal_wajib_diisi_saat_kuis_bertipe_dungeon(): void
    {
        $response = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Berapakah 2 + 2?',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '4'],
                ['label' => 'B', 'teks_pilihan' => '5'],
            ],
            // tingkat_soal sengaja dikosongkan
        ]);

        $response->assertSessionHasErrors(['tingkat_soal']);
    }

    public function test_soal_benar_salah_pada_dungeon_hanya_boleh_tingkat_mudah(): void
    {
        // 1. Coba buat Benar/Salah di tingkat Sedang -> harus ditolak
        $responseSedang = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 3, // Benar/Salah
            'tingkat_soal' => 'sedang',
            'pertanyaan' => 'Apakah 10 adalah bilangan genap?',
            'correct_choice' => 'A',
        ]);

        $responseSedang->assertSessionHasErrors(['id_jenis_soal']);

        // 2. Coba buat Benar/Salah di tingkat Mudah -> harus berhasil
        $responseMudah = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 3, // Benar/Salah
            'tingkat_soal' => 'mudah',
            'pertanyaan' => 'Apakah 10 adalah bilangan genap?',
            'correct_choice' => 'A',
        ]);

        $responseMudah->assertRedirect(route('admin.soal'));
        $this->assertDatabaseHas('soal', [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'pertanyaan' => 'Apakah 10 adalah bilangan genap?',
            'tingkat_soal' => 'mudah',
            'id_penulis' => $this->guru1->id_user,
            'aktif' => true,
        ]);
    }

    public function test_penulis_dan_status_aktif_terisi_otomatis(): void
    {
        $response = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'sulit',
            'pertanyaan' => 'Hitunglah akar kuadrat dari 144!',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '12', 'tetap_di_bawah' => 0],
                ['label' => 'B', 'teks_pilihan' => '14', 'tetap_di_bawah' => 0],
                ['label' => 'C', 'teks_pilihan' => 'Semua jawaban salah', 'tetap_di_bawah' => 1],
            ],
        ]);

        $response->assertRedirect(route('admin.soal'));

        $soal = Soal::where('pertanyaan', 'Hitunglah akar kuadrat dari 144!')->firstOrFail();
        $this->assertEquals($this->guru1->id_user, $soal->id_penulis);
        $this->assertTrue((bool) $soal->aktif);
        $this->assertEquals('sulit', $soal->tingkat_soal);

        // Verifikasi pilihan_soal.tetap_di_bawah
        $pilihanC = PilihanSoal::where('id_soal', $soal->id_soal)->where('label', 'C')->firstOrFail();
        $this->assertTrue((bool) $pilihanC->tetap_di_bawah);
    }

    public function test_anti_duplikasi_dalam_satu_kuis_dungeon_tetap_menolak_soal_sama(): void
    {
        // Masukkan soal pertama
        Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'mudah',
            'pertanyaan' => 'Berapakah 7 x 8?',
            'jawaban_benar' => 'A',
            'poin' => 10,
        ]);

        // Coba masukkan soal dengan pertanyaan yang sama persis di kuis Dungeon yang sama
        $response = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'sedang',
            'pertanyaan' => 'Berapakah 7 x 8?',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '56'],
                ['label' => 'B', 'teks_pilihan' => '54'],
            ],
        ]);

        $response->assertSessionHasErrors(['pertanyaan']);
    }

    public function test_duplikasi_antar_kuis_untuk_dungeon_hanya_memberi_peringatan_dan_tidak_menolak(): void
    {
        // Soal 'Berapa luas persegi dengan sisi 4 cm?' sudah ada di kuis Ulangan Harian
        // Saat dimasukkan ke kuis Dungeon, sistem TIDAK boleh menolak, tetapi memberi peringatan
        $response = $this->actingAs($this->guru1)->post(route('soal.store'), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'mudah',
            'pertanyaan' => 'Berapa luas persegi dengan sisi 4 cm?',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '16 cm2'],
                ['label' => 'B', 'teks_pilihan' => '8 cm2'],
            ],
        ]);

        $response->assertRedirect(route('admin.soal'));
        $response->assertSessionHas('warning_dungeon');

        $this->assertDatabaseHas('soal', [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'pertanyaan' => 'Berapa luas persegi dengan sisi 4 cm?',
            'tingkat_soal' => 'mudah',
        ]);
    }

    public function test_dungeon_quiz_boleh_disimpan_tanpa_soal(): void
    {
        // Admin membuat kuis dungeon baru tanpa soal sama sekali
        $response = $this->actingAs($this->admin)->post(route('admin.quiz.store'), [
            'judul' => 'Dungeon Baru Tanpa Soal',
            'id_jenjang' => 1,
            'id_tipequiz' => $this->dungeonQuiz->id_tipequiz,
            'mode_pengerjaan' => 'wayground',
            'soal' => [],
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $this->assertDatabaseHas('quiz', [
            'judul' => 'Dungeon Baru Tanpa Soal',
        ]);
    }

    public function test_hak_akses_guru_hanya_dapat_mengedit_dan_menghapus_soal_buatannya_sendiri_di_dungeon(): void
    {
        // Guru 1 membuat soal di dungeon
        $soalGuru1 = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'sedang',
            'id_penulis' => $this->guru1->id_user,
            'pertanyaan' => 'Pertanyaan milik Guru 1',
            'jawaban_benar' => 'A',
            'poin' => 20,
        ]);

        PilihanSoal::create([
            'id_soal' => $soalGuru1->id_soal,
            'label' => 'A',
            'teks_pilihan' => 'Jawaban Benar',
            'is_correct' => true,
        ]);
        PilihanSoal::create([
            'id_soal' => $soalGuru1->id_soal,
            'label' => 'B',
            'teks_pilihan' => 'Jawaban Salah',
            'is_correct' => false,
        ]);

        // Guru 1 dapat mengedit soal miliknya
        $responseEditGuru1 = $this->actingAs($this->guru1)->get(route('soal.edit', $soalGuru1->id_soal));
        $responseEditGuru1->assertStatus(200);

        // Guru 2 TIDAK BISA mengedit soal milik Guru 1 (HTTP 403)
        $responseEditGuru2 = $this->actingAs($this->guru2)->get(route('soal.edit', $soalGuru1->id_soal));
        $responseEditGuru2->assertStatus(403);

        // Guru 2 TIDAK BISA mengupdate soal milik Guru 1
        $responseUpdateGuru2 = $this->actingAs($this->guru2)->put(route('soal.update', $soalGuru1->id_soal), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'sedang',
            'pertanyaan' => 'Pertanyaan yang diubah oleh Guru 2',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '1'],
                ['label' => 'B', 'teks_pilihan' => '2'],
            ],
        ]);
        $responseUpdateGuru2->assertStatus(403);

        // Admin DAPAT mengupdate soal siapapun di Dungeon
        $responseUpdateAdmin = $this->actingAs($this->admin)->put(route('soal.update', $soalGuru1->id_soal), [
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'tingkat_soal' => 'sedang',
            'pertanyaan' => 'Pertanyaan yang diupdate Admin',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '1'],
                ['label' => 'B', 'teks_pilihan' => '2'],
            ],
        ]);
        $responseUpdateAdmin->assertRedirect(route('admin.soal'));
        $this->assertDatabaseHas('soal', [
            'id_soal' => $soalGuru1->id_soal,
            'pertanyaan' => 'Pertanyaan yang diupdate Admin',
        ]);

        // Guru 2 TIDAK BISA menghapus soal milik Guru 1
        $responseHapusGuru2 = $this->actingAs($this->guru2)->delete(route('soal.destroy', $soalGuru1->id_soal));
        $responseHapusGuru2->assertStatus(403);

        // Guru 1 BISA menghapus soal miliknya sendiri
        $responseHapusGuru1 = $this->actingAs($this->guru1)->delete(route('soal.destroy', $soalGuru1->id_soal));
        $responseHapusGuru1->assertRedirect(route('admin.soal'));
        $this->assertDatabaseMissing('soal', [
            'id_soal' => $soalGuru1->id_soal,
        ]);
    }
}
