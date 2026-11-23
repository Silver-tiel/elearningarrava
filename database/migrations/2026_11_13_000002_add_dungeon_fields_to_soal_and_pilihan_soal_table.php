<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Kolom aditif pada tabel soal
        Schema::table('soal', function (Blueprint $table) {
            $table->string('tingkat_soal')->nullable()->after('id_jenis_soal'); // mudah, sedang, sulit
            $table->unsignedInteger('id_penulis')->nullable()->after('tingkat_soal');
            $table->boolean('aktif')->default(true)->after('id_penulis');
            $table->text('nonaktif_alasan')->nullable()->after('aktif');

            if (Schema::hasTable('user')) {
                $table->foreign('id_penulis')->references('id_user')->on('user')->nullOnDelete();
            }
        });

        // 2. Kolom aditif pada tabel pilihan_soal
        Schema::table('pilihan_soal', function (Blueprint $table) {
            $table->boolean('tetap_di_bawah')->default(false)->after('is_correct');
        });

        // 3. Masukkan tipe 'Dungeon' ke tabel tipequiz jika belum ada
        if (Schema::hasTable('tipequiz')) {
            $exists = DB::table('tipequiz')->where('nama_tipe', 'Dungeon')->exists();
            if (!$exists) {
                $maxId = DB::table('tipequiz')->max('id_tipequiz') ?? 2;
                $targetId = max(3, (int) $maxId + 1);
                DB::table('tipequiz')->insert([
                    'id_tipequiz' => $targetId,
                    'nama_tipe' => 'Dungeon',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('pilihan_soal', function (Blueprint $table) {
            $table->dropColumn('tetap_di_bawah');
        });

        Schema::table('soal', function (Blueprint $table) {
            if (Schema::hasTable('user')) {
                $table->dropForeign(['id_penulis']);
            }
            $table->dropColumn(['tingkat_soal', 'id_penulis', 'aktif', 'nonaktif_alasan']);
        });

        if (Schema::hasTable('tipequiz')) {
            DB::table('tipequiz')->where('nama_tipe', 'Dungeon')->delete();
        }
    }
};
