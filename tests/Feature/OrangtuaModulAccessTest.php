<?php

namespace Tests\Feature;

use App\Models\Modul;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrangtuaModulAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->timestamps();
        });
        Schema::create('orangtua_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_orangtua');
            $table->unsignedInteger('id_siswa');
            $table->timestamps();
        });
        foreach (['jenjang' => 'id_jenjang', 'tipemodul' => 'id_tipemodul'] as $name => $key) {
            Schema::create($name, function (Blueprint $table) use ($key) {
                $table->increments($key);
                $table->string('nama_tipe');
            });
        }
        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_tipemodul')->nullable();
            $table->unsignedInteger('id_quiz')->nullable();
            $table->string('file_materi')->nullable();
            $table->string('tipe_file')->nullable();
            $table->string('progressModul')->nullable();
            $table->timestamps();
        });
        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz');
            $table->boolean('is_lulus')->default(false);
        });
    }

    private function account(int $role, ?int $jenjang = null): User
    {
        return User::create([
            'nama' => 'Pengguna ' . User::count(),
            'email' => 'user' . User::count() . '@example.test',
            'password' => 'password',
            'id_tipeuser' => $role,
            'id_jenjang' => $jenjang,
        ]);
    }

    private function module(int $jenjang = 1, string $status = 'Tersedia'): Modul
    {
        return Modul::create([
            'judul_modul' => 'Materi ' . $status . ' ' . $jenjang,
            'id_jenjang' => $jenjang,
            'progressModul' => $status,
            'file_materi' => 'https://example.test/materi',
            'tipe_file' => 'link',
        ]);
    }

    public function test_parent_can_read_linked_child_module_and_return_to_the_same_child(): void
    {
        $parent = $this->account(4);
        $child = $this->account(3, 1);
        OrangtuaSiswa::create(['id_orangtua' => $parent->id_user, 'id_siswa' => $child->id_user]);
        $module = $this->module();

        $this->actingAs($parent)->get(route('modul.show', ['id' => $module->id_modul, 'siswa_id' => $child->id_user]))
            ->assertOk()
            ->assertSee('Portal Orang Tua')
            ->assertSee('hanya baca.')
            ->assertSee(route('orangtua.materi-pembelajaran', ['siswa_id' => $child->id_user]), false)
            ->assertDontSee('id="btn-selesai"', false);

        $this->get(route('modul.show', $module->id_modul))->assertOk();
    }

    public function test_parent_cannot_read_drafts_other_levels_or_unlinked_children(): void
    {
        $parent = $this->account(4);
        $child = $this->account(3, 1);
        $otherChild = $this->account(3, 1);
        OrangtuaSiswa::create(['id_orangtua' => $parent->id_user, 'id_siswa' => $child->id_user]);
        $this->actingAs($parent);

        $this->get(route('modul.show', $this->module(1, 'Draft')->id_modul))->assertForbidden();
        $this->get(route('modul.show', $this->module(2)->id_modul))->assertForbidden();
        $module = $this->module();
        $this->get(route('modul.show', ['id' => $module->id_modul, 'siswa_id' => $otherChild->id_user]))->assertForbidden();
        $this->actingAs($this->account(4))->get(route('modul.show', $module->id_modul))->assertForbidden();
        $this->app['auth']->guard()->logout();
        $this->get(route('modul.show', $module->id_modul))->assertRedirect(route('login'));
    }

    public function test_parent_list_only_shows_published_modules_for_selected_child(): void
    {
        $parent = $this->account(4);
        $child = $this->account(3, 1);
        OrangtuaSiswa::create(['id_orangtua' => $parent->id_user, 'id_siswa' => $child->id_user]);
        $visible = $this->module();
        $draft = $this->module(1, 'Draft');
        $other = $this->module(2);

        $this->actingAs($parent)->get(route('orangtua.materi-pembelajaran', ['siswa_id' => $child->id_user]))
            ->assertOk()
            ->assertSee($visible->judul_modul)
            ->assertDontSee($draft->judul_modul)
            ->assertDontSee($other->judul_modul)
            ->assertSee(route('modul.show', ['id' => $visible->id_modul, 'siswa_id' => $child->id_user]), false);
    }
}
