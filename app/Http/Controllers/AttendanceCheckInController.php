<?php

namespace App\Http\Controllers;

use App\Exceptions\AttendanceCheckInException;
use App\Http\Requests\CheckInAttendanceRequest;
use App\Models\AttendanceSession;
use App\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/** Mentor/guru: halaman scan, konfirmasi dari tautan QR, dan proses check-in. */
class AttendanceCheckInController extends Controller
{
    public function __construct(private readonly AttendanceService $service)
    {
    }

    public function scan()
    {
        Gate::authorize('checkIn', AttendanceSession::class);

        return view('attendance.scan');
    }

    /**
     * Tujuan tautan di dalam QR. SENGAJA tidak mencatat kehadiran (GET tidak boleh mengubah data,
     * agar aman dari prefetch/bot). Menampilkan konfirmasi; pencatatan lewat POST + CSRF.
     */
    public function confirm(Request $request)
    {
        Gate::authorize('checkIn', AttendanceSession::class);

        $token = trim((string) $request->query('token', ''));
        $session = $this->service->findByToken($token);

        return view('attendance.confirm', [
            'session' => $session,
            'token' => $session ? $token : null,
            'status' => $session?->effectiveStatus(),
        ]);
    }

    public function store(CheckInAttendanceRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $record = $this->service->checkIn(
                $request->user(), // identitas dari sesi login, bukan dari input
                $request->validated('token'),
                $request->ip(),
                $request->userAgent()
            );
        } catch (AttendanceCheckInException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'reason' => $e->reason, 'message' => $e->getMessage()], $e->httpStatus());
            }

            return redirect()->route('attendance.scan')->with('error', $e->getMessage());
        }

        $pesan = 'Check-in berhasil. Status: ' . ($record->status === 'terlambat' ? 'Terlambat' : 'Hadir')
            . ' pada pukul ' . $record->checked_in_at->format('H:i') . '.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $record->status,
                'checked_in_at' => $record->checked_in_at->format('H:i:s'),
                'message' => $pesan,
            ]);
        }

        return redirect()->route('attendance.scan')->with('success', $pesan);
    }
}
