<?php

namespace App\Policies;

use App\Models\Soal;
use App\Models\User;

/** Soal mengikuti kepemilikan quiz induknya. */
class SoalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function update(User $user, Soal $soal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Bank Soal standalone (tanpa quiz)
        if ($soal->id_quiz === null) {
            return $user->isGuru()
                && $soal->id_penulis !== null
                && (int) $soal->id_penulis === (int) $user->id_user;
        }

        $quiz = $soal->relationLoaded('quiz') ? $soal->quiz : \App\Models\Quiz::find($soal->id_quiz);

        if ($quiz && $quiz->isDungeon()) {
            return $user->isGuru()
                && $soal->id_penulis !== null
                && (int) $soal->id_penulis === (int) $user->id_user;
        }

        return $user->isGuru()
            && $quiz !== null
            && $quiz->id_pembuat !== null
            && (int) $quiz->id_pembuat === (int) $user->id_user;
    }

    public function delete(User $user, Soal $soal): bool
    {
        return $this->update($user, $soal);
    }
}
