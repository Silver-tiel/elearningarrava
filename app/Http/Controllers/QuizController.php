<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use App\Models\Jenjang;
use App\Models\User;
use App\Models\HasilQuizModul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

// Controller khusus untuk mengelola data kuis pembelajaran.
class QuizController extends Controller
{
    // Menampilkan daftar kuis untuk halaman admin atau guru.
    public function index(Request $request)
    {
        $filters = $request->validate([
            'jenjang' => ['nullable', 'integer', 'exists:jenjang,id_jenjang'],
            'tingkat' => ['nullable', 'integer', 'exists:tingkatquiz,id_tingkatquiz'],
            'status' => ['nullable', 'in:all,published,draft,kadaluarsa'],
            'sort' => ['nullable', 'in:terbaru,terlama'],
        ]);

        if (auth()->check()) {
            Gate::authorize('viewAny', Quiz::class);
        }

        $query = Quiz::with(['tipeQuiz', 'tingkatQuiz', 'jenjang'])->withCount('soal');

        // Guru hanya melihat quiz miliknya sendiri; admin melihat semua.
        if ($request->user() && $request->user()->isGuru()) {
            $query->where('id_pembuat', $request->user()->id_user);
        }

        if (!empty($filters['jenjang'])) {
            $query->where('id_jenjang', $filters['jenjang']);
        }

        if (!empty($filters['tingkat'])) {
            $query->where('id_tingkatquiz', $filters['tingkat']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            if ($filters['status'] === 'draft') {
                $query->draft();
            } elseif ($filters['status'] === 'published') {
                $query->published()->where(function ($sub) {
                    $sub->whereNull('waktu_kadaluarsa')
                        ->orWhere('waktu_kadaluarsa', '>', now());
                });
            } elseif ($filters['status'] === 'kadaluarsa') {
                $query->whereNotNull('waktu_kadaluarsa')
                    ->where('waktu_kadaluarsa', '<=', now())
                    ->where(function ($sub) {
                        $sub->whereNull('token')->orWhere('token', '');
                    });
            }
        }

        if (isset($filters['sort']) && $filters['sort'] === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $quizzes = $query->get();
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $tingkatQuizList = \App\Models\TingkatQuiz::orderBy('id_tingkatquiz')->get();

        return view('admin.quiz.index', compact('quizzes', 'jenjangList', 'tingkatQuizList'));
    }

    // Menampilkan form untuk menambah kuis baru (bergaya Kahoot).
    public function create()
    {
        if (auth()->check()) {
            Gate::authorize('create', Quiz::class);
        }

        $jenjangList = Jenjang::all();
        $tingkatQuizList = \App\Models\TingkatQuiz::all();
        $questions = $this->questionEditorState(old('soal', []));
        return view('admin.quiz.create', compact('jenjangList', 'tingkatQuizList', 'questions'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->where('id_quiz', $id)->orWhere('kode_quiz', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('update', $quiz);
        }
        $jenjangList = Jenjang::all();
        $tingkatQuizList = \App\Models\TingkatQuiz::all();
        $savedQuestions = $quiz->soal->map(function (Soal $soal) {
            $type = match ((int) $soal->id_jenis_soal) {
                2 => 'isian_singkat',
                3 => 'true_false',
                default => 'kuis',
            };

            $choices = collect(['A', 'B', 'C', 'D'])->map(function (string $label) use ($soal, $type) {
                $choice = $soal->pilihanSoal->firstWhere('label', $label);
                return [
                    'label' => $label,
                    'teks' => $choice->teks_pilihan ?? ($type === 'true_false' && $label === 'A' ? 'Benar' : ($type === 'true_false' && $label === 'B' ? 'Salah' : '')),
                    'is_correct' => (int) ($choice->is_correct ?? false),
                ];
            })->all();

            return [
                'id_soal' => $soal->id_soal,
                'kode_soal' => $soal->kode_soal,
                'jenis_soal' => $type,
                'pertanyaan' => $soal->pertanyaan,
                'timer' => (string) ($soal->durasi_detik ?? 20),
                'poin' => (int) ($soal->poin ?? 10),
                'jawaban_singkat' => $type === 'isian_singkat' ? $soal->jawaban_benar : '',
                'foto_soal' => $soal->foto_soal,
                'foto_url' => $soal->foto_soal ? asset('storage/' . $soal->foto_soal) : null,
                'pilihan' => $choices,
            ];
        })->values()->all();
        $oldQuestions = old('soal');
        $questions = is_array($oldQuestions) ? $this->questionEditorState($oldQuestions) : $savedQuestions;

        return view('admin.quiz.create', compact('quiz', 'jenjangList', 'tingkatQuizList', 'questions'));
    }

    // Menyimpan kuis baru beserta soal dan pilihan jawaban ke database.
    public function store(Request $request)
    {
        if (auth()->check()) {
            Gate::authorize('create', Quiz::class);
        }

        $isDraft = $request->input('action_type') === 'draft';

        if ($isDraft) {
            $validated = $request->validate([
                'judul'            => 'required|string|max:255|unique:quiz,judul|regex:/^[a-zA-Z0-9\s]+$/',
                'deskripsi'        => 'nullable|string|max:3000',
                'id_jenjang'       => 'required|integer',
                'id_tipequiz'      => 'nullable|integer',
                'id_tingkatquiz'   => 'nullable|integer',
                'waktu_kadaluarsa' => ['nullable', 'date'],
                'mode_pengerjaan'  => 'nullable|in:wayground,biasa',
                'durasi_total_menit' => 'nullable|integer|min:1|max:360',
                'opsi_preview'     => 'nullable|in:lengkap,tipe_saja',
                'use_token'        => 'nullable|boolean',
                'token'            => 'nullable|string|max:50',
                'foto_quiz'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal'             => 'nullable|array',
                'soal.*.pertanyaan' => 'nullable|string',
                'soal.*.jenis_soal' => 'nullable|in:kuis,true_false,isian_singkat',
                'soal.*.jawaban_singkat' => 'nullable|string|max:1000',
                'soal.*.poin'      => 'nullable|integer|min:0',
                'soal.*.durasi_detik' => 'nullable|integer',
                'soal.*.pilihan'   => 'nullable|array',
                'soal.*.pilihan.*.label' => 'nullable|in:A,B,C,D',
                'soal.*.pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
                'soal.*.pilihan.*.is_correct' => 'nullable|boolean',
                'soal_foto'        => 'nullable|array',
                'soal_foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal.*.foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ], $this->quizValidationMessages());
            $questions = $this->normalizeQuestionAnswers($validated['soal'] ?? [], true);
        } else {
            $validated = $request->validate([
                'judul'            => 'required|string|max:255|unique:quiz,judul|regex:/^[a-zA-Z0-9\s]+$/',
                'deskripsi'        => 'nullable|string|max:3000',
                'id_jenjang'       => 'required|integer',
                'id_tipequiz'      => 'nullable|integer',
                'id_tingkatquiz'   => 'nullable|integer',
                'waktu_kadaluarsa' => ['nullable', 'date', 'after_or_equal:now'],
                'mode_pengerjaan'  => 'required|in:wayground,biasa',
                'durasi_total_menit' => 'nullable|required_if:mode_pengerjaan,biasa|integer|min:1|max:360',
                'opsi_preview'     => 'nullable|in:lengkap,tipe_saja',
                'use_token'        => 'nullable|boolean',
                'token'            => 'nullable|required_if:use_token,1|string|max:50',
                'foto_quiz'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal'             => 'required|array|min:1',
                'soal.*.pertanyaan' => 'required|string',
                'soal.*.jenis_soal' => 'required|in:kuis,true_false,isian_singkat',
                'soal.*.jawaban_singkat' => 'nullable|string|max:1000',
                'soal.*.poin'      => 'nullable|integer|min:0',
                'soal.*.durasi_detik' => 'nullable|required_if:mode_pengerjaan,wayground|integer|in:10,20,30,60',
                'soal.*.pilihan'   => 'nullable|array',
                'soal.*.pilihan.*.label' => 'required|in:A,B,C,D',
                'soal.*.pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
                'soal.*.pilihan.*.is_correct' => 'nullable|boolean',
                'soal_foto'        => 'nullable|array',
                'soal_foto.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal.*.foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ], $this->quizValidationMessages());
            $questions = $this->normalizeQuestionAnswers($validated['soal'], false);
        }

        if (!$isDraft && $request->filled('waktu_kadaluarsa')) {
            $waktuKadaluarsa = \Carbon\Carbon::parse($request->waktu_kadaluarsa);
            if ($waktuKadaluarsa->lt(now())) {
                return redirect()->back()->withErrors([
                    'waktu_kadaluarsa' => 'Waktu kadaluarsa tidak boleh lebih kecil dari waktu sekarang.',
                ])->withInput();
            }
        }

        $token = $request->boolean('use_token')
            ? ($request->filled('token') ? trim($request->input('token')) : strtoupper(Str::random(6)))
            : null;

        $fotoQuizPath = null;
        if ($request->hasFile('foto_quiz') && $request->file('foto_quiz')->isValid()) {
            $fotoQuizPath = $request->file('foto_quiz')->store('quiz/cover', 'public');
        }

        DB::transaction(function () use ($request, $questions, $token, $fotoQuizPath, $isDraft) {
            // 1. Simpan quiz
            $quiz = Quiz::create([
                'judul'            => $request->judul,
                'deskripsi'        => $request->deskripsi ?: null,
                'id_jenjang'       => $request->id_jenjang,
                'id_tipequiz'      => $request->id_tipequiz ?? 1,
                'id_tingkatquiz'   => $request->id_tingkatquiz ?? 1,
                'waktu_kadaluarsa' => $request->waktu_kadaluarsa ?: null,
                'mode_pengerjaan'  => $request->mode_pengerjaan ?: 'wayground',
                'durasi_total_menit' => $request->mode_pengerjaan === 'biasa' ? $request->durasi_total_menit : null,
                'opsi_preview'     => $request->input('opsi_preview', 'lengkap'),
                'token'            => $token,
                'foto_quiz'        => $fotoQuizPath,
                'proggressQuiz'    => $isDraft ? 'Draft' : 'Tersedia',
            ]);

            // 2. Simpan setiap soal
            foreach ($questions as $index => $soalData) {
                $fotoPath = null;
                $foto = null;
                if ($request->hasFile("soal_foto.$index")) {
                    $foto = $request->file("soal_foto.$index");
                } elseif ($request->hasFile("soal.$index.foto_soal")) {
                    $foto = $request->file("soal.$index.foto_soal");
                }
                if ($foto && $foto->isValid()) {
                    $fotoPath = $foto->store('soal/foto', 'public');
                }

                $soal = Soal::create([
                    'id_quiz'       => $quiz->id_quiz,
                    'id_jenjang'    => $request->id_jenjang,
                    'pertanyaan'    => $soalData['pertanyaan'],
                    'id_jenis_soal' => $soalData['id_jenis_soal'],
                    'jawaban_benar' => $soalData['jawaban_benar'],
                    'poin'          => $soalData['poin'],
                    'durasi_detik'  => $soalData['durasi_detik'] ?? 20,
                    'foto_soal'     => $fotoPath,
                ]);

                foreach ($soalData['pilihan'] as $pilihanData) {
                    PilihanSoal::create([
                        'id_soal'      => $soal->id_soal,
                        'label'        => $pilihanData['label'],
                        'teks_pilihan' => $pilihanData['teks_pilihan'],
                        'is_correct'   => $pilihanData['is_correct'],
                    ]);
                }
            }
        });

        return redirect()->route('admin.quiz')->with('success', $isDraft ? 'Draf quiz berhasil disimpan! 📝' : 'Quiz berhasil dipublikasikan! 🎉');
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::where('id_quiz', $id)->orWhere('kode_quiz', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('update', $quiz);
        }
        $isDraft = $request->input('action_type') === 'draft';

        if ($isDraft) {
            $validated = $request->validate([
                'judul' => 'required|string|max:255|unique:quiz,judul,' . $quiz->id_quiz . ',id_quiz|regex:/^[a-zA-Z0-9\s]+$/',
                'deskripsi' => 'nullable|string|max:3000',
                'id_jenjang' => 'required|integer',
                'id_tipequiz' => 'nullable|integer',
                'id_tingkatquiz' => 'nullable|integer',
                'waktu_kadaluarsa' => ['nullable', 'date'],
                'mode_pengerjaan' => 'nullable|in:wayground,biasa',
                'durasi_total_menit' => 'nullable|integer|min:1|max:360',
                'opsi_preview' => 'nullable|in:lengkap,tipe_saja',
                'use_token' => 'nullable|boolean',
                'token' => 'nullable|string|max:50',
                'foto_quiz' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'hapus_foto_quiz' => 'nullable|boolean',
                'soal' => 'nullable|array',
                'soal.*.pertanyaan' => 'nullable|string',
                'soal.*.jenis_soal' => 'nullable|in:kuis,true_false,isian_singkat',
                'soal.*.jawaban_singkat' => 'nullable|string|max:1000',
                'soal.*.poin' => 'nullable|integer|min:0',
                'soal.*.durasi_detik' => 'nullable|integer',
                'soal.*.pilihan' => 'nullable|array',
                'soal.*.pilihan.*.label' => 'nullable|in:A,B,C,D',
                'soal.*.pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
                'soal.*.pilihan.*.is_correct' => 'nullable|boolean',
                'soal_foto' => 'nullable|array',
                'soal_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal.*.foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ], $this->quizValidationMessages());

            $questions = $this->normalizeQuestionAnswers($validated['soal'] ?? [], true);
        } else {
            $validated = $request->validate([
                'judul' => 'required|string|max:255|unique:quiz,judul,' . $quiz->id_quiz . ',id_quiz|regex:/^[a-zA-Z0-9\s]+$/',
                'deskripsi' => 'nullable|string|max:3000',
                'id_jenjang' => 'required|integer',
                'id_tipequiz' => 'nullable|integer',
                'id_tingkatquiz' => 'nullable|integer',
                'waktu_kadaluarsa' => ['nullable', 'date'],
                'mode_pengerjaan' => 'required|in:wayground,biasa',
                'durasi_total_menit' => 'nullable|required_if:mode_pengerjaan,biasa|integer|min:1|max:360',
                'opsi_preview' => 'nullable|in:lengkap,tipe_saja',
                'use_token' => 'nullable|boolean',
                'token' => 'nullable|required_if:use_token,1|string|max:50',
                'foto_quiz' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'hapus_foto_quiz' => 'nullable|boolean',
                'soal' => 'required|array|min:1',
                'soal.*.pertanyaan' => 'required|string',
                'soal.*.jenis_soal' => 'required|in:kuis,true_false,isian_singkat',
                'soal.*.jawaban_singkat' => 'nullable|string|max:1000',
                'soal.*.poin' => 'nullable|integer|min:0',
                'soal.*.durasi_detik' => 'nullable|required_if:mode_pengerjaan,wayground|integer|in:10,20,30,60',
                'soal.*.pilihan' => 'nullable|array',
                'soal.*.pilihan.*.label' => 'required|in:A,B,C,D',
                'soal.*.pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
                'soal.*.pilihan.*.is_correct' => 'nullable|boolean',
                'soal_foto' => 'nullable|array',
                'soal_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'soal.*.foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ], $this->quizValidationMessages());

            $questions = $this->normalizeQuestionAnswers($validated['soal'], false);
        }

        // Cegah unggah gambar yang sama persis pada soal yang sama saat edit kuis
        $oldSoalList = $quiz->soal()->orderBy('id_soal')->get();
        $fotoErrors = [];
        foreach ($oldSoalList as $idx => $oldSoal) {
            if ($oldSoal->foto_soal && Storage::disk('public')->exists($oldSoal->foto_soal)) {
                $uploadedFoto = null;
                $inputKey = null;
                if ($request->hasFile("soal_foto.$idx")) {
                    $uploadedFoto = $request->file("soal_foto.$idx");
                    $inputKey = "soal_foto.$idx";
                } elseif ($request->hasFile("soal.$idx.foto_soal")) {
                    $uploadedFoto = $request->file("soal.$idx.foto_soal");
                    $inputKey = "soal.$idx.foto_soal";
                }

                if ($uploadedFoto && $uploadedFoto->isValid()) {
                    $oldPath = Storage::disk('public')->path($oldSoal->foto_soal);
                    if (file_exists($oldPath) && md5_file($uploadedFoto->getRealPath()) === md5_file($oldPath)) {
                        $fotoErrors[$inputKey] = 'Foto yang diunggah sama dengan foto yang sudah terpasang pada soal ini.';
                    }
                }
            }
        }

        if ($fotoErrors) {
            throw ValidationException::withMessages($fotoErrors);
        }

        $token = $request->boolean('use_token')
            ? ($request->filled('token') ? trim($request->input('token')) : ($quiz->token ?: strtoupper(Str::random(6))))
            : null;

        $fotoQuizPath = $quiz->foto_quiz;
        if ($request->boolean('hapus_foto_quiz')) {
            if ($quiz->foto_quiz && Storage::disk('public')->exists($quiz->foto_quiz)) {
                Storage::disk('public')->delete($quiz->foto_quiz);
            }
            $fotoQuizPath = null;
        }

        if ($request->hasFile('foto_quiz') && $request->file('foto_quiz')->isValid()) {
            if ($quiz->foto_quiz && Storage::disk('public')->exists($quiz->foto_quiz)) {
                Storage::disk('public')->delete($quiz->foto_quiz);
            }
            $fotoQuizPath = $request->file('foto_quiz')->store('quiz/cover', 'public');
        }

        DB::transaction(function () use ($quiz, $validated, $questions, $request, $token, $fotoQuizPath, $isDraft) {
            $quiz->update([
                'judul' => $validated['judul'],
                'deskripsi' => $request->deskripsi ?: null,
                'id_jenjang' => $validated['id_jenjang'],
                'id_tipequiz' => $validated['id_tipequiz'] ?? $quiz->id_tipequiz,
                'id_tingkatquiz' => $validated['id_tingkatquiz'] ?? $quiz->id_tingkatquiz,
                'waktu_kadaluarsa' => $validated['waktu_kadaluarsa'] ?? null,
                'mode_pengerjaan' => $validated['mode_pengerjaan'] ?? $quiz->mode_pengerjaan,
                'durasi_total_menit' => ($validated['mode_pengerjaan'] ?? $quiz->mode_pengerjaan) === 'biasa' ? ($validated['durasi_total_menit'] ?? $quiz->durasi_total_menit) : null,
                'opsi_preview' => $validated['opsi_preview'] ?? 'lengkap',
                'token' => $token,
                'foto_quiz' => $fotoQuizPath,
                'proggressQuiz' => $isDraft ? 'Draft' : 'Tersedia',
            ]);

            $this->replaceQuestions($quiz, $questions, (int) $validated['id_jenjang'], $request);
        });

        return redirect()->route('admin.quiz')->with('success', $isDraft ? 'Draf quiz berhasil diperbarui! 📝' : 'Quiz berhasil dipublikasikan! 🎉');
    }

    public function destroy($id)
    {
        $quiz = Quiz::where('id_quiz', $id)->orWhere('kode_quiz', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('delete', $quiz);
        }

        DB::transaction(function () use ($quiz) {
            $oldSoalList = $quiz->soal()->get();
            $questionIds = $oldSoalList->pluck('id_soal');
            
            // Hapus cover quiz jika ada
            if ($quiz->foto_quiz && Storage::disk('public')->exists($quiz->foto_quiz)) {
                Storage::disk('public')->delete($quiz->foto_quiz);
            }

            // Hapus semua foto soal terkait dari storage
            foreach ($oldSoalList as $oldSoal) {
                if ($oldSoal->foto_soal && Storage::disk('public')->exists($oldSoal->foto_soal)) {
                    Storage::disk('public')->delete($oldSoal->foto_soal);
                }
            }

            PilihanSoal::whereIn('id_soal', $questionIds)->delete();
            $quiz->soal()->delete();
            $quiz->delete();
        });

        return redirect()->route('admin.quiz')->with('success', 'Quiz dan seluruh soalnya berhasil dihapus.');
    }

    private function replaceQuestions(Quiz $quiz, array $questions, int $idJenjang, Request $request = null): void
    {
        $oldSoalList = $quiz->soal()->orderBy('id_soal')->get();
        $oldPhotosByIndex = $oldSoalList->mapWithKeys(fn($item, $idx) => [$idx => $item->foto_soal]);
        
        $questionIds = $oldSoalList->pluck('id_soal');
        PilihanSoal::whereIn('id_soal', $questionIds)->delete();
        $quiz->soal()->delete();

        foreach ($questions as $index => $questionData) {
            $fotoPath = $oldPhotosByIndex[$index] ?? null;
            if ($request) {
                $foto = null;
                if ($request->hasFile("soal_foto.$index")) {
                    $foto = $request->file("soal_foto.$index");
                } elseif ($request->hasFile("soal.$index.foto_soal")) {
                    $foto = $request->file("soal.$index.foto_soal");
                }
                if ($foto && $foto->isValid()) {
                    $newPath = $foto->store('soal/foto', 'public');
                    if ($fotoPath && $fotoPath !== $newPath && Storage::disk('public')->exists($fotoPath)) {
                        Storage::disk('public')->delete($fotoPath);
                    }
                    $fotoPath = $newPath;
                }
            }

            $soal = Soal::create([
                'id_quiz' => $quiz->id_quiz,
                'id_jenjang' => $idJenjang,
                'id_jenis_soal' => $questionData['id_jenis_soal'],
                'pertanyaan' => $questionData['pertanyaan'],
                'jawaban_benar' => $questionData['jawaban_benar'],
                'poin' => $questionData['poin'],
                'durasi_detik' => $questionData['durasi_detik'] ?? 20,
                'foto_soal' => $fotoPath,
            ]);

            foreach ($questionData['pilihan'] as $choice) {
                PilihanSoal::create([
                    'id_soal' => $soal->id_soal,
                    'label' => $choice['label'],
                    'teks_pilihan' => $choice['teks_pilihan'],
                    'is_correct' => $choice['is_correct'],
                ]);
            }
        }
    }

    private function normalizeQuestionAnswers(array $questions, bool $isDraft = false): array
    {
        $normalized = [];
        $errors = [];
        $seenQuestions = [];

        foreach ($questions as $index => $question) {
            $pertanyaanRaw = trim((string) ($question['pertanyaan'] ?? ''));
            $pertanyaanKey = mb_strtolower($pertanyaanRaw);

            if ($pertanyaanKey !== '') {
                if (in_array($pertanyaanKey, $seenQuestions, true)) {
                    if (!$isDraft) {
                        $errors["soal.$index.pertanyaan"] = 'Pertanyaan tidak boleh sama dengan soal lain dalam quiz ini.';
                    }
                } else {
                    $seenQuestions[] = $pertanyaanKey;
                }
            } elseif ($isDraft) {
                $pertanyaanRaw = '(Draf Soal #' . ($index + 1) . ')';
            }

            $type = $question['jenis_soal'] ?? 'kuis';
            $choices = [];
            $correctChoice = null;
            $answer = '';

            if ($type === 'isian_singkat') {
                $answer = trim($question['jawaban_singkat'] ?? '');
                if ($answer === '' && !$isDraft) {
                    $errors["soal.$index.jawaban_singkat"] = 'Kunci jawaban isian singkat wajib diisi.';
                }
                $idJenisSoal = 2;
            } elseif ($type === 'true_false') {
                $submittedChoices = array_values($question['pilihan'] ?? []);
                $correctIndexes = [];
                foreach ([0, 1] as $choiceIndex) {
                    if (in_array($submittedChoices[$choiceIndex]['is_correct'] ?? null, [1, '1', true], true)) {
                        $correctIndexes[] = $choiceIndex;
                    }
                }

                if (count($correctIndexes) !== 1 && !$isDraft) {
                    $errors["soal.$index.pilihan"] = 'Pilih tepat satu jawaban benar untuk soal Benar/Salah.';
                }

                $choices = [
                    ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => in_array(0, $correctIndexes, true)],
                    ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => in_array(1, $correctIndexes, true)],
                ];
                $correctChoice = $choices[$correctIndexes[0] ?? 0] ?? null;
                $answer = in_array(1, $correctIndexes, true) ? 'B' : 'A';
                $idJenisSoal = 3;
            } else {
                $submittedChoices = array_values($question['pilihan'] ?? []);
                $seenLabels = [];
                $seenTexts = [];
                foreach ($submittedChoices as $choice) {
                    $label = strtoupper(trim($choice['label'] ?? ''));
                    $text = trim($choice['teks_pilihan'] ?? '');
                    $isCorrect = in_array($choice['is_correct'] ?? null, [1, '1', true], true);

                    if ($text === '') {
                        if ($isCorrect && !$isDraft) {
                            $errors["soal.$index.pilihan"] = 'Jawaban benar tidak boleh menunjuk pilihan kosong.';
                        }
                        if (!$isDraft) {
                            continue;
                        }
                    }

                    if (in_array($label, $seenLabels, true) && !$isDraft) {
                        $errors["soal.$index.pilihan"] = 'Label pilihan jawaban tidak boleh berulang.';
                    }
                    $seenLabels[] = $label;

                    $textKey = mb_strtolower($text);
                    if ($textKey !== '' && in_array($textKey, $seenTexts, true) && !$isDraft) {
                        $errors["soal.$index.pilihan"] = 'Teks pilihan jawaban tidak boleh sama dalam satu soal.';
                    }
                    if ($textKey !== '') {
                        $seenTexts[] = $textKey;
                    }

                    $choices[] = ['label' => $label ?: 'A', 'teks_pilihan' => $text, 'is_correct' => $isCorrect];
                    if ($isCorrect && !$correctChoice) {
                        $correctChoice = $choices[array_key_last($choices)];
                    }
                }

                if (!$isDraft) {
                    $correctCount = count(array_filter($choices, fn (array $choice): bool => $choice['is_correct']));
                    if (count($choices) < 2) {
                        $errors["soal.$index.pilihan"] = 'Soal pilihan ganda wajib memiliki minimal dua pilihan terisi.';
                    }
                    if ($correctCount !== 1) {
                        $errors["soal.$index.pilihan"] = 'Pilih tepat satu jawaban benar dari pilihan yang terisi.';
                    }
                } else {
                    if (empty($choices)) {
                        $choices = [
                            ['label' => 'A', 'teks_pilihan' => '', 'is_correct' => true],
                            ['label' => 'B', 'teks_pilihan' => '', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => '', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => false],
                        ];
                        $correctChoice = $choices[0];
                    }
                }

                $answer = $correctChoice['label'] ?? ($choices[0]['label'] ?? 'A');
                $idJenisSoal = 1;
            }

            $normalized[] = [
                'pertanyaan' => $pertanyaanRaw ?: '(Draf Soal #' . ($index + 1) . ')',
                'id_jenis_soal' => $idJenisSoal,
                'jawaban_benar' => $answer ?: 'A',
                'poin' => (int) ($question['poin'] ?? 10),
                'durasi_detik' => (int) ($question['durasi_detik'] ?? 20),
                'pilihan' => $choices,
            ];
        }

        if ($errors && !$isDraft) {
            throw ValidationException::withMessages($errors);
        }

        return $normalized;
    }

    private function questionEditorState($questions): array
    {
        if (!is_array($questions)) {
            return [];
        }

        return array_values(array_map(function ($question) {
            if (!is_array($question)) {
                return [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => '',
                    'timer' => '20',
                    'poin' => 10,
                    'jawaban_singkat' => '',
                    'pilihan' => $this->emptyEditorChoices(),
                ];
            }

            $type = in_array($question['jenis_soal'] ?? null, ['kuis', 'true_false', 'isian_singkat'], true)
                ? $question['jenis_soal']
                : 'kuis';
            $submittedChoices = is_array($question['pilihan'] ?? null) ? array_values($question['pilihan']) : [];
            $timer = $question['durasi_detik'] ?? 20;
            $points = $question['poin'] ?? 10;
            $choices = collect(['A', 'B', 'C', 'D'])->map(function (string $label, int $index) use ($submittedChoices, $type) {
                $choice = is_array($submittedChoices[$index] ?? null) ? $submittedChoices[$index] : [];
                $text = $choice['teks_pilihan'] ?? '';
                $correct = in_array($choice['is_correct'] ?? null, [1, '1', true], true) ? 1 : 0;

                if ($type === 'true_false') {
                    $text = $index === 0 ? 'Benar' : ($index === 1 ? 'Salah' : '');
                    if ($index > 1) $correct = 0;
                } elseif ($type === 'isian_singkat') {
                    $text = '';
                    $correct = 0;
                }

                return [
                    'label' => $label,
                    'teks' => is_scalar($text) ? (string) $text : '',
                    'is_correct' => $correct,
                ];
            })->all();

            return [
                'jenis_soal' => $type,
                'pertanyaan' => is_scalar($question['pertanyaan'] ?? null) ? (string) $question['pertanyaan'] : '',
                'timer' => is_scalar($timer) ? (string) $timer : '20',
                'poin' => is_scalar($points) ? $points : 10,
                'jawaban_singkat' => is_scalar($question['jawaban_singkat'] ?? null) ? (string) $question['jawaban_singkat'] : '',
                'pilihan' => $choices,
            ];
        }, $questions));
    }

    private function emptyEditorChoices(): array
    {
        return collect(['A', 'B', 'C', 'D'])->map(fn (string $label) => [
            'label' => $label,
            'teks' => '',
            'is_correct' => 0,
        ])->all();
    }

    private function quizValidationMessages(): array
    {
        return [
            'judul.required' => 'Judul quiz wajib diisi.',
            'judul.max' => 'Judul quiz maksimal 255 karakter.',
            'judul.unique' => 'Judul quiz sudah digunakan, gunakan judul lain.',
            'judul.regex' => 'Judul quiz hanya boleh berisi huruf, angka, dan spasi.',
            'id_jenjang.required' => 'Jenjang quiz wajib dipilih.',
            'id_jenjang.integer' => 'Jenjang quiz tidak valid.',
            'waktu_kadaluarsa.date' => 'Format waktu kadaluarsa tidak valid.',
            'waktu_kadaluarsa.after_or_equal' => 'Waktu kadaluarsa tidak boleh lebih awal dari sekarang.',
            'mode_pengerjaan.required' => 'Mode pengerjaan wajib dipilih.',
            'mode_pengerjaan.in' => 'Mode pengerjaan tidak valid.',
            'durasi_total_menit.required_if' => 'Durasi seluruh quiz wajib diisi untuk mode kuis biasa.',
            'durasi_total_menit.integer' => 'Durasi quiz harus berupa angka bulat.',
            'durasi_total_menit.min' => 'Durasi quiz minimal 1 menit.',
            'durasi_total_menit.max' => 'Durasi quiz maksimal 360 menit.',
            'deskripsi.max' => 'Deskripsi quiz maksimal 3000 karakter.',
            'token.required_if' => 'Token quiz wajib diisi jika opsi token diaktifkan.',
            'token.max' => 'Token quiz maksimal 50 karakter.',
            'foto_quiz.image' => 'File cover quiz harus berupa gambar.',
            'foto_quiz.mimes' => 'Format cover quiz harus JPG, PNG, atau WebP.',
            'foto_quiz.max' => 'Ukuran file cover quiz maksimal 2MB.',
            'soal.required' => 'Tambahkan minimal satu soal ke quiz.',
            'soal.array' => 'Data soal tidak valid.',
            'soal.min' => 'Quiz wajib memiliki minimal satu soal.',
            'soal.*.pertanyaan.required' => 'Teks pertanyaan wajib diisi.',
            'soal.*.jenis_soal.required' => 'Jenis soal wajib dipilih.',
            'soal.*.jenis_soal.in' => 'Jenis soal tidak dikenali.',
            'soal.*.jawaban_singkat.max' => 'Kunci jawaban maksimal 1000 karakter.',
            'soal.*.poin.integer' => 'Poin soal harus berupa angka bulat.',
            'soal.*.poin.min' => 'Poin soal tidak boleh kurang dari 0.',
            'soal.*.durasi_detik.required_if' => 'Durasi setiap soal wajib dipilih untuk mode Wayground.',
            'soal.*.durasi_detik.integer' => 'Durasi soal harus berupa angka bulat.',
            'soal.*.durasi_detik.in' => 'Durasi soal harus 10, 20, 30, atau 60 detik.',
            'soal.*.pilihan.array' => 'Format pilihan jawaban tidak valid.',
            'soal.*.pilihan.*.label.required' => 'Label pilihan jawaban wajib diisi.',
            'soal.*.pilihan.*.label.in' => 'Label pilihan harus A, B, C, atau D.',
            'soal.*.pilihan.*.teks_pilihan.max' => 'Teks pilihan maksimal 1000 karakter.',
            'soal.*.pilihan.*.is_correct.boolean' => 'Penanda jawaban benar tidak valid.',
        ];
    }

    // =========================================================================
    // API ENDPOINTS FOR MOBILE APP (ARRAVA MOBILE)
    // =========================================================================

    public function apiIndex(Request $request)
    {
        $query = Quiz::with(['tipeQuiz', 'tingkatQuiz', 'jenjang'])
            ->withCount(['soal', 'hasil as participants_count']);

        if ($request->filled('jenjang')) {
            $query->where('id_jenjang', $request->jenjang);
        }

        if ($request->filled('tingkat')) {
            $query->where('id_tingkatquiz', $request->tingkat);
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if ($status === 'draft') {
                $query->draft();
            } elseif ($status === 'tersedia' || $status === 'published') {
                $query->published();
            } elseif ($status === 'kadaluarsa') {
                $query->where('waktu_kadaluarsa', '<=', now());
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kode_quiz', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'terbaru');
        $query->orderBy('id_quiz', $sort === 'terlama' ? 'asc' : 'desc');

        $quizzes = $query->get()->map(function ($quiz) {
            return $this->formatQuizResource($quiz);
        });

        return response()->json([
            'status' => 'success',
            'data' => $quizzes,
        ]);
    }

    public function apiShow($id)
    {
        $quiz = Quiz::with(['tipeQuiz', 'tingkatQuiz', 'jenjang', 'soal.pilihanSoal'])
            ->withCount(['soal', 'hasil as participants_count'])
            ->find($id);

        if (!$quiz) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quiz tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $this->formatQuizResource($quiz),
        ]);
    }

    public function apiStore(Request $request)
    {
        $isDraft = $request->input('action_type') === 'draft';

        $rules = [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:3000',
            'id_jenjang' => 'required|integer',
            'id_tipequiz' => 'nullable|integer',
            'id_tingkatquiz' => 'nullable|integer',
            'waktu_kadaluarsa' => 'nullable|date',
            'mode_pengerjaan' => 'nullable|in:wayground,biasa',
            'durasi_total_menit' => 'nullable|integer|min:1|max:360',
            'opsi_preview' => 'nullable|in:lengkap,tipe_saja',
            'use_token' => 'nullable|boolean',
            'token' => 'nullable|string|max:50',
            'soal' => $isDraft ? 'nullable|array' : 'required|array|min:1',
            'soal.*.pertanyaan' => $isDraft ? 'nullable|string' : 'required|string',
            'soal.*.jenis_soal' => 'nullable|in:kuis,true_false,isian_singkat',
            'soal.*.poin' => 'nullable|integer|min:0',
            'soal.*.durasi_detik' => 'nullable|integer',
            'soal.*.pilihan' => 'nullable|array',
            'soal.*.pilihan.*.label' => 'nullable|string',
            'soal.*.pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
            'soal.*.pilihan.*.is_correct' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules, $this->quizValidationMessages());

        $token = $request->boolean('use_token')
            ? ($request->filled('token') ? trim($request->input('token')) : strtoupper(Str::random(6)))
            : null;

        $quiz = DB::transaction(function () use ($request, $validated, $token, $isDraft) {
            $quiz = Quiz::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'id_jenjang' => $validated['id_jenjang'],
                'id_tipequiz' => $validated['id_tipequiz'] ?? 1,
                'id_tingkatquiz' => $validated['id_tingkatquiz'] ?? 1,
                'waktu_kadaluarsa' => $validated['waktu_kadaluarsa'] ?? null,
                'mode_pengerjaan' => $validated['mode_pengerjaan'] ?? 'wayground',
                'durasi_total_menit' => ($validated['mode_pengerjaan'] ?? 'wayground') === 'biasa' ? ($validated['durasi_total_menit'] ?? 30) : null,
                'opsi_preview' => $validated['opsi_preview'] ?? 'lengkap',
                'token' => $token,
                'foto_quiz' => null,
                'proggressQuiz' => $isDraft ? 'Draft' : 'Tersedia',
            ]);

            $soalInput = $request->input('soal', []);
            if (is_array($soalInput)) {
                foreach ($soalInput as $index => $soalData) {
                    $typeStr = $soalData['jenis_soal'] ?? 'kuis';
                    $idJenisSoal = $typeStr === 'true_false' ? 3 : ($typeStr === 'isian_singkat' ? 2 : 1);
                    $pertanyaan = trim($soalData['pertanyaan'] ?? '') ?: 'Pertanyaan ' . ($index + 1);
                    $poin = (int) ($soalData['poin'] ?? 10);
                    $durasiDetik = (int) ($soalData['durasi_detik'] ?? 20);

                    $jawabanBenar = 'A';
                    if ($typeStr === 'isian_singkat') {
                        $jawabanBenar = trim($soalData['jawaban_singkat'] ?? '');
                    }

                    $pilihanList = $soalData['pilihan'] ?? [];
                    if (!empty($pilihanList) && is_array($pilihanList)) {
                        foreach ($pilihanList as $p) {
                            if (!empty($p['is_correct'])) {
                                $jawabanBenar = $p['label'] ?? 'A';
                                break;
                            }
                        }
                    }

                    $soal = Soal::create([
                        'id_quiz' => $quiz->id_quiz,
                        'id_jenjang' => $quiz->id_jenjang,
                        'pertanyaan' => $pertanyaan,
                        'id_jenis_soal' => $idJenisSoal,
                        'jawaban_benar' => $jawabanBenar,
                        'poin' => $poin,
                        'durasi_detik' => $durasiDetik,
                        'foto_soal' => null,
                    ]);

                    if ($idJenisSoal === 1 || $idJenisSoal === 3) {
                        $defaultChoices = $idJenisSoal === 3
                            ? [['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $jawabanBenar === 'A'], ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $jawabanBenar === 'B']]
                            : [
                                ['label' => 'A', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'A'],
                                ['label' => 'B', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'B'],
                                ['label' => 'C', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'C'],
                                ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'D'],
                            ];

                        $choicesToSave = !empty($pilihanList) ? $pilihanList : $defaultChoices;

                        foreach ($choicesToSave as $choice) {
                            PilihanSoal::create([
                                'id_soal' => $soal->id_soal,
                                'label' => $choice['label'] ?? 'A',
                                'teks_pilihan' => $choice['teks_pilihan'] ?? '',
                                'is_correct' => !empty($choice['is_correct']),
                            ]);
                        }
                    }
                }
            }

            return $quiz;
        });

        $quiz->load(['tipeQuiz', 'tingkatQuiz', 'jenjang', 'soal.pilihanSoal'])->loadCount(['soal', 'hasil as participants_count']);

        return response()->json([
            'status' => 'success',
            'message' => 'Quiz berhasil dibuat.',
            'data' => $this->formatQuizResource($quiz),
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quiz tidak ditemukan.',
            ], 404);
        }

        $isDraft = $request->input('action_type') === 'draft' || ($request->has('action_type') ? false : $quiz->isDraft());

        $rules = [
            'judul' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string|max:3000',
            'id_jenjang' => 'sometimes|required|integer',
            'id_tipequiz' => 'nullable|integer',
            'id_tingkatquiz' => 'nullable|integer',
            'waktu_kadaluarsa' => 'nullable|date',
            'mode_pengerjaan' => 'nullable|in:wayground,biasa',
            'durasi_total_menit' => 'nullable|integer|min:1|max:360',
            'opsi_preview' => 'nullable|in:lengkap,tipe_saja',
            'use_token' => 'nullable|boolean',
            'token' => 'nullable|string|max:50',
            'soal' => 'nullable|array',
        ];

        $validated = $request->validate($rules, $this->quizValidationMessages());

        DB::transaction(function () use ($quiz, $request, $validated, $isDraft) {
            $updateData = [];
            if ($request->has('judul')) $updateData['judul'] = $validated['judul'];
            if ($request->has('deskripsi')) $updateData['deskripsi'] = $validated['deskripsi'];
            if ($request->has('id_jenjang')) $updateData['id_jenjang'] = $validated['id_jenjang'];
            if ($request->has('id_tipequiz')) $updateData['id_tipequiz'] = $validated['id_tipequiz'];
            if ($request->has('id_tingkatquiz')) $updateData['id_tingkatquiz'] = $validated['id_tingkatquiz'];
            if ($request->has('waktu_kadaluarsa')) $updateData['waktu_kadaluarsa'] = $validated['waktu_kadaluarsa'];
            if ($request->has('mode_pengerjaan')) $updateData['mode_pengerjaan'] = $validated['mode_pengerjaan'];
            if ($request->has('durasi_total_menit')) $updateData['durasi_total_menit'] = $validated['durasi_total_menit'];
            if ($request->has('opsi_preview')) $updateData['opsi_preview'] = $validated['opsi_preview'];
            if ($request->has('action_type')) {
                $updateData['proggressQuiz'] = $isDraft ? 'Draft' : 'Tersedia';
            }
            if ($request->has('use_token')) {
                $updateData['token'] = $request->boolean('use_token')
                    ? ($request->filled('token') ? trim($request->input('token')) : strtoupper(Str::random(6)))
                    : null;
            }

            $quiz->update($updateData);

            if ($request->has('soal') && is_array($request->input('soal'))) {
                $existingSoalIds = $quiz->soal()->pluck('id_soal');
                PilihanSoal::whereIn('id_soal', $existingSoalIds)->delete();
                $quiz->soal()->delete();

                foreach ($request->input('soal') as $index => $soalData) {
                    $typeStr = $soalData['jenis_soal'] ?? 'kuis';
                    $idJenisSoal = $typeStr === 'true_false' ? 3 : ($typeStr === 'isian_singkat' ? 2 : 1);
                    $pertanyaan = trim($soalData['pertanyaan'] ?? '') ?: 'Pertanyaan ' . ($index + 1);
                    $poin = (int) ($soalData['poin'] ?? 10);
                    $durasiDetik = (int) ($soalData['durasi_detik'] ?? 20);

                    $jawabanBenar = 'A';
                    if ($typeStr === 'isian_singkat') {
                        $jawabanBenar = trim($soalData['jawaban_singkat'] ?? '');
                    }

                    $pilihanList = $soalData['pilihan'] ?? [];
                    if (!empty($pilihanList) && is_array($pilihanList)) {
                        foreach ($pilihanList as $p) {
                            if (!empty($p['is_correct'])) {
                                $jawabanBenar = $p['label'] ?? 'A';
                                break;
                            }
                        }
                    }

                    $soal = Soal::create([
                        'id_quiz' => $quiz->id_quiz,
                        'id_jenjang' => $quiz->id_jenjang,
                        'pertanyaan' => $pertanyaan,
                        'id_jenis_soal' => $idJenisSoal,
                        'jawaban_benar' => $jawabanBenar,
                        'poin' => $poin,
                        'durasi_detik' => $durasiDetik,
                        'foto_soal' => null,
                    ]);

                    if ($idJenisSoal === 1 || $idJenisSoal === 3) {
                        $defaultChoices = $idJenisSoal === 3
                            ? [['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $jawabanBenar === 'A'], ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $jawabanBenar === 'B']]
                            : [
                                ['label' => 'A', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'A'],
                                ['label' => 'B', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'B'],
                                ['label' => 'C', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'C'],
                                ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => $jawabanBenar === 'D'],
                            ];

                        $choicesToSave = !empty($pilihanList) ? $pilihanList : $defaultChoices;

                        foreach ($choicesToSave as $choice) {
                            PilihanSoal::create([
                                'id_soal' => $soal->id_soal,
                                'label' => $choice['label'] ?? 'A',
                                'teks_pilihan' => $choice['teks_pilihan'] ?? '',
                                'is_correct' => !empty($choice['is_correct']),
                            ]);
                        }
                    }
                }
            }
        });

        $quiz->load(['tipeQuiz', 'tingkatQuiz', 'jenjang', 'soal.pilihanSoal'])->loadCount(['soal', 'hasil as participants_count']);

        return response()->json([
            'status' => 'success',
            'message' => 'Quiz berhasil diperbarui.',
            'data' => $this->formatQuizResource($quiz),
        ]);
    }

    public function apiDestroy($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quiz tidak ditemukan.',
            ], 404);
        }

        DB::transaction(function () use ($quiz) {
            $soalIds = $quiz->soal()->pluck('id_soal');
            PilihanSoal::whereIn('id_soal', $soalIds)->delete();

            $soals = $quiz->soal()->get();
            foreach ($soals as $soal) {
                if ($soal->foto_soal && Storage::disk('public')->exists($soal->foto_soal)) {
                    Storage::disk('public')->delete($soal->foto_soal);
                }
            }
            $quiz->soal()->delete();

            if ($quiz->foto_quiz && Storage::disk('public')->exists($quiz->foto_quiz)) {
                Storage::disk('public')->delete($quiz->foto_quiz);
            }

            $quiz->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Quiz berhasil dihapus.',
        ]);
    }

    public function apiQuestionBank(Request $request)
    {
        $query = Soal::with(['pilihanSoal', 'jenjang', 'jenisSoal', 'quiz']);

        if ($request->filled('jenjang')) {
            $query->where('id_jenjang', $request->jenjang);
        }

        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', "%{$request->search}%");
        }

        $questions = $query->latest('id_soal')->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $questions,
        ]);
    }

    public function apiVerifyToken(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['status' => 'error', 'message' => 'Quiz tidak ditemukan.'], 404);
        }

