<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InactiveStudentAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->default(3);
            $table->string('status_akun')->nullable();
            $table->timestamps();
        });
    }

    public function test_inactive_student_cannot_log_in_through_web_or_api(): void
    {
        $student = $this->createStudent('Nonaktif');

        $this->from(route('login'))->post(route('login.submit'), [
            'email' => $student->email,
            'password' => 'password123',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();

        $this->postJson('/api/login', [
            'email' => $student->email,
            'password' => 'password123',
        ])
            ->assertForbidden()
            ->assertJsonPath('success', false);
    }

    public function test_inactive_student_is_logged_out_when_status_changes_during_session(): void
    {
        $student = $this->createStudent('Aktif');

        $this->actingAs($student);
        $student->status_akun = 'Nonaktif';
        $student->save();

        $this->get(route('siswa.profil'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_active_student_can_still_log_in(): void
    {
        $student = $this->createStudent('Aktif');

        $this->post(route('login.submit'), [
            'email' => $student->email,
            'password' => 'password123',
        ])->assertRedirect('/siswa/dashboard');
    }

    private function createStudent(string $status): User
    {
        return User::create([
            'nama' => 'Siswa Tes',
            'email' => uniqid('siswa-', true) . '@example.com',
            'password' => Hash::make('password123'),
            'id_tipeuser' => 3,
            'status_akun' => $status,
        ]);
    }
}
