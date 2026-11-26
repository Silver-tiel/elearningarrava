<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return Auth::check() ? redirect('/dashboard') : view('login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'redirect' => url('/dashboard')]);
            }

            return redirect('/dashboard');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $guard = Auth::guard('web');
        if (!$guard->validate($credentials)) {
            return $this->loginError($request, 'Email atau password salah.', 422);
        }

        $user = $guard->getLastAttempted();
        if ((int) $user->id_tipeuser === 3 && $user->status_akun === 'Nonaktif') {
            return $this->loginError($request, 'Akun Anda dinonaktifkan. Silakan hubungi administrator.', 403);
        }

        $guard->setRememberDuration(30 * 24 * 60)->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $dashboard = $this->dashboard($user);
        if ($request->expectsJson() || $request->ajax()) {
            $intended = $request->session()->pull('url.intended');
            if (is_string($intended) && parse_url($intended, PHP_URL_PATH) === '/attendance/check-in') {
                $dashboard = $intended;
            }

            return response()->json(['success' => true, 'name' => $user->nama, 'redirect' => url($dashboard)]);
        }

        return redirect()->intended($dashboard);
    }

    private function dashboard(User $user): string
    {
        return match ((int) $user->id_tipeuser) {
            1, 2 => '/admin',
            4 => '/orangtua/dashboard',
            default => '/siswa/dashboard',
        };
    }

    private function loginError(Request $request, string $message, int $status)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => $message], $status);
        }

        return back()->withErrors(['email' => $message])->onlyInput('email');
    }
}
