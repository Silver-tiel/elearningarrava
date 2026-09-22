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
}
