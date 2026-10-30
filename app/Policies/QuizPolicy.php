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
        return $user->isAdmin()
            || ($user->isGuru()
                && $quiz->id_pembuat !== null
                && (int) $quiz->id_pembuat === (int) $user->id_user);
    }

    public function delete(User $user, Quiz $quiz): bool
    {
        return $this->update($user, $quiz);
    }
}
