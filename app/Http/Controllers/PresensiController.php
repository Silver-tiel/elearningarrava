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

        $kelasQuery = Kelas::orderBy('nama');
        if ($user->isGuru()) {
            $kelasQuery->whereIn('id_kelas', $user->kelasDiampu()->pluck('kelas.id_kelas'));
        }
        $semuaKelas = $kelasQuery->get();
        $totalKelas = $semuaKelas->count();

        // Sesi presensi dibuat OTOMATIS untuk setiap kelas yang aktif hari ini
        // (status aktif + masa berlaku + jadwal hari). Tidak ada pembuatan manual.
        foreach ($semuaKelas as $kelas) {
            SesiPresensi::pastikanUntuk($kelas, now(), $user->id_user);
        }

        $dasar = fn () => SesiPresensi::with('kelas')
            ->withCount('presensi')
            ->whereIn('id_kelas', $semuaKelas->pluck('id_kelas'));

        $hariIni = now()->toDateString();

        $sesiHariIni = $dasar()
            ->whereDate('tanggal', $hariIni)
            ->get()
            ->sortBy(fn (SesiPresensi $s) => $s->kelas->nama)
            ->values();

        // Riwayat: default = minggu ini (Senin sampai kemarin); opsional 30 hari terakhir.
        $rentang = $request->query('rentang') === 'bulan' ? 'bulan' : 'minggu';
        $hari = (int) $request->query('hari');
        $hari = ($hari >= 1 && $hari <= 7) ? $hari : null;

        $mulai = $rentang === 'bulan'
            ? now()->subDays(30)->toDateString()
            : now()->startOfWeek(Carbon::MONDAY)->toDateString();

        $riwayat = $dasar()
            ->whereDate('tanggal', '>=', $mulai)
            ->whereDate('tanggal', '<', $hariIni)
            ->orderByDesc('tanggal')
            ->orderByDesc('id_sesi')
            ->limit(300)
            ->get();

        if ($hari !== null) {
            $riwayat = $riwayat->filter(fn (SesiPresensi $s) => $s->tanggal->dayOfWeekIso === $hari)->values();
        }

        $riwayatPerTanggal = $riwayat->groupBy(fn (SesiPresensi $s) => $s->tanggal->toDateString());

        return view('guru.presensi.index', [
            'totalKelas' => $totalKelas,
            'sesiHariIni' => $sesiHariIni,
            'riwayatPerTanggal' => $riwayatPerTanggal,
            'rentang' => $rentang,
            'hari' => $hari,
            'namaHari' => Kelas::HARI,
        ]);
    }

    public function sesiAktif(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', SesiPresensi::class);

        $user = $request->user();
        $kelasQuery = Kelas::orderBy('nama');
        if ($user->isGuru()) {
            $kelasQuery->whereIn('id_kelas', $user->kelasDiampu()->pluck('kelas.id_kelas'));
        }

        $kelas = $kelasQuery->get();
        foreach ($kelas as $item) {
            SesiPresensi::pastikanUntuk($item, now(), $user->id_user);
        }

        $sesiAktif = SesiPresensi::with('kelas.jenjang')
            ->withCount('presensi')
            ->whereIn('id_kelas', $kelas->pluck('id_kelas'))
            ->whereDate('tanggal', now()->toDateString())
            ->get()
            ->filter(fn (SesiPresensi $sesi) => $sesi->bisaDipindai())
            ->sortBy(fn (SesiPresensi $sesi) => $sesi->kelas->nama)
            ->values()
            ->map(fn (SesiPresensi $sesi) => [
                'id_sesi' => (int) $sesi->id_sesi,
                'id_kelas' => (int) $sesi->id_kelas,
                'judul' => $sesi->judul,
                'pertemuan_ke' => (int) $sesi->pertemuan_ke,
                'tanggal' => $sesi->tanggal?->toDateString(),
                'batas_tepat_waktu' => $sesi->batas_tepat_waktu?->toIso8601String(),
                'status' => $sesi->statusTampil(),
                'presensi_count' => (int) $sesi->presensi_count,
                'kelas' => [
                    'nama' => $sesi->kelas->nama,
                    'jenjang' => $sesi->kelas->jenjang?->nama_jenjang,
                ],
            ]);

        return response()->json([
            'success' => true,
            'data' => $sesiAktif,
        ]);
    }

    public function rekapApi($id_sesi): JsonResponse
    {
        $sesi = SesiPresensi::with('kelas.jenjang')->findOrFail($id_sesi);
        Gate::authorize('view', $sesi);

        $presensi = Presensi::where('id_sesi', $sesi->id_sesi)
            ->get()
            ->keyBy('id_siswa');

        $siswa = $sesi->kelas->anggota()
            ->orderBy('nama')
            ->get(['id_user', 'nama', 'nisn'])
            ->map(function (User $user) use ($presensi) {
                $catatan = $presensi->get($user->id_user);

                return [
                    'id_siswa' => (int) $user->id_user,
                    'nama' => $user->nama,
                    'nisn' => $user->nisn,
                    'status' => $catatan?->status ?? 'tidak_hadir',
                    'waktu_scan' => $catatan?->waktu_scan?->format('H:i'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'sesi' => [
                    'id_sesi' => (int) $sesi->id_sesi,
                    'judul' => $sesi->judul,
                    'status' => $sesi->statusTampil(),
                    'kelas' => $sesi->kelas->nama,
                    'jenjang' => $sesi->kelas->jenjang?->nama_jenjang,
                    'tanggal' => $sesi->tanggal?->toDateString(),
                ],
                'ringkasan' => [
                    'total' => $siswa->count(),
                    'hadir' => $siswa->where('status', 'hadir')->count(),
                    'terlambat' => $siswa->where('status', 'terlambat')->count(),
                    'tidak_hadir' => $siswa->where('status', 'tidak_hadir')->count(),
                ],
                'siswa' => $siswa,
            ],
        ]);
    }

    public function scan($id)
    {
        $sesi = SesiPresensi::with('kelas')->findOrFail($id);
        Gate::authorize('scan', $sesi);

        if ($sesi->kedaluwarsa()) {
            return redirect()->route('guru.presensi.rekap', $sesi->id_sesi)
                ->withErrors(['sesi' => 'Sesi presensi ini sudah kedaluwarsa (hanya berlaku pada tanggalnya). Data kehadiran tetap bisa dilihat di sini.']);
        }

        if (!$sesi->kelas->aktifPadaTanggal($sesi->tanggal)) {
            return redirect()->route('guru.presensi.rekap', $sesi->id_sesi)
                ->withErrors(['sesi' => 'Kelas ini sedang tidak aktif (di luar jadwal atau masa berlaku), jadi presensi tidak bisa dipindai.']);
        }

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

        if (!$sesi->isHariIni()) {
            $this->catat($request, $sesi, null, $token, 'kedaluwarsa');
            return $this->balas('kedaluwarsa', 'Sesi presensi ini sudah kedaluwarsa. Presensi hanya bisa dipindai pada hari yang sama dengan tanggal sesi.', 422);
        }

        // Batas penggunaan scan mengikuti jadwal/masa berlaku kelas (bisa berubah setelah sesi dibuat).
        if (!$sesi->kelas->aktifPadaTanggal($sesi->tanggal)) {
            $this->catat($request, $sesi, null, $token, 'kelas_nonaktif');
            return $this->balas('kelas_nonaktif', 'Kelas ' . $sesi->kelas->nama . ' sedang tidak aktif (di luar jadwal atau masa berlaku). Presensi tidak dapat dicatat.', 422);
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

        // 3) Siswa harus peserta kelas sesi ini (jenjang sama dengan kelas).
        if (!$sesi->kelas->punyaPeserta($siswa)) {
            $this->catat($request, $sesi, $siswa->id_user, $token, 'bukan_anggota');
            return $this->balas('bukan_anggota', 'Siswa ini bukan peserta kelas ' . $sesi->kelas->nama . ' (jenjangnya berbeda).', 422);
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

        $anggota = $sesi->kelas->anggota()->orderBy('nama')->get(['id_user', 'nama']);

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
        $total = $sesi->kelas->anggota()->count();
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
