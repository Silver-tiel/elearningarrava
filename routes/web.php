<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\OrangtuaController;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AnakSayaController;
use App\Http\Controllers\PerkembanganNilaiController;
use App\Http\Controllers\MateriPembelajaranController;
use App\Http\Controllers\PencapaianController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\QrAdminController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaQrController;


// Halaman pendaftaran.
Route::get('/pendaftaran', function () {
    $jenjang = App\Models\jenjang::all();
    return view('pendaftaran', ['jenjang' => $jenjang]);
})->name('pendaftaran');

// Langsung arahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
})->name('beranda');

Route::get('/home', function () {
    return redirect()->route('login');
})->name('home');

// Login.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout (mendukung POST dari modal logout dan GET jika diakses langsung/refresh)
Route::match(['get', 'post'], '/logout', [LogoutController::class, 'logout'])->name('logout');

// // Lupa password - UI dan endpoint awal. Pengiriman email reset dapat disambungkan
// // ke Laravel Password Broker ketika konfigurasi mail sudah tersedia.
// Route::get('/forgot-password', function () {
//     return view('forgot-password');
// })->name('password.request');

// Route::post('/forgot-password', function (Request $request) {
//     $request->validate([
//         'email' => ['required', 'email'],
//     ]);

//     return back()->with('status', 'Jika email terdaftar, tautan pengaturan ulang akan diproses.');
// })->name('password.email');

// Proses pendaftaran.
Route::post('/pendaftaran', [PendaftaranController::class, 'UserBaru'])->name('pendaftaranBaru');

// Dashboard.
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && ($user->id_tipeuser == 1 || $user->id_tipeuser == 2)) {
        return redirect()->route('admin');
    }
    if ($user && $user->id_tipeuser == 4) {
        return redirect()->route('orangtua.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth', 'active.student']);

// Orangtua routes.
Route::prefix('orangtua')
    ->name('orangtua.')
    ->middleware(['auth', 'active.student', 'role:orangtua'])
    ->group(function () {
        Route::get('/dashboard', [OrangtuaController::class, 'dashboard'])->name('dashboard');

        Route::get('/anak-saya', [AnakSayaController::class, 'index'])->name('anak-saya');

        Route::get('/perkembangan-nilai', [PerkembanganNilaiController::class, 'index'])->name('perkembangan-nilai');

        Route::get('/pengaturan', [OrangtuaController::class, 'pengaturan'])->name('pengaturan');
        Route::put('/pengaturan', [OrangtuaController::class, 'updatePengaturan'])->name('pengaturan.update');

        Route::get('/materi-pembelajaran', [MateriPembelajaranController::class, 'index'])->name('materi-pembelajaran');
        Route::get('/pencapaian', [PencapaianController::class, 'index'])->name('pencapaian');

        Route::get('/riwayat-quiz', [OrangtuaController::class, 'riwayatQuiz'])
        ->name('riwayat-quiz');

        Route::get('/aktivitas-belajar', [OrangtuaController::class, 'aktivitasBelajar'])
        ->name('aktivitas-belajar');

        Route::get('/absensi', [OrangtuaController::class, 'absensi'])
        ->name('absensi');
    });

// Route Notifikasi Presensi Realtime (Siswa & Orang Tua)
Route::middleware(['auth', 'active.student', 'role:siswa,orangtua'])->group(function () {
    Route::get('/notifikasi/check', [\App\Http\Controllers\NotifikasiController::class, 'check'])->name('notifikasi.check');
    Route::post('/notifikasi/mark-read', [\App\Http\Controllers\NotifikasiController::class, 'markRead'])->name('notifikasi.mark_read');
});

// Global Route untuk semua user login
Route::get('/modul/{id}/show', [ModulController::class, 'show'])->name('modul.show')->middleware(['auth', 'active.student', 'role:admin,guru,siswa,orangtua']);

