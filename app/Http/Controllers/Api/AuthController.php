<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login Flutter
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::with(['tipeUser', 'jenjang'])
            ->where('email', $validated['email'])
            ->first();

        if (!$user || !Hash::check(
            $validated['password'],
            $user->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Hapus token lama jika ingin satu sesi per perangkat.
        $user->tokens()->delete();

        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',

            'token' => $token,

            'user' => [
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'email' => $user->email,
                'nisn' => $user->nisn,
                'id_tipeuser' => $user->id_tipeuser,
                'id_jenjang' => $user->id_jenjang,
                'status_akun' => $user->status_akun,
                'foto_profil' => $user->foto_profil,
            ],
        ]);
    }

    /**
     * Data user yang sedang login.
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'user' => [
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'email' => $user->email,
                'nisn' => $user->nisn,
                'id_tipeuser' => $user->id_tipeuser,
                'id_jenjang' => $user->id_jenjang,
                'status_akun' => $user->status_akun,
                'foto_profil' => $user->foto_profil,
            ],
        ]);
    }

    /**
     * Logout Flutter.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }
}