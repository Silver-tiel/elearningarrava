<?php

namespace App\Services;

use App\Exceptions\AttendanceCheckInException as Gagal;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Logika absensi mentor/guru dengan QR yang dibuat admin.
 * Semua aturan divalidasi di sini (server-side); frontend hanya membantu UX.
 */
class AttendanceService
{
    /** Batas percobaan token tidak valid per menit (anti brute force), per pengguna dan per IP. */
    public const MAKS_GAGAL_PER_MENIT = 10;

    public function createSession(array $data, User $admin): AttendanceSession
    {
        return AttendanceSession::create([
            'title' => $data['title'],
            'token' => $this->generateUniqueToken(),
            'created_by' => $admin->id_user,
            'starts_at' => $data['starts_at'],
            'expires_at' => $data['expires_at'],
            'late_after_minutes' => $data['late_after_minutes'] ?? null,
            'status' => AttendanceSession::STATUS_ACTIVE,
        ]);
    }

    public function closeSession(AttendanceSession $session): AttendanceSession
    {
        if ($session->status !== AttendanceSession::STATUS_CLOSED) {
            $session->update(['status' => AttendanceSession::STATUS_CLOSED]);
        }

        return $session;
    }

    /** Tandai sesi active yang sudah lewat waktunya menjadi expired. Mengembalikan jumlah baris. */
    public function markExpired(): int
    {
        return AttendanceSession::where('status', AttendanceSession::STATUS_ACTIVE)
            ->where('expires_at', '<=', now())
            ->update(['status' => AttendanceSession::STATUS_EXPIRED]);
    }

    /**
     * Check-in untuk PENGGUNA YANG SEDANG LOGIN. Tidak pernah menerima user_id dari luar.
     *
     * @throws Gagal
     */
    public function checkIn(User $user, string $token, ?string $ip = null, ?string $userAgent = null): AttendanceRecord
    {
        // 1) Hanya mentor/guru.
        if (!$user->isGuru()) {
            throw new Gagal(Gagal::FORBIDDEN_ROLE, 'Hanya mentor/guru yang dapat melakukan check-in absensi.');
        }

        // 2) Batasi percobaan gagal (anti tebak token).
        $kunciUser = 'attendance-gagal:user:' . $user->id_user;
        $kunciIp = 'attendance-gagal:ip:' . ($ip ?? 'tidak-diketahui');
        foreach ([$kunciUser, $kunciIp] as $kunci) {
            if (RateLimiter::tooManyAttempts($kunci, self::MAKS_GAGAL_PER_MENIT)) {
                $detik = RateLimiter::availableIn($kunci);
                throw new Gagal(Gagal::TOO_MANY_ATTEMPTS, "Terlalu banyak percobaan dengan token tidak valid. Coba lagi dalam {$detik} detik.");
            }
        }

        // 3) Format + keberadaan token.
        $token = trim($token);
        $session = preg_match('/^[A-Za-z0-9]{64}$/', $token)
            ? AttendanceSession::where('token', $token)->first()
            : null;

        if (!$session) {
            RateLimiter::hit($kunciUser, 60);
            RateLimiter::hit($kunciIp, 60);
            throw new Gagal(Gagal::TOKEN_INVALID, 'Token tidak valid. Periksa kembali QR atau token yang dimasukkan.');
        }

        // 4) Status & jendela waktu sesi.
        if ($session->status === AttendanceSession::STATUS_CLOSED) {
            throw new Gagal(Gagal::SESSION_CLOSED, 'Sesi absensi ini sudah ditutup oleh admin.');
        }

        if ($session->status === AttendanceSession::STATUS_EXPIRED || $session->expires_at->lte(now())) {
            if ($session->status === AttendanceSession::STATUS_ACTIVE) {
                $session->update(['status' => AttendanceSession::STATUS_EXPIRED]);
            }
            throw new Gagal(Gagal::SESSION_EXPIRED, 'Sesi absensi ini sudah berakhir.');
        }

        if (!$session->hasStarted()) {
            throw new Gagal(Gagal::NOT_STARTED, 'Sesi absensi belum dimulai. Mulai pukul ' . $session->starts_at->format('H:i') . '.');
        }

        // 5) Belum pernah check-in pada sesi ini.
        $sudah = AttendanceRecord::where('attendance_session_id', $session->id)->where('user_id', $user->id_user)->first();
        if ($sudah) {
            throw $this->sudahCheckIn($sudah);
        }

        // 6) Tentukan status hadir/terlambat memakai waktu server.
        $sekarang = now();
        $batas = $session->lateThreshold();
        $status = ($batas !== null && $sekarang->greaterThan($batas))
            ? AttendanceRecord::STATUS_TERLAMBAT
            : AttendanceRecord::STATUS_HADIR;

        try {
            return AttendanceRecord::create([
                'attendance_session_id' => $session->id,
                'user_id' => $user->id_user,
                'checked_in_at' => $sekarang,
                'status' => $status,
                'ip_address' => $ip,
                'user_agent' => $userAgent !== null ? Str::limit($userAgent, 500, '') : null,
            ]);
        } catch (QueryException $e) {
            // Dua permintaan bersamaan: unique(attendance_session_id, user_id) menahan yang kedua.
            $sudah = AttendanceRecord::where('attendance_session_id', $session->id)->where('user_id', $user->id_user)->first();
            if ($sudah) {
                throw $this->sudahCheckIn($sudah);
            }

            throw $e;
        }
    }

