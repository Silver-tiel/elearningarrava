<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\LogAktivitas;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use App\Services\RegistrationOtp;
use Illuminate\Database\UniqueConstraintViolationException;
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

    public function UserBaru(Request $request, RegistrationOtp $otp)
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

        $this->validateParentAccount($validated);
        $validated['password'] = Hash::make($validated['password']);
        $validated['password_orangtua'] = empty($validated['password_orangtua'])
            ? $validated['password']
            : Hash::make($validated['password_orangtua']);

        $request->session()->put('registration', [
            'data' => $validated,
            'otp' => $otp->send($validated['email'], 'email'),
            'expires_at' => now()->addMinutes(30)->timestamp,
        ]);

        return redirect()->route('pendaftaran.otp');
    }

    public function showOtp(Request $request)
    {
        $pending = $this->pendingRegistration($request);
        if (!$pending) {
            return $this->expiredRegistration();
        }

        return response()->view('pendaftaran-otp', [
            'email' => $pending['data']['email'],
            'resendIn' => max(0, $pending['otp']['resend_at'] - now()->timestamp),
        ])->header('Cache-Control', 'no-store, private');
    }

    public function resendOtp(Request $request, RegistrationOtp $otp)
    {
        $pending = $this->pendingRegistration($request);
        if (!$pending) {
            return $this->expiredRegistration();
        }

        if ($pending['otp']['resend_at'] > now()->timestamp) {
            return redirect()->route('pendaftaran.otp')->withErrors(['resend' => 'Tunggu hingga hitung mundur selesai.']);
        }

        // Pertahankan kode lama jika pengiriman gagal, tetapi tetap hormati jeda percobaan kirim.
        $request->session()->put('registration.otp.resend_at', now()->timestamp + RegistrationOtp::COOLDOWN);
        $pending['otp'] = $otp->send($pending['data']['email'], 'resend', $pending['otp']);
        $request->session()->put('registration', $pending);

        return redirect()->route('pendaftaran.otp')->with('status', 'Kode baru sudah dikirim.');
    }

    public function verifyOtp(Request $request, RegistrationOtp $otp)
    {
        $pending = $this->pendingRegistration($request);
        if (!$pending) {
            return $this->expiredRegistration();
        }

        $code = $request->validate(['code' => ['required', 'string', 'digits:6']], [
            'code.required' => 'Masukkan kode OTP.',
            'code.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ])['code'];

        $challenge = $pending['otp'];
        if ($challenge['expires_at'] <= now()->timestamp || $challenge['attempts'] >= 5) {
            return redirect()->route('pendaftaran.otp')->withErrors(['code' => 'Kode kedaluwarsa atau batas percobaan tercapai. Minta kode baru.']);
        }

        if (!$otp->matches($challenge, $code)) {
            $attempts = $challenge['attempts'] + 1;
            $request->session()->put('registration.otp.attempts', $attempts);
            $message = $attempts === 5 ? 'Batas percobaan tercapai. Minta kode baru.' : 'Kode OTP salah. Periksa email lalu coba lagi.';

            return redirect()->route('pendaftaran.otp')->withErrors(['code' => $message]);
        }

        try {
            $response = $this->createAccounts($pending['data']);
        } catch (ValidationException $exception) {
            $response = redirect()->route('pendaftaran')->withErrors($exception->errors());
        } catch (UniqueConstraintViolationException) {
            $response = redirect()->route('pendaftaran')->withErrors(['email' => 'Data pendaftaran sudah digunakan. Periksa kembali data siswa.']);
        }

        $request->session()->forget('registration');

        return $response;
    }

    private function pendingRegistration(Request $request): ?array
    {
        $pending = $request->session()->get('registration');
        if ($pending && $pending['expires_at'] > now()->timestamp) {
            return $pending;
        }

        return null;
    }

    private function expiredRegistration()
    {
        return redirect()->route('pendaftaran')->withErrors(['email' => 'Sesi verifikasi berakhir. Isi kembali formulir pendaftaran.']);
    }

    private function validateParentAccount(array $data): void
    {
        if (!empty($data['email_orangtua']) && User::where('email', $data['email_orangtua'])->where('id_tipeuser', '!=', 4)->exists()) {
            throw ValidationException::withMessages([
                'email_orangtua' => 'Email ini sudah terdaftar sebagai akun siswa/guru. Gunakan email lain untuk orang tua.',
            ]);
        }
    }

    private function createAccounts(array $validated)
    {
        $adaOrangtua = false;

        DB::transaction(function () use ($validated, &$adaOrangtua) {
            $this->validateParentAccount($validated);
            validator($validated, [
                'nama' => ['unique:user,nama'],
                'email' => ['unique:user,email'],
                'nisn' => ['unique:user,nisn'],
                'id_jenjang' => ['exists:jenjang,id_jenjang'],
            ])->validate();

            // 1. Simpan Akun Siswa (id_tipeuser = 3)
            $siswaData = [
                'nisn' => $validated['nisn'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nomor_hp' => $validated['nomor_handphone'],
                'password' => $validated['password'],
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
            LogAktivitas::catat($siswa, 'Mendaftar sebagai siswa.');

            // 2. Hubungkan atau Buat Akun Orang Tua jika data orang tua diisi
            if (!empty($validated['nama_orangtua']) && !empty($validated['email_orangtua'])) {
                $adaOrangtua = true;
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
                        'password' => $validated['password_orangtua'],
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
