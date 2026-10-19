<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\PencapaianUser;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAchievementTest extends TestCase
{
    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat skema SQLite in-memory untuk testing
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->default(1);
            $table->integer('total_poin')->default(0);
            $table->string('status_akun')->default('Aktif');
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

        $this->admin = User::create([
            'nama' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'id_tipeuser' => 1,
        ]);

        $this->student = User::create([
            'nama' => 'Siswa Hebat',
            'email' => 'siswa@test.com',
            'password' => bcrypt('password'),
            'id_tipeuser' => 3,
            'total_poin' => 150,
        ]);
    }

    public function test_admin_can_view_achievement_index_page(): void
    {
        Achievement::create([
            'nama_achivement' => 'Juara Matematika',
            'minimal_poin_achivement' => 100,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.achievement'));

        $response->assertOk();
        $response->assertSee('Penghargaan &amp; Achievement Siswa', false);
        $response->assertSee('Juara Matematika');
        $response->assertSee('100 Poin');
    }

    public function test_admin_can_create_achievement_with_upload(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('lencana.png', 200, 200);

        $response = $this->actingAs($this->admin)->post(route('admin.achievement.store'), [
            'nama_achivement' => 'Bintang Belajar',
            'minimal_poin_achivement' => 100,
            'gambar_achivement' => $file,
            'deskripsi' => 'Diberikan kepada siswa yang giat belajar',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.achievement'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('achievements', [
            'nama_achivement' => 'Bintang Belajar',
            'minimal_poin_achivement' => 100,
            'deskripsi' => 'Diberikan kepada siswa yang giat belajar',
            'is_active' => true,
        ]);

        $achievement = Achievement::where('nama_achivement', 'Bintang Belajar')->first();
        $this->assertNotNull($achievement);
        $this->assertNotNull($achievement->gambar_achivement);
        Storage::disk('public')->assertExists($achievement->gambar_achivement);

        // Siswa dengan 150 poin harus otomatis mendapat pencapaian ini
        $this->assertDatabaseHas('pencapaianuser', [
            'id_user' => $this->student->id_user,
            'id_achievement' => $achievement->id_achievement,
            'nama' => 'Bintang Belajar',
        ]);
    }

    public function test_create_achievement_requires_name_points_and_image(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.achievement.store'), [
            'nama_achivement' => '',
            'minimal_poin_achivement' => '',
            'gambar_achivement' => '',
        ]);

        $response->assertSessionHasErrors(['nama_achivement', 'minimal_poin_achivement', 'gambar_achivement']);
    }

    public function test_admin_can_update_achievement(): void
    {
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->image('old_badge.png');
        $oldPath = $oldFile->store('achievements', 'public');

        $achievement = Achievement::create([
            'nama_achivement' => 'Nama Awal',
            'minimal_poin_achivement' => 50,
            'gambar_achivement' => $oldPath,
            'deskripsi' => 'Deskripsi lama',
            'is_active' => true,
        ]);

        $newFile = UploadedFile::fake()->image('new_badge.png');

        $response = $this->actingAs($this->admin)->put(route('admin.achievement.update', $achievement->id_achievement), [
            'nama_achivement' => 'Nama Diperbarui',
            'minimal_poin_achivement' => 200,
            'gambar_achivement' => $newFile,
            'deskripsi' => 'Deskripsi baru',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.achievement'));

        $achievement->refresh();
        $this->assertSame('Nama Diperbarui', $achievement->nama_achivement);
        $this->assertSame(200, $achievement->minimal_poin_achivement);
        $this->assertSame('Deskripsi baru', $achievement->deskripsi);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($achievement->gambar_achivement);
    }

    public function test_admin_can_delete_achievement(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('badge_delete.png');
        $path = $file->store('achievements', 'public');

        $achievement = Achievement::create([
            'nama_achivement' => 'Penghargaan Dihapus',
            'minimal_poin_achivement' => 300,
            'gambar_achivement' => $path,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.achievement.destroy', $achievement->id_achievement));

        $response->assertRedirect(route('admin.achievement'));
        $this->assertDatabaseMissing('achievements', [
            'id_achievement' => $achievement->id_achievement,
        ]);
        Storage::disk('public')->assertMissing($path);
    }
}
