<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\HasilQuizModul;
use App\Models\Modul;
use App\Models\OrangtuaSiswa;
use App\Models\PencapaianUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnakSayaController extends Controller
{
    public function index(Request $request)
    {
        $orangtuaId = Auth::id();

        // Hanya ambil siswa yang terhubung ke orang tua login.
        $siswaIds = OrangtuaSiswa::where('id_orangtua', $orangtuaId)
            ->pluck('id_siswa');

        $query = User::query()
            ->whereIn('id_user', $siswaIds)
            ->where('id_tipeuser', 3)
            ->with('jenjang');

        // Filter jenjang pendidikan jika dipilih.
        if ($request->filled('jenjang')) {
            $query->where('id_jenjang', $request->jenjang);
        }

        $siswaList = $query->get();

        // Daftar jenjang untuk dropdown filter.
        $jenjangList = DB::table('jenjang')
            ->whereIn('id_jenjang', function ($query) use ($siswaIds) {
                $query->select('id_jenjang')
                    ->from('user')
                    ->whereIn('id_user', $siswaIds)
                    ->whereNotNull('id_jenjang');
            })
            ->get();

        $totalModul = Modul::count();

        // Statistik setiap anak.
        $siswaList->transform(function ($siswa) use ($totalModul) {
            $hasilQuiz = HasilQuizModul::where('id_user', $siswa->id_user)
                ->with('quiz')
                ->orderByDesc('waktu_dapat')
                ->get();

            $nilaiList = $hasilQuiz->map(function ($hasil) {
                return (float) $hasil->total_poin > 0
                    ? ($hasil->poin_didapat / $hasil->total_poin) * 100
                    : 0;
            });

            $siswa->rata_rata_nilai = round(
                $nilaiList->isNotEmpty() ? $nilaiList->avg() : 0,
                1
            );

            // Hitung modul yang memiliki kuis dan sudah lulus.
            $quizLulus = $hasilQuiz
                ->where('is_lulus', true)
                ->pluck('id_quiz')
                ->unique();

            $modulSelesai = $totalModul > 0
                ? Modul::whereIn('id_quiz', $quizLulus)
                    ->distinct()
                    ->count('id_modul')
                : 0;

            $siswa->modul_selesai = $modulSelesai;
            $siswa->total_modul   = $totalModul;

            $siswa->progres_modul = $totalModul > 0
                ? min(100, (int) round(($modulSelesai / $totalModul) * 100))
                : 0;

            $siswa->jumlah_kuis = $hasilQuiz->count();

            $siswa->aktivitas_terakhir = $hasilQuiz->first()?->waktu_dapat;

            $siswa->peringkat = DB::table('user')
                ->where('id_tipeuser', 3)
                ->where('id_jenjang', $siswa->id_jenjang)
                ->where('total_poin', '>', (int) $siswa->total_poin)
                ->count() + 1;

            // Hitung persentase presensi / kuis (kuis yang lulus / total kuis dikerjakan).
            $totalKuisDikerjakan = $hasilQuiz->count();
            $kuisLulus = $hasilQuiz->where('is_lulus', true)->count();
            $siswa->presensi_persen = $totalKuisDikerjakan > 0
                ? min(100, (int) round(($kuisLulus / $totalKuisDikerjakan) * 100))
                : 0;

            // Label kehadiran berdasarkan persentase.
            if ($siswa->presensi_persen >= 90) {
                $siswa->label_kehadiran = 'Kehadiran Baik';
            } elseif ($siswa->presensi_persen >= 70) {
                $siswa->label_kehadiran = 'Cukup Baik';
            } else {
                $siswa->label_kehadiran = 'Perlu Perhatian';
            }

            // Jumlah lencana / achievement yang diraih siswa.
            $siswa->jumlah_lencana = PencapaianUser::where('id_user', $siswa->id_user)->count();

            // Label nilai vs KKM (KKM = 75).
            $kkm = 75;
            $selisih = round($siswa->rata_rata_nilai - $kkm, 1);
            $siswa->kkm_selisih = $selisih;
            $siswa->di_atas_target = $siswa->rata_rata_nilai >= $kkm;

            return $siswa;
        });

        return view('orangtua.anak_saya', [
            'orangtua'    => Auth::user(),
            'siswaList'   => $siswaList,
            'jenjangList' => $jenjangList,
            'jenjangAktif' => $request->jenjang,
        ]);
    }
}