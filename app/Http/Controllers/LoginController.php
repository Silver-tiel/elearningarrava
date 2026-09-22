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

            // Jika tipe akun admin (1) atau guru (2), arahkan langsung ke halaman admin
            if ($user && ($user->id_tipeuser == 1 || $user->id_tipeuser == 2)) {
                return redirect()->intended('/admin');
            }

            // Redirect ke halaman dashboard untuk siswa/user biasa.
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, tampilkan pesan error dan tetap mempertahankan input email.
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
}
