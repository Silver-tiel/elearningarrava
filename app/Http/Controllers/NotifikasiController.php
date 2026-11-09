<?php

namespace App\Http\Controllers;

use App\Services\NotifikasiPresensiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NotifikasiController extends Controller
{
    /**
     * Mengambil daftar notifikasi presensi terbaru untuk user yang sedang login.
     */
    public function check(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'notifikasi' => [],
                'unreadCount' => 0,
            ], 401);
        }

        $notifikasi = [];
        if ($user->id_tipeuser == 3) { // Siswa
            $notifikasi = NotifikasiPresensiService::untukSiswa($user);
        } elseif ($user->id_tipeuser == 4) { // Orang Tua
            $siswaId = $request->query('siswa_id');
            $notifikasi = NotifikasiPresensiService::untukOrangtua($user, $siswaId ? (int) $siswaId : null);
        }

        $cacheKey = "read_notif_{$user->id_user}";
        $serverReadIds = Cache::get($cacheKey, []);
        if (empty($serverReadIds) && session()->isStarted() && session()->has($cacheKey)) {
            $serverReadIds = session()->get($cacheKey, []);
        }

        $unreadCount = 0;
        foreach ($notifikasi as &$item) {
            $isRead = in_array($item['id'] ?? '', $serverReadIds, true);
            $item['is_read'] = $isRead;
            if (!$isRead) {
                $unreadCount++;
            }
        }
        unset($item);

        return response()->json([
            'success' => true,
            'userId' => $user->id_user,
            'userName' => $user->nama,
            'role' => $user->id_tipeuser == 3 ? 'siswa' : 'orangtua',
            'notifikasi' => $notifikasi,
            'unreadCount' => $unreadCount,
            'serverReadIds' => $serverReadIds,
        ]);
    }

    /**
     * Tandai satu atau semua notifikasi sebagai telah dibaca.
     */
    public function markRead(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $cacheKey = "read_notif_{$user->id_user}";
        $readIds = Cache::get($cacheKey, []);
        if (empty($readIds) && session()->isStarted() && session()->has($cacheKey)) {
            $readIds = session()->get($cacheKey, []);
        }

        if ($request->boolean('all')) {
            $notifikasi = [];
            if ($user->id_tipeuser == 3) {
                $notifikasi = NotifikasiPresensiService::untukSiswa($user);
            } elseif ($user->id_tipeuser == 4) {
                $siswaId = $request->query('siswa_id') ?? $request->input('siswa_id');
                $notifikasi = NotifikasiPresensiService::untukOrangtua($user, $siswaId ? (int) $siswaId : null);
            }
            $allIds = collect($notifikasi)->pluck('id')->all();
            $readIds = array_values(array_unique(array_merge($readIds, $allIds)));
        } elseif ($request->filled('id')) {
            $id = $request->input('id');
            if (!in_array($id, $readIds, true)) {
                $readIds[] = $id;
            }
        }

        Cache::put($cacheKey, $readIds, now()->addDays(30));
        if (session()->isStarted()) {
            session()->put($cacheKey, $readIds);
        }

        return response()->json([
            'success' => true,
            'readIds' => $readIds,
        ]);
    }
}

