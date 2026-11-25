<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;

class DungeonBankPolicy
{
    /**
     * Menentukan apakah user dapat melihat bank soal Dungeon.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    /**
     * Menentukan apakah user dapat menambahkan soal ke kuis Dungeon tertentu.
     */
    public function addSoal(User $user, Quiz $quiz): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru() && $quiz->isDungeon()) {
            return true;
        }

        return false;
    }

    /**
     * Menentukan apakah user dapat memperbarui soal Dungeon.
     * Admin dapat memperbarui semua soal; Guru hanya dapat memperbarui soal buatannya sendiri.
     */
    public function update(User $user, Soal $soal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if (!$user->isGuru()) {
            return false;
        }

        $quiz = $soal->relationLoaded('quiz') ? $soal->quiz : Quiz::find($soal->id_quiz);
        if ($quiz instanceof Quiz && $quiz->isDungeon()) {
            return $soal->id_penulis !== null && (int) $soal->id_penulis === (int) $user->id_user;
        }

        return false;
    }

    /**
     * Menentukan apakah user dapat menghapus soal Dungeon.
     */
    public function delete(User $user, Soal $soal): bool
    {
        return $this->update($user, $soal);
    }

    /**
     * Menentukan apakah user dapat mengaktifkan/menonaktifkan soal Dungeon.
     */
    public function toggleAktif(User $user, Soal $soal): bool
    {
        return $this->update($user, $soal);
    }
}
