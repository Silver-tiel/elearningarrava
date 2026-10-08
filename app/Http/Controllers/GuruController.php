<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Tampilkan profil guru yang sedang login.
     */
    public function profil()
    {
        $user = Auth::user();

        return view('admin.guru.profil', compact('user'));
    }

    public function index()
    {
        $gurus = Guru::latest()->get();

        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s.,]+$/',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:guru,nik',
            ],

            'no_telepon' => [
                'required',
                'digits_between:10,13',
            ],
        ], [
            'nama.required' => 'Nama guru wajib diisi.',
            'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nama.max' => 'Nama guru maksimal 100 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK tersebut sudah terdaftar.',

            'no_telepon.required' => 'No. telepon wajib diisi.',
            'no_telepon.digits_between' => 'No. telepon harus berupa angka 10 sampai 13 digit.',
        ]);

        Guru::create($validated);

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s.,]+$/',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:guru,nik,' . $guru->id_guru . ',id_guru',
            ],

            'no_telepon' => [
                'required',
                'digits_between:10,13',
            ],
        ], [
            'nama.required' => 'Nama guru wajib diisi.',
            'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nama.max' => 'Nama guru maksimal 100 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK tersebut sudah terdaftar.',

            'no_telepon.required' => 'No. telepon wajib diisi.',
            'no_telepon.digits_between' => 'No. telepon harus berupa angka 10 sampai 13 digit.',
        ]);

        $guru->update($validated);

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        $guru->delete();

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
