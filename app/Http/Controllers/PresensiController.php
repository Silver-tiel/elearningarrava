<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LogPemindaian;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\User;
use App\Support\QrToken;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/** Presensi QR untuk guru (kelas yang diampu) dan admin (semua kelas). */
class PresensiController extends Controller
{
    private const BATAS_GAGAL_PER_MENIT = 10;

    public function index(Request $request)
    {
        Gate::authorize('viewAny', SesiPresensi::class);

        $user = $request->user();

        $kelasQuery = Kelas::where('aktif', true)->orderBy('nama');
        if ($user->isGuru()) {
            $kelasQuery->whereIn('id_kelas', $user->kelasDiampu()->pluck('kelas.id_kelas'));
        }
        $kelasList = $kelasQuery->get();

        $sesiList = SesiPresensi::with('kelas')
            ->withCount('presensi')
            ->whereIn('id_kelas', $kelasList->pluck('id_kelas'))
            ->orderByDesc('tanggal')
            ->orderByDesc('id_sesi')
            ->limit(20)
            ->get();

        return view('guru.presensi.index', compact('kelasList', 'sesiList'));
    }

    public function storeSesi(Request $request)
    {
        $data = $request->validate([
            'id_kelas' => ['required', 'integer', 'exists:kelas,id_kelas'],
            'judul' => ['required', 'string', 'max:150'],
            'pertemuan_ke' => ['nullable', 'integer', 'min:1', 'max:999'],
            'tanggal' => ['required', 'date'],
            'jam_batas' => ['nullable', 'date_format:H:i'],
        ], [
            'id_kelas.required' => 'Pilih kelas terlebih dahulu.',
            'id_kelas.exists' => 'Kelas tidak ditemukan.',
            'judul.required' => 'Judul pertemuan wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jam_batas.date_format' => 'Format jam batas harus JJ:MM, misalnya 08:15.',
        ]);

        $kelas = Kelas::findOrFail($data['id_kelas']);

        // Anti-IDOR: guru hanya boleh membuat sesi untuk kelas yang ia ampu.
        Gate::authorize('create', [SesiPresensi::class, $kelas]);

        if (!$kelas->aktif) {
            return back()->withInput()->withErrors(['id_kelas' => 'Kelas ini sudah tidak aktif.']);
        }

        $tanggal = Carbon::parse($data['tanggal'])->startOfDay();
        $batas = !empty($data['jam_batas'])
            ? Carbon::parse($tanggal->toDateString() . ' ' . $data['jam_batas'])
            : null;

        $sesi = SesiPresensi::create([
            'id_kelas' => $kelas->id_kelas,
            'id_guru' => $request->user()->id_user,
            'judul' => $data['judul'],
            'pertemuan_ke' => $data['pertemuan_ke'] ?? null,
            'tanggal' => $tanggal->toDateString(),
            'batas_tepat_waktu' => $batas,
            'status' => 'buka',
        ]);

        return redirect()->route('guru.presensi.scan', $sesi->id_sesi);
    }

    public function scan($id)
    {
        $sesi = SesiPresensi::with('kelas')->findOrFail($id);
        Gate::authorize('scan', $sesi);

        $riwayat = LogPemindaian::with('siswa:id_user,nama')
            ->where('id_sesi', $sesi->id_sesi)
            ->orderByDesc('id_log')
            ->limit(10)
            ->get()
            ->map(fn ($l) => [
                'hasil' => $l->hasil,
                'nama' => $l->siswa?->nama,
                'waktu' => $l->created_at?->format('H:i:s'),
            ]);

        return view('guru.presensi.scan', [
            'sesi' => $sesi,
            'riwayat' => $riwayat,
            'ringkasan' => $this->ringkasan($sesi),
        ]);
    }

