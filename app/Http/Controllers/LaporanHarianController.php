<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\LaporanHarian;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LaporanHarianController extends Controller
{
    public function index()
    {
        return redirect()->route('guru.presensi.index', ['tab' => 'pelaporan']);
    }

    public function edit(Request $request, int $id)
    {
        $sesi = $this->sesiGuru($request, $id);
        $sesi->load(['kelas.jenjang', 'presensi.siswa']);

        $mapel = Mapel::forJenjang($sesi->kelas->id_jenjang)
            ->orderBy('nama_mapel')
            ->get();
        $hadir = $sesi->presensi
            ->whereIn('status', ['hadir', 'terlambat'])
            ->sortBy(fn (Presensi $presensi) => $presensi->siswa?->nama);
        $laporan = $sesi->laporanHarian()->with('mapel')->first();

        return view('guru.laporan-harian.edit', compact('sesi', 'mapel', 'hadir', 'laporan'));
    }

    public function update(Request $request, int $id)
    {
        $sesi = $this->sesiGuru($request, $id);
        $sesi->load('kelas');

        $data = $request->validate([
            'id_mapel' => ['required', 'integer', Rule::exists('mapel', 'id_mapel')],
            'waktu_mulai' => ['required', 'date_format:H:i'],
            'waktu_selesai' => ['required', 'date_format:H:i', 'after:waktu_mulai'],
            'id_siswa_bintang' => [
                'required',
                'integer',
                Rule::exists('presensi', 'id_siswa')->where(
                    fn ($query) => $query->where('id_sesi', $sesi->id_sesi)
                        ->whereIn('status', ['hadir', 'terlambat'])
                ),
            ],
        ], [
            'id_mapel.required' => 'Mata pelajaran wajib dipilih.',
            'waktu_mulai.required' => 'Jam mulai wajib diisi.',
            'waktu_selesai.required' => 'Jam selesai wajib diisi.',
            'waktu_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'id_siswa_bintang.required' => 'Pilih satu siswa yang hadir sebagai siswa bintang.',
            'id_siswa_bintang.exists' => 'Siswa bintang harus merupakan siswa yang hadir pada sesi ini.',
        ]);

        $mapelValid = Mapel::forJenjang($sesi->kelas->id_jenjang)
            ->where('id_mapel', $data['id_mapel'])
            ->exists();
        if (!$mapelValid) {
            return back()
                ->withInput()
                ->withErrors(['id_mapel' => 'Mata pelajaran tidak sesuai dengan jenjang kelas ini.']);
        }

        DB::transaction(function () use ($data, $request, $sesi) {
            LaporanHarian::updateOrCreate(
                ['id_sesi' => $sesi->id_sesi],
                [
                    'id_guru' => $request->user()->id_user,
                    'id_mapel' => $data['id_mapel'],
                    'waktu_mulai' => $data['waktu_mulai'],
                    'waktu_selesai' => $data['waktu_selesai'],
                    'kelas_berlaku_dari' => $sesi->kelas->berlaku_dari,
                    'kelas_berlaku_sampai' => $sesi->kelas->berlaku_sampai,
                ]
            );

            Presensi::where('id_sesi', $sesi->id_sesi)->update(['is_bintang' => false]);
            Presensi::where('id_sesi', $sesi->id_sesi)
                ->where('id_siswa', $data['id_siswa_bintang'])
                ->update(['is_bintang' => true]);
        });

        return redirect()->route('guru.presensi.index', ['tab' => 'pelaporan'])
            ->with('success', 'Laporan harian dan siswa bintang berhasil disimpan.');
    }

    public function adminIndex(Request $request)
    {
        $request->validate([
            'tanggal' => ['nullable', 'date'],
            'id_guru' => ['nullable', 'integer', Rule::exists('user', 'id_user')->where('id_tipeuser', 2)],
        ]);

        $laporanQuery = LaporanHarian::with([
            'guru',
            'mapel',
            'sesi.kelas.jenjang',
            'sesi.presensi.siswa',
        ])->orderByDesc('created_at');

        if ($request->filled('tanggal')) {
            $laporanQuery->whereHas('sesi', fn ($query) => $query->whereDate('tanggal', $request->query('tanggal')));
        }
        if ($request->filled('id_guru')) {
            $laporanQuery->where('id_guru', $request->query('id_guru'));
        }

        $laporan = $laporanQuery->paginate(25)->withQueryString();
        $guruList = User::where('id_tipeuser', 2)->orderBy('nama')->get(['id_user', 'nama']);

        return view('admin.laporan-harian.index', compact('laporan', 'guruList'));
    }

    private function sesiGuru(Request $request, int $id): SesiPresensi
    {
        $sesi = SesiPresensi::with('kelas')->findOrFail($id);
        $guru = $request->user();

        abort_unless(
            $guru->isGuru() && $guru->kelasDiampu()->where('kelas.id_kelas', $sesi->id_kelas)->exists(),
            403
        );

        return $sesi;
    }
}
