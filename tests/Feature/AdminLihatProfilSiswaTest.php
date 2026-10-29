<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\HasilQuizModul;
use App\Models\Jenjang;
use App\Models\Modul;
use App\Models\PencapaianUser;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminLihatProfilSiswaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('username', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nisn')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->unsignedInteger('id_tipeuser')->default(3);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->string('status_akun')->default('Aktif');
            $table->unsignedInteger('id_modul')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });

        Schema::create('tipeuser', function (Blueprint $table) {
            $table->increments('id_tipeuser');
            $table->string('nama_tipe');
        });

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('kode_quiz')->nullable();
            $table->string('judul');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('proggressQuiz')->nullable();
            $table->timestamps();
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->unsignedInteger('id_tipemodul')->default(1);
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_quiz')->nullable();
            $table->string('progressModul')->nullable();
            $table->timestamps();
        });

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz')->default(1);
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->boolean('is_lulus')->default(false);
            $table->dateTime('waktu_dapat')->nullable();
            $table->timestamps();
        });

        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id_achievement');
            $table->string('nama_achivement');
            $table->text('deskripsi_achivement')->nullable();
            $table->integer('minimal_poin_achivement')->default(0);
            $table->string('gambar_achivement')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pencapaianuser', function (Blueprint $table) {
            $table->increments('id_pencapaian');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_achievement');
            $table->string('nama')->nullable();
            $table->dateTime('waktu_pencapaian')->nullable();
            $table->timestamps();
        });

        Schema::create('orangtua_siswa', function (Blueprint $table) {
            $table->increments('id_orangtua_siswa');
            $table->unsignedInteger('id_orangtua');
            $table->unsignedInteger('id_siswa');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('jenjang')->insert([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD'],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP'],
            ['id_jenjang' => 3, 'nama_tipe' => 'SMA'],
        ]);

        \Illuminate\Support\Facades\DB::table('tipeuser')->insert([
            ['id_tipeuser' => 1, 'nama_tipe' => 'Admin'],
            ['id_tipeuser' => 2, 'nama_tipe' => 'Guru'],
            ['id_tipeuser' => 3, 'nama_tipe' => 'Siswa'],
        ]);

        Achievement::create([
            'nama_achivement' => 'Pemula Teladan',
            'minimal_poin_achivement' => 50,
            'is_active' => true,
        ]);
        Achievement::create([
            'nama_achivement' => 'Master Pengetahuan',
            'minimal_poin_achivement' => 200,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_student_profile_page(): void
    {
        $admin = User::create([
            'nama' => 'Super Admin',
            'email' => 'admin@arrava.id',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);

        $siswa = User::create([
            'nama' => 'Budi Sanjaya',
            'username' => 'budisanjaya',
            'email' => 'budi@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 3, // SMA
            'nisn' => '0089281721',
            'nomor_hp' => '08123456789',
            'asal_sekolah' => 'SMAN 1 Futuristik',
            'total_poin' => 150,
            'status_akun' => 'Aktif',
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Fisika Kuantum',
            'id_jenjang' => 3,
            'proggressQuiz' => 'Tersedia',
        ]);

        HasilQuizModul::create([
            'id_user' => $siswa->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => 100,
            'poin_didapat' => 90,
            'is_lulus' => true,
            'waktu_dapat' => now()->subDay(),
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.siswa.profil', $siswa->id_user));

        $response->assertOk();
        $response->assertSee('Budi Sanjaya');
        $response->assertSee('budisanjaya');
        $response->assertSee('0089281721');
        $response->assertSee('SMAN 1 Futuristik');
        $response->assertSee('Kuis Fisika Kuantum');
        $response->assertSee('90%');
        $response->assertSee('LULUS');
        $response->assertSee('Grafik Tren Nilai dan Evaluasi Kuis');
        $response->assertSee('Rasio Hasil Kuis');
        $response->assertSee('quizTrendChart');
        $response->assertSee('performanceDonutChart');
    }

    public function test_admin_profile_view_returns_404_for_non_student(): void
    {
        $admin = User::create([
            'nama' => 'Admin Utama',
            'email' => 'admin-check@arrava.id',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);

        $guru = User::create([
            'nama' => 'Guru Fisika',
            'email' => 'guru@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 2,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.siswa.profil', $guru->id_user));
        $response->assertNotFound();
    }

    public function test_data_siswa_list_shows_action_link_to_student_profile(): void
    {
        $admin = User::create([
            'nama' => 'Admin Data',
            'email' => 'admin-list@arrava.id',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);

        $siswa = User::create([
            'nama' => 'Siti Aisyah',
            'email' => 'siti@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 2,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.daftar_siswa'));

        $response->assertOk();
        $response->assertSee('Siti Aisyah');
        $response->assertSee(route('admin.siswa.profil', $siswa->id_user));
        $response->assertSee('Profil');
    }
}
