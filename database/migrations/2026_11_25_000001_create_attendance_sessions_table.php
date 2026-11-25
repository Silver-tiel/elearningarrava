<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // Token acak 64 karakter (Str::random). Unik; ditampilkan hanya kepada admin.
            $table->string('token', 64)->unique();
            // Tabel pengguna proyek ini bernama `user` dengan PK `id_user` (unsigned int),
            // sehingga FK memakai unsignedInteger, bukan foreignId().
            $table->unsignedInteger('created_by');
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->unsignedSmallInteger('late_after_minutes')->nullable();
            $table->enum('status', ['active', 'closed', 'expired'])->default('active');
            $table->timestamps();

            $table->index(['status', 'expires_at']);
            $table->foreign('created_by')->references('id_user')->on('user')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
