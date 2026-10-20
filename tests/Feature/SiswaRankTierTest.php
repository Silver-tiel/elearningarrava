<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiswaRankTierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('tipeuser', function (Blueprint $table) {
            $table->increments('id_tipeuser');
            $table->string('nama_tipe');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('username', 50)->nullable()->unique();
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

        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id_achievement');
            $table->string('nama_achivement', 255);
            $table->unsignedInteger('minimal_poin_achivement')->default(0);
            $table->string('gambar_achivement', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pencapaianuser', function (Blueprint $table) {
            $table->increments('id_pencapaian');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_achievement')->nullable();
            $table->string('nama');
            $table->dateTime('waktu_pencapaian');
            $table->timestamps();
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('id_tipemodul')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('foto_modul')->nullable();
            $table->string('youtube_id')->nullable();
            $table->timestamps();
        });

        Schema::create('tipemodul', function (Blueprint $table) {
            $table->increments('id_tipemodul');
            $table->string('nama_tipe');
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul_quiz');
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

        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);

        // Seed 3 active achievements for testing tiers
        Achievement::create([
            'nama_achivement' => 'Lower Beginner',
            'minimal_poin_achivement' => 20,
            'is_active' => true,
        ]);
        Achievement::create([
            'nama_achivement' => 'Upper Beginner',
            'minimal_poin_achivement' => 100,
            'is_active' => true,
        ]);
        Achievement::create([
            'nama_achivement' => 'Advance',
            'minimal_poin_achivement' => 500,
            'is_active' => true,
        ]);
    }

    public function test_rank_tier_calculation_for_novice(): void
    {
        $user = User::create([
            'nama' => 'Budi Siswa',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 10,
        ]);

        $rank = $user->rank_tier;

        $this->assertSame('Pemula', $rank['current_rank']);
        $this->assertSame('Lower Beginner', $rank['next_rank']);
        $this->assertSame(10, $rank['current_points']);
        $this->assertSame(20, $rank['next_points']);
        $this->assertSame(10, $rank['points_needed']);
        $this->assertSame(50, $rank['percent']); // 10/20 = 50%
        $this->assertFalse($rank['is_max']);
    }

    public function test_rank_tier_calculation_for_intermediate_progress(): void
    {
        $user = User::create([
            'nama' => 'Siti Siswa',
            'email' => 'siti@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 60,
        ]);

        $rank = $user->rank_tier;

        // 60 points: unlocked Lower Beginner (20), targeting Upper Beginner (100)
        // Span = 100 - 20 = 80. Earned = 60 - 20 = 40. Percent = 40/80 = 50%
        $this->assertSame('Lower Beginner', $rank['current_rank']);
        $this->assertSame('Upper Beginner', $rank['next_rank']);
        $this->assertSame(60, $rank['current_points']);
        $this->assertSame(100, $rank['next_points']);
        $this->assertSame(40, $rank['points_needed']);
        $this->assertSame(50, $rank['percent']);
        $this->assertFalse($rank['is_max']);
    }

    public function test_rank_tier_calculation_for_max_tier(): void
    {
        $user = User::create([
            'nama' => 'Joko Siswa',
            'email' => 'joko@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 600,
        ]);

        $rank = $user->rank_tier;

        $this->assertSame('Advance', $rank['current_rank']);
        $this->assertNull($rank['next_rank']);
        $this->assertSame(600, $rank['current_points']);
        $this->assertSame(0, $rank['points_needed']);
        $this->assertSame(100, $rank['percent']);
        $this->assertTrue($rank['is_max']);
    }

    public function test_dashboard_displays_rank_and_exp_bar(): void
    {
        $user = User::create([
            'nama' => 'Ani Siswa',
            'email' => 'ani@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 40,
            'id_tipeuser' => 3,
        ]);

        $response = $this->actingAs($user)->get(route('siswa.dashboard'));

        $response->assertOk();
        $response->assertSee('Peringkat &amp; EXP', false);
        $response->assertSee('Lower Beginner');
        $response->assertSee('Upper Beginner');
        $response->assertSee('assets/widget/exp.png');
    }

    public function test_profile_displays_rank_and_exp_bar(): void
    {
        $user = User::create([
            'nama' => 'Doni Siswa',
            'email' => 'doni@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 80,
            'id_tipeuser' => 3,
        ]);

        $response = $this->actingAs($user)->get(route('siswa.profil'));

        $response->assertOk();
        $response->assertSee('Peringkat &amp; EXP Belajar', false);
        $response->assertSee('Rank: Lower Beginner');
        $response->assertSee('assets/widget/exp.png');
    }

    public function test_level_up_modal_is_rendered_when_rank_up_session_is_present(): void
    {
        $user = User::create([
            'nama' => 'Rina Siswa',
            'email' => 'rina@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 120,
            'id_tipeuser' => 3,
        ]);

        $response = $this->actingAs($user)
            ->withSession([
                'rank_up' => [
                    'old_rank' => 'Lower Beginner',
                    'new_rank' => 'Upper Beginner',
                    'badge_url' => '/storage/achievements/upper_beginner.png',
                    'poin' => 120,
                    'poin_diberikan' => 40,
                ],
            ])
            ->get(route('siswa.dashboard'));

        $response->assertOk();
        $response->assertSee('LEVEL UP! RANK BARU TERBUKA');
        $response->assertSee('Upper Beginner');
        $response->assertSee('assets/levelUp/littleLevelUp.gif');
        $response->assertSee('Keren, Lanjutkan Belajar!');
    }

    public function test_level_up_modal_preview_via_query_param(): void
    {
        $user = User::create([
            'nama' => 'Kevin Siswa',
            'email' => 'kevin@test.com',
            'password' => bcrypt('password'),
            'total_poin' => 50,
            'id_tipeuser' => 3,
        ]);

        $response = $this->actingAs($user)->get(route('siswa.dashboard', ['preview_levelup' => 1]));

        $response->assertOk();
        $response->assertSee('LEVEL UP! RANK BARU TERBUKA');
        $response->assertSee('assets/levelUp/littleLevelUp.gif');
    }
}
