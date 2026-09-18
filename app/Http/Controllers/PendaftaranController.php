<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controller khusus untuk proses registrasi pengguna baru.
class PendaftaranController extends Controller
{
    // Menampilkan halaman form pendaftaran jika dibutuhkan secara terpisah.
    public function showPendaftaranForm()
    {
        return view('pendaftaran');
    }

    // Menyimpan data user baru ke database setelah validasi berhasil.
    public function UserBaru(Request $request)
    {
        // Validasi data input agar sesuai aturan aplikasi dan database.
        $request->validate([
            'nama' => ['required|string|min:2|max:255|unique:user,nama', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required|email|unique:user,email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'max:255'],
            'password' => 'required|min:8|max:255',
            'id_jenjang' => 'required|exists:jenjang,id_jenjang',
        ]);

        // Simpan akun baru dengan password yang telah di-hash.
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_jenjang' => $request->id_jenjang,
            'id_tipeuser' => 3,
        ]);

        // Redirect ke halaman login setelah registrasi berhasil.
        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
