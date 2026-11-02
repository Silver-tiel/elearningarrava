<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PendaftaranFormTest extends TestCase
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
            $table->string('nama')->unique();
            $table->string('email')->unique();
            $table->string('nisn')->nullable()->unique();
            $table->string('nomor_hp')->nullable();
            $table->string('password');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_tipeuser');
            $table->char('qr_token', 36)->nullable()->unique();
            $table->timestamp('qr_dibuat_pada')->nullable();
            $table->timestamps();
        });

        DB::table('jenjang')->insert(['nama_tipe' => 'SD']);
    }

    private function dataValid(array $ubah = []): array
    {
        return array_merge([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nisn' => '1234567890',
            'nomor_handphone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'id_jenjang' => 1,
        ], $ubah);
    }

    public function test_nama_kolom_di_formulir_sama_dengan_yang_divalidasi_controller(): void
    {
        $html = $this->get('/pendaftaran')->assertOk()->getContent();

        foreach (array_keys($this->dataValid()) as $field) {
            $this->assertStringContainsString(
                'name="' . $field . '"',
                $html,
                "Formulir pendaftaran tidak punya kolom bernama '{$field}'."
            );
        }
    }

    public function test_pendaftaran_siswa_berhasil_dan_langsung_punya_token_qr(): void
    {
        $this->post('/pendaftaran', $this->dataValid())
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');

        $siswa = User::where('email', 'budi@example.com')->firstOrFail();

        $this->assertSame(3, (int) $siswa->id_tipeuser);
        $this->assertSame('081234567890', $siswa->nomor_hp);
        $this->assertNotEmpty($siswa->qr_token);
        $this->assertSame(36, strlen($siswa->qr_token));
        $this->assertNotNull($siswa->qr_dibuat_pada);
    }

    public function test_nomor_handphone_kosong_ditolak(): void
    {
        $this->from('/pendaftaran')
            ->post('/pendaftaran', $this->dataValid(['nomor_handphone' => '']))
            ->assertSessionHasErrors('nomor_handphone');

        $this->assertSame(0, User::count());
    }
}
