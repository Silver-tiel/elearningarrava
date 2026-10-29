<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller khusus untuk menangani proses autentikasi pengguna.
class LoginController extends Controller
{
    // Menampilkan halaman form login kepada user.
    public function showLoginForm()
    {
        return view('login');
    }

    // Memvalidasi kredensial user lalu login jika data benar.
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi dengan email dan password yang dimasukkan.
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user && (int) $user->id_tipeuser === 3 && $user->status_akun === 'Nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.'
                    ], 403);
                }

                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }

            // Tentukan tujuan redirect berdasarkan tipe akun
            $redirectUrl = '/siswa/dashboard';
            if ($user && ($user->id_tipeuser == 1 || $user->id_tipeuser == 2)) {
                $redirectUrl = '/admin';
            } elseif ($user && $user->id_tipeuser == 4) {
                $redirectUrl = '/orangtua/dashboard';
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'name' => $user->nama ?? 'Siswa',
                    'redirect' => url($redirectUrl),
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 422);
        }

        // Jika gagal, tampilkan pesan error dan tetap mempertahankan input email.
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}