    /** Pratinjau sesi dari token (untuk halaman konfirmasi). Null jika token tidak dikenal. */
    public function findByToken(string $token): ?AttendanceSession
    {
        $token = trim($token);

        return preg_match('/^[A-Za-z0-9]{64}$/', $token)
            ? AttendanceSession::where('token', $token)->first()
            : null;
    }

    /** SVG QR berisi URL check-in sesi. Dirender di server (tanpa dependensi JS/ekstensi tambahan). */
    public function qrSvg(AttendanceSession $session, int $size = 360): string
    {
        $renderer = new ImageRenderer(new RendererStyle($size, 2), new SvgImageBackEnd());
        $svg = (new Writer($renderer))->writeString($session->checkInUrl());

        return preg_replace('/^<\?xml.*?\?>\s*/s', '', $svg);
    }

    /**
     * Data rekap: yang sudah check-in, yang belum, dan ringkasan jumlah.
     *
     * @return array{records: Collection, belum: Collection, ringkasan: array<string,int>}
     */
    public function report(AttendanceSession $session): array
    {
        $records = $session->records()->with('user:id_user,nama,email')->orderBy('checked_in_at')->get();

        $belum = User::where('id_tipeuser', 2)
            ->whereNotIn('id_user', $records->pluck('user_id'))
            ->orderBy('nama')
            ->get(['id_user', 'nama', 'email']);

        return [
            'records' => $records,
            'belum' => $belum,
            'ringkasan' => [
                'hadir' => $records->where('status', AttendanceRecord::STATUS_HADIR)->count(),
                'terlambat' => $records->where('status', AttendanceRecord::STATUS_TERLAMBAT)->count(),
                'belum' => $belum->count(),
            ],
        ];
    }

    /** Baris CSV rekap (sudah dinetralkan dari formula injection). */
    public function csvRows(AttendanceSession $session): array
    {
        $data = $this->report($session);
        $baris = [['Nama', 'Email', 'Status', 'Waktu Check-in']];

        foreach ($data['records'] as $r) {
            $baris[] = [
                $this->aman($r->user->nama ?? '-'),
                $this->aman($r->user->email ?? '-'),
                $r->status === AttendanceRecord::STATUS_TERLAMBAT ? 'Terlambat' : 'Hadir',
                $r->checked_in_at->format('Y-m-d H:i:s'),
            ];
        }
        foreach ($data['belum'] as $u) {
            $baris[] = [$this->aman($u->nama), $this->aman($u->email), 'Belum check-in', ''];
        }

        return $baris;
    }

    private function sudahCheckIn(AttendanceRecord $rec): Gagal
    {
        return new Gagal(
            Gagal::ALREADY_CHECKED_IN,
            'Anda sudah check-in pada sesi ini pukul ' . $rec->checked_in_at->format('H:i') . '.'
        );
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(64);
        } while (AttendanceSession::where('token', $token)->exists());

        return $token;
    }

    /** Cegah CSV/formula injection (=, +, -, @ di awal sel). */
    private function aman(string $nilai): string
    {
        return preg_match('/^[=+\-@\t\r]/', $nilai) ? "'" . $nilai : $nilai;
    }
}
