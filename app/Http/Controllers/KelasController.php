<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/** Manajemen kelas (peserta = siswa sejenjang) dan penugasan guru. Khusus admin. */
class KelasController extends Controller
{
    public function index()
    {
        Gate::authorize('kelola-sistem');

        $kelasList = Kelas::with('jenjang')
            ->withCount('guru')
            ->orderByDesc('aktif')
            ->orderBy('nama')
            ->get();

        // Jumlah siswa aktif per jenjang (satu query, bukan per kelas).
        $siswaPerJenjang = User::where('id_tipeuser', 3)
            ->where(function ($w) {
                $w->whereNull('status_akun')->orWhere('status_akun', '!=', 'Nonaktif');
            })
            ->selectRaw('id_jenjang, count(*) as total')
            ->groupBy('id_jenjang')
            ->pluck('total', 'id_jenjang');

        return view('admin.kelas.index', [
            'kelasList' => $kelasList,
            'siswaPerJenjang' => $siswaPerJenjang,
            'jenjangList' => Jenjang::orderBy('id_jenjang')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('kelola-sistem');

        $data = $this->validasiKelas($request);
        $kelas = Kelas::create($data + ['aktif' => true]);

        // Sesi presensi hari ini dibuat otomatis jika kelas aktif hari ini; hari berikutnya
        // dibuat otomatis pada setiap hari aktif kelas.
        $sesi = SesiPresensi::pastikanUntuk($kelas, now(), $request->user()->id_user);

        $pesan = 'Kelas berhasil dibuat. Siswa pada jenjang yang dipilih otomatis menjadi peserta. Tugaskan guru pengampu. '
            . ($sesi
                ? 'Sesi presensi hari ini sudah siap dipindai.'
                : 'Sesi presensi dibuat otomatis pada hari aktif kelas (' . $kelas->ringkasJadwal() . ').');

        return redirect()->route('admin.kelas.show', $kelas->id_kelas)->with('success', $pesan);
    }

    public function show($id)
    {
        Gate::authorize('kelola-sistem');

        $kelas = Kelas::with(['jenjang', 'guru'])->findOrFail($id);

        $peserta = $kelas->anggota()->orderBy('nama')->get(['id_user', 'nama']);

        $guruTersedia = User::where('id_tipeuser', 2)
            ->whereNotIn('id_user', $kelas->guru->pluck('id_user'))
            ->orderBy('nama')
            ->get(['id_user', 'nama']);

        return view('admin.kelas.show', [
            'kelas' => $kelas,
            'peserta' => $peserta,
            'guruTersedia' => $guruTersedia,
            'jenjangList' => Jenjang::orderBy('id_jenjang')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('kelola-sistem');

        $kelas = Kelas::findOrFail($id);
        $data = $this->validasiKelas($request);
        $data['aktif'] = $request->boolean('aktif');
        $kelas->update($data);
        $kelas->refresh();

        // Jadwal berubah: pastikan sesi hari ini ada (jika kelas aktif hari ini) dan
        // samakan batas tepat waktu sesi otomatis hari ini dengan pengaturan terbaru.
        $sesi = SesiPresensi::pastikanUntuk($kelas, now(), $request->user()->id_user);
        if ($sesi && $sesi->kunci_otomatis) {
            $sesi->update(['batas_tepat_waktu' => $kelas->batasPada(now())]);
        }

        return back()->with('success', 'Data kelas diperbarui.');
    }

    public function destroy($id)
    {
        Gate::authorize('kelola-sistem');

        Kelas::findOrFail($id)->delete();

        return redirect()->route('admin.kelas')->with('success', 'Kelas dihapus.');
    }

    public function tambahGuru(Request $request, $id)
    {
        Gate::authorize('kelola-sistem');

        $kelas = Kelas::findOrFail($id);
        $request->validate(
            ['id_guru' => ['required', 'integer']],
            ['id_guru.required' => 'Pilih guru terlebih dahulu.']
        );

        $guru = User::where('id_tipeuser', 2)->find($request->id_guru);
        if (!$guru) {
            return back()->withErrors(['id_guru' => 'Guru tidak ditemukan.']);
        }

        $kelas->guru()->syncWithoutDetaching([$guru->id_user]);

        return back()->with('success', $guru->nama . ' ditugaskan ke kelas ini.');
    }

    public function hapusGuru($id, $guru)
    {
        Gate::authorize('kelola-sistem');

        Kelas::findOrFail($id)->guru()->detach((int) $guru);

        return back()->with('success', 'Penugasan guru dicabut.');
    }

    private function validasiKelas(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'id_jenjang' => ['required', 'integer', 'exists:jenjang,id_jenjang'],
            'tahun_ajaran' => ['nullable', 'string', 'max:20'],
            'hari' => ['nullable', 'array'],
            'hari.*' => ['integer', 'between:1,7'],
            'berlaku_dari' => ['nullable', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_dari'],
            'jam_batas' => ['nullable', 'date_format:H:i'],
        ], [
            'nama.required' => 'Nama kelas wajib diisi.',
            'nama.max' => 'Nama kelas maksimal 150 karakter.',
            'id_jenjang.required' => 'Jenjang wajib dipilih. Semua siswa pada jenjang itu otomatis menjadi peserta kelas.',
            'id_jenjang.exists' => 'Jenjang tidak valid.',
            'hari.*.between' => 'Hari tidak valid.',
            'berlaku_dari.date' => 'Tanggal mulai berlaku tidak valid.',
            'berlaku_sampai.date' => 'Tanggal akhir berlaku tidak valid.',
            'berlaku_sampai.after_or_equal' => 'Tanggal akhir berlaku tidak boleh sebelum tanggal mulai.',
            'jam_batas.date_format' => 'Format batas tepat waktu harus JJ:MM, misalnya 08:15.',
        ]);

        // Hari disimpan sebagai CSV terurut; kosong = setiap hari.
        $hari = collect($data['hari'] ?? [])->map(fn ($h) => (int) $h)->unique()->sort()->values();
        $data['hari'] = $hari->isEmpty() ? null : $hari->implode(',');
        $data['berlaku_dari'] = $data['berlaku_dari'] ?? null;
        $data['berlaku_sampai'] = $data['berlaku_sampai'] ?? null;
        $data['jam_batas'] = $data['jam_batas'] ?? null;

        return $data;
    }
}
