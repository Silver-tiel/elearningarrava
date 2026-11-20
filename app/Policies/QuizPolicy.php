<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    /** Dipakai juga untuk pratinjau dan pengelolaan soal di dalam quiz. */
    public function update(User $user, Quiz $quiz): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru()) {
            // Guru boleh mengelola dan menambahkan soal ke kuis Dungeon
            if ($quiz->isDungeon()) {
                return true;
            }
            return $quiz->id_pembuat !== null && (int) $quiz->id_pembuat === (int) $user->id_user;
        }

        return false;
    }

    public function delete(User $user, Quiz $quiz): bool
    {
        // Kuis dungeon adalah milik sistem dan tidak boleh dihapus
        if ($quiz->isDungeon()) {
            return false;
        }

        return $this->update($user, $quiz);
    }

    /** Guru dan admin boleh menambahkan soal ke kuis Dungeon atau kuis miliknya sendiri */
    public function addSoal(User $user, Quiz $quiz): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($quiz->isDungeon()) {
            return $user->isGuru();
        }

        return $this->update($user, $quiz);
    }
}
