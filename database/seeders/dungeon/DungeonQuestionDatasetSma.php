<?php

namespace Database\Seeders\Dungeon;

require_once __DIR__ . '/DungeonQuestionDatasetSmaUmum.php';
require_once __DIR__ . '/DungeonQuestionDatasetSmaPeminatan.php';

class DungeonQuestionDatasetSma
{
    /**
     * Menggabungkan daftar soal dungeon jenjang SMA (11 mapel umum + 6 mapel peminatan = 17 mapel).
     */
    public static function getQuestionsByMapel(): array
    {
        $umum = DungeonQuestionDatasetSmaUmum::getQuestionsByMapel();
        $peminatan = DungeonQuestionDatasetSmaPeminatan::getQuestionsByMapel();

        return $umum + $peminatan;
    }
}
