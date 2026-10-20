<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || (int) $user->id_tipeuser !== 3 || $user->status_akun !== 'Nonaktif') {
            return $next($request);
        }

        if ($request->is('api/*')) {
            $accessToken = $user->currentAccessToken();
            if ($accessToken && method_exists($accessToken, 'delete')) {
                $accessToken->delete();
            }

            return response()->json([
                'success' => false,
                'message' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.',
            ], 403);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'email' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.',
        ]);
    }
}
