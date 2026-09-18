<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    public function showPendaftaranForm()
    {
        return view('pendaftaran');
    }

    public function UserBaru(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:user,nama',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8',
            'id_jenjang' => 'required|exists:jenjang,id_jenjang',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_jenjang' => $request->id_jenjang,
            'id_tipeuser' => 3,
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
