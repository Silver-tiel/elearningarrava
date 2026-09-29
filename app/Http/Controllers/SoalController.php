<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        return view('admin.soal.create', compact('jenjangList'));
    }

    // Menyimpan soal baru ke database.
    public function store(Request $request)
    {
        $questionData = $this->validateQuestionData($request);

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
            $soal = Soal::create($questionData['soal'] + ['foto_soal' => $pathFoto]);
            $this->syncChoices($soal, $questionData['pilihan']);
        });

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit soal.
    public function edit($id)
    {
        $soal = Soal::with('pilihanSoal')->findOrFail($id);
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        return view('admin.soal.edit', compact('soal', 'jenjangList'));
    }

    // Memperbarui soal di database.
    public function update(Request $request, $id)
    {
        $soal = Soal::findOrFail($id);
        $questionData = $this->validateQuestionData($request);

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

            $pathFoto = $foto->store('soal/foto', 'public');

            if (!$pathFoto) {
                return back()->withInput()->withErrors([
                    'foto_soal' => 'Gagal mengunggah foto soal. Silakan coba lagi.',
                ]);
            }
            $fotoBaruDiunggah = true;
        }

        DB::transaction(function () use ($soal, $questionData, $pathFoto) {
            $soal->update($questionData['soal'] + ['foto_soal' => $pathFoto]);
            $this->syncChoices($soal, $questionData['pilihan']);
        });

        if ($fotoBaruDiunggah && $fotoLama && $fotoLama !== $pathFoto
            && Storage::disk('public')->exists($fotoLama)) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil diperbarui.');
    }

    private function validateQuestionData(Request $request): array
    {
        $validated = $request->validate([
            'id_quiz' => 'required|integer|exists:quiz,id_quiz',
            'id_jenjang' => 'nullable|integer|exists:jenjang,id_jenjang',
            'id_jenis_soal' => 'required|integer|exists:jenis_soal,id_jenis_soal',
            'pertanyaan' => 'required|string|max:10000',
            'jawaban_benar' => 'nullable|string|max:2000',
            'correct_choice' => 'nullable|in:A,B,C,D',
            'pilihan' => 'nullable|array',
            'pilihan.*.label' => 'required|in:A,B,C,D',
            'pilihan.*.teks_pilihan' => 'nullable|string|max:1000',
        ]);

        $type = (int) $validated['id_jenis_soal'];
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
                ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $correctLabel === 'A'],
                ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $correctLabel === 'B'],
            ];
            $answer = $correctLabel;
        } else {
            $correctLabel = $validated['correct_choice'] ?? '';
            $seenLabels = [];
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
                $isCorrect = $label === $correctLabel;
                $choices[] = ['label' => $label, 'teks_pilihan' => $text, 'is_correct' => $isCorrect];
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
                'id_quiz' => $validated['id_quiz'],
                'id_jenjang' => $validated['id_jenjang'] ?? null,
                'id_jenis_soal' => $type,
                'pertanyaan' => $validated['pertanyaan'],
                'jawaban_benar' => $answer,
            ],
            'pilihan' => $choices,
        ];
    }

    private function syncChoices(Soal $soal, array $choices): void
    {
        $soal->pilihanSoal()->delete();

        foreach ($choices as $choice) {
            $soal->pilihanSoal()->create($choice);
        }
    }

    // Menghapus soal dari database.
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);

        if ($soal->foto_soal && Storage::disk('public')->exists($soal->foto_soal)) {
            Storage::disk('public')->delete($soal->foto_soal);
        }

        $soal->delete();

        return redirect()->route('admin.soal')->with('success', 'Soal berhasil dihapus.');
    }
}
