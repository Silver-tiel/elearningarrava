<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $gurus = Guru::with('user')->latest()->get();

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
                'unique:user,nisn',
            ],

            'no_telepon' => [
                'required',
                'digits_between:10,13',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:user,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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

            'email.required' => 'Email login guru wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',

            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto-guru', 'public');
        }

        DB::transaction(function () use ($validated, $fotoPath) {
            // 1. Simpan data guru ke tabel guru
            Guru::create([
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'no_telepon' => $validated['no_telepon'],
                'foto' => $fotoPath,
            ]);

            // 2. Buat akun login guru ke tabel user (id_tipeuser = 2)
            User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nisn' => $validated['nik'], // NIK 16 digit dijadikan identitas unik pada akun user
                'nomor_hp' => $validated['no_telepon'],
                'foto_profil' => $fotoPath,
                'id_tipeuser' => 2, // 2 = Role Guru
                'status_akun' => 'Aktif',
                'total_poin' => 0,
            ]);
        });

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru, foto profil, dan akun login berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $user = $guru->user ?: User::where('nisn', $guru->nik)->first();

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
                $user ? 'unique:user,nisn,' . $user->id_user . ',id_user' : 'unique:user,nisn',
            ],

            'no_telepon' => [
                'required',
                'digits_between:10,13',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                $user ? 'unique:user,email,' . $user->id_user . ',id_user' : 'unique:user,email',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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

            'email.required' => 'Email login guru wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',

            'password.min' => 'Password baru minimal 6 karakter.',

            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = $guru->foto ?: $user?->foto_profil;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('foto-guru', 'public');
        }

        DB::transaction(function () use ($guru, $user, $validated, $fotoPath) {
            // 1. Update data guru
            $guru->update([
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'no_telepon' => $validated['no_telepon'],
                'foto' => $fotoPath,
            ]);

            // 2. Update atau buat akun user jika belum ada
            if ($user) {
                $userData = [
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'nisn' => $validated['nik'],
                    'nomor_hp' => $validated['no_telepon'],
                    'foto_profil' => $fotoPath,
                ];
                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }
                $user->update($userData);
            } else {
                User::create([
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'] ?: 'password123'),
                    'nisn' => $validated['nik'],
                    'nomor_hp' => $validated['no_telepon'],
                    'foto_profil' => $fotoPath,
                    'id_tipeuser' => 2,
                    'status_akun' => 'Aktif',
                    'total_poin' => 0,
                ]);
            }
        });

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru, foto, dan akun login berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        DB::transaction(function () use ($guru) {
            // Hapus file foto dari storage
            $fotoPath = $guru->foto ?: $guru->user?->foto_profil;
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            // Hapus juga akun user login terkait
            if ($guru->user) {
                $guru->user->delete();
            } else {
                User::where('nisn', $guru->nik)->where('id_tipeuser', 2)->delete();
            }

            $guru->delete();
        });

        return redirect()
            ->route('admin.guru')
            ->with('success', 'Data guru dan akun login berhasil dihapus.');
    }
}
