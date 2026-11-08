<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\OrangtuaSiswa;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class NotifikasiPresensiService
{
    /**
     * Mengambil daftar notifikasi presensi untuk Siswa.
     * 1. Menandakan absen: Kelas aktif hari ini dan siswa belum absen.
     * 2. Melewatkan absensi: Sesi presensi dalam 7 hari terakhir yang tidak dihadiri siswa.
     *
     * @param User $siswa
     * @return array<int, array<string, mixed>>
     */
    public static function untukSiswa(User $siswa): array
    {
        if (!Schema::hasTable('kelas') || !Schema::hasTable('sesi_presensi') || !Schema::hasTable('presensi')) {
            return [];
        }

        if (empty($siswa->id_jenjang)) {
            return [];
        }

        $notifikasi = [];
        $today = now();
        $todayStr = $today->toDateString();

        // 1. KELAS AKTIF HARI INI (MENANDAKAN ABSEN)
        $kelasQuery = Kelas::where('aktif', true)
            ->where('id_jenjang', $siswa->id_jenjang);

        if (Schema::hasTable('kelas_siswa') && $siswa->kelasDiikuti()->exists()) {
            $kelasQuery->whereIn('id_kelas', $siswa->kelasDiikuti()->pluck('kelas.id_kelas'));
        }

        $semuaKelas = $kelasQuery->get();
        $kelasHariIni = $semuaKelas->filter(fn (Kelas $k) => $k->aktifPadaTanggal($today));

        foreach ($kelasHariIni as $kelas) {
            $sesiHariIni = SesiPresensi::where('id_kelas', $kelas->id_kelas)
                ->whereDate('tanggal', $todayStr)
                ->first();

            $sudahAbsen = false;
            if ($sesiHariIni) {
                $presensi = Presensi::where('id_sesi', $sesiHariIni->id_sesi)
                    ->where('id_siswa', $siswa->id_user)
                    ->first();

                if ($presensi && in_array($presensi->status, ['hadir', 'terlambat'], true)) {
                    $sudahAbsen = true;
                }
            }

            if (!$sudahAbsen) {
                $jamBatasInfo = $kelas->jam_batas ? " sebelum jam {$kelas->jam_batas}" : "";
                $notifikasi[] = [
                    'id' => 'absen-today-' . $kelas->id_kelas . '-' . $todayStr,
                    'kategori' => 'hari_ini',
                    'tipe' => 'info',
                    'badge' => 'Hari Ini',
                    'badge_color' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'icon' => 'calendar',
                    'judul' => 'Presensi Kelas Hari Ini',
                    'pesan' => "Kelas {$kelas->nama} aktif hari ini. Jangan lupa lakukan presensi kehadiran{$jamBatasInfo}!",
                    'waktu' => 'Hari ini, ' . $today->locale('id')->translatedFormat('d F Y'),
                    'action_url' => route('siswa.profil'),
                    'action_label' => 'Buka QR Presensi',
                ];
            }
        }

        // 2. MELEWATKAN ABSENSI (SESI KELAS DALAM 7 HARI TERAKHIR YANG TIDAK DIHADIRI)
        $tujuhHariLalu = now()->subDays(7)->toDateString();

        $sesiLewat = SesiPresensi::whereHas('kelas', function ($q) use ($siswa) {
                $q->where('id_jenjang', $siswa->id_jenjang)->where('aktif', true);
            })
            ->whereDate('tanggal', '>=', $tujuhHariLalu)
            ->whereDate('tanggal', '<', $todayStr)
            ->with('kelas')
            ->orderByDesc('tanggal')
            ->get();

        foreach ($sesiLewat as $sesi) {
            if (Schema::hasTable('kelas_siswa') && $siswa->kelasDiikuti()->exists()) {
                if (!$siswa->kelasDiikuti()->where('kelas.id_kelas', $sesi->id_kelas)->exists()) {
                    continue;
                }
            }

            $presensi = Presensi::where('id_sesi', $sesi->id_sesi)
                ->where('id_siswa', $siswa->id_user)
                ->first();

            if (!$presensi || in_array($presensi->status, ['alpa', 'tidak_hadir'], true)) {
                $tglFormatted = $sesi->tanggal ? $sesi->tanggal->locale('id')->translatedFormat('l, d F Y') : '-';
                $notifikasi[] = [
                    'id' => 'absen-missed-' . $sesi->id_sesi . '-' . $siswa->id_user,
                    'kategori' => 'terlewat',
                    'tipe' => 'danger',
                    'badge' => 'Terlewat',
                    'badge_color' => 'bg-rose-100 text-rose-700 border-rose-200',
                    'icon' => 'alert',
                    'judul' => 'Melewatkan Presensi',
                    'pesan' => "Kamu melewatkan presensi kelas {$sesi->kelas->nama} pada {$tglFormatted}.",
                    'waktu' => $tglFormatted,
                    'action_url' => route('siswa.profil'),
                    'action_label' => 'Cek Profil Siswa',
                ];
            }
        }

        return $notifikasi;
    }

    /**
     * Mengambil daftar notifikasi presensi untuk Orang Tua (memantau semua ananda).
     *
     * @param User $orangtua
     * @return array<int, array<string, mixed>>
     */
    public static function untukOrangtua(User $orangtua): array
    {
        if (!Schema::hasTable('kelas') || !Schema::hasTable('sesi_presensi') || !Schema::hasTable('presensi') || !Schema::hasTable('orangtua_siswa')) {
            return [];
        }

        $siswaIds = OrangtuaSiswa::where('id_orangtua', $orangtua->id_user)->pluck('id_siswa');
        if ($siswaIds->isEmpty()) {
            return [];
        }

        $anakList = User::whereIn('id_user', $siswaIds)->get();
        $semuaNotif = [];

        foreach ($anakList as $anak) {
            $notifAnak = static::untukSiswa($anak);
            foreach ($notifAnak as $item) {
                $namaAnak = $anak->nama;
                $isHariIni = $item['kategori'] === 'hari_ini';

                $semuaNotif[] = [
                    'id' => 'ot-' . $anak->id_user . '-' . $item['id'],
                    'anak_id' => $anak->id_user,
                    'nama_anak' => $namaAnak,
                    'kategori' => $item['kategori'],
                    'tipe' => $item['tipe'],
                    'badge' => $namaAnak . ' · ' . $item['badge'],
                    'badge_color' => $item['badge_color'],
                    'icon' => $item['icon'],
                    'judul' => $isHariIni ? "Jadwal Presensi: {$namaAnak}" : "Presensi Terlewat: {$namaAnak}",
                    'pesan' => $isHariIni
                        ? "Hari ini ananda {$namaAnak} memiliki jadwal kelas presensi aktif. Pastikan ananda melakukan presensi kehadiran."
                        : "Ananda {$namaAnak} melewatkan presensi kelas " . ($item['pesan'] ? preg_replace('/^Kamu melewatkan presensi kelas /', '', $item['pesan']) : '.'),
                    'waktu' => $item['waktu'],
                    'action_url' => route('orangtua.dashboard', ['siswa_id' => $anak->id_user]),
                    'action_label' => 'Pantau Ananda',
                ];
            }
        }

        return $semuaNotif;
    }
}
