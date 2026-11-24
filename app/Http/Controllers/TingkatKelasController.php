<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\TingkatKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TingkatKelasController extends Controller
{
    public function index()
    {
        Gate::authorize('kelola-sistem');

        $jenjangList = Jenjang::with(['tingkatKelas' => function ($q) {
            $q->orderBy('urutan');
        }])->orderBy('id_jenjang')->get();

        return view('admin.tingkat-kelas.index', compact('jenjangList'));
    }

    public function store(Request $request)
    {
        Gate::authorize('kelola-sistem');

        $validated = $request->validate([
            'id_jenjang' => ['required', 'integer', 'exists:jenjang,id_jenjang'],
            'nama' => ['required', 'string', 'max:50'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ]);

        if (empty($validated['urutan'])) {
            $max = TingkatKelas::where('id_jenjang', $validated['id_jenjang'])->max('urutan') ?? 0;
            $validated['urutan'] = $max + 1;
        }

        $validated['aktif'] = true;

        TingkatKelas::create($validated);

        return redirect()->route('admin.tingkat-kelas')->with('success', 'Tingkat kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('kelola-sistem');

        $tingkat = TingkatKelas::findOrFail($id);

        $validated = $request->validate([
            'id_jenjang' => ['required', 'integer', 'exists:jenjang,id_jenjang'],
            'nama' => ['required', 'string', 'max:50'],
            'urutan' => ['required', 'integer', 'min:1'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        $tingkat->update($validated);

        return redirect()->route('admin.tingkat-kelas')->with('success', 'Tingkat kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Gate::authorize('kelola-sistem');

        $tingkat = TingkatKelas::withCount(['users', 'quizzes', 'moduls'])->findOrFail($id);

        if ($tingkat->users_count > 0 || $tingkat->quizzes_count > 0 || $tingkat->moduls_count > 0) {
            return back()->with('error', 'Tidak dapat menghapus tingkat kelas ini karena sedang digunakan oleh siswa, kuis, atau modul.');
        }

        $tingkat->delete();

        return redirect()->route('admin.tingkat-kelas')->with('success', 'Tingkat kelas berhasil dihapus.');
    }

    public function byJenjang(Request $request, $idJenjang = null)
    {
        $jenjangId = $idJenjang ?? $request->query('jenjang') ?? $request->query('id_jenjang');

        $query = TingkatKelas::with('jenjang')
            ->where('aktif', true)
            ->orderBy('urutan');

        if (!empty($jenjangId)) {
            $query->where('id_jenjang', $jenjangId);
        }

        $list = $query->get()->map(function ($t) {
            return [
                'id_tingkat' => (int) $t->id_tingkat,
                'id_jenjang' => (int) $t->id_jenjang,
                'nama' => $t->nama,
                'urutan' => (int) $t->urutan,
                'nama_jenjang' => $t->jenjang->nama_tipe ?? null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => $list,
        ]);
    }
}
