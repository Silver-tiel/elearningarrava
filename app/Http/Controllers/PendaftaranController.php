<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

// Controller khusus untuk proses registrasi pengguna baru.
class PendaftaranController extends Controller
{
    // Menampilkan halaman form pendaftaran.
    public function showPendaftaranForm()
    {
        $jenjang = Jenjang::all();
        return view('pendaftaran', ['jenjang' => $jenjang]);
    }

    // Menyimpan data siswa & akun orang tua ke database setelah validasi berhasil.
    public function UserBaru(Request $request)
    {
        // Kompatibilitas fallback: jika input dikirim dengan nama nomor_hp, sinkronkan ke nomor_handphone
        if (!$request->has('nomor_handphone') && $request->has('nomor_hp')) {
            $request->merge(['nomor_handphone' => $request->input('nomor_hp')]);
        }

        $validated = $request->validate(
            [
                // Data Siswa (Langkah 1)
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
                    'required',
                    'string',
                    'min:10',
                    'max:20',
                    'regex:/^[0-9+\-\s]+$/',
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

                // Data Orang Tua / Wali (Langkah 2 - Opsional jika pendaftaran tanpa orang tua)
                'nama_orangtua' => [
                    'nullable',
                    'required_with:email_orangtua',
                    'string',
                    'min:2',
                    'max:255',
                ],

                'email_orangtua' => [
                    'nullable',
                    'required_with:nama_orangtua',
                    'email',
                    'different:email',
                    'max:255',
                ],

                'nomor_hp_orangtua' => [
                    'nullable',
                    'required_with:nama_orangtua',
                    'string',
                    'min:10',
                    'max:20',
                    'regex:/^[0-9+\-\s]+$/',
                ],

                'password_orangtua' => [
                    'nullable',
                    'string',
                    'min:8',
                    'max:255',
                ],
            ],
            [
                // Pesan validasi Siswa
                'nama.required' => 'Nama lengkap siswa wajib diisi.',
                'nama.unique' => 'Nama siswa sudah terdaftar. Silakan gunakan nama lain.',
                'nama.regex' => 'Nama siswa hanya boleh berisi huruf dan spasi.',
                'email.required' => 'Alamat email siswa wajib diisi.',
                'email.email' => 'Format alamat email siswa tidak valid.',
                'email.unique' => 'Email siswa sudah terdaftar. Silakan gunakan email lain.',

                'nisn.required' => 'NISN wajib diisi.',
                'nisn.min' => 'NISN harus terdiri dari 10 digit.',
                'nisn.max' => 'NISN harus terdiri dari 10 digit.',
                'nisn.regex' => 'NISN hanya boleh berisi angka.',
                'nisn.unique' => 'NISN sudah terdaftar. Silakan gunakan NISN lain.',

                'nomor_handphone.required' => 'Nomor handphone siswa wajib diisi.',
                'nomor_handphone.min' => 'Nomor handphone siswa minimal 10 digit/karakter.',
                'nomor_handphone.max' => 'Nomor handphone siswa maksimal 20 digit/karakter.',
                'nomor_handphone.regex' => 'Format nomor handphone siswa tidak valid.',

                'password.required' => 'Kata sandi siswa wajib diisi.',
                'password.min' => 'Kata sandi minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

                'id_jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
                'id_jenjang.exists' => 'Jenjang pendidikan yang dipilih tidak valid.',

                // Pesan validasi Orang Tua
                'nama_orangtua.required' => 'Nama lengkap orang tua / wali wajib diisi.',
                'email_orangtua.required' => 'Alamat email orang tua wajib diisi.',
                'email_orangtua.email' => 'Format email orang tua tidak valid.',
                'email_orangtua.different' => 'Email orang tua tidak boleh sama dengan email siswa.',

                'nomor_hp_orangtua.required' => 'Nomor handphone orang tua wajib diisi.',
                'nomor_hp_orangtua.min' => 'Nomor handphone orang tua minimal 10 digit/karakter.',
                'nomor_hp_orangtua.max' => 'Nomor handphone orang tua maksimal 20 digit/karakter.',
                'nomor_hp_orangtua.regex' => 'Format nomor handphone orang tua tidak valid.',

                'password_orangtua.min' => 'Kata sandi orang tua minimal 8 karakter.',
            ]
        );

        $adaOrangtua = false;

        DB::transaction(function () use ($validated, &$adaOrangtua) {
            // 1. Simpan Akun Siswa (id_tipeuser = 3)
            $siswaData = [
                'nisn' => $validated['nisn'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nomor_hp' => $validated['nomor_handphone'],
                'password' => Hash::make($validated['password']),
                'id_jenjang' => $validated['id_jenjang'],
                'id_tipeuser' => 3, // Siswa
            ];
            if (Schema::hasColumn('user', 'status_akun')) {
                $siswaData['status_akun'] = 'Aktif';
            }
            if (Schema::hasColumn('user', 'total_poin')) {
                $siswaData['total_poin'] = 0;
            }

            $siswa = User::create($siswaData);

            // 2. Hubungkan atau Buat Akun Orang Tua jika data orang tua diisi
            if (!empty($validated['nama_orangtua']) && !empty($validated['email_orangtua'])) {
                $adaOrangtua = true;
                $parentPassword = !empty($validated['password_orangtua'])
                    ? $validated['password_orangtua']
                    : $validated['password'];

                $orangtua = User::where('email', $validated['email_orangtua'])->first();

                if ($orangtua) {
                    // Jika akun sudah ada, pastikan akun tersebut bertipe orang tua
                    if ((int) $orangtua->id_tipeuser !== 4) {
                        throw ValidationException::withMessages([
                            'email_orangtua' => 'Email ini sudah terdaftar sebagai akun siswa/guru. Gunakan email lain untuk orang tua.',
                        ]);
                    }
                } else {
                    // Buat akun orang tua baru dengan NISN virtual unik (format OT-XXXX)
                    $nisnOt = 'OT-' . strtoupper(Str::random(8));
                    while (User::where('nisn', $nisnOt)->exists()) {
                        $nisnOt = 'OT-' . strtoupper(Str::random(8));
                    }

                    $orangtuaData = [
                        'nama' => $validated['nama_orangtua'],
                        'email' => $validated['email_orangtua'],
                        'nisn' => $nisnOt,
                        'nomor_hp' => $validated['nomor_hp_orangtua'] ?? null,
                        'password' => Hash::make($parentPassword),
                        'id_jenjang' => $validated['id_jenjang'],
                        'id_tipeuser' => 4, // Orang Tua
                    ];
                    if (Schema::hasColumn('user', 'status_akun')) {
                        $orangtuaData['status_akun'] = 'Aktif';
                    }
                    if (Schema::hasColumn('user', 'total_poin')) {
                        $orangtuaData['total_poin'] = 0;
                    }

                    $orangtua = User::create($orangtuaData);
                }

                // 3. Hubungkan relasi di tabel orangtua_siswa
                if (Schema::hasTable('orangtua_siswa')) {
                    OrangtuaSiswa::firstOrCreate([
                        'id_orangtua' => $orangtua->id_user,
                        'id_siswa' => $siswa->id_user,
                    ]);
                }
            }
        });

        $pesanSukses = $adaOrangtua
            ? 'Pendaftaran berhasil! Akun Siswa dan Akun Orang Tua telah aktif. Silakan login.'
            : 'Pendaftaran berhasil! Akun Siswa Anda telah aktif. Silakan login.';

        return redirect('/login')
            ->with('success', $pesanSukses);
    }
}
