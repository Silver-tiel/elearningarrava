<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\TipeModul;
use App\Models\Jenjang;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ModulController extends Controller
{
    // Menampilkan daftar seluruh modul dengan relasinya, filter, dan sortir
    public function index(Request $request)
    {
        $query = Modul::with(['tipeModul', 'jenjang', 'quiz']);

        // Filter Status (all, published, draft)
        $statusFilter = $request->query('status', 'all');
        if ($statusFilter === 'draft') {
            $query->draft();
        } elseif ($statusFilter === 'published') {
            $query->published();
        }

        // Filter Jenjang
        $jenjangFilter = $request->query('jenjang', 'all');
        if ($jenjangFilter !== 'all' && is_numeric($jenjangFilter)) {
            $query->where('id_jenjang', (int) $jenjangFilter);
        }

        // Filter Tipe Modul
        $tipeFilter = $request->query('tipe', 'all');
        if ($tipeFilter !== 'all' && is_numeric($tipeFilter)) {
            $query->where('id_tipemodul', (int) $tipeFilter);
        }

        // Pencarian Kata Kunci
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('judul_modul', 'like', '%' . $search . '%')
                  ->orWhereHas('jenjang', function ($j) use ($search) {
                      $j->where('nama_tipe', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('tipeModul', function ($t) use ($search) {
                      $t->where('nama_tipe', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sortir / Pengurutan
        $sort = $request->query('sort', 'latest');
        $idPdf = TipeModul::where('nama_tipe', 'like', '%pdf%')->value('id_tipemodul') ?? 2;
        $idVideo = TipeModul::where('nama_tipe', 'like', '%video%')->value('id_tipemodul') ?? 1;
        $idArtikel = TipeModul::where('nama_tipe', 'like', '%artikel%')->value('id_tipemodul') ?? 3;

        match ($sort) {
            'oldest' => $query->oldest('id_modul'),
            'title_asc' => $query->orderBy('judul_modul', 'asc'),
            'title_desc' => $query->orderBy('judul_modul', 'desc'),
            'type_pdf' => $query->orderByRaw("CASE WHEN modul.id_tipemodul = {$idPdf} THEN 0 ELSE 1 END")->latest('modul.id_modul'),
            'type_video' => $query->orderByRaw("CASE WHEN modul.id_tipemodul = {$idVideo} THEN 0 ELSE 1 END")->latest('modul.id_modul'),
            'type_artikel' => $query->orderByRaw("CASE WHEN modul.id_tipemodul = {$idArtikel} THEN 0 ELSE 1 END")->latest('modul.id_modul'),
            'type_asc' => $query->leftJoin('tipemodul', 'modul.id_tipemodul', '=', 'tipemodul.id_tipemodul')
                                ->orderBy('tipemodul.nama_tipe', 'asc')
                                ->select('modul.*'),
            'type_desc' => $query->leftJoin('tipemodul', 'modul.id_tipemodul', '=', 'tipemodul.id_tipemodul')
                                 ->orderBy('tipemodul.nama_tipe', 'desc')
                                 ->select('modul.*'),
            default => $query->latest('id_modul'),
        };

        $moduls = $query->get();

        // Statistik
        $totalModul = Modul::count();
        $totalPublished = Modul::published()->count();
        $totalDraft = Modul::draft()->count();

        $masterJenjang = Jenjang::whereIn('id_jenjang', [1, 2, 3])->get();
        $masterTipe = TipeModul::all();

        return view('admin.modul.index', compact(
            'moduls',
            'totalModul',
            'totalPublished',
            'totalDraft',
            'statusFilter',
            'jenjangFilter',
            'tipeFilter',
            'search',
            'sort',
            'masterJenjang',
            'masterTipe'
        ));
    }

    // Menampilkan form tambah modul baru
    public function create()
    {
        // Mengambil data master untuk dropdown
        $tipeModul = TipeModul::all();
        // Hanya ambil jenjang SD, SMP, SMA (id 1, 2, 3)
        $jenjang = Jenjang::whereIn('id_jenjang', [1, 2, 3])->get();
        $quizzes = Quiz::with('jenjang')->orderBy('judul')->get();

        return view('admin.modul.create', compact('tipeModul', 'jenjang', 'quizzes'));
    }

    // Menyimpan data modul baru & memproses upload file fisik / draf
    public function store(Request $request)
    {
        $isDraft = $request->input('action_type') === 'draft';

        $rules = [
            'judul_modul' => 'required|string|max:255|unique:modul,judul_modul',
            'id_jenjang' => 'required|integer|exists:jenjang,id_jenjang',
            'id_tipemodul' => $isDraft ? 'nullable|integer' : 'required|integer|exists:tipemodul,id_tipemodul',
            'id_quiz' => 'nullable|integer|exists:quiz,id_quiz',
            'file_upload' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'file_link' => 'nullable|url',
            'foto_modul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        $messages = [
            'judul_modul.required' => 'Judul modul wajib diisi.',
            'judul_modul.unique' => 'Judul modul sudah digunakan, gunakan judul yang lain.',
            'id_jenjang.required' => 'Pilih jenjang pendidikan modul.',
            'id_jenjang.exists' => 'Jenjang pendidikan yang dipilih tidak valid.',
            'id_tipemodul.required' => 'Pilih jenis materi modul.',
            'file_upload.mimes' => 'Berkas materi harus berformat PDF atau PPT/PPTX.',
            'file_upload.max' => 'Ukuran berkas materi maksimal 50MB.',
            'file_link.url' => 'Format tautan eksternal tidak valid.',
            'foto_modul.image' => 'Sampul modul harus berupa gambar.',
        ];

        $validated = $request->validate($rules, $messages);

        // Sinkronisasi: Quiz yang dikaitkan harus memiliki jenjang yang sama dengan modul
        if (!empty($validated['id_quiz'])) {
            $quiz = Quiz::find($validated['id_quiz']);
            if ($quiz && $quiz->id_jenjang && (int) $quiz->id_jenjang !== (int) $validated['id_jenjang']) {
                $namaJenjangModul = Jenjang::find($validated['id_jenjang'])?->nama_tipe ?? 'yang dipilih';
                $namaJenjangQuiz = $quiz->jenjang?->nama_tipe ?? 'lain';
                throw ValidationException::withMessages([
                    'id_quiz' => "Kuis '{$quiz->judul}' berjenjang {$namaJenjangQuiz}. Modul ini berjenjang {$namaJenjangModul}. Kuis hanya dapat dikaitkan dengan modul yang memiliki jenjang yang sama.",
                ]);
            }
        }

        $pathFile = null;
        $tipeFile = null;

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $pathFile = $file->store('modul/files', 'public');
            $tipeFile = $file->getClientOriginalExtension();
        } elseif ($request->filled('file_link')) {
            $pathFile = $request->file_link;
            $tipeFile = 'link';
        }

        $pathFoto = null;
        if ($request->hasFile('foto_modul')) {
            $foto = $request->file('foto_modul');
            $pathFoto = $foto->store('modul/covers', 'public');
        }

        Modul::create([
            'judul_modul' => $validated['judul_modul'],
            'file_materi' => $pathFile,
            'tipe_file' => $tipeFile,
            'id_tipemodul' => $validated['id_tipemodul'] ?? 1,
            'id_jenjang' => $validated['id_jenjang'],
            'id_quiz' => !empty($validated['id_quiz']) ? $validated['id_quiz'] : null,
            'progressModul' => $isDraft ? 'Draft' : 'Tersedia',
            'foto_modul' => $pathFoto,
        ]);

        return redirect()->route('admin.modul')->with('success', $isDraft ? 'Draf modul berhasil disimpan! 📝' : 'Modul pembelajaran berhasil ditambahkan & dipublikasikan! 🎉');
    }

    // Menampilkan detail / preview modul
    public function show($id)
    {
        $modul = Modul::with(['tipeModul', 'jenjang', 'quiz'])->findOrFail($id);

        // Jika modul draf dan yang mengakses bukan admin (tipeuser != 1)
        if ($modul->isDraft() && auth()->check() && (int) auth()->user()->id_tipeuser !== 1) {
            return redirect()->route('siswa.modul')->withErrors([
                'modul' => 'Modul ini masih dalam bentuk draf dan belum tersedia untuk dipelajari.',
            ]);
        }

        return view('modul.show', compact('modul'));
    }

    // Menampilkan form edit modul
    public function edit($id)
    {
        $module = Modul::findOrFail($id);
        $tipeModul = TipeModul::all();
        $jenjang = Jenjang::whereIn('id_jenjang', [1, 2, 3])->get();
        $quizzes = Quiz::with('jenjang')->orderBy('judul')->get();

        return view('admin.modul.edit', compact('module', 'tipeModul', 'jenjang', 'quizzes'));
    }

    // Memproses update data modul (bisa simpan draf atau publikasikan)
    public function update(Request $request, $id)
    {
        $module = Modul::findOrFail($id);
        $isDraft = $request->input('action_type') === 'draft';

        $rules = [
            'judul_modul' => 'required|string|max:255|unique:modul,judul_modul,' . $module->id_modul . ',id_modul',
            'id_jenjang' => 'required|integer|exists:jenjang,id_jenjang',
            'id_tipemodul' => $isDraft ? 'nullable|integer' : 'required|integer|exists:tipemodul,id_tipemodul',
            'id_quiz' => 'nullable|integer|exists:quiz,id_quiz',
            'file_upload' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'file_link' => 'nullable|url',
            'foto_modul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        $messages = [
            'judul_modul.required' => 'Judul modul wajib diisi.',
            'judul_modul.unique' => 'Judul modul sudah digunakan oleh modul lain.',
            'id_jenjang.required' => 'Pilih jenjang pendidikan modul.',
            'id_jenjang.exists' => 'Jenjang pendidikan yang dipilih tidak valid.',
            'id_tipemodul.required' => 'Pilih jenis materi modul.',
            'file_upload.mimes' => 'Berkas materi harus berformat PDF atau PPT/PPTX.',
            'file_upload.max' => 'Ukuran berkas materi maksimal 50MB.',
            'file_link.url' => 'Format tautan eksternal tidak valid.',
            'foto_modul.image' => 'Sampul modul harus berupa gambar.',
        ];

        $validated = $request->validate($rules, $messages);

        // Sinkronisasi: Quiz yang dikaitkan harus memiliki jenjang yang sama dengan modul
        if (!empty($validated['id_quiz'])) {
            $quiz = Quiz::find($validated['id_quiz']);
            if ($quiz && $quiz->id_jenjang && (int) $quiz->id_jenjang !== (int) $validated['id_jenjang']) {
                $namaJenjangModul = Jenjang::find($validated['id_jenjang'])?->nama_tipe ?? 'yang dipilih';
                $namaJenjangQuiz = $quiz->jenjang?->nama_tipe ?? 'lain';
                throw ValidationException::withMessages([
                    'id_quiz' => "Kuis '{$quiz->judul}' berjenjang {$namaJenjangQuiz}. Modul ini berjenjang {$namaJenjangModul}. Kuis hanya dapat dikaitkan dengan modul yang memiliki jenjang yang sama.",
                ]);
            }
        }

        $pathFile = $module->file_materi;
        $tipeFile = $module->tipe_file;

        if ($request->hasFile('file_upload')) {
            if ($module->file_materi && $module->tipe_file !== 'link' && Storage::disk('public')->exists($module->file_materi)) {
                Storage::disk('public')->delete($module->file_materi);
            }

            $file = $request->file('file_upload');
            $pathFile = $file->store('modul/files', 'public');
            $tipeFile = $file->getClientOriginalExtension();
        } elseif ($request->filled('file_link')) {
            if ($module->file_materi && $module->tipe_file !== 'link' && Storage::disk('public')->exists($module->file_materi)) {
                Storage::disk('public')->delete($module->file_materi);
            }
            $pathFile = $request->file_link;
            $tipeFile = 'link';
        }

        $pathFoto = $module->foto_modul;
        if ($request->hasFile('foto_modul')) {
            if ($module->foto_modul && Storage::disk('public')->exists($module->foto_modul)) {
                Storage::disk('public')->delete($module->foto_modul);
            }
            $foto = $request->file('foto_modul');
            $pathFoto = $foto->store('modul/covers', 'public');
        }

        $module->update([
            'judul_modul' => $validated['judul_modul'],
            'file_materi' => $pathFile,
            'tipe_file' => $tipeFile,
            'id_tipemodul' => $validated['id_tipemodul'] ?? $module->id_tipemodul ?? 1,
            'id_jenjang' => $validated['id_jenjang'],
            'id_quiz' => !empty($validated['id_quiz']) ? $validated['id_quiz'] : null,
            'progressModul' => $isDraft ? 'Draft' : 'Tersedia',
            'foto_modul' => $pathFoto,
        ]);

        return redirect()->route('admin.modul')->with('success', $isDraft ? 'Draf modul berhasil diperbarui! 📝' : 'Modul pembelajaran berhasil diperbarui & dipublikasikan! 🎉');
    }

    // Menghapus data modul dan file fisik terkait dari storage
    public function destroy($id)
    {
        $modul = Modul::findOrFail($id);

        // Hapus file materi dari storage jika ada & bukan link eksternal
        if ($modul->file_materi && $modul->tipe_file !== 'link' && Storage::disk('public')->exists($modul->file_materi)) {
            Storage::disk('public')->delete($modul->file_materi);
        }

        // Hapus foto cover dari storage jika ada
        if ($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul)) {
            Storage::disk('public')->delete($modul->foto_modul);
        }

        $modul->delete();

        return redirect()->route('admin.modul')->with('success', 'Modul berhasil dihapus.');
    }
    // API: mengambil semua modul
    public function apiIndex()
    {
        $moduls = Modul::with([
            'tipeModul',
            'jenjang',
            'quiz'
        ])
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data modul berhasil diambil.',
            'data' => $moduls,
        ], 200);
    }

    // API: menampilkan detail modul
    public function apiShow($id)
    {
        $modul = Modul::with(['tipeModul', 'jenjang', 'quiz'])->find($id);

        if (!$modul) {
            return response()->json([
                'success' => false,
                'message' => 'Modul tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail modul berhasil diambil.',
            'data' => $modul,
        ], 200);
    }

    // API: menyimpan data modul baru
    public function apiStore(Request $request)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'id_tipemodul' => 'required|integer',
            'id_jenjang' => 'required|integer',
            'file_upload' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'file_link' => 'nullable|url',
            'foto_modul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathFile = null;
        $tipeFile = null;

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $pathFile = $file->store('modul/files', 'public');
            $tipeFile = $file->getClientOriginalExtension();
        } elseif ($request->filled('file_link')) {
            $pathFile = $request->file_link;
            $tipeFile = 'link';
        }

        $pathFoto = null;
        if ($request->hasFile('foto_modul')) {
            $foto = $request->file('foto_modul');
            $pathFoto = $foto->store('modul/covers', 'public');
        }

        $modul = Modul::create([
            'judul_modul' => $request->judul_modul,
            'file_materi' => $pathFile,
            'tipe_file' => $tipeFile,
            'id_tipemodul' => $request->id_tipemodul,
            'id_jenjang' => $request->id_jenjang,
            'id_quiz' => $request->id_quiz ?: null,
            'progressModul' => 'Tersedia',
            'foto_modul' => $pathFoto,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil ditambahkan.',
            'data' => $modul,
        ], 201);
    }

    // API: update data modul
    public function apiUpdate(Request $request, $id)
    {
        $module = Modul::find($id);

        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'Modul tidak ditemukan.',
            ], 404);
        }

        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'id_tipemodul' => 'required|integer',
            'id_jenjang' => 'required|integer',
            'file_upload' => 'nullable|file|mimes:pdf,ppt,pptx|max:51200',
            'file_link' => 'nullable|url',
            'foto_modul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathFile = $module->file_materi;
        $tipeFile = $module->tipe_file;

        if ($request->hasFile('file_upload')) {
            if ($module->file_materi && $module->tipe_file !== 'link' && Storage::disk('public')->exists($module->file_materi)) {
                Storage::disk('public')->delete($module->file_materi);
            }

            $file = $request->file('file_upload');
            $pathFile = $file->store('modul/files', 'public');
            $tipeFile = $file->getClientOriginalExtension();
        } elseif ($request->filled('file_link')) {
            if ($module->file_materi && $module->tipe_file !== 'link' && Storage::disk('public')->exists($module->file_materi)) {
                Storage::disk('public')->delete($module->file_materi);
            }
            $pathFile = $request->file_link;
            $tipeFile = 'link';
        }

        $pathFoto = $module->foto_modul;
        if ($request->hasFile('foto_modul')) {
            if ($module->foto_modul && Storage::disk('public')->exists($module->foto_modul)) {
                Storage::disk('public')->delete($module->foto_modul);
            }
            $foto = $request->file('foto_modul');
            $pathFoto = $module->store('modul/covers', 'public');
        }

        $module->update([
            'judul_modul' => $request->judul_modul,
            'file_materi' => $pathFile,
            'tipe_file' => $tipeFile,
            'id_tipemodul' => $request->id_tipemodul,
            'id_jenjang' => $request->id_jenjang,
            'id_quiz' => $request->id_quiz ?: null,
            'foto_modul' => $pathFoto,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil diperbarui.',
            'data' => $module,
        ], 200);
    }

    // API: hapus modul
    public function apiDestroy($id)
    {
        $modul = Modul::find($id);

        if (!$modul) {
            return response()->json([
                'success' => false,
                'message' => 'Modul tidak ditemukan.',
            ], 404);
        }

        if ($modul->file_materi && $modul->tipe_file !== 'link' && Storage::disk('public')->exists($modul->file_materi)) {
            Storage::disk('public')->delete($modul->file_materi);
        }

        if ($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul)) {
            Storage::disk('public')->delete($modul->foto_modul);
        }

        $modul->delete();

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil dihapus.',
        ], 200);
    }
}