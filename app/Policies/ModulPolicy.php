<?php

namespace App\Policies;

use App\Models\Modul;
use App\Models\User;

class ModulPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function update(User $user, Modul $modul): bool
    {
        return $user->isAdmin() || $this->milikGuru($user, $modul);
    }

    public function delete(User $user, Modul $modul): bool
    {
        return $this->update($user, $modul);
    }

    private function milikGuru(User $user, Modul $modul): bool
    {
        // Konten lama tanpa pemilik (id_pembuat null) hanya boleh diubah admin.
        return $user->isGuru()
            && $modul->id_pembuat !== null
            && (int) $modul->id_pembuat === (int) $user->id_user;
    }
}
