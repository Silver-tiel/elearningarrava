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

            // Redirect ke halaman yang dituju setelah login berhasil.
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, tampilkan pesan error dan tetap mempertahankan input email.
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    //Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session & regenerate CSRF token demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login
        return redirect()->route('login');
    }
}
