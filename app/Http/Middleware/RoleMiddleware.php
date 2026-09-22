<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Peta nama role ke id_tipeuser di database.
     * 1 = admin, 2 = guru, 3 = siswa
     */
    private const ROLE_MAP = [
        'admin' => 1,
        'guru'  => 2,
        'siswa' => 3,
    ];

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Konversi nama role ('siswa','admin','guru') ke id angka
        $allowedIds = array_map(
            fn($role) => self::ROLE_MAP[$role] ?? null,
            $roles
        );

        if (!in_array((int) $user->id_tipeuser, $allowedIds, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}