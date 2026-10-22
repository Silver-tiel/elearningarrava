<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang!');
        $response->assertSee('Email');
        $response->assertSee('Kata Sandi');
    }

    public function test_student_can_login_and_access_dashboard_ui(): void
    {
        $student = User::create([
            'nama' => 'Budi Pratama',
            'nisn' => '1000000001',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'id_tipeuser' => 3, // Siswa
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
            'total_poin' => 0,
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($student);
        $response->assertRedirect('/siswa/dashboard');

        // Mengakses dashboard dan memastikan antarmuka (UI) dashboard siswa tampil
        $dashboardResponse = $this->get('/siswa/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dashboard Siswa');
        $dashboardResponse->assertSee('Halo, Budi Pratama');
        $dashboardResponse->assertSee('Materi Tersedia');
        $dashboardResponse->assertSee('Quiz Tersedia');
    }

    public function test_admin_can_login_and_access_admin_dashboard_ui(): void
    {
        $admin = User::create([
            'nama' => 'Admin Arrava',
            'nisn' => '1000000002',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'id_tipeuser' => 1, // Admin
            'status_akun' => 'Aktif',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect('/admin');

        // Mengakses dashboard dan memastikan antarmuka (UI) dashboard admin tampil
        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Admin Arrava');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::create([
            'nama' => 'User Tes',
            'nisn' => '1000000003',
            'email' => 'usertes@example.com',
            'password' => Hash::make('password123'),
            'id_tipeuser' => 3,
            'status_akun' => 'Aktif',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'usertes@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }
}