    public function prosesScan(Request $request, $id): JsonResponse
    {
        $sesi = SesiPresensi::with('kelas')->findOrFail($id);

        // Server-side authorization (anti-IDOR): guru hanya pada kelas yang ia ampu.
        if (Gate::denies('scan', $sesi)) {
            return $this->balas('ditolak', 'Anda tidak memiliki akses untuk memindai pada kelas ini.', 403);
        }

        $guru = $request->user();
        $kunciGagal = 'scan-gagal:' . $guru->id_user;

        if (RateLimiter::tooManyAttempts($kunciGagal, self::BATAS_GAGAL_PER_MENIT)) {
            $detik = RateLimiter::availableIn($kunciGagal);
            return $this->balas('dibatasi', "Terlalu banyak QR tidak valid. Coba lagi dalam {$detik} detik.", 429);
        }

        $token = (string) $request->input('token', '');

        if (!$sesi->isBuka()) {
            $this->catat($request, $sesi, null, $token, 'sesi_ditutup');
            return $this->balas('sesi_ditutup', 'Sesi presensi ini sudah ditutup.', 422);
        }

        // 1) Cek format + tanda tangan SEBELUM menyentuh database.
        $uuid = QrToken::uuidDariPayload($token);
        if ($uuid === null) {
            RateLimiter::hit($kunciGagal, 60);
            $this->catat($request, $sesi, null, $token, 'tidak_valid');
            return $this->balas('tidak_valid', 'QR tidak dikenali. Pastikan yang dipindai adalah QR presensi Arava.', 422);
        }

        // 2) Cari siswa pemilik token.
        $siswa = User::where('qr_token', $uuid)->where('id_tipeuser', 3)->first();
        if (!$siswa) {
            RateLimiter::hit($kunciGagal, 60);
            $this->catat($request, $sesi, null, $token, 'tidak_valid');
            return $this->balas('tidak_valid', 'QR ini sudah tidak berlaku atau tidak terdaftar. Minta siswa menghubungi admin.', 422);
        }

        if (($siswa->status_akun ?? 'Aktif') === 'Nonaktif') {
            $this->catat($request, $sesi, $siswa->id_user, $token, 'tidak_aktif');
            return $this->balas('tidak_aktif', 'Akun siswa ini sedang nonaktif.', 422);
        }

        // 3) Siswa harus anggota kelas sesi ini.
        $anggota = DB::table('kelas_siswa')
            ->where('id_kelas', $sesi->id_kelas)
            ->where('id_siswa', $siswa->id_user)
            ->exists();

        if (!$anggota) {
            $this->catat($request, $sesi, $siswa->id_user, $token, 'bukan_anggota');
            return $this->balas('bukan_anggota', 'Siswa ini tidak terdaftar di kelas ' . $sesi->kelas->nama . '.', 422);
        }

        // 4) Catat kehadiran; unique(id_sesi, id_siswa) mencegah duplikasi.
        $sudah = Presensi::where('id_sesi', $sesi->id_sesi)->where('id_siswa', $siswa->id_user)->first();

        if (!$sudah) {
            $status = ($sesi->batas_tepat_waktu && now()->greaterThan($sesi->batas_tepat_waktu)) ? 'terlambat' : 'hadir';

            try {
                $presensi = Presensi::create([
                    'id_sesi' => $sesi->id_sesi,
                    'id_siswa' => $siswa->id_user,
                    'id_guru_pemindai' => $guru->id_user,
                    'status' => $status,
                    'waktu_scan' => now(),
                ]);

                $this->catat($request, $sesi, $siswa->id_user, $token, $status);

                return $this->balas($status, $status === 'terlambat' ? 'Tercatat terlambat.' : 'Kehadiran tercatat.', 200, [
                    'siswa' => ['nama' => $siswa->nama, 'kelas' => $sesi->kelas->nama],
                    'waktu' => $presensi->waktu_scan->format('H:i'),
                    'ringkasan' => $this->ringkasan($sesi),
                ]);
            } catch (QueryException $e) {
                // Scan bersamaan: baris sudah dibuat oleh permintaan lain.
                $sudah = Presensi::where('id_sesi', $sesi->id_sesi)->where('id_siswa', $siswa->id_user)->first();
                if (!$sudah) {
                    throw $e;
                }
            }
        }

        $this->catat($request, $sesi, $siswa->id_user, $token, 'duplikat');

        return $this->balas('duplikat', 'Sudah tercatat hadir pukul ' . $sudah->waktu_scan->format('H:i') . '.', 200, [
            'siswa' => ['nama' => $siswa->nama, 'kelas' => $sesi->kelas->nama],
            'waktu' => $sudah->waktu_scan->format('H:i'),
            'ringkasan' => $this->ringkasan($sesi),
        ]);
    }

    public function tutup($id)
    {
        $sesi = SesiPresensi::findOrFail($id);
        Gate::authorize('tutup', $sesi);

        $sesi->update(['status' => 'tutup']);

        return redirect()->route('guru.presensi.rekap', $sesi->id_sesi)
            ->with('success', 'Sesi presensi ditutup.');
    }

    public function rekap($id)
    {
        $sesi = SesiPresensi::with('kelas')->findOrFail($id);
        Gate::authorize('view', $sesi);

        $anggota = DB::table('kelas_siswa')
            ->join('user', 'user.id_user', '=', 'kelas_siswa.id_siswa')
            ->where('kelas_siswa.id_kelas', $sesi->id_kelas)
            ->orderBy('user.nama')
            ->get(['user.id_user', 'user.nama']);

        $presensi = Presensi::where('id_sesi', $sesi->id_sesi)->get()->keyBy('id_siswa');

        $baris = $anggota->map(function ($a) use ($presensi) {
            $p = $presensi->get($a->id_user);
            return [
                'nama' => $a->nama,
                'status' => $p?->status ?? 'tidak_hadir',
                'waktu' => $p?->waktu_scan?->format('H:i'),
            ];
        });

        return view('guru.presensi.rekap', [
            'sesi' => $sesi,
            'baris' => $baris,
            'ringkasan' => $this->ringkasan($sesi),
        ]);
    }

    private function ringkasan(SesiPresensi $sesi): array
    {
        $total = DB::table('kelas_siswa')->where('id_kelas', $sesi->id_kelas)->count();
        $hadir = Presensi::where('id_sesi', $sesi->id_sesi)->where('status', 'hadir')->count();
        $terlambat = Presensi::where('id_sesi', $sesi->id_sesi)->where('status', 'terlambat')->count();

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'tidak_hadir' => max(0, $total - $hadir - $terlambat),
        ];
    }

    /** Catat setiap percobaan. Token mentah TIDAK disimpan, hanya hash-nya. */
    private function catat(Request $request, SesiPresensi $sesi, ?int $idSiswa, string $token, string $hasil): void
    {
        LogPemindaian::create([
            'id_sesi' => $sesi->id_sesi,
            'id_guru' => $request->user()->id_user,
            'id_siswa' => $idSiswa,
            'token_hash' => $token !== '' ? QrToken::hash($token) : null,
            'hasil' => $hasil,
            'ip' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 250, ''),
            'created_at' => now(),
        ]);
    }

    private function balas(string $status, string $pesan, int $http, array $extra = []): JsonResponse
    {
        return response()->json(['status' => $status, 'pesan' => $pesan] + $extra, $http);
    }
}
