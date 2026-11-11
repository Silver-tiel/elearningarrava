<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalaksiHeroSectionTest extends TestCase
{
    use RefreshDatabase;

    private User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\MasterDataSeeder::class);

        $this->siswa = User::create([
            'nama' => 'Siswa Galaksi',
            'username' => 'siswagalaksi',
            'email' => 'galaksi@example.com',
            'nisn' => '9988776655',
            'password' => bcrypt('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
            'total_poin' => 100,
        ]);
    }

    public function test_galaksi_hero_component_renders_all_space_assets_physics_and_overlay(): void
    {
        $view = $this->blade(
            '<x-galaksi-hero :user="$user" :kuis-lulus="$kuisLulus" :modul-count="$modulCount" :quiz-count="$quizCount" />',
            [
                'user' => $this->siswa,
                'kuisLulus' => 7,
                'modulCount' => 9,
                'quizCount' => 12,
            ]
        );

        $view->assertSee('id="galaksiHeroCard"', false);
        $view->assertSee('assets/widget/cards/herosection/herosection2/BackgroundSpace.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/blue-stars.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/near_stars_twinkle_4frames.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/layer4_celestial.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/prop-planet-big.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/prop-planet-small.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/asteroid-1.webp');
        $view->assertSee('assets/widget/cards/herosection/herosection2/asteroid-2.webp');
        $view->assertSee('data-asset-asteroid-one=', false);
        $view->assertSee('data-asset-asteroid-two=', false);
        $view->assertDontSee('dataset.assetAsteroid1', false);
        $view->assertDontSee('dataset.assetAsteroid2', false);
        $view->assertSee('ROCK_MULTS');
        $view->assertSee('Halo, Siswa Galaksi');
        $view->assertSee('Peringkat &amp; EXP', false);
        $view->assertSee('7 Kuis Selesai');
        $view->assertSee('9 Modul');
        $view->assertSee('Ganti Hero (Samudra)');
    }

    public function test_siswa_dashboard_keeps_samudra_default_and_previews_galaksi_via_query(): void
    {
        $defaultResponse = $this->actingAs($this->siswa)->get(route('siswa.dashboard'));
        $defaultResponse->assertOk();
        $defaultResponse->assertSee('id="samudraHeroCard"', false);
        $defaultResponse->assertDontSee('id="galaksiHeroCard"', false);
        $defaultResponse->assertSee('Ganti Hero (Galaksi)');

        $galaksiResponse = $this->actingAs($this->siswa)->get(route('siswa.dashboard', ['hero' => 'galaksi']));
        $galaksiResponse->assertOk();
        $galaksiResponse->assertSee('id="galaksiHeroCard"', false);
        $galaksiResponse->assertDontSee('id="samudraHeroCard"', false);
        $galaksiResponse->assertSee('assets/widget/cards/herosection/herosection2/BackgroundSpace.webp');

        $niereView = $this->blade('<x-niere-widget />');
        $niereView->assertSee('#samudraHeroCard, #galaksiHeroCard', false);
    }

    public function test_siswa_can_switch_hero_section_from_profile_page_and_persist_choice(): void
    {
        $profilResponse = $this->actingAs($this->siswa)->get(route('siswa.profil'));
        $profilResponse->assertOk();
        $profilResponse->assertSee('Tema Hero Dashboard');
        $profilResponse->assertSee('id="hero-theme-carousel-track"', false);
        $profilResponse->assertSee('id="hero-carousel-prev"', false);
        $profilResponse->assertSee('id="hero-carousel-next"', false);
        $profilResponse->assertSee('Samudra Piksel');
        $profilResponse->assertSee('Galaksi Piksel');
        $profilResponse->assertSee('Ganti Hero ke Galaksi');

        $switchResponse = $this->actingAs($this->siswa)
            ->patch(route('siswa.profil.hero_theme'), [
                'hero_theme' => 'galaksi',
                'redirect_to' => 'profil',
            ]);

        $switchResponse->assertRedirect(route('siswa.profil'));
        $switchResponse->assertSessionHas('success', 'Tema hero dashboard berhasil diganti ke Galaksi Piksel.');
        $this->assertSame('galaksi', $this->siswa->fresh()->hero_theme);

        // Setelah diganti di profil, dashboard otomatis memakai hero Galaksi Piksel
        $dashboardAfter = $this->actingAs($this->siswa->fresh())->get(route('siswa.dashboard'));
        $dashboardAfter->assertOk();
        $dashboardAfter->assertSee('id="galaksiHeroCard"', false);
        $dashboardAfter->assertDontSee('id="samudraHeroCard"', false);

        // Kembalikan ke Samudra lewat tombol pengalih pada hero dashboard
        $switchBackResponse = $this->actingAs($this->siswa->fresh())
            ->patch(route('siswa.profil.hero_theme'), [
                'hero_theme' => 'samudra',
                'redirect_to' => 'dashboard',
            ]);

        $switchBackResponse->assertRedirect(route('siswa.dashboard'));
        $this->assertSame('samudra', $this->siswa->fresh()->hero_theme);
    }

    public function test_invalid_hero_theme_is_rejected(): void
    {
        $response = $this->actingAs($this->siswa)
            ->from(route('siswa.profil'))
            ->patch(route('siswa.profil.hero_theme'), [
                'hero_theme' => 'tema-tidak-valid',
            ]);

        $response->assertRedirect(route('siswa.profil'));
        $response->assertSessionHasErrors('hero_theme');
        $this->assertSame('samudra', $this->siswa->fresh()->hero_theme);
    }
}
