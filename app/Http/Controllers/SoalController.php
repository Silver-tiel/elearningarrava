<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;

// Controller khusus untuk mengelola soal quiz per jenjang.
class SoalController extends Controller
{
    // Menampilkan daftar soal yang ada di sistem.
    public function index()
    {
        $soals = Soal::all();

        return view('admin.soal.index', ['soals' => $soals]);
    }

    // Menampilkan form untuk menambah soal baru.
    public function create()
    {
        return view('admin.soal.create');
    }

    // Menyimpan soal baru ke database.
    public function store(Request $request)
    {
        $request->validate([
            'id_quiz' => 'required|integer',
            'id_jenjang' => 'required|integer',
            'id_jenis_soal' => 'required|integer',
            'pertanyaan' => 'required|string',
            'jawaban_benar' => 'required|string',
        ]);

        Soal::create([
            'id_quiz' => $request->id_quiz,
            'id_jenjang' => $request->id_jenjang,
            'id_jenis_soal' => $request->id_jenis_soal,
            'pertanyaan' => $request->pertanyaan,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit soal.
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        return view('admin.soal.edit', compact('soal'));
    }

    // Memperbarui soal di database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_quiz' => 'required|integer',
            'id_jenjang' => 'nullable|integer',
            'id_jenis_soal' => 'required|integer',
            'pertanyaan' => 'required|string',
            'jawaban_benar' => 'nullable|string',
        ]);

        $soal = Soal::findOrFail($id);
        $soal->update([
            'id_quiz' => $request->id_quiz,
            'id_jenjang' => $request->id_jenjang,
            'id_jenis_soal' => $request->id_jenis_soal,
            'pertanyaan' => $request->pertanyaan,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil diperbarui.');
    }

    // Menghapus soal dari database.
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil dihapus.');
    }
}
