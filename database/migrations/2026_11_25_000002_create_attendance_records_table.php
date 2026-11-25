<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->cascadeOnDelete();
            $table->unsignedInteger('user_id');
            $table->dateTime('checked_in_at');
            $table->enum('status', ['hadir', 'terlambat']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Satu mentor hanya boleh satu kali check-in per sesi (pagar terakhir di level database).
            $table->unique(['attendance_session_id', 'user_id']);
            $table->foreign('user_id')->references('id_user')->on('user')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
