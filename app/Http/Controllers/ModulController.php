<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;

// Controller khusus untuk mengelola data modul pembelajaran.
class ModulController extends Controller
{
    // Menampilkan daftar modul untuk halaman user atau admin.
    public function index()
    {
        $moduls = Modul::all();

        return view('modul.index', ['moduls' => $moduls]);
    }

    // Menampilkan form tambah modul baru.
    public function create()
    {
        return view('modul.create');
    }

    // Menyimpan data modul baru ke database.
    public function store(Request $request)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'id_tipemodul' => 'required|integer',
            'id_jenjang' => 'required|integer',
        ]);

        Modul::create([
            'judul_modul' => $request->judul_modul,
            'file_materi' => $request->file_materi,
            'tipe_file' => $request->tipe_file,
            'id_tipemodul' => $request->id_tipemodul,
            'id_jenjang' => $request->id_jenjang,
            'id_quiz' => $request->id_quiz,
            'progressModul' => $request->progressModul,
            'foto_modul' => $request->foto_modul,
        ]);

        return redirect()->route('admin.modul')->with('success', 'Modul berhasil ditambahkan.');
    }
}
