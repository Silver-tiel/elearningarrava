<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/** Admin: melihat status QR siswa dan men-generate ulang (revoke + regenerate). */
class QrAdminController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('regenerate-qr');

        $cari = trim((string) $request->query('q', ''));

        // Hanya kolom non-rahasia yang diambil: token TIDAK pernah ditampilkan.
        $siswa = User::where('id_tipeuser', 3)
            ->when($cari !== '', fn ($q) => $q->where('nama', 'like', '%' . $cari . '%'))
            ->orderBy('nama')
            ->paginate(20, ['id_user', 'nama', 'qr_dibuat_pada'])
            ->withQueryString();

        return view('admin.qr.index', ['siswa' => $siswa, 'cari' => $cari]);
    }

    public function regenerate($siswa)
    {
        Gate::authorize('regenerate-qr');

        $user = User::where('id_tipeuser', 3)->findOrFail($siswa);
        $user->regenerasiQr();

        return back()->with('success', 'QR milik ' . $user->nama . ' berhasil dibuat ulang. QR lama tidak berlaku lagi.');
    }
}
