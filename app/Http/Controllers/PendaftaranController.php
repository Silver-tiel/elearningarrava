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
   $validated = $request->validate(
    [
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

        'nisn' => [
            'required',
            'string',
            'min:10',
            'max:10',
            'regex:/^\d+$/',
            'unique:user,nisn',
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
    ],
    [
        'nama.unique' => 'Nama sudah digunakan. Silakan gunakan nama lain.',
        'nisn.unique' => 'NISN sudah terdaftar. Silakan gunakan NISN lain.',
        'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',

        'nisn.required' => 'NISN wajib diisi.',
        'nisn.min' => 'NISN harus terdiri dari 10 digit.',
        'nisn.max' => 'NISN harus terdiri dari 10 digit.',
        'nisn.regex' => 'NISN hanya boleh berisi angka.',

        'nama.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',

        'password.required' => 'Kata sandi wajib diisi.',
        'password.min' => 'Kata sandi minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

        'id_jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
        'id_jenjang.exists' => 'Jenjang pendidikan yang dipilih tidak valid.',
    ]
);

User::create([
    'nisn' => $validated['nisn'],
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
