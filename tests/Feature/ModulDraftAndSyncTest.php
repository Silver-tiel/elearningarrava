<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\TipeModul;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ModulDraftAndSyncTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->timestamps();
        });

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('tipemodul', function (Blueprint $table) {
            $table->increments('id_tipemodul');
            $table->string('nama_tipe');
        });

        Schema::create('tipequiz', function (Blueprint $table) {
            $table->increments('id_tipequiz');
            $table->string('nama_tipe');
        });

        Schema::create('tingkatquiz', function (Blueprint $table) {
            $table->increments('id_tingkatquiz');
            $table->string('nama_tingkat');
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('kode_quiz')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('id_tipequiz')->default(1);
            $table->unsignedInteger('id_tingkatquiz')->default(1);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->string('token')->nullable();
            $table->string('foto_quiz')->nullable();
            $table->string('opsi_preview')->default('lengkap');
            $table->string('proggressQuiz')->nullable();
            $table->timestamps();
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->string('file_materi')->nullable();
            $table->string('tipe_file', 50)->nullable();
            $table->unsignedInteger('id_tipemodul')->default(1);
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_quiz')->nullable();
            $table->string('progressModul')->nullable();
            $table->integer('kkm_quiz')->default(70);
            $table->integer('poin_modul')->default(50);
            $table->string('foto_modul')->nullable();
            $table->timestamps();
        });

        Schema::create('modul_soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_modul');
            $table->text('pertanyaan');
            $table->integer('poin')->default(10);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });

        Schema::create('modul_soal_pilihan', function (Blueprint $table) {
            $table->increments('id_pilihan');
            $table->unsignedInteger('id_soal');
            $table->string('label', 10)->nullable();
            $table->text('teks_pilihan');
            $table->boolean('is_benar')->default(false);
            $table->timestamps();
        });

        Schema::create('progres_modul_siswa', function (Blueprint $table) {
            $table->increments('id_progres');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_modul');
            $table->boolean('materi_selesai')->default(false);
            $table->boolean('quiz_selesai')->default(false);
            $table->boolean('quiz_lulus')->default(false);
            $table->integer('nilai_quiz')->default(0);
            $table->boolean('is_tuntas')->default(false);
            $table->integer('poin_didapat')->default(0);
            $table->dateTime('waktu_materi_selesai')->nullable();
            $table->dateTime('waktu_quiz_selesai')->nullable();
            $table->dateTime('waktu_tuntas')->nullable();
            $table->timestamps();
            $table->unique(['id_user', 'id_modul']);
        });

        Schema::create('catatan_modul', function (Blueprint $table) {
            $table->increments('id_catatan');
            $table->unsignedInteger('id_modul');
            $table->string('judul_catatan')->nullable();
            $table->text('isi_catatan')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz');
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->boolean('is_lulus')->default(false);
            $table->dateTime('waktu_dapat')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('jenjang')->insert([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD'],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP'],
            ['id_jenjang' => 3, 'nama_tipe' => 'SMA'],
        ]);

        \Illuminate\Support\Facades\DB::table('tipemodul')->insert([
            ['id_tipemodul' => 1, 'nama_tipe' => 'Video'],
            ['id_tipemodul' => 2, 'nama_tipe' => 'PDF'],
            ['id_tipemodul' => 3, 'nama_tipe' => 'Artikel'],
        ]);
    }

    public function test_admin_can_save_modul_as_draft(): void
    {
        $this->actingAs($this->makeAdmin());

        $response = $this->post(route('admin.modul.store'), [
            'action_type' => 'draft',
            'judul_modul' => 'Modul Konsep Belum Matang',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
        ]);

        $response->assertRedirect(route('admin.modul'));
        $response->assertSessionHas('success');

        $modul = Modul::where('judul_modul', 'Modul Konsep Belum Matang')->first();
        $this->assertNotNull($modul);
        $this->assertTrue($modul->isDraft());
        $this->assertSame('Draft', $modul->progressModul);
    }

    public function test_admin_can_publish_modul(): void
    {
        $this->actingAs($this->makeAdmin());

        $response = $this->post(route('admin.modul.store'), [
            'action_type' => 'publish',
            'judul_modul' => 'Modul Siap Terbit',
            'id_jenjang' => 2,
            'id_tipemodul' => 1,
            'file_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response->assertRedirect(route('admin.modul'));
        $modul = Modul::where('judul_modul', 'Modul Siap Terbit')->first();
        $this->assertNotNull($modul);
        $this->assertTrue($modul->isPublished());
        $this->assertSame('Tersedia', $modul->progressModul);
    }

    public function test_modul_quiz_sync_allows_quiz_with_same_jenjang(): void
    {
        $this->actingAs($this->makeAdmin());

        $quizSma = Quiz::create([
            'judul' => 'Kuis Fisika SMA',
            'id_jenjang' => 3,
            'proggressQuiz' => 'Tersedia',
        ]);

        $response = $this->post(route('admin.modul.store'), [
            'action_type' => 'publish',
            'judul_modul' => 'Modul Fisika Gelombang',
            'id_jenjang' => 3, // Jenjang sama (SMA)
            'id_tipemodul' => 1,
            'id_quiz' => $quizSma->id_quiz,
        ]);

        $response->assertRedirect(route('admin.modul'));
        $modul = Modul::where('judul_modul', 'Modul Fisika Gelombang')->first();
        $this->assertNotNull($modul);
        $this->assertSame($quizSma->id_quiz, (int) $modul->id_quiz);
    }

    public function test_modul_quiz_sync_rejects_quiz_with_different_jenjang(): void
    {
        $this->actingAs($this->makeAdmin());

        $quizSmp = Quiz::create([
            'judul' => 'Kuis IPA SMP',
            'id_jenjang' => 2, // SMP
            'proggressQuiz' => 'Tersedia',
        ]);

        $response = $this->post(route('admin.modul.store'), [
            'action_type' => 'publish',
            'judul_modul' => 'Modul Biologi SMA',
            'id_jenjang' => 3, // SMA (berbeda jenjang dengan quiz)
            'id_tipemodul' => 1,
            'id_quiz' => $quizSmp->id_quiz,
        ]);

        $response->assertSessionHasErrors('id_quiz');
        $this->assertNull(Modul::where('judul_modul', 'Modul Biologi SMA')->first());
    }

    public function test_admin_can_update_modul_draft_to_published_and_vice_versa(): void
    {
        $this->actingAs($this->makeAdmin());

        $modul = Modul::create([
            'judul_modul' => 'Modul Draf Pertama',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
            'progressModul' => 'Draft',
        ]);

        // Update ke Publish
        $this->put(route('admin.modul.update', $modul->id_modul), [
            'action_type' => 'publish',
            'judul_modul' => 'Modul Draf Pertama',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
        ])->assertRedirect(route('admin.modul'));

        $modul->refresh();
        $this->assertTrue($modul->isPublished());
        $this->assertSame('Tersedia', $modul->progressModul);

        // Update kembali ke Draf
        $this->put(route('admin.modul.update', $modul->id_modul), [
            'action_type' => 'draft',
            'judul_modul' => 'Modul Draf Pertama',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
        ])->assertRedirect(route('admin.modul'));

        $modul->refresh();
        $this->assertTrue($modul->isDraft());
        $this->assertSame('Draft', $modul->progressModul);
    }

    public function test_admin_can_filter_and_sort_modul(): void
    {
        $this->actingAs($this->makeAdmin());

        Modul::create([
            'judul_modul' => 'Modul Z Terbit SD',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
            'progressModul' => 'Tersedia',
        ]);

        Modul::create([
            'judul_modul' => 'Modul A Draf SMP',
            'id_jenjang' => 2,
            'id_tipemodul' => 2,
            'progressModul' => 'Draft',
        ]);

        // Filter status: draft
        $this->get(route('admin.modul', ['status' => 'draft']))
            ->assertOk()
            ->assertSee('Modul A Draf SMP')
            ->assertDontSee('Modul Z Terbit SD');

        // Filter status: published
        $this->get(route('admin.modul', ['status' => 'published']))
            ->assertOk()
            ->assertSee('Modul Z Terbit SD')
            ->assertDontSee('Modul A Draf SMP');

        // Filter jenjang: 1 (SD)
        $this->get(route('admin.modul', ['jenjang' => 1]))
            ->assertOk()
            ->assertSee('Modul Z Terbit SD')
            ->assertDontSee('Modul A Draf SMP');
    }

    public function test_draft_modul_is_hidden_from_siswa(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Pengakses',
            'email' => 'siswa-modul-draft@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        Modul::create([
            'judul_modul' => 'Modul Terbit Siswa',
            'id_jenjang' => 1,
            'progressModul' => 'Tersedia',
        ]);

        Modul::create([
            'judul_modul' => 'Modul Rahasia Draf',
            'id_jenjang' => 1,
            'progressModul' => 'Draft',
        ]);

        $this->actingAs($siswa);

        // Di halaman belajar / modul
        $this->get(route('siswa.modul'))
            ->assertOk()
            ->assertSee('Modul Terbit Siswa')
            ->assertDontSee('Modul Rahasia Draf');

        // Di dashboard siswa
        $this->get(route('siswa.dashboard'))
            ->assertOk()
            ->assertSee('Modul Terbit Siswa')
            ->assertDontSee('Modul Rahasia Draf');
    }

    public function test_siswa_cannot_access_draft_modul_detail_or_latihan(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Coba Akses Draf',
            'email' => 'siswa-forbidden-modul@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $modulDraft = Modul::create([
            'judul_modul' => 'Modul Draf Belum Boleh Dibuka',
            'id_jenjang' => 1,
            'progressModul' => 'Draft',
        ]);

        $this->actingAs($siswa);

        // Detail materi modul
        $this->get(route('siswa.modul.materi', $modulDraft->id_modul))
            ->assertRedirect(route('siswa.modul'))
            ->assertSessionHasErrors('modul');

        // Latihan soal modul
        $this->get(route('siswa.modul.latihan', $modulDraft->id_modul))
            ->assertRedirect(route('siswa.modul'))
            ->assertSessionHasErrors('modul');
    }

    public function test_siswa_only_sees_modul_matching_their_jenjang(): void
    {
        $siswaSD = User::create([
            'nama' => 'Siswa SD Jenjang 1',
            'email' => 'siswa-sd-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $modulSD = Modul::create([
            'judul_modul' => 'Matematika Dasar SD Khusus',
            'id_jenjang' => 1,
            'progressModul' => 'Tersedia',
        ]);

        $modulSMP = Modul::create([
            'judul_modul' => 'Biologi Ekosistem SMP Khusus',
            'id_jenjang' => 2,
            'progressModul' => 'Tersedia',
        ]);

        $this->actingAs($siswaSD);

        // Halaman modul / belajar
        $this->get(route('siswa.modul'))
            ->assertOk()
            ->assertSee('Matematika Dasar SD Khusus')
            ->assertDontSee('Biologi Ekosistem SMP Khusus');

        // Dashboard siswa
        $this->get(route('siswa.dashboard'))
            ->assertOk()
            ->assertSee('Matematika Dasar SD Khusus')
            ->assertDontSee('Biologi Ekosistem SMP Khusus');
    }

    public function test_siswa_cannot_access_different_jenjang_modul_detail_or_latihan(): void
    {
        $siswaSD = User::create([
            'nama' => 'Siswa SD Penasaran',
            'email' => 'siswa-sd-penasaran-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $modulSMA = Modul::create([
            'judul_modul' => 'Fisika Kuantum SMA',
            'id_jenjang' => 3,
            'progressModul' => 'Tersedia',
        ]);

        $this->actingAs($siswaSD);

        // Akses materi modul beda jenjang langsung via URL
        $this->get(route('siswa.modul.materi', $modulSMA->id_modul))
            ->assertRedirect(route('siswa.modul'))
            ->assertSessionHasErrors('modul');

        // Akses latihan soal modul beda jenjang langsung via URL
        $this->get(route('siswa.modul.latihan', $modulSMA->id_modul))
            ->assertRedirect(route('siswa.modul'))
            ->assertSessionHasErrors('modul');
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('progres_modul_siswa');
        Schema::dropIfExists('modul_soal_pilihan');
        Schema::dropIfExists('modul_soal');
        Schema::dropIfExists('hasilquizmodul');
        Schema::dropIfExists('catatan_modul');
        Schema::dropIfExists('modul');
        Schema::dropIfExists('quiz');
        Schema::dropIfExists('tingkatquiz');
        Schema::dropIfExists('tipequiz');
        Schema::dropIfExists('tipemodul');
        Schema::dropIfExists('jenjang');
        Schema::dropIfExists('user');

        parent::tearDown();
    }

    private function makeAdmin(): User
    {
        return User::create([
            'nama' => 'Admin Modul',
            'email' => 'admin-modul-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);
    }
}