// Admin dashboard.
Route::get('/admin', function () {
    $user = Auth::user();
    // Siswa tidak boleh akses halaman admin
    if ($user && $user->id_tipeuser == 3) {
        return redirect()->route('siswa.dashboard');
    }

    $dashboardView = in_array(request('view'), ['overview', 'siswa', 'guru'], true)
        ? request('view')
        : 'overview';
    $isGuru = $user && $user->isGuru();
    $modulQuery = Modul::query();
    $quizQuery = Quiz::query();

    if (in_array($dashboardView, ['overview', 'guru'], true)) {
        if ($isGuru && \Illuminate\Support\Facades\Schema::hasColumn('modul', 'id_pembuat')) {
            $modulQuery->where('id_pembuat', $user->id_user);
        }
        if ($isGuru && \Illuminate\Support\Facades\Schema::hasColumn('quiz', 'id_pembuat')) {
            $quizQuery->where('id_pembuat', $user->id_user);
        }
    }

    $logAktivitasTersedia = $dashboardView === 'overview' && Schema::hasTable('logaktivitas');
    $awalMinggu = now()->startOfWeek(Carbon::MONDAY)->startOfDay();
    $akhirMinggu = $awalMinggu->copy()->addDays(6)->endOfDay();
    $grafikPenyelesaianMingguan = collect();
    $hasilKuisMingguIni = collect();
    $jumlahSubmitKuis = 0;
    $rataNilaiKuis = null;
    $persentaseLulusKuis = null;
    $hasilKuisPerJenjang = collect();
    $siswaAktifMingguIni = 0;
    $siswaAktif14HariIni = 0;
    $siswaTidakAktif14Hari = 0;
    $jumlahSiswaAktif = 0;
    $progressPerJenjang = collect();
    $presensiTersedia = false;
    $jumlahPesertaSeharusnya = 0;
    $jumlahHadirMingguan = 0;
    $persentaseHadirMingguan = null;
    $sesiPresensiSelesai = 0;
    $presensiPerJenjang = collect();
    $jenjangDashboard = collect();

    if ($dashboardView === 'siswa') {
    $hasilKuisHarian = Schema::hasTable('hasilquizmodul')
        ? DB::table('hasilquizmodul')
            ->whereIn('id_user', User::where('id_tipeuser', 3)->select('id_user'))
            ->whereBetween('waktu_dapat', [$awalMinggu, $akhirMinggu])
            ->selectRaw('DATE(waktu_dapat) as tanggal, COUNT(*) as jumlah')
            ->groupByRaw('DATE(waktu_dapat)')
            ->pluck('jumlah', 'tanggal')
        : collect();
    $modulTuntasHarian = Schema::hasTable('progres_modul_siswa')
        ? DB::table('progres_modul_siswa')
            ->whereIn('id_user', User::where('id_tipeuser', 3)->select('id_user'))
            ->where('is_tuntas', true)
            ->whereBetween('waktu_tuntas', [$awalMinggu, $akhirMinggu])
            ->selectRaw('DATE(waktu_tuntas) as tanggal, COUNT(*) as jumlah')
            ->groupByRaw('DATE(waktu_tuntas)')
            ->pluck('jumlah', 'tanggal')
        : collect();
    $grafikPenyelesaianMingguan = collect(range(0, 6))->map(function (int $offset) use ($awalMinggu, $hasilKuisHarian, $modulTuntasHarian) {
        $tanggal = $awalMinggu->copy()->addDays($offset);
        $tanggalKey = $tanggal->toDateString();

        return [
            'tanggal' => $tanggalKey,
            'label' => $tanggal->locale('id')->translatedFormat('l'),
            'kuis' => (int) ($hasilKuisHarian->get($tanggalKey) ?? 0),
            'modul' => (int) ($modulTuntasHarian->get($tanggalKey) ?? 0),
        ];
    });
    $siswaAktifQuery = fn () => User::where('id_tipeuser', 3)
        ->where(function ($query) {
            $query->whereNull('status_akun')->orWhere('status_akun', '!=', 'Nonaktif');
        });
    $jenjangDashboard = Schema::hasTable('jenjang')
        ? DB::table('jenjang')->select('id_jenjang', 'nama_tipe')->orderBy('nama_tipe')->get()
        : collect();

    $hasilKuisMingguIni = Schema::hasTable('hasilquizmodul')
        ? DB::table('hasilquizmodul as hasil')
            ->join('user as siswa', 'siswa.id_user', '=', 'hasil.id_user')
            ->where('siswa.id_tipeuser', 3)
            ->whereBetween('hasil.waktu_dapat', [$awalMinggu, now()])
            ->select('siswa.id_jenjang')
            ->selectRaw('COUNT(*) as jumlah_submit')
            ->selectRaw('AVG(CASE WHEN hasil.total_poin > 0 THEN hasil.poin_didapat * 100.0 / hasil.total_poin END) as rata_nilai')
            ->selectRaw('COUNT(CASE WHEN hasil.total_poin > 0 THEN 1 END) as jumlah_nilai')
            ->selectRaw('SUM(CASE WHEN hasil.is_lulus = 1 THEN 1 ELSE 0 END) as jumlah_lulus')
            ->groupBy('siswa.id_jenjang')
            ->get()
            ->keyBy('id_jenjang')
        : collect();

    $jumlahSubmitKuis = (int) $hasilKuisMingguIni->sum('jumlah_submit');
    $jumlahKuisLulus = (int) $hasilKuisMingguIni->sum('jumlah_lulus');
    $jumlahNilaiKuis = (int) $hasilKuisMingguIni->sum('jumlah_nilai');
    $rataNilaiKuis = $jumlahNilaiKuis > 0
        ? round((float) (
            $hasilKuisMingguIni->sum(fn ($row) => (float) ($row->rata_nilai ?? 0) * (int) $row->jumlah_nilai)
            / $jumlahNilaiKuis
        ), 1)
        : null;
    $persentaseLulusKuis = $jumlahSubmitKuis > 0
        ? round(($jumlahKuisLulus / $jumlahSubmitKuis) * 100, 1)
        : null;

    if (Schema::hasTable('modul') && Schema::hasTable('progres_modul_siswa')) {
        $modulPerJenjang = Modul::published()
            ->select('id_jenjang')
            ->selectRaw('COUNT(*) as jumlah_modul')
            ->groupBy('id_jenjang')
            ->pluck('jumlah_modul', 'id_jenjang');
        $jumlahSiswaPerJenjang = $siswaAktifQuery()
            ->select('id_jenjang')
            ->selectRaw('COUNT(*) as jumlah_siswa')
            ->groupBy('id_jenjang')
            ->pluck('jumlah_siswa', 'id_jenjang');
        $modulTuntasPerJenjang = DB::table('progres_modul_siswa as progres')
            ->join('user as siswa', 'siswa.id_user', '=', 'progres.id_user')
            ->join('modul', 'modul.id_modul', '=', 'progres.id_modul')
            ->where('siswa.id_tipeuser', 3)
            ->where(function ($query) {
                $query->whereNull('siswa.status_akun')->orWhere('siswa.status_akun', '!=', 'Nonaktif');
            })
            ->where('progres.is_tuntas', true)
            ->whereColumn('modul.id_jenjang', 'siswa.id_jenjang')
            ->where(function ($query) {
                $query->whereNull('modul.progressModul')->orWhere('modul.progressModul', '!=', 'Draft');
            })
            ->whereNotNull('siswa.id_jenjang')
            ->select('siswa.id_jenjang')
            ->selectRaw('COUNT(*) as jumlah_tuntas')
            ->groupBy('siswa.id_jenjang')
            ->pluck('jumlah_tuntas', 'id_jenjang');

        $progressPerJenjang = $jenjangDashboard->map(function ($jenjang) use ($modulPerJenjang, $jumlahSiswaPerJenjang, $modulTuntasPerJenjang) {
            $jumlahModul = (int) ($modulPerJenjang->get($jenjang->id_jenjang) ?? 0);
            $jumlahSiswa = (int) ($jumlahSiswaPerJenjang->get($jenjang->id_jenjang) ?? 0);
            $jumlahPeluangTuntas = $jumlahModul * $jumlahSiswa;
            $jumlahTuntas = (int) ($modulTuntasPerJenjang->get($jenjang->id_jenjang) ?? 0);

            return [
                'jenjang' => $jenjang->nama_tipe,
                'jumlah_siswa' => $jumlahSiswa,
                'jumlah_modul' => $jumlahModul,
                'jumlah_tuntas' => $jumlahTuntas,
                'persentase' => $jumlahPeluangTuntas > 0
                    ? min(100, round(($jumlahTuntas / $jumlahPeluangTuntas) * 100, 1))
                    : null,
            ];
        })->values();
    }

    $aktivitasMingguIni = collect();
    $aktivitas14HariIni = collect();
    if (Schema::hasTable('hasilquizmodul')) {
        $aktivitasMingguIni = $aktivitasMingguIni->merge(
            DB::table('hasilquizmodul')
                ->whereIn('id_user', $siswaAktifQuery()->select('id_user'))
                ->whereBetween('waktu_dapat', [$awalMinggu, now()])
                ->distinct()
                ->pluck('id_user')
        );
        $aktivitas14HariIni = $aktivitas14HariIni->merge(
            DB::table('hasilquizmodul')
                ->whereIn('id_user', $siswaAktifQuery()->select('id_user'))
                ->whereBetween('waktu_dapat', [now()->copy()->subDays(14), now()])
                ->distinct()
                ->pluck('id_user')
        );
    }
    if (Schema::hasTable('progres_modul_siswa')) {
        $aktivitasMingguIni = $aktivitasMingguIni->merge(
            DB::table('progres_modul_siswa')
                ->whereIn('id_user', $siswaAktifQuery()->select('id_user'))
                ->whereBetween('updated_at', [$awalMinggu, now()])
                ->distinct()
                ->pluck('id_user')
        );
        $aktivitas14HariIni = $aktivitas14HariIni->merge(
            DB::table('progres_modul_siswa')
                ->whereIn('id_user', $siswaAktifQuery()->select('id_user'))
                ->whereBetween('updated_at', [now()->copy()->subDays(14), now()])
                ->distinct()
                ->pluck('id_user')
        );
    }
    $siswaAktifMingguIni = $aktivitasMingguIni->unique()->count();
    $siswaAktif14HariIni = $aktivitas14HariIni->unique()->count();
    $siswaTidakAktif14Hari = max(0, (int) $siswaAktifQuery()->count() - $siswaAktif14HariIni);

    $presensiTersedia = Schema::hasTable('sesi_presensi')
        && Schema::hasTable('presensi')
        && Schema::hasTable('kelas');
    $presensiMingguan = collect();
    if ($presensiTersedia) {
        $hadirPerSesi = DB::table('presensi as presensi')
            ->join('user as siswa', 'siswa.id_user', '=', 'presensi.id_siswa')
            ->where('siswa.id_tipeuser', 3)
            ->where(function ($query) {
                $query->whereNull('siswa.status_akun')->orWhere('siswa.status_akun', '!=', 'Nonaktif');
            })
            ->select('presensi.id_sesi')
            ->selectRaw('COUNT(DISTINCT presensi.id_siswa) as jumlah_hadir')
            ->groupBy('presensi.id_sesi');
        $presensiMingguan = DB::table('sesi_presensi as sesi')
            ->join('kelas', 'kelas.id_kelas', '=', 'sesi.id_kelas')
            ->leftJoinSub($hadirPerSesi, 'rekap_hadir', function ($join) {
                $join->on('rekap_hadir.id_sesi', '=', 'sesi.id_sesi');
            })
            ->whereNotNull('kelas.id_jenjang')
            ->whereBetween('sesi.tanggal', [$awalMinggu->toDateString(), now()->toDateString()])
            ->where(function ($query) {
                $query->where('sesi.tanggal', '<', now()->toDateString())
                    ->orWhere(function ($today) {
                        $today->where('sesi.tanggal', now()->toDateString())
                            ->where('sesi.status', 'tutup');
                    });
            })
            ->select('sesi.id_sesi', 'kelas.id_jenjang')
            ->selectRaw('COALESCE(rekap_hadir.jumlah_hadir, 0) as jumlah_hadir')
            ->get();
    }
    $jumlahSiswaPresensiPerJenjang = [];
    foreach ($presensiMingguan as $sesi) {
        $idJenjang = (int) $sesi->id_jenjang;
        if (!array_key_exists($idJenjang, $jumlahSiswaPresensiPerJenjang)) {
            $jumlahSiswaPresensiPerJenjang[$idJenjang] = (int) $siswaAktifQuery()
                ->where('id_jenjang', $idJenjang)
                ->count();
        }
        $peserta = $jumlahSiswaPresensiPerJenjang[$idJenjang];
        if ($peserta === 0) {
            continue;
        }
        $jumlahPesertaSeharusnya += $peserta;
        $jumlahHadir = min($peserta, (int) $sesi->jumlah_hadir);
        $jumlahHadirMingguan += $jumlahHadir;
        $sesiPresensiSelesai++;

        $rekapJenjang = $presensiPerJenjang->get($idJenjang, [
            'jenjang' => $jenjangDashboard->firstWhere('id_jenjang', $idJenjang)?->nama_tipe ?? 'Lainnya',
            'jumlah_hadir' => 0,
            'jumlah_peserta' => 0,
            'jumlah_sesi' => 0,
        ]);
        $rekapJenjang['jumlah_hadir'] += $jumlahHadir;
        $rekapJenjang['jumlah_peserta'] += $peserta;
        $rekapJenjang['jumlah_sesi']++;
        $presensiPerJenjang->put($idJenjang, $rekapJenjang);
    }
    $persentaseHadirMingguan = $jumlahPesertaSeharusnya > 0
        ? round(($jumlahHadirMingguan / $jumlahPesertaSeharusnya) * 100, 1)
        : null;
    $presensiPerJenjang = $presensiPerJenjang->map(function ($rekap) {
        $rekap['persentase'] = $rekap['jumlah_peserta'] > 0
            ? round(($rekap['jumlah_hadir'] / $rekap['jumlah_peserta']) * 100, 1)
            : null;

        return $rekap;
    })->values();
    $jumlahSiswaAktif = (int) $siswaAktifQuery()->count();
    $hasilKuisPerJenjang = $jenjangDashboard->map(function ($jenjang) use ($hasilKuisMingguIni) {
        $hasil = $hasilKuisMingguIni->get($jenjang->id_jenjang);
        $jumlahSubmit = (int) ($hasil->jumlah_submit ?? 0);

        return [
            'jenjang' => $jenjang->nama_tipe,
            'jumlah_submit' => $jumlahSubmit,
            'rata_nilai' => $hasil?->rata_nilai !== null ? round((float) $hasil->rata_nilai, 1) : null,
            'persentase_lulus' => $jumlahSubmit > 0
                ? round(((int) $hasil->jumlah_lulus / $jumlahSubmit) * 100, 1)
                : null,
        ];
    })->values();
    }

    $registrasiBulanan = collect();
    $awalBulanRegistrasi = now()->startOfMonth()->subMonths(5)->startOfDay();
    if (in_array($dashboardView, ['overview', 'guru'], true)) {
        $tipeRegistrasi = $dashboardView === 'guru' ? [2] : [2, 3];
        $registrasiBulananRaw = User::whereIn('id_tipeuser', $tipeRegistrasi)
            ->whereBetween('created_at', [$awalBulanRegistrasi, now()])
            ->get(['id_tipeuser', 'created_at'])
            ->groupBy(fn (User $registeredUser) => $registeredUser->created_at?->format('Y-m'));
        $registrasiBulanan = collect(range(0, 5))->map(function (int $offset) use ($awalBulanRegistrasi, $registrasiBulananRaw) {
        $bulan = $awalBulanRegistrasi->copy()->addMonths($offset);
        $dataBulan = $registrasiBulananRaw->get($bulan->format('Y-m'), collect());

        return [
            'bulan' => $bulan->locale('id')->translatedFormat('M Y'),
            'siswa' => $dataBulan->where('id_tipeuser', 3)->count(),
            'guru' => $dataBulan->where('id_tipeuser', 2)->count(),
        ];
        });
    }

    return view('admin.admin', [
        'dashboardView' => $dashboardView,
        'siswaCount' => $dashboardView === 'overview' ? User::where('id_tipeuser', 3)->count() : 0,
        'guruCount' => in_array($dashboardView, ['overview', 'guru'], true) ? User::where('id_tipeuser', 2)->count() : 0,
        'kelasCount' => $dashboardView === 'overview' && Schema::hasTable('kelas') ? Kelas::count() : 0,
        'modulCount' => in_array($dashboardView, ['overview', 'guru'], true) ? (clone $modulQuery)->count() : 0,
        'quizCount' => in_array($dashboardView, ['overview', 'guru'], true) ? (clone $quizQuery)->count() : 0,
        'achievementCount' => $dashboardView === 'overview' ? Achievement::count() : 0,
        'siswaTerbaru' => $dashboardView === 'siswa' ? User::where('id_tipeuser', 3)->latest()->take(5)->get() : collect(),
        'modulTerbaru' => in_array($dashboardView, ['overview', 'guru'], true) ? (clone $modulQuery)->with(['jenjang'])->latest()->take(5)->get() : collect(),
        'logAktivitasTersedia' => $logAktivitasTersedia,
        'logAktivitasTerbaru' => $dashboardView === 'overview' && $user?->isAdmin() && $logAktivitasTersedia
            ? LogAktivitas::with('user')->orderByDesc('waktu_kegiataan')->take(8)->get()
            : collect(),
        'grafikPenyelesaianMingguan' => $grafikPenyelesaianMingguan,
        'rentangMinggu' => $awalMinggu->locale('id')->translatedFormat('d M') . ' - ' . $akhirMinggu->locale('id')->translatedFormat('d M Y'),
        'jumlahSubmitKuis' => $jumlahSubmitKuis,
        'rataNilaiKuis' => $rataNilaiKuis,
        'persentaseLulusKuis' => $persentaseLulusKuis,
        'hasilKuisPerJenjang' => $hasilKuisPerJenjang,
        'siswaAktifMingguIni' => $siswaAktifMingguIni,
        'siswaAktif14HariIni' => $siswaAktif14HariIni,
        'siswaTidakAktif14Hari' => $siswaTidakAktif14Hari,
        'jumlahSiswaAktif' => $jumlahSiswaAktif,
        'progressPerJenjang' => $progressPerJenjang,
        'presensiTersedia' => $presensiTersedia,
        'sesiPresensiSelesai' => $sesiPresensiSelesai,
        'jumlahHadirMingguan' => $jumlahHadirMingguan,
        'jumlahPesertaSeharusnya' => $jumlahPesertaSeharusnya,
        'persentaseHadirMingguan' => $persentaseHadirMingguan,
        'presensiPerJenjang' => $presensiPerJenjang,
        'registrasiBulanan' => $registrasiBulanan,
        'rentangRegistrasi' => $awalBulanRegistrasi->locale('id')->translatedFormat('M Y') . ' - ' . now()->locale('id')->translatedFormat('M Y'),
    ]);
})->middleware(['auth', 'active.student', 'role:admin,guru'])->name('admin');

