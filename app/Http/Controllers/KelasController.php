<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/** Manajemen kelas, keanggotaan siswa, dan penugasan guru. Khusus admin. */
class KelasController extends Controller
{
    public function index()
    {
        Gate::authorize('kelola-sistem');

        $kelasList = Kelas::with('jenjang')
            ->withCount(['siswa', 'guru'])
            ->orderByDesc('aktif')
            ->orderBy('nama')
            ->get();

        return view('admin.kelas.index', [
            'kelasList' => $kelasList,
            'jenjangList' => Jenjang::orderBy('id_jenjang')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('kelola-sistem');

        $data = $this->validasiKelas($request);
        $kelas = Kelas::create($data + ['aktif' => true]);

        return redirect()->route('admin.kelas.show', $kelas->id_kelas)
            ->with('success', 'Kelas berhasil dibuat. Silakan tambahkan siswa dan guru.');
    }

    public function show($id)
    {
        Gate::authorize('kelola-sistem');

        $kelas = Kelas::with(['jenjang', 'siswa', 'guru'])->findOrFail($id);

        $siswaTersedia = User::where('id_tipeuser', 3)
            ->whereNotIn('id_user', $kelas->siswa->pluck('id_user'))
            ->orderBy('nama')
            ->get(['id_user', 'nama']);

        $guruTersedia = User::where('id_tipeuser', 2)
            ->whereNotIn('id_user', $kelas->guru->pluck('id_user'))
            ->orderBy('nama')
            ->get(['id_user', 'nama']);

        return view('admin.kelas.show', [
            'kelas' => $kelas,
            'siswaTersedia' => $siswaTersedia,
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

        return back()->with('success', 'Data kelas diperbarui.');
    }

    public function destroy($id)
    {
        Gate::authorize('kelola-sistem');

        Kelas::findOrFail($id)->delete();

        return redirect()->route('admin.kelas')->with('success', 'Kelas dihapus.');
    }

    public function tambahSiswa(Request $request, $id)
    {
        Gate::authorize('kelola-sistem');

        $kelas = Kelas::findOrFail($id);
        $request->validate(
            ['id_siswa' => ['required', 'integer']],
            ['id_siswa.required' => 'Pilih siswa terlebih dahulu.']
        );

        // Hanya akun siswa (tipe 3) yang boleh menjadi anggota kelas.
        $siswa = User::where('id_tipeuser', 3)->find($request->id_siswa);
        if (!$siswa) {
            return back()->withErrors(['id_siswa' => 'Siswa tidak ditemukan.']);
        }

        $kelas->siswa()->syncWithoutDetaching([$siswa->id_user]);

        return back()->with('success', $siswa->nama . ' ditambahkan ke kelas.');
    }

    public function hapusSiswa($id, $siswa)
    {
        Gate::authorize('kelola-sistem');

        Kelas::findOrFail($id)->siswa()->detach((int) $siswa);

        return back()->with('success', 'Siswa dikeluarkan dari kelas.');
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
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'id_jenjang' => ['nullable', 'integer', 'exists:jenjang,id_jenjang'],
            'tahun_ajaran' => ['nullable', 'string', 'max:20'],
        ], [
            'nama.required' => 'Nama kelas wajib diisi.',
            'nama.max' => 'Nama kelas maksimal 150 karakter.',
            'id_jenjang.exists' => 'Jenjang tidak valid.',
        ]);
    }
}