        if (!$quiz->perluToken()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Quiz tidak memerlukan token.',
                'data' => ['valid' => true],
            ]);
        }

        $tokenInput = trim((string) $request->input('token', ''));
        if ($tokenInput === '' || strcasecmp($tokenInput, (string) $quiz->token) !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token kuis salah. Silakan tanyakan token kepada guru Anda.',
                'data' => ['valid' => false],
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Token valid.',
            'data' => ['valid' => true],
        ]);
    }

    public function apiSubmitQuiz(Request $request, $id)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->find($id);
        if (!$quiz) {
            return response()->json(['status' => 'error', 'message' => 'Quiz tidak ditemukan.'], 404);
        }

        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
        }

        $jawabanSiswa = $request->input('jawaban', []);
        $normalizedAnswers = [];
        if (is_array($jawabanSiswa)) {
            foreach ($jawabanSiswa as $key => $val) {
                if (is_array($val) && isset($val['id_soal'])) {
                    $normalizedAnswers[$val['id_soal']] = $val['jawaban'] ?? null;
                } else {
                    $normalizedAnswers[$key] = $val;
                }
            }
        }

        $totalPoinQuiz = (int) $quiz->soal->sum('poin');
        $poinDidapat = 0;
        $totalBenar = 0;
        $totalSalah = 0;
        $detailEvaluasi = [];

        foreach ($quiz->soal as $soal) {
            $jawaban = $normalizedAnswers[$soal->id_soal] ?? null;
            $isBenar = false;

            if ($soal->id_jenis_soal == 2) {
                $isBenar = !empty($jawaban) && strcasecmp(trim((string) $jawaban), trim((string) $soal->jawaban_benar)) === 0;
            } else {
                $pilihanBenar = $soal->pilihanSoal->firstWhere('is_correct', true);
                if ($pilihanBenar) {
                    $isBenar = !empty($jawaban) && (
                        strcasecmp(trim((string) $jawaban), trim((string) $pilihanBenar->label)) === 0
                        || (string) $jawaban === (string) $pilihanBenar->id_pilihan
                        || strcasecmp(trim((string) $jawaban), trim((string) $pilihanBenar->teks_pilihan)) === 0
                    );
                } else {
                    $isBenar = !empty($jawaban) && strcasecmp(trim((string) $jawaban), trim((string) $soal->jawaban_benar)) === 0;
                }
            }

            if ($isBenar) {
                $poinDidapat += (int) ($soal->poin ?? 10);
                $totalBenar++;
            } else {
                $totalSalah++;
            }

            $detailEvaluasi[] = [
                'id_soal' => (int) $soal->id_soal,
                'jawaban_siswa' => $jawaban,
                'jawaban_benar' => $soal->jawaban_benar,
                'is_correct' => $isBenar,
                'poin' => $isBenar ? (int) ($soal->poin ?? 10) : 0,
            ];
        }

        $persentase = $totalPoinQuiz > 0 ? round(($poinDidapat / $totalPoinQuiz) * 100, 1) : 0;
        $isLulus = $persentase >= 60;

        $sudahLulusSebelumnya = HasilQuizModul::where('id_user', $user->id_user)
            ->where('id_quiz', $quiz->id_quiz)
            ->where('is_lulus', true)
            ->exists();

        $poinDiberikan = ($isLulus && !$sudahLulusSebelumnya) ? $poinDidapat : 0;

        $hasil = HasilQuizModul::create([
            'id_user' => $user->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => $totalPoinQuiz,
            'poin_didapat' => $poinDidapat,
            'is_lulus' => $isLulus,
            'waktu_dapat' => now(),
        ]);

        if ($poinDiberikan > 0) {
            User::whereKey($user->id_user)->increment('total_poin', $poinDiberikan);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Hasil kuis berhasil disimpan.',
            'data' => [
                'id_hasil' => $hasil->id_hasil,
                'id_quiz' => $quiz->id_quiz,
                'judul' => $quiz->judul,
                'poin_didapat' => $poinDidapat,
                'total_poin' => $totalPoinQuiz,
                'persentase' => $persentase,
                'benar' => $totalBenar,
                'salah' => $totalSalah,
                'total_soal' => $quiz->soal->count(),
                'is_lulus' => $isLulus,
                'poin_diberikan' => $poinDiberikan,
                'evaluasi' => $quiz->opsi_preview === 'lengkap' ? $detailEvaluasi : [],
            ],
        ]);
    }

    private function formatQuizResource(Quiz $quiz): array
    {
        $totalPoints = $quiz->relationLoaded('soal')
            ? (int) $quiz->soal->sum('poin')
            : (int) $quiz->soal()->sum('poin');

        $user = request()->user();
        $userResult = null;
        if ($user) {
            $latestHasil = HasilQuizModul::where('id_quiz', $quiz->id_quiz)
                ->where('id_user', $user->id_user)
                ->orderByDesc('id_hasil')
                ->first();
            if ($latestHasil) {
                $userResult = [
                    'id_hasil' => (int) $latestHasil->id_hasil,
                    'total_poin' => (int) $latestHasil->total_poin,
                    'poin_didapat' => (int) $latestHasil->poin_didapat,
                    'is_lulus' => (bool) $latestHasil->is_lulus,
                    'waktu_dapat' => $latestHasil->waktu_dapat ? $latestHasil->waktu_dapat->toIso8601String() : null,
                ];
            }
        }

        return [
            'id_quiz' => (int) $quiz->id_quiz,
            'kode_quiz' => $quiz->kode_quiz,
            'judul' => $quiz->judul,
            'deskripsi' => $quiz->deskripsi,
            'id_jenjang' => $quiz->id_jenjang ? (int) $quiz->id_jenjang : null,
            'nama_jenjang' => $quiz->jenjang->nama_tipe ?? $quiz->jenjang->nama_jenjang ?? null,
            'id_tingkatquiz' => $quiz->id_tingkatquiz ? (int) $quiz->id_tingkatquiz : null,
            'nama_tingkat' => $quiz->tingkatQuiz->nama_tingkat ?? $quiz->tingkatQuiz->nama_tingkatquiz ?? null,
            'id_tipequiz' => $quiz->id_tipequiz ? (int) $quiz->id_tipequiz : null,
            'nama_tipe' => $quiz->tipeQuiz->nama_tipe ?? $quiz->tipeQuiz->nama_tipequiz ?? null,
            'mode_pengerjaan' => $quiz->mode_pengerjaan ?? 'wayground',
            'durasi_total_menit' => $quiz->durasi_total_menit ? (int) $quiz->durasi_total_menit : null,
            'waktu_kadaluarsa' => $quiz->waktu_kadaluarsa ? $quiz->waktu_kadaluarsa->toIso8601String() : null,
            'is_expired' => $quiz->sudahKadaluarsa(),
            'token' => $quiz->token,
            'requires_token' => $quiz->perluToken(),
            'proggressQuiz' => $quiz->proggressQuiz ?? 'Draft',
            'is_draft' => $quiz->isDraft(),
            'foto_quiz' => $quiz->foto_quiz,
            'cover_url' => $quiz->cover_url,
            'opsi_preview' => $quiz->opsi_preview ?? 'lengkap',
            'questions_count' => (int) ($quiz->soal_count ?? ($quiz->relationLoaded('soal') ? $quiz->soal->count() : 0)),
            'participants_count' => (int) ($quiz->participants_count ?? 0),
            'total_points' => $totalPoints,
            'user_result' => $userResult,
            'soal' => $quiz->relationLoaded('soal') ? $quiz->soal->map(function ($s) {
                return [
                    'id_soal' => (int) $s->id_soal,
                    'kode_soal' => $s->kode_soal,
                    'pertanyaan' => $s->pertanyaan,
                    'id_jenis_soal' => (int) $s->id_jenis_soal,
                    'jenis_soal' => $s->id_jenis_soal == 3 ? 'true_false' : ($s->id_jenis_soal == 2 ? 'isian_singkat' : 'kuis'),
                    'jawaban_benar' => $s->jawaban_benar,
                    'poin' => (int) ($s->poin ?? 10),
                    'durasi_detik' => (int) ($s->durasi_detik ?? 20),
                    'foto_soal' => $s->foto_soal ? asset('storage/' . $s->foto_soal) : null,
                    'pilihan' => $s->relationLoaded('pilihanSoal') ? $s->pilihanSoal->map(function ($p) {
                        return [
                            'id_pilihan' => (int) $p->id_pilihan,
                            'label' => $p->label,
                            'teks_pilihan' => $p->teks_pilihan,
                            'is_correct' => (bool) $p->is_correct,
                        ];
                    })->values()->all() : [],
                ];
            })->values()->all() : [],
        ];
    }
}
