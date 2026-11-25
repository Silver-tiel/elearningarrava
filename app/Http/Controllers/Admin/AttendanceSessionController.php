<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceSessionRequest;
use App\Models\AttendanceSession;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/** Admin: membuat sesi absensi mentor, menampilkan QR, melihat rekap, menutup sesi. */
class AttendanceSessionController extends Controller
{
    public function __construct(private readonly AttendanceService $service)
    {
    }

    public function index()
    {
        Gate::authorize('viewAny', AttendanceSession::class);

        $this->service->markExpired();

        $sessions = AttendanceSession::query()
            ->withCount([
                'records as hadir_count' => fn ($q) => $q->where('status', 'hadir'),
                'records as terlambat_count' => fn ($q) => $q->where('status', 'terlambat'),
            ])
            ->orderByDesc('starts_at')
            ->paginate(15);

        return view('admin.attendance.index', compact('sessions'));
    }

    public function create()
    {
        Gate::authorize('create', AttendanceSession::class);

        return view('admin.attendance.create', [
            'defaultMulai' => now()->format('Y-m-d\TH:i'),
            'defaultBerakhir' => now()->addHours(2)->format('Y-m-d\TH:i'),
        ]);
    }

    public function store(StoreAttendanceSessionRequest $request)
    {
        $session = $this->service->createSession($request->validated(), $request->user());

        return redirect()
            ->route('admin.attendance.qr', $session)
            ->with('success', 'Sesi absensi berhasil dibuat. Tampilkan QR ini kepada mentor/guru.');
    }

    public function qr(AttendanceSession $attendanceSession)
    {
        Gate::authorize('view', $attendanceSession);

        return response()
            ->view('admin.attendance.qr', [
                'session' => $attendanceSession,
                'svg' => $this->service->qrSvg($attendanceSession),
            ])
            ->header('Cache-Control', 'no-store, private');
    }

    public function report(AttendanceSession $attendanceSession)
    {
        Gate::authorize('report', $attendanceSession);

        $this->service->markExpired();
        $attendanceSession->refresh();

        return view('admin.attendance.report', array_merge(
            ['session' => $attendanceSession],
            $this->service->report($attendanceSession)
        ));
    }

    public function export(AttendanceSession $attendanceSession)
    {
        Gate::authorize('report', $attendanceSession);

        $baris = $this->service->csvRows($attendanceSession);
        $nama = 'absensi-mentor-' . $attendanceSession->id . '-' . $attendanceSession->starts_at->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($baris) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar Excel membaca UTF-8
            foreach ($baris as $b) {
                fputcsv($out, $b);
            }
            fclose($out);
        }, $nama, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function close(Request $request, AttendanceSession $attendanceSession)
    {
        Gate::authorize('close', $attendanceSession);

        $this->service->closeSession($attendanceSession);

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Sesi absensi "' . $attendanceSession->title . '" telah ditutup.');
    }
}
