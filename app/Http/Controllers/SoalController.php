<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Quiz;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\JenisSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

// Controller khusus untuk mengelola soal quiz per jenjang.
class SoalController extends Controller
{
    // Menampilkan daftar soal yang ada di sistem (Bank Soal & Kuis).
    public function index(Request $request)
    {
        if (auth()->check()) {
            Gate::authorize('viewAny', Soal::class);
        }

        $sumber = $request->query('sumber', 'all');
        $mapelId = $request->query('mapel_id');
        $jenjangId = $request->query('jenjang_id');
        $jenisSoal = $request->query('jenis_soal', 'all');
        $tingkat = $request->query('tingkat_soal', 'all');
        $search = trim((string) $request->query('q', ''));

        $query = Soal::query()
            ->with(['quiz.tipeQuiz', 'jenjang', 'jenisSoal', 'mapel', 'penulis'])
            ->when(auth()->user() && auth()->user()->isGuru(), function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('id_quiz')
                        ->orWhere('id_penulis', auth()->id())
                        ->orWhereHas('quiz', fn($k) => $k->where('id_pembuat', auth()->id()));
                });
            })
            ->when($sumber === 'bank', fn($q) => $q->whereNull('id_quiz'))
            ->when($sumber === 'quiz', fn($q) => $q->whereNotNull('id_quiz'))
            ->when(!empty($mapelId) && $mapelId !== 'all', fn($q) => $q->where('id_mapel', $mapelId))
            ->when(!empty($jenjangId) && $jenjangId !== 'all', fn($q) => $q->where('id_jenjang', $jenjangId))
            ->when(!empty($tingkat) && $tingkat !== 'all', fn($q) => $q->where('tingkat_soal', $tingkat))
            ->when(!empty($jenisSoal) && $jenisSoal !== 'all', function ($q) use ($jenisSoal) {
                if ($jenisSoal === 'pilihan_ganda' || $jenisSoal === '1') {
                    $q->where('id_jenis_soal', 1);
                } elseif ($jenisSoal === 'isian' || $jenisSoal === '2') {
                    $q->where('id_jenis_soal', 2);
                } elseif ($jenisSoal === 'benar_salah' || $jenisSoal === '3') {
                    $q->where('id_jenis_soal', 3);
                } elseif ($jenisSoal === 'bergambar') {
                    $q->whereNotNull('foto_soal')->where('foto_soal', '!=', '');
                }
            })
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(pertanyaan) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(kode_soal) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(jawaban_benar) LIKE ?', ["%{$search}%"]);
                });
            })
            ->latest('id_soal');

        $totalFiltered = (clone $query)->count();
        $soals = $query->paginate(24)->withQueryString();

        $mapelList = Schema::hasTable('mapel') ? Mapel::orderBy('nama_mapel')->get() : collect();
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $quizList = Quiz::with('tipeQuiz')
            ->when(auth()->user() && auth()->user()->isGuru(), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('id_pembuat', auth()->id())
                        ->orWhere(function ($d) {
                            $d->whereHas('tipeQuiz', fn($t) => $t->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"));
                        });
                });
            })
            ->orderBy('judul')
            ->get();

        return view('admin.soal.index', compact('soals', 'mapelList', 'jenjangList', 'quizList', 'totalFiltered'));
    }

    // Menampilkan form untuk menambah soal baru (Bank Soal atau ke Kuis).
    public function create(Request $request)
    {
        if (auth()->check()) {
            Gate::authorize('create', Soal::class);
        }

        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $mapelList = Schema::hasTable('mapel') ? Mapel::orderBy('nama_mapel')->get() : collect();
        $jenisSoalList = Schema::hasTable('jenis_soal') ? JenisSoal::orderBy('id_jenis_soal')->get() : collect();
        $selectedQuizId = $request->query('id_quiz') ?? old('id_quiz');
        $selectedQuiz = $selectedQuizId ? Quiz::with('tipeQuiz')->find($selectedQuizId) : null;
        $quizList = Quiz::with('tipeQuiz')
            ->when(auth()->user() && auth()->user()->isGuru(), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('id_pembuat', auth()->id())
                        ->orWhere(function ($d) {
                            $d->whereHas('tipeQuiz', fn($t) => $t->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"));
                        });
                });
            })
            ->orderBy('judul')
            ->get();

        return view('admin.soal.create', compact('jenjangList', 'mapelList', 'jenisSoalList', 'selectedQuiz', 'selectedQuizId', 'quizList'));
    }

    // Menyimpan soal baru ke database.
    public function store(Request $request)
    {
        if (auth()->check()) {
            Gate::authorize('create', Soal::class);
        }

        // Jika request dikirim dari builder Kahoot-style (soal array)
        if ($request->has('soal') && is_array($request->soal)) {
            return $this->storeBatchFromBuilder($request);
        }

        $questionData = $this->validateQuestionData($request);

        // Guru hanya boleh menambah soal ke quiz miliknya atau ke kuis Dungeon.
        if (auth()->check() && !empty($questionData['soal']['id_quiz'])) {
            /** @var Quiz|null $quizTujuan */
            $quizTujuan = Quiz::find($questionData['soal']['id_quiz']);
            if ($quizTujuan instanceof Quiz) {
                if ($quizTujuan->isDungeon()) {
                    Gate::authorize('addSoal', $quizTujuan);
                } else {
                    Gate::authorize('update', $quizTujuan);
                }
            }
        }

        $request->validate([
            'foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto_soal.image' => 'File foto soal harus berupa gambar.',
            'foto_soal.mimes' => 'Format foto soal harus JPEG, PNG, JPG, atau WEBP.',
            'foto_soal.max' => 'Ukuran foto soal maksimal 2MB.',
        ]);

        $pathFoto = null;

        if ($request->hasFile('foto_soal')) {
            $foto = $request->file('foto_soal');

            if (!$foto->isValid()) {
                return back()->withInput()->withErrors([
                    'foto_soal' => 'File foto soal tidak valid atau rusak.',
                ]);
            }

            $pathFoto = $foto->store('soal/foto', 'public');

            if (!$pathFoto) {
                return back()->withInput()->withErrors([
                    'foto_soal' => 'Gagal mengunggah foto soal. Silakan coba lagi.',
                ]);
            }
        }

        DB::transaction(function () use ($questionData, $pathFoto) {
            $extraData = ['foto_soal' => $pathFoto];
            if (auth()->check() && Schema::hasColumn('soal', 'id_penulis')) {
                $extraData['id_penulis'] = auth()->id();
            }
            if (Schema::hasColumn('soal', 'aktif')) {
                $extraData['aktif'] = true;
            }

            $payload = $questionData['soal'] + $extraData;
            if (!Schema::hasColumn('soal', 'tingkat_soal')) {
                unset($payload['tingkat_soal']);
            }

            $soal = Soal::create($payload);
            $this->syncChoices($soal, $questionData['pilihan']);
        });

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit soal.
    public function edit($id)
    {
        $soal = Soal::with(['pilihanSoal', 'quiz.tipeQuiz', 'mapel', 'jenjang'])->where('id_soal', $id)->orWhere('kode_soal', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('update', $soal);
        }
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $mapelList = Schema::hasTable('mapel') ? Mapel::orderBy('nama_mapel')->get() : collect();
        $jenisSoalList = Schema::hasTable('jenis_soal') ? JenisSoal::orderBy('id_jenis_soal')->get() : collect();
        $quizList = Quiz::with('tipeQuiz')
            ->when(auth()->user() && auth()->user()->isGuru(), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('id_pembuat', auth()->id())
                        ->orWhere(function ($d) {
                            $d->whereHas('tipeQuiz', fn($t) => $t->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"));
                        });
                });
            })
            ->orderBy('judul')
            ->get();

        return view('admin.soal.edit', compact('soal', 'jenjangList', 'mapelList', 'jenisSoalList', 'quizList'));
    }

    // Memperbarui soal di database.
    public function update(Request $request, $id)
    {
        $soal = Soal::where('id_soal', $id)->orWhere('kode_soal', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('update', $soal);
        }
        $questionData = $this->validateQuestionData($request, $soal->id_soal);

        $request->validate([
            'foto_soal' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto_soal.image' => 'File foto soal harus berupa gambar.',
            'foto_soal.mimes' => 'Format foto soal harus JPEG, PNG, JPG, atau WEBP.',
            'foto_soal.max' => 'Ukuran foto soal maksimal 2MB.',
        ]);

        $pathFoto = $soal->foto_soal;
        $fotoLama = $soal->foto_soal;
        $fotoBaruDiunggah = false;

        if ($request->hasFile('foto_soal')) {
            $foto = $request->file('foto_soal');

            if (!$foto->isValid()) {
                return back()->withInput()->withErrors([
                    'foto_soal' => 'File foto soal tidak valid atau rusak.',
                ]);
            }

            // Cegah upload ulang gambar yang sama persis pada soal ini
            if ($fotoLama && Storage::disk('public')->exists($fotoLama)) {
                $fotoLamaPath = Storage::disk('public')->path($fotoLama);
                if (file_exists($fotoLamaPath) && md5_file($foto->getRealPath()) === md5_file($fotoLamaPath)) {
                    return back()->withInput()->withErrors([
                        'foto_soal' => 'Foto yang diunggah sama dengan foto yang sudah terpasang pada soal ini.',
                    ]);
                }
            }

            $pathFoto = $foto->store('soal/foto', 'public');

            if (!$pathFoto) {
                return back()->withInput()->withErrors([
                    'foto_soal' => 'Gagal mengunggah foto soal. Silakan coba lagi.',
                ]);
            }
            $fotoBaruDiunggah = true;
        }

        DB::transaction(function () use ($soal, $questionData, $pathFoto) {
            $updatePayload = $questionData['soal'] + ['foto_soal' => $pathFoto];
            if (!Schema::hasColumn('soal', 'tingkat_soal')) {
                unset($updatePayload['tingkat_soal']);
            }
            $soal->update($updatePayload);
            $this->syncChoices($soal, $questionData['pilihan']);
        });

        if (
            $fotoBaruDiunggah && $fotoLama && $fotoLama !== $pathFoto
            && Storage::disk('public')->exists($fotoLama)
        ) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil diperbarui.');
    }

    private function storeBatchFromBuilder(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required|integer|exists:mapel,id_mapel',
            'id_jenjang' => 'nullable|integer',
            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => 'required|string',
            'soal_foto' => 'nullable|array',
            'soal_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'id_mapel.required' => 'Mata pelajaran wajib dipilih untuk soal Bank Soal.',
            'soal.required' => 'Minimal ada satu soal yang ditambahkan.',
            'soal.*.pertanyaan.required' => 'Teks pertanyaan wajib diisi untuk setiap soal.',
            'soal_foto.*.image' => 'File foto soal harus berupa gambar.',
            'soal_foto.*.mimes' => 'Format foto harus JPEG, PNG, JPG, atau WEBP.',
            'soal_foto.*.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $idMapel = (int) $request->id_mapel;
        $idJenjang = $request->filled('id_jenjang') ? (int) $request->id_jenjang : null;
        $createdCount = 0;

        DB::transaction(function () use ($request, $idMapel, $idJenjang, &$createdCount) {
            foreach ($request->soal as $idx => $sData) {
                $pertanyaan = trim((string) ($sData['pertanyaan'] ?? ''));
                if ($pertanyaan === '') continue;

                // Anti-duplikasi di Bank Soal per mata pelajaran
                $pertanyaanLower = mb_strtolower($pertanyaan);
                $exists = Soal::whereNull('id_quiz')
                    ->where('id_mapel', $idMapel)
                    ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaanLower])
                    ->exists();

                if ($exists) {
                    throw ValidationException::withMessages([
                        'soal' => "Pertanyaan: \"{$pertanyaan}\" sudah ada di Bank Soal untuk mata pelajaran ini.",
                    ]);
                }

                $rawJenis = $sData['jenis_soal'] ?? 'kuis';
                $idJenis = ($rawJenis === 'true_false' || $rawJenis === '3') ? 3 : (($rawJenis === 'isian_singkat' || $rawJenis === '2') ? 2 : 1);
                $tingkat = $sData['tingkat_soal'] ?? 'sedang';
                if (!in_array($tingkat, ['mudah', 'sedang', 'sulit'], true)) {
                    $tingkat = 'sedang';
                }

                // Handle file foto
                $pathFoto = null;
                if ($request->hasFile("soal_foto.{$idx}")) {
                    $foto = $request->file("soal_foto.{$idx}");
                    if ($foto && $foto->isValid()) {
                        $pathFoto = $foto->store('soal/foto', 'public');
                    }
                } elseif ($request->hasFile("soal.{$idx}.foto_soal")) {
                    $foto = $request->file("soal.{$idx}.foto_soal");
                    if ($foto && $foto->isValid()) {
                        $pathFoto = $foto->store('soal/foto', 'public');
                    }
                }

                $jawabanBenar = null;
                if ($idJenis === 2) {
                    $jawabanBenar = trim((string) ($sData['jawaban_singkat'] ?? ''));
                }

                $payload = [
                    'id_quiz' => null,
                    'id_mapel' => $idMapel,
                    'id_jenjang' => $idJenjang,
                    'id_jenis_soal' => $idJenis,
                    'tingkat_soal' => $tingkat,
                    'pertanyaan' => $pertanyaan,
                    'poin' => (int) ($sData['poin'] ?? 10),
                    'durasi_detik' => (int) ($sData['durasi_detik'] ?? 20),
                    'jawaban_benar' => $jawabanBenar,
                    'foto_soal' => $pathFoto,
                    'id_penulis' => auth()->id(),
                    'aktif' => true,
                ];

                $soal = Soal::create($payload);

                // Sinkronisasi pilihan
                $choices = [];
                if ($idJenis === 1) {
                    $pilData = $sData['pilihan'] ?? [];
                    foreach (['A', 'B', 'C', 'D'] as $pIdx => $lbl) {
                        $pItem = $pilData[$pIdx] ?? null;
                        $teks = trim((string) ($pItem['teks_pilihan'] ?? ($pItem['teks'] ?? '')));
                        $isCorrect = !empty($pItem['is_correct']) ? 1 : 0;
                        $tetapDiBawah = !empty($pItem['tetap_di_bawah']) ? 1 : 0;
                        if ($teks !== '' || $pIdx < 2) {
                            $choices[] = [
                                'label' => $lbl,
                                'teks_pilihan' => $teks,
                                'is_correct' => $isCorrect,
                                'tetap_di_bawah' => $tetapDiBawah,
                            ];
                        }
                    }
                } elseif ($idJenis === 3) {
                    $pilData = $sData['pilihan'] ?? [];
                    $correctA = !empty($pilData[0]['is_correct']) ? 1 : 0;
                    $correctB = !empty($pilData[1]['is_correct']) ? 1 : 0;
                    if (!$correctA && !$correctB) {
                        $correctA = 1;
                    }
                    $choices = [
                        ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $correctA, 'tetap_di_bawah' => 0],
                        ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $correctB, 'tetap_di_bawah' => 0],
                    ];
                }

                $this->syncChoices($soal, $choices);
                $createdCount++;
            }
        });

        return redirect()->route('admin.soal')->with('success', "{$createdCount} soal berhasil ditambahkan ke Bank Soal.");
    }

    private function validateQuestionData(Request $request, $ignoreSoalId = null): array
    {
        /** @var Quiz|null $quiz */
        $quiz = $request->filled('id_quiz') ? Quiz::find($request->id_quiz) : null;
        $isDungeon = ($quiz instanceof Quiz) && $quiz->isDungeon();

        $rules = [
            'id_quiz' => 'nullable|integer|exists:quiz,id_quiz',
            'id_mapel' => 'nullable|integer|exists:mapel,id_mapel',
            'id_jenjang' => 'nullable|integer|exists:jenjang,id_jenjang',
            'id_jenis_soal' => 'required|integer|exists:jenis_soal,id_jenis_soal',
            'pertanyaan' => 'required|string|max:10000',
            'jawaban_benar' => 'nullable|string|max:2000',
            'poin' => 'nullable|integer|min:0',
            'durasi_detik' => 'nullable|integer|min:1',
            'correct_choice' => 'nullable|in:A,B,C,D',
            'pilihan' => 'nullable|array',
            'pilihan.*.label' => 'required|in:A,B,C,D',
            'pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
            'pilihan.*.tetap_di_bawah' => 'nullable|boolean',
        ];

        if ($isDungeon) {
            $rules['tingkat_soal'] = 'required|in:mudah,sedang,sulit';
        } else {
            $rules['tingkat_soal'] = 'nullable|in:mudah,sedang,sulit';
        }

        $validated = $request->validate($rules, [
            'tingkat_soal.required' => 'Tingkat soal (Mudah, Sedang, Sulit) wajib dipilih untuk kuis Dungeon.',
            'tingkat_soal.in' => 'Tingkat soal harus berupa: mudah, sedang, atau sulit.',
        ]);

        $idQuiz = !empty($validated['id_quiz']) ? (int) $validated['id_quiz'] : null;
        $idMapel = !empty($validated['id_mapel']) ? (int) $validated['id_mapel'] : ($quiz ? $quiz->id_mapel : null);

        if (!$idQuiz && !$idMapel) {
            throw ValidationException::withMessages([
                'id_mapel' => 'Mata pelajaran wajib dipilih untuk soal Bank Soal.',
            ]);
        }

        $type = (int) $validated['id_jenis_soal'];
        $tingkatSoal = $validated['tingkat_soal'] ?? 'sedang';

        // Validasi: Soal Benar/Salah hanya boleh di tingkat Mudah untuk kuis Dungeon
        if ($isDungeon && $type === 3 && $tingkatSoal !== 'mudah') {
            throw ValidationException::withMessages([
                'id_jenis_soal' => 'Soal Benar/Salah hanya boleh dibuat pada tingkat Mudah di kuis Dungeon.',
            ]);
        }

        $pertanyaanLower = mb_strtolower(trim($validated['pertanyaan']));
        if ($idQuiz) {
            $duplikatQuery = Soal::where('id_quiz', $idQuiz)
                ->where(function ($q) use ($pertanyaanLower) {
                    $q->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaanLower]);
                });
        } else {
            $duplikatQuery = Soal::whereNull('id_quiz')
                ->where('id_mapel', $idMapel)
                ->where(function ($q) use ($pertanyaanLower) {
                    $q->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaanLower]);
                });
        }

        if ($ignoreSoalId) {
            $duplikatQuery->where('id_soal', '!=', $ignoreSoalId);
        }

        if ($duplikatQuery->exists()) {
            throw ValidationException::withMessages([
                'pertanyaan' => $idQuiz
                    ? 'Pertanyaan dengan teks yang sama sudah ada di quiz ini.'
                    : 'Pertanyaan dengan teks yang sama sudah ada di Bank Soal untuk mata pelajaran ini.',
            ]);
        }

        // Peringatan (bukan penolakan) jika soal kuis Dungeon cocok dengan soal di kuis bertipe Ujian/Evaluasi/Ulangan
        if ($isDungeon && Schema::hasTable('quiz') && Schema::hasTable('tipequiz')) {
            $crossMatch = DB::table('soal')
                ->join('quiz', 'soal.id_quiz', '=', 'quiz.id_quiz')
                ->join('tipequiz', 'quiz.id_tipequiz', '=', 'tipequiz.id_tipequiz')
                ->whereRaw('LOWER(TRIM(soal.pertanyaan)) = ?', [$pertanyaanLower])
                ->where('quiz.id_quiz', '!=', $idQuiz)
                ->whereIn(DB::raw("LOWER(COALESCE(tipequiz.nama_tipe, ''))"), ['ulangan', 'ujian', 'evaluasi'])
                ->select('quiz.judul', 'tipequiz.nama_tipe')
                ->first();

            if ($crossMatch) {
                session()->flash('warning_dungeon', "Peringatan: Teks pertanyaan serupa dengan soal pada kuis bertipe {$crossMatch->nama_tipe} ('{$crossMatch->judul}').");
            }
        }

        $choices = [];

        if ($type === 2) {
            $answer = trim($validated['jawaban_benar'] ?? '');
            if ($answer === '') {
                throw ValidationException::withMessages([
                    'jawaban_benar' => 'Kunci jawaban wajib diisi untuk soal essay/isian.',
                ]);
            }
        } elseif ($type === 3) {
            $correctLabel = $validated['correct_choice'] ?? '';
            if (!in_array($correctLabel, ['A', 'B'], true)) {
                throw ValidationException::withMessages([
                    'correct_choice' => 'Pilih jawaban Benar atau Salah sebagai kunci.',
                ]);
            }

            $choices = [
                ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $correctLabel === 'A', 'tetap_di_bawah' => false],
                ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $correctLabel === 'B', 'tetap_di_bawah' => false],
            ];
            $answer = $correctLabel;
        } else {
            $correctLabel = $validated['correct_choice'] ?? '';
            $seenLabels = [];
            $seenTexts = [];
            $correctText = null;

            foreach ($validated['pilihan'] ?? [] as $choice) {
                $label = strtoupper(trim($choice['label']));
                $text = trim($choice['teks_pilihan'] ?? '');
                if ($text === '') {
                    continue;
                }

                if (in_array($label, $seenLabels, true)) {
                    throw ValidationException::withMessages([
                        'pilihan' => 'Label pilihan jawaban tidak boleh berulang.',
                    ]);
                }
                $seenLabels[] = $label;

                $textKey = mb_strtolower($text);
                if (in_array($textKey, $seenTexts, true)) {
                    throw ValidationException::withMessages([
                        'pilihan' => 'Teks pilihan jawaban tidak boleh sama dalam satu soal.',
                    ]);
                }
                $seenTexts[] = $textKey;

                $isCorrect = $label === $correctLabel;
                $choices[] = [
                    'label' => $label,
                    'teks_pilihan' => $text,
                    'is_correct' => $isCorrect,
                    'tetap_di_bawah' => !empty($choice['tetap_di_bawah']),
                ];
                if ($isCorrect) {
                    $correctText = $text;
                }
            }

            if (count($choices) < 2) {
                throw ValidationException::withMessages([
                    'pilihan' => 'Soal pilihan ganda wajib memiliki minimal dua pilihan terisi.',
                ]);
            }
            if ($correctText === null) {
                throw ValidationException::withMessages([
                    'correct_choice' => 'Pilih jawaban benar yang memiliki teks pilihan.',
                ]);
            }

            $answer = $correctLabel;
        }

        return [
            'soal' => [
                'id_quiz' => $idQuiz,
                'id_mapel' => $idMapel,
                'id_jenjang' => $validated['id_jenjang'] ?? ($quiz ? $quiz->id_jenjang : null),
                'id_jenis_soal' => $type,
                'tingkat_soal' => $tingkatSoal,
                'pertanyaan' => $validated['pertanyaan'],
                'jawaban_benar' => $answer,
                'poin' => $validated['poin'] ?? 10,
                'durasi_detik' => $validated['durasi_detik'] ?? 20,
            ],
            'pilihan' => $choices,
        ];
    }

    private function syncChoices(Soal $soal, array $choices): void
    {
        $soal->pilihanSoal()->delete();

        foreach ($choices as $choice) {
            if (!Schema::hasColumn('pilihan_soal', 'tetap_di_bawah')) {
                unset($choice['tetap_di_bawah']);
            }
            $soal->pilihanSoal()->create($choice);
        }
    }

    // Menghapus soal dari database.
    public function destroy($id)
    {
        $soal = Soal::where('id_soal', $id)->orWhere('kode_soal', $id)->firstOrFail();
        if (auth()->check()) {
            Gate::authorize('delete', $soal);
        }

        if ($soal->foto_soal && Storage::disk('public')->exists($soal->foto_soal)) {
            Storage::disk('public')->delete($soal->foto_soal);
        }

        $soal->delete();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil dihapus.');
    }

    // API JSON untuk modal picker Bank Soal pada pembuatan/edit quiz & mobile app
    public function apiBankSoal(Request $request)
    {
        if (auth()->check()) {
            Gate::authorize('viewAny', Soal::class);
        }

        $sumber = $request->query('sumber', 'all'); // 'bank', 'all', 'quiz'

        // Jika sumber 'bank' tapi bank soal masih kosong di sistem, otomatis fallback ke 'all'
        $bankCount = Soal::whereNull('id_quiz')->count();
        if ($sumber === 'bank' && $bankCount === 0) {
            $sumber = 'all';
        }

        $query = Soal::query()
            ->when(auth()->user() && auth()->user()->isGuru(), function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('id_quiz')
                        ->orWhere('id_penulis', auth()->id())
                        ->orWhereHas('quiz', fn($k) => $k->where('id_pembuat', auth()->id()));
                });
            })
            ->when($sumber === 'bank', fn($q) => $q->whereNull('id_quiz'))
            ->when($sumber === 'quiz', fn($q) => $q->whereNotNull('id_quiz'))
            ->with(['jenisSoal', 'jenjang', 'mapel', 'pilihanSoal', 'penulis', 'quiz'])
            ->when($request->filled('mapel_id') && $request->mapel_id !== 'all', fn($q) => $q->where('id_mapel', $request->mapel_id))
            ->when($request->filled('jenjang_id') && $request->jenjang_id !== 'all', function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('id_jenjang', $request->jenjang_id)
                        ->orWhereNull('id_jenjang');
                });
            })
            ->when($request->filled('tingkat_soal') && $request->tingkat_soal !== 'all', function ($q) use ($request) {
                $tingkat = strtolower(trim($request->tingkat_soal));
                if ($tingkat === 'sedang') {
                    $q->where(function ($sub) {
                        $sub->where('tingkat_soal', 'sedang')
                            ->orWhereNull('tingkat_soal')
                            ->orWhere('tingkat_soal', '');
                    });
                } else {
                    $q->where('tingkat_soal', $tingkat);
                }
            })
            ->when($request->filled('jenis_soal') && $request->jenis_soal !== 'all', function ($q) use ($request) {
                $val = $request->jenis_soal;
                if ($val === 'pilihan_ganda' || $val === '1' || $val === 'kuis') {
                    $q->where('id_jenis_soal', 1);
                } elseif ($val === 'isian' || $val === '2' || $val === 'isian_singkat') {
                    $q->where('id_jenis_soal', 2);
                } elseif ($val === 'benar_salah' || $val === '3' || $val === 'true_false') {
                    $q->where('id_jenis_soal', 3);
                } elseif ($val === 'bergambar') {
                    $q->whereNotNull('foto_soal')->where('foto_soal', '!=', '');
                }
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = mb_strtolower(trim($request->q));
                $q->where(function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(pertanyaan) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(kode_soal) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(jawaban_benar) LIKE ?', ["%{$search}%"]);
                });
            })
            ->latest('id_soal');

        $limit = (int) $request->input('per_page', $request->input('limit', 150));
        $soals = $query->take(min($limit, 300))->get()->map(function (Soal $s) {
            $rawJenis = strtolower(trim((string) ($s->jenisSoal?->nama_jenis ?? '')));
            $idJenis = (int) ($s->id_jenis_soal ?? 1);
            $jenisSlug = ($idJenis === 3 || str_contains($rawJenis, 'benar')) ? 'true_false' : (($idJenis === 2 || str_contains($rawJenis, 'isian')) ? 'isian_singkat' : 'kuis');

            $choices = collect(['A', 'B', 'C', 'D'])->map(function (string $label) use ($s, $jenisSlug) {
                $choice = $s->pilihanSoal->firstWhere('label', $label);
                return [
                    'label' => $label,
                    'teks' => $choice->teks_pilihan ?? ($jenisSlug === 'true_false' && $label === 'A' ? 'Benar' : ($jenisSlug === 'true_false' && $label === 'B' ? 'Salah' : '')),
                    'is_correct' => (int) ($choice->is_correct ?? false),
                ];
            })->all();

            $isBank = is_null($s->id_quiz);
            $quizTitle = $s->quiz?->judul ?? 'Bank Soal';

            return [
                'id_soal' => $s->id_soal,
                'kode_soal' => $s->kode_soal,
                'is_bank' => $isBank,
                'sumber_label' => $isBank ? '📚 Bank Soal' : '🎯 Kuis: ' . \Illuminate\Support\Str::limit($quizTitle, 20),
                'id_mapel' => $s->id_mapel,
                'mapel_nama' => $s->mapel?->nama_mapel ?? 'Semua Mapel',
                'id_jenjang' => $s->id_jenjang,
                'jenjang_nama' => $s->jenjang?->nama_tipe ?? $s->jenjang?->nama_jenjang ?? 'Umum',
                'id_jenis_soal' => $idJenis,
                'jenis_soal' => $jenisSlug,
                'tingkat_soal' => $s->tingkat_soal ?: 'sedang',
                'pertanyaan' => $s->pertanyaan,
                'jawaban_benar' => $s->jawaban_benar,
                'jawaban_singkat' => $jenisSlug === 'isian_singkat' ? $s->jawaban_benar : '',
                'poin' => (int) ($s->poin ?? 10),
                'durasi_detik' => (int) ($s->durasi_detik ?? 20),
                'timer' => (string) ($s->durasi_detik ?? 20),
                'foto_soal' => $s->foto_soal,
                'foto_url' => $s->foto_soal ? asset('storage/' . $s->foto_soal) : null,
                'penulis_nama' => $s->penulis?->nama ?? 'Admin',
                'pilihan' => $choices,
            ];
        });

        return response()->json([
            'success' => true,
            'total' => $soals->count(),
            'sumber_used' => $sumber,
            'data' => $soals,
        ]);
    }

    // Menyalin satu atau lebih soal kuis ke Bank Soal (standalone: id_quiz = null)
    public function copyToBank(Request $request)
    {
        $request->validate([
            'soal_ids' => 'required|array|min:1',
            'soal_ids.*' => 'integer|exists:soal,id_soal',
        ]);

        $soals = Soal::with('pilihanSoal')->whereIn('id_soal', $request->soal_ids)->get();
        $insertedCount = 0;
        $skippedCount = 0;

        DB::transaction(function () use ($soals, &$insertedCount, &$skippedCount) {
            foreach ($soals as $soal) {
                $idMapel = $soal->id_mapel ?? $soal->quiz?->id_mapel;
                if (!$idMapel) {
                    $skippedCount++;
                    continue;
                }

                $pertanyaanLower = mb_strtolower(trim((string) $soal->pertanyaan));

                // Cek duplikasi di Bank Soal untuk mapel yang sama
                $exists = Soal::whereNull('id_quiz')
                    ->where('id_mapel', $idMapel)
                    ->where(function ($q) use ($soal, $pertanyaanLower) {
                        $q->where('parent_soal_id', $soal->id_soal);
                        if ($pertanyaanLower !== '') {
                            $q->orWhereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaanLower]);
                        }
                    })
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                $newBankSoal = Soal::create([
                    'id_quiz' => null,
                    'id_mapel' => $idMapel,
                    'parent_soal_id' => $soal->id_soal,
                    'id_jenjang' => $soal->id_jenjang ?? $soal->quiz?->id_jenjang,
                    'id_jenis_soal' => $soal->id_jenis_soal,
                    'tingkat_soal' => $soal->tingkat_soal ?: 'sedang',
                    'id_penulis' => auth()->id() ?? $soal->id_penulis,
                    'aktif' => true,
                    'pertanyaan' => $soal->pertanyaan,
                    'jawaban_benar' => $soal->jawaban_benar,
                    'foto_soal' => $soal->foto_soal,
                    'poin' => $soal->poin ?? 10,
                    'durasi_detik' => $soal->durasi_detik ?? 20,
                ]);

                foreach ($soal->pilihanSoal as $pilihan) {
                    $pilihanData = [
                        'id_soal' => $newBankSoal->id_soal,
                        'label' => $pilihan->label,
                        'teks_pilihan' => $pilihan->teks_pilihan,
                        'is_correct' => $pilihan->is_correct,
                    ];
                    if (Schema::hasColumn('pilihan_soal', 'tetap_di_bawah')) {
                        $pilihanData['tetap_di_bawah'] = !empty($pilihan->tetap_di_bawah);
                    }
                    $newBankSoal->pilihanSoal()->create($pilihanData);
                }

                $insertedCount++;
            }
        });

        $message = "Berhasil menyalin {$insertedCount} soal ke Bank Soal.";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} soal dilewati karena sudah ada di Bank Soal).";
        }

        if ($request->wantsJson() || $request->ajax() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'inserted' => $insertedCount,
                'skipped' => $skippedCount,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    // Assign / menyalin satu atau lebih soal dari Bank Soal ke suatu Quiz/Dungeon
    public function assignToQuiz(Request $request)
    {
        $request->validate([
            'id_quiz' => 'required|integer|exists:quiz,id_quiz',
            'soal_ids' => 'required|array|min:1',
            'soal_ids.*' => 'integer|exists:soal,id_soal',
        ]);

        $quiz = Quiz::with('tipeQuiz')->findOrFail($request->id_quiz);
        if (auth()->check()) {
            if ($quiz->isDungeon()) {
                Gate::authorize('addSoal', $quiz);
            } else {
                Gate::authorize('update', $quiz);
            }
        }

        $bankSoals = Soal::with('pilihanSoal')
            ->whereIn('id_soal', $request->soal_ids)
            ->get();

        $insertedCount = 0;
        $skippedCount = 0;

        DB::transaction(function () use ($quiz, $bankSoals, &$insertedCount, &$skippedCount) {
            foreach ($bankSoals as $bankSoal) {
                $pertanyaanLower = mb_strtolower(trim((string) $bankSoal->pertanyaan));

                // Cek apakah soal ini sudah ada di kuis tujuan (baik lewat parent_soal_id atau teks pertanyaan sama)
                $exists = Soal::where('id_quiz', $quiz->id_quiz)
                    ->where(function ($q) use ($bankSoal, $pertanyaanLower) {
                        $q->where('parent_soal_id', $bankSoal->id_soal);
                        if ($pertanyaanLower !== '') {
                            $q->orWhereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaanLower]);
                        }
                    })
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                $newSoal = Soal::create([
                    'id_quiz' => $quiz->id_quiz,
                    'id_mapel' => $quiz->id_mapel,
                    'parent_soal_id' => $bankSoal->id_soal,
                    'id_jenjang' => $bankSoal->id_jenjang ?? $quiz->id_jenjang,
                    'id_jenis_soal' => $bankSoal->id_jenis_soal,
                    'tingkat_soal' => $bankSoal->tingkat_soal ?? ($quiz->isDungeon() ? 'sedang' : null),
                    'id_penulis' => auth()->id() ?? $bankSoal->id_penulis,
                    'aktif' => true,
                    'pertanyaan' => $bankSoal->pertanyaan,
                    'jawaban_benar' => $bankSoal->jawaban_benar,
                    'foto_soal' => $bankSoal->foto_soal,
                    'poin' => $bankSoal->poin ?? 10,
                    'durasi_detik' => $bankSoal->durasi_detik ?? 20,
                ]);

                foreach ($bankSoal->pilihanSoal as $pilihan) {
                    $pilihanData = [
                        'id_soal' => $newSoal->id_soal,
                        'label' => $pilihan->label,
                        'teks_pilihan' => $pilihan->teks_pilihan,
                        'is_correct' => $pilihan->is_correct,
                    ];
                    if (Schema::hasColumn('pilihan_soal', 'tetap_di_bawah')) {
                        $pilihanData['tetap_di_bawah'] = !empty($pilihan->tetap_di_bawah);
                    }
                    $newSoal->pilihanSoal()->create($pilihanData);
                }

                $insertedCount++;
            }
        });

        $message = "Berhasil memasukkan {$insertedCount} soal ke kuis '{$quiz->judul}'.";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} soal dilewati karena sudah ada di kuis ini).";
        }

        if ($request->wantsJson() || $request->ajax() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'inserted' => $insertedCount,
                'skipped' => $skippedCount,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
