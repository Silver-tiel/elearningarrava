<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\TipeModul;
use App\Models\Jenjang;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    // Menampilkan daftar seluruh modul dengan relasinya
    public function index()
    {
        // Mengambil data modul beserta relasi tipeModul dan jenjang
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->get();

        return view('admin.modul.index', compact('moduls'));
    }

    // Menampilkan form tambah modul baru
    public function create()
    {
        // Mengambil data master untuk dropdown
        $tipeModul = TipeModul::all();
        // Hanya ambil jenjang SD, SMP, SMA (id 1, 2, 3)
        $jenjang = Jenjang::whereIn('id_jenjang', [1, 2, 3])->get();
        $quizzes = Quiz::all();

        return view('admin.modul.create', compact('tipeModul', 'jenjang', 'quizzes'));
    }

    // Menyimpan data modul baru & memproses upload file fisik
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'id_tipemodul' => 'required|integer',
            'id_jenjang' => 'required|integer',
            'file_upload' => 'nullable|file|mimes:pdf,docx,doc,ppt,pptx,mp4,mkv|max:51200', // Maks 50MB
            'file_link' => 'nullable|url', // Untuk link eksternal / video youtube
            'foto_modul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB
        ]);

        $pathFile = null;
        $tipeFile = null;

        // 2. Cek apakah pengguna mengunggah file fisik
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            // Simpan ke storage/app/public/modul/files
            $pathFile = $file->store('modul/files', 'public');
            // Dapatkan ekstensi file (misal: pdf, mp4)
            $tipeFile = $file->getClientOriginalExtension();
        } elseif ($request->filled('file_link')) {
            // Jika memilih memasukkan link URL (misal YouTube / Google Drive)
            $pathFile = $request->file_link;
            $tipeFile = 'link';
        }

        // 3. Cek apakah ada upload cover thumbnail
        $pathFoto = null;
        if ($request->hasFile('foto_modul')) {
            $foto = $request->file('foto_modul');
            $pathFoto = $foto->store('modul/covers', 'public');
        }

        // 4. Simpan ke database
        Modul::create([
            'judul_modul' => $request->judul_modul,
            'file_materi' => $pathFile,
            'tipe_file' => $tipeFile,
            'id_tipemodul' => $request->id_tipemodul,
            'id_jenjang' => $request->id_jenjang,
            'id_quiz' => $request->id_quiz ?: null,
            'progressModul' => 'Tersedia',
            'foto_modul' => $pathFoto,
        ]);

        return redirect()->route('admin.modul')->with('success', 'Modul pembelajaran berhasil ditambahkan!');
    }

    // Menampilkan detail / preview modul
    public function show($id)
    {
        $modul = Modul::with(['tipeModul', 'jenjang', 'quiz'])->findOrFail($id);
        return view('admin.modul.show', compact('modul'));
    }

    // Menghapus data modul dan file fisik terkait dari storage
    public function destroy($id)
    {
        $modul = Modul::findOrFail($id);

        // Hapus file materi dari storage jika ada & bukan link eksternal
        if ($modul->file_materi && Storage::disk('public')->exists($modul->file_materi)) {
            Storage::disk('public')->delete($modul->file_materi);
        }

        // Hapus foto cover dari storage jika ada
        if ($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul)) {
            Storage::disk('public')->delete($modul->foto_modul);
        }

        $modul->delete();

        return redirect()->route('admin.modul')->with('success', 'Modul berhasil dihapus.');
    }
}
