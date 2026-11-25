<?php

namespace App\Policies;

use App\Models\AttendanceSession;
use App\Models\User;

/** Sesi absensi mentor: dikelola penuh oleh admin; mentor/guru hanya boleh check-in. */
class AttendanceSessionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /** Melihat QR (dan token) sesi. */
    public function view(User $user, AttendanceSession $session): bool
    {
        return $user->isAdmin();
    }

    public function report(User $user, AttendanceSession $session): bool
    {
        return $user->isAdmin();
    }

    public function close(User $user, AttendanceSession $session): bool
    {
        return $user->isAdmin();
    }

    /** Check-in: hanya mentor/guru. Dipanggil dengan nama class (tanpa instance sesi). */
    public function checkIn(User $user): bool
    {
        return $user->isGuru();
    }
}
