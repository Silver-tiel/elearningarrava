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
    $validated = $request->validate([
        'nama' => [
            'required',
            'string',
            'min:2',
            'max:255',
            'unique:user,nama',
            'regex:/^[a-zA-Z\s]+$/',
        ],

        'email' => [
            'required',
            'email',
            'unique:user,email',
            'max:255',
        ],

        'nomor_handphone' => [
            'nullable',
            'string',
            'max:20',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'max:255',
            'confirmed',
        ],

        'id_jenjang' => [
            'required',
            'exists:jenjang,id_jenjang',
        ],
    ]);

    User::create([
        'nama' => $validated['nama'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'id_jenjang' => $validated['id_jenjang'],
        'id_tipeuser' => 3,
    ]);

    return redirect('/login')
        ->with('success', 'Pendaftaran berhasil! Silakan login.');
}
}
