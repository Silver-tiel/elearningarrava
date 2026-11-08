<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\TipeUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiswaDashboardProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    private User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\MasterDataSeeder::class);

        $this->siswa = User::create([
            'nama' => 'Budi Siswa',
            'username' => 'budisiswa',
            'email' => 'budi@test.com',
            'nisn' => '1234567890',
            'password' => bcrypt('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
            'total_poin' => 50,
        ]);
    }

    public function test_dashboard_renders_avatar_fallback_when_no_photo(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.dashboard'));

        $response->assertOk();
        $response->assertSee('Halo, Budi Siswa', false);
        // Fallback initial
        $response->assertSee('B');
    }

    public function test_dashboard_renders_uploaded_profile_photo(): void
    {
        Storage::fake('public');
        $photo = UploadedFile::fake()->image('avatar.jpg');
        $path = $photo->store('profil-siswa', 'public');

        $this->siswa->update(['foto_profil' => $path]);

        $response = $this->actingAs($this->siswa)->get(route('siswa.dashboard'));

        $response->assertOk();
        $expectedUrl = Storage::disk('public')->url($path);
        $response->assertSee($expectedUrl, false);
    }

    public function test_user_accessor_returns_null_when_photo_does_not_exist(): void
    {
        Storage::fake('public');
        $this->siswa->update(['foto_profil' => 'profil-siswa/nonexistent.jpg']);

        $this->assertNull($this->siswa->foto_profil_url);
    }
}