// Siswa.
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'active.student', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');

    // Halaman Belajar
    Route::get('/belajar', [SiswaController::class, 'belajar'])->name('modul');
    Route::get('/belajar/{id_modul}/materi', [SiswaController::class, 'materiVideoDetail'])->name('modul.materi');
    Route::get('/belajar/{id_modul}/latihan', [SiswaController::class, 'latihanSoalModul'])->name('modul.latihan');
    Route::post('/belajar/{id_modul}/selesai-materi', [SiswaController::class, 'tandaiMateriSelesai'])->name('modul.selesai_materi');
    Route::post('/belajar/{id_modul}/kuis-submit', [SiswaController::class, 'submitKuisModul'])->name('modul.kuis_submit');

    // Quiz global
    Route::get('/quiz', [SiswaController::class, 'quiz'])->name('quiz');
    Route::get('/quiz/{quiz}/detail', [SiswaController::class, 'detailQuiz'])->name('quiz.detail');
    Route::post('/quiz/{quiz}/mulai', [SiswaController::class, 'mulaiQuiz'])->name('quiz.mulai');
    Route::get('/quiz/{quiz}', [SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
    Route::post('/quiz/{quiz}/submit', [SiswaController::class, 'submitQuiz'])->name('quiz.submit');

    Route::get('/profil', [SiswaController::class, 'profile'])->name('profil');
    Route::put('/profil/update', [SiswaController::class, 'updateProfile'])->name('profil.update');
    Route::patch('/profil/hero-theme', [SiswaController::class, 'updateHeroTheme'])->name('profil.hero_theme');

    Route::get('/leaderboard', [SiswaController::class, 'leaderboard'])->name('leaderboard');

    Route::get('/qr', [SiswaQrController::class, 'show'])->name('qr');
});

