<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginParallaxEffectTest extends TestCase
{
    public function test_login_page_renders_with_adapted_parallax_floating_effect(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        // Memastikan efek latar belakang dan partikel gelombang terpasang di login
        $response->assertSee('images/backgorund1.png');
        $response->assertSee('images/backgorund3.png');
        $response->assertSee('layer bg bg1', false);
        $response->assertSee('layer float f1', false);
        $response->assertSee('CFG');
        $response->assertSee('ease');
        $response->assertSee('pp(');

        // Memastikan form login asli Arrava tetap utuh dan fungsional
        $response->assertSee('Selamat Datang!');
        $response->assertSee('Silakan masuk ke akun Anda');
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('Masuk Sekarang');
        $response->assertSee(route('login.submit'));
        $response->assertSee(route('pendaftaran'));
    }

    public function test_siswa_dashboard_view_renders_with_pixel_wave_parallax_effect(): void
    {
        $dummyUser = new User([
            'id_user' => 1,
            'nama' => 'Siswa Pengujian',
            'email' => 'siswa@example.com',
            'id_tipeuser' => 3,
            'status_akun' => 'Aktif',
        ]);

        $view = $this->view('siswa.dashboard', [
            'user' => $dummyUser,
            'modulCount' => 5,
            'quizCount' => 3,
            'moduls' => collect(),
        ]);

        $view->assertSee('images/backgorund1.png');
        $view->assertSee('images/backgorund3.png');
        $view->assertSee('dash-layer dash-bg dash-bg1', false);
        $view->assertSee('dash-layer dash-float dash-f1', false);
        $view->assertSee('Halo, Siswa Pengujian 👋');
    }

    public function test_other_siswa_pages_inherit_pixel_wave_effect(): void
    {
        // Halaman Belajar Modul mewarisi efek gelombang piksel dari layout siswa
        $modulView = $this->view('siswa.modul', [
            'moduls' => collect(),
        ]);
        $modulView->assertSee('images/backgorund1.png');
        $modulView->assertSee('images/backgorund3.png');
        $modulView->assertSee('dash-layer dash-bg dash-bg1', false);
        $modulView->assertSee('dash-layer dash-float dash-f1', false);
    }
}
