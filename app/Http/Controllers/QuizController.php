<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

// Controller khusus untuk mengelola data kuis pembelajaran.
class QuizController extends Controller
{
    // Menampilkan daftar kuis untuk halaman admin atau guru.
    public function index(Request $request)
    {
        $filters = $request->validate([
            'jenjang' => ['nullable', 'integer', 'exists:jenjang,id_jenjang'],
            'tingkat' => ['nullable', 'integer', 'exists:tingkatquiz,id_tingkatquiz'],
            'sort' => ['nullable', 'in:terbaru,terlama'],
        ]);

        $query = Quiz::with(['tipeQuiz', 'tingkatQuiz', 'jenjang'])->withCount('soal');

        if (!empty($filters['jenjang'])) {
            $query->where('id_jenjang', $filters['jenjang']);
        }

        if (!empty($filters['tingkat'])) {
            $query->where('id_tingkatquiz', $filters['tingkat']);
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
        $jenjangList = Jenjang::all();
        $tingkatQuizList = \App\Models\TingkatQuiz::all();
        $questions = $this->questionEditorState(old('soal', []));
        return view('admin.quiz.create', compact('jenjangList', 'tingkatQuizList', 'questions'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id);
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
                'jenis_soal' => $type,
                'pertanyaan' => $soal->pertanyaan,
                'timer' => (string) ($soal->durasi_detik ?? 20),
                'poin' => (int) ($soal->poin ?? 10),
                'jawaban_singkat' => $type === 'isian_singkat' ? $soal->jawaban_benar : '',
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
        $validated = $request->validate([
            'judul'            => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'id_jenjang'       => 'required|integer',
            'id_tipequiz'      => 'nullable|integer',
            'id_tingkatquiz'   => 'nullable|integer',
            'waktu_kadaluarsa' => ['nullable', 'date', 'after_or_equal:now'],
            'mode_pengerjaan' => 'required|in:wayground,biasa',
            'durasi_total_menit' => 'nullable|required_if:mode_pengerjaan,biasa|integer|min:1|max:360',
            'soal'             => 'required|array|min:1',
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
        ], $this->quizValidationMessages());
        $questions = $this->normalizeQuestionAnswers($validated['soal']);

        if ($request->filled('waktu_kadaluarsa')) {
            $waktuKadaluarsa = \Carbon\Carbon::parse($request->waktu_kadaluarsa);
            if ($waktuKadaluarsa->lt(now())) {
                return redirect()->back()->withErrors([
                    'waktu_kadaluarsa' => 'Waktu kadaluarsa tidak boleh lebih kecil dari waktu sekarang.',
                ])->withInput();
            }
        }

        DB::transaction(function () use ($request, $questions) {
            // 1. Simpan quiz
            $quiz = Quiz::create([
                'judul'            => $request->judul,
                'id_jenjang'       => $request->id_jenjang,
                'id_tipequiz'      => $request->id_tipequiz ?? 1,
                'id_tingkatquiz'   => $request->id_tingkatquiz ?? 1,
                'waktu_kadaluarsa' => $request->waktu_kadaluarsa ?: null,
                'mode_pengerjaan' => $request->mode_pengerjaan,
                'durasi_total_menit' => $request->mode_pengerjaan === 'biasa' ? $request->durasi_total_menit : null,
                'proggressQuiz'    => 'Tersedia',
            ]);

            // 2. Simpan setiap soal
            foreach ($questions as $index => $soalData) {
                $fotoPath = null;
                if ($request->hasFile("soal_foto.$index")) {
                    $foto = $request->file("soal_foto.$index");
                    if ($foto->isValid()) {
                        $fotoPath = $foto->store('soal/foto', 'public');
                    }
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

        return redirect()->route('admin.quiz')->with('success', 'Quiz berhasil dibuat! 🎉');
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'id_jenjang' => 'required|integer',
            'id_tipequiz' => 'nullable|integer',
            'id_tingkatquiz' => 'nullable|integer',
            'waktu_kadaluarsa' => ['nullable', 'date'],
            'mode_pengerjaan' => 'required|in:wayground,biasa',
            'durasi_total_menit' => 'nullable|required_if:mode_pengerjaan,biasa|integer|min:1|max:360',
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
        ], $this->quizValidationMessages());
        $questions = $this->normalizeQuestionAnswers($validated['soal']);

        DB::transaction(function () use ($quiz, $validated, $questions, $request) {
            $quiz->update([
                'judul' => $validated['judul'],
                'id_jenjang' => $validated['id_jenjang'],
                'id_tipequiz' => $validated['id_tipequiz'] ?? $quiz->id_tipequiz,
                'id_tingkatquiz' => $validated['id_tingkatquiz'] ?? $quiz->id_tingkatquiz,
                'waktu_kadaluarsa' => $validated['waktu_kadaluarsa'] ?: null,
                'mode_pengerjaan' => $validated['mode_pengerjaan'],
                'durasi_total_menit' => $validated['mode_pengerjaan'] === 'biasa' ? $validated['durasi_total_menit'] : null,
            ]);

            $this->replaceQuestions($quiz, $questions, (int) $validated['id_jenjang'], $request);
        });

        return redirect()->route('admin.quiz')->with('success', 'Quiz berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        DB::transaction(function () use ($quiz) {
            $questionIds = $quiz->soal()->pluck('id_soal');
            PilihanSoal::whereIn('id_soal', $questionIds)->delete();
            $quiz->soal()->delete();
            $quiz->delete();
        });

        return redirect()->route('admin.quiz')->with('success', 'Quiz dan seluruh soalnya berhasil dihapus.');
    }

    private function replaceQuestions(Quiz $quiz, array $questions, int $idJenjang, Request $request = null): void
    {
        $oldSoalList = $quiz->soal()->get();
        
        $questionIds = $oldSoalList->pluck('id_soal');
        PilihanSoal::whereIn('id_soal', $questionIds)->delete();
        $quiz->soal()->delete();
        
        // Hapus foto lama agar tidak menumpuk di storage (opsional)
        // foreach ($oldSoalList as $oldSoal) {
        //     if ($oldSoal->foto_soal && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldSoal->foto_soal)) {
        //         \Illuminate\Support\Facades\Storage::disk('public')->delete($oldSoal->foto_soal);
        //     }
        // }

        foreach ($questions as $index => $questionData) {
            $fotoPath = null;
            if ($request && $request->hasFile("soal_foto.$index")) {
                $foto = $request->file("soal_foto.$index");
                if ($foto->isValid()) {
                    $fotoPath = $foto->store('soal/foto', 'public');
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

    private function normalizeQuestionAnswers(array $questions): array
    {
        $normalized = [];
        $errors = [];

        foreach ($questions as $index => $question) {
            $type = $question['jenis_soal'];
            $choices = [];
            $correctChoice = null;

            if ($type === 'isian_singkat') {
                $answer = trim($question['jawaban_singkat'] ?? '');
                if ($answer === '') {
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

                if (count($correctIndexes) !== 1) {
                    $errors["soal.$index.pilihan"] = 'Pilih tepat satu jawaban benar untuk soal Benar/Salah.';
                }

                $choices = [
                    ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => ($correctIndexes[0] ?? null) === 0],
                    ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => ($correctIndexes[0] ?? null) === 1],
                ];
                $correctChoice = $choices[$correctIndexes[0] ?? -1] ?? null;
                $answer = $correctChoice['label'] ?? '';
                $idJenisSoal = 3;
            } else {
                $submittedChoices = array_values($question['pilihan'] ?? []);
                $seenLabels = [];
                foreach ($submittedChoices as $choice) {
                    $label = strtoupper(trim($choice['label']));
                    $text = trim($choice['teks_pilihan'] ?? '');
                    $isCorrect = in_array($choice['is_correct'] ?? null, [1, '1', true], true);

                    if ($text === '') {
                        if ($isCorrect) {
                            $errors["soal.$index.pilihan"] = 'Jawaban benar tidak boleh menunjuk pilihan kosong.';
                        }
                        continue;
                    }

                    if (in_array($label, $seenLabels, true)) {
                        $errors["soal.$index.pilihan"] = 'Label pilihan jawaban tidak boleh berulang.';
                    }
                    $seenLabels[] = $label;
                    $choices[] = ['label' => $label, 'teks_pilihan' => $text, 'is_correct' => $isCorrect];
                    if ($isCorrect) {
                        $correctChoice = $choices[array_key_last($choices)];
                    }
                }

                $correctCount = count(array_filter($choices, fn (array $choice): bool => $choice['is_correct']));
                if (count($choices) < 2) {
                    $errors["soal.$index.pilihan"] = 'Soal pilihan ganda wajib memiliki minimal dua pilihan terisi.';
                }
                if ($correctCount !== 1) {
                    $errors["soal.$index.pilihan"] = 'Pilih tepat satu jawaban benar dari pilihan yang terisi.';
                }

                $answer = $correctChoice['label'] ?? '';
                $idJenisSoal = 1;
            }

            $normalized[] = [
                'pertanyaan' => $question['pertanyaan'],
                'id_jenis_soal' => $idJenisSoal,
                'jawaban_benar' => $answer,
                'poin' => $question['poin'] ?? 10,
                'durasi_detik' => $question['durasi_detik'] ?? 20,
                'pilihan' => $choices,
            ];
        }

        if ($errors) {
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
}
