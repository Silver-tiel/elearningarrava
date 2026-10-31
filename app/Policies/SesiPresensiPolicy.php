<?php

namespace App\Policies;

use App\Models\Kelas;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SesiPresensiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    /** Membuat sesi untuk sebuah kelas: admin bebas, guru hanya kelas yang ia ampu. */
    public function create(User $user, Kelas $kelas): bool
    {
        return $user->isAdmin() || $this->mengampu($user, (int) $kelas->id_kelas);
    }

    public function view(User $user, SesiPresensi $sesi): bool
    {
        return $user->isAdmin() || $this->mengampu($user, (int) $sesi->id_kelas);
    }

    /** Memindai siswa pada sesi ini (anti-IDOR: guru hanya pada kelas yang ia ampu). */
    public function scan(User $user, SesiPresensi $sesi): bool
    {
        return $this->view($user, $sesi);
    }

    public function tutup(User $user, SesiPresensi $sesi): bool
    {
        return $this->view($user, $sesi);
    }

    private function mengampu(User $user, int $idKelas): bool
    {
        return $user->isGuru()
            && DB::table('kelas_guru')
                ->where('id_guru', $user->id_user)
                ->where('id_kelas', $idKelas)
                ->exists();
    }
}
