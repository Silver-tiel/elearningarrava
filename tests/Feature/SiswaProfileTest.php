<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiswaProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('username', 50)->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nisn')->unique();
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

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz')->default(1);
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->boolean('is_lulus')->default(false);
            $table->dateTime('waktu_dapat')->nullable();
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul');
        });

        Schema::create('pencapaianuser', function (Blueprint $table) {
            $table->increments('id_pencapaian');
            $table->unsignedInteger('id_user');
            $table->string('nama');
            $table->dateTime('waktu_pencapaian');
        });

        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);
    }

    public function test_student_can_update_profile_without_changing_email(): void
    {
        Storage::fake('public');

        $student = User::create([
            'nama' => 'Nama Lama',
            'username' => 'namalama',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
            'nisn' => '0012345678',
            'nomor_hp' => '08123456789',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $this->actingAs($student)
            ->put(route('siswa.profil.update'), [
                'nama' => 'Nama Baru',
                'username' => 'namabaru',
                'nisn' => '0098765432',
                'nomor_hp' => '08111111111',
                'kelas' => 'Kelas 10',
                'asal_sekolah' => 'SMA Negeri 1',
                'id_jenjang' => 1,
                'foto_profil' => UploadedFile::fake()->image('profil.jpg'),
                'email' => 'email-baru@example.com',
            ])
            ->assertRedirect(route('siswa.profil'))
            ->assertSessionHas('success');

        $student->refresh();

        $this->assertSame('namabaru', $student->username);
        $this->assertSame('08111111111', $student->nomor_hp);
        $this->assertSame('siswa@example.com', $student->email);
        $this->assertSame('Kelas 10', $student->kelas);
        $this->assertSame('SMA Negeri 1', $student->asal_sekolah);
        $this->assertNotEmpty($student->foto_profil);
        Storage::disk('public')->assertExists($student->foto_profil);

        $this->actingAs($student)
            ->get(route('siswa.profil'))
            ->assertOk()
            ->assertSee('namabaru')
            ->assertSee('Email')
            ->assertSee('Simpan Perubahan')
            ->assertSeeHtml('data-open-on-load="false"');

        User::create([
            'nama' => 'Siswa Lain',
            'username' => 'lain',
            'email' => 'lain@example.com',
            'password' => bcrypt('password123'),
            'nisn' => '0088888888',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $this->actingAs($student)
            ->from(route('siswa.profil'))
            ->put(route('siswa.profil.update'), [
                'username' => 'lain', // Duplicate username should trigger error
                'id_jenjang' => 1,
            ])
            ->assertRedirect(route('siswa.profil'))
            ->assertSessionHasErrors('username');

        $this->get(route('siswa.profil'))
            ->assertOk()
            ->assertSeeHtml('data-open-on-load="true"');

        $this->assertSame('namabaru', $student->fresh()->username);
    }

    public function test_profile_graph_groups_quiz_attempts_by_completion_date(): void
    {
        $student = User::create([
            'nama' => 'Siswa Grafik',
            'username' => 'siswagrafik',
            'email' => 'grafik@example.com',
            'password' => bcrypt('password123'),
            'nisn' => '0011111111',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        DB::table('quiz')->insert([
            ['id_quiz' => 1, 'judul' => 'Kuis Matematika'],
            ['id_quiz' => 2, 'judul' => 'Kuis Bahasa'],
            ['id_quiz' => 3, 'judul' => 'Kuis IPA'],
            ['id_quiz' => 4, 'judul' => 'Kuis Sejarah'],
            ['id_quiz' => 5, 'judul' => 'Kuis Geografi'],
            ['id_quiz' => 6, 'judul' => 'Kuis Seni'],
        ]);

        foreach ([0, 0, 0, 1, 1, 2] as $index => $dayOffset) {
            $quizId = $index + 1;
            DB::table('hasilquizmodul')->insert([
                'id_user' => $student->id_user,
                'id_quiz' => $quizId,
                'total_poin' => 10,
                'poin_didapat' => 10,
                'is_lulus' => false,
                'waktu_dapat' => now()->startOfDay()->addDays($dayOffset),
            ]);
        }

        $this->actingAs($student)
            ->get(route('siswa.profil'))
            ->assertOk()
            ->assertSee('Jumlah pengerjaan', false)
            ->assertSee('Tanggal')
            ->assertSee('3 pengerjaan')
            ->assertSee('2 pengerjaan')
            ->assertSee('1 pengerjaan')
            ->assertSee('viewBox="0 0 600 250"', false)
            ->assertSee('class="block h-auto w-full"', false)
            ->assertSee(\Illuminate\Support\Carbon::now()->startOfDay()->translatedFormat('d M'))
            ->assertSee('Lihat selengkapnya')
            ->assertSee('data-open-quiz-history', false)
            ->assertSee('id="quiz-history-modal"', false)
            ->assertSee('Beberapa kuis yang dikerjakan pada tanggal yang sama dihitung sebagai satu titik.');
    }
}