// Profil guru (hanya untuk guru yang login)
Route::get('/admin/profil', [GuruController::class, 'profil'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.profil');

// Admin resource routes (dikelompokkan dengan prefix & middleware)
Route::prefix('admin')->middleware(['auth', 'active.student', 'role:admin,guru'])->group(function () {
    Route::get('/modul', [ModulController::class, 'index'])->name('admin.modul');
    Route::get('/modul/create', [ModulController::class, 'create'])->name('admin.modul.create');
    Route::post('/modul/store', [ModulController::class, 'store'])->name('admin.modul.store');
    Route::get('/modul/{id}/edit', [ModulController::class, 'edit'])->name('admin.modul.edit');
    Route::put('/modul/{id}', [ModulController::class, 'update'])->name('admin.modul.update');
    Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('admin.modul.destroy');

    Route::get('/quiz',         [QuizController::class, 'index'])->name('admin.quiz');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('quiz.create');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('admin.quiz.create');
    Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])->name('admin.quiz.edit');
    Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('admin.quiz.update');
    Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');
    Route::get('/quiz/{id}/preview', [SiswaController::class, 'previewQuiz'])->name('admin.quiz.preview');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('quiz.store');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('admin.quiz.store');

    Route::get('/soal',         [SoalController::class, 'index'])->name('admin.soal');
    Route::get('/soal/create',  [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal/store',  [SoalController::class, 'store'])->name('soal.store');
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit');
    Route::put('/soal/{id}',    [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy');
});

// ADMIN SAJA: manajemen user/data siswa, guru, penghargaan, kelas, penugasan, QR.
// Guru TIDAK boleh mengakses grup ini.
Route::prefix('admin')->middleware(['auth', 'active.student', 'role:admin'])->group(function () {
    // Route untuk Halaman Utama/Tabel Daftar Siswa
    Route::get('/data', [SiswaController::class, 'dataSiswa'])->name('admin.daftar_siswa');
    Route::get('/data/{id}/profil', [SiswaController::class, 'adminLihatProfilSiswa'])->name('admin.siswa.profil');
    Route::patch('/data/{id}', [SiswaController::class, 'updateStudentData'])->name('admin.siswa.update');
    Route::patch('/data/{id}/jenjang', [SiswaController::class, 'updateStudentJenjang'])->name('admin.siswa.jenjang');
    Route::post('/data/jenjang-massal', [SiswaController::class, 'updateStudentJenjangMassal'])->name('admin.siswa.jenjang.massal');
    Route::patch('/data/{id}/status', [SiswaController::class, 'updateStatus'])->name('admin.siswa.status');

    // Route Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('admin.guru');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    // Route Achievement / Penghargaan Siswa
    Route::get('/achievement', [AchievementController::class, 'index'])->name('admin.achievement');
    Route::get('/achievement/create', [AchievementController::class, 'create'])->name('admin.achievement.create');
    Route::post('/achievement', [AchievementController::class, 'store'])->name('admin.achievement.store');
    Route::get('/achievement/{id}/edit', [AchievementController::class, 'edit'])->name('admin.achievement.edit');
    Route::put('/achievement/{id}', [AchievementController::class, 'update'])->name('admin.achievement.update');
    Route::delete('/achievement/{id}', [AchievementController::class, 'destroy'])->name('admin.achievement.destroy');
    Route::post('/achievement/{id}/sync', [AchievementController::class, 'sync'])->name('admin.achievement.sync');

    // Kelas, keanggotaan siswa, dan penugasan guru
    Route::get('/kelas', [KelasController::class, 'index'])->name('admin.kelas');
    Route::post('/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('/kelas/{id}', [KelasController::class, 'show'])->whereNumber('id')->name('admin.kelas.show');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->whereNumber('id')->name('admin.kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->whereNumber('id')->name('admin.kelas.destroy');
    Route::post('/kelas/{id}/siswa', [KelasController::class, 'tambahSiswa'])->whereNumber('id')->name('admin.kelas.siswa.tambah');
    Route::delete('/kelas/{id}/siswa/{siswa}', [KelasController::class, 'hapusSiswa'])->whereNumber(['id', 'siswa'])->name('admin.kelas.siswa.hapus');
    Route::post('/kelas/{id}/guru', [KelasController::class, 'tambahGuru'])->whereNumber('id')->name('admin.kelas.guru.tambah');
    Route::delete('/kelas/{id}/guru/{guru}', [KelasController::class, 'hapusGuru'])->whereNumber(['id', 'guru'])->name('admin.kelas.guru.hapus');

    // QR siswa (generate ulang)
    Route::get('/qr', [QrAdminController::class, 'index'])->name('admin.qr');
    Route::post('/qr/{siswa}/regenerate', [QrAdminController::class, 'regenerate'])->whereNumber('siswa')->name('admin.qr.regenerate');
});

// PRESENSI: guru (kelas yang diampu) dan admin (semua kelas). Otorisasi akhir lewat SesiPresensiPolicy.
Route::prefix('guru/presensi')->name('guru.presensi.')->middleware(['auth', 'active.student', 'role:admin,guru'])->group(function () {
    Route::get('/', [PresensiController::class, 'index'])->name('index');
    Route::get('/sesi/{id}', [PresensiController::class, 'scan'])->whereNumber('id')->name('scan');
    Route::get('/sesi/{id}/rekap', [PresensiController::class, 'rekap'])->whereNumber('id')->name('rekap');
    Route::post('/sesi/{id}/tutup', [PresensiController::class, 'tutup'])->whereNumber('id')->name('tutup');
    Route::post('/sesi/{id}/scan', [PresensiController::class, 'prosesScan'])
        ->whereNumber('id')->middleware('throttle:scan-qr')->name('proses');
});

// Fallback route untuk melayani file storage secara andal (mendukung php artisan serve / Windows junction)
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath) || !is_file($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => '*',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');
