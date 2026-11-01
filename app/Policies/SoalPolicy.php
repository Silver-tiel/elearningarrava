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

        $quiz = $soal->quiz;

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
