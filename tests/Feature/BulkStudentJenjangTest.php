<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BulkStudentJenjangTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->default(3);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('status_akun')->nullable();
            $table->timestamps();
        });

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
            $table->timestamps();
        });

        DB::table('jenjang')->insert([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD'],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP'],
        ]);
    }

    public function test_admin_can_update_only_selected_student_accounts(): void
    {
        $selectedStudent = $this->createUser('Siswa Dipilih', 3, 1);
        $otherStudent = $this->createUser('Siswa Lain', 3, 1);
        $admin = $this->createUser('Admin', 1, 1);

        $this->post(route('admin.siswa.jenjang.massal'), [
            'id_jenjang' => 2,
            'all_filtered' => '0',
            'student_ids' => [$selectedStudent->id_user],
        ])->assertRedirect(route('admin.daftar_siswa'))
            ->assertSessionHas('success');

        $this->assertSame(2, (int) $selectedStudent->fresh()->id_jenjang);
        $this->assertSame(1, (int) $otherStudent->fresh()->id_jenjang);
        $this->assertSame(1, (int) $admin->fresh()->id_jenjang);
    }

    public function test_admin_can_update_all_students_matching_current_filters(): void
    {
        $matchingStudent = $this->createUser('Siswa SD Aktif', 3, 1, 'Aktif');
        $otherGradeStudent = $this->createUser('Siswa SMP Aktif', 3, 2, 'Aktif');
        $inactiveStudent = $this->createUser('Siswa SD Nonaktif', 3, 1, 'Nonaktif');

        $this->post(route('admin.siswa.jenjang.massal'), [
            'id_jenjang' => 2,
            'all_filtered' => '1',
            'kelas' => 'SD',
            'status' => 'Aktif',
        ])->assertRedirect(route('admin.daftar_siswa', ['kelas' => 'SD', 'status' => 'Aktif']))
            ->assertSessionHas('success');

        $this->assertSame(2, (int) $matchingStudent->fresh()->id_jenjang);
        $this->assertSame(2, (int) $otherGradeStudent->fresh()->id_jenjang);
        $this->assertSame(1, (int) $inactiveStudent->fresh()->id_jenjang);
    }

    private function createUser(string $name, int $type, ?int $jenjang, ?string $status = 'Aktif'): User
    {
        return User::create([
            'nama' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)) . '@example.test',
            'password' => bcrypt('password'),
            'id_tipeuser' => $type,
            'id_jenjang' => $jenjang,
            'status_akun' => $status,
        ]);
    }
}
