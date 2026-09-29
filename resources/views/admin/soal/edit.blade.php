<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Soal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f9ff;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #1565c0;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d0d7de;
            border-radius: 10px;
        }

        input[type="radio"] {
            width: auto;
            padding: 0;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            background: #1565c0;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
        }
        .btn-cancel {
            background: #e0e0e0;
            color: #333;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            margin-left: 10px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Soal</h1>
        @if($errors->any())
            <div style="color:#c62828; margin-bottom:16px;">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_quiz">ID Quiz</label>
                <input type="number" id="id_quiz" name="id_quiz" value="{{ $soal->id_quiz }}" required>
            </div>

            <div class="form-group">
                <label for="id_jenjang">Jenjang</label>
                <select id="id_jenjang" name="id_jenjang">
                    <option value="">-- Pilih --</option>
                    @foreach($jenjangList as $jenjang)
                        <option value="{{ $jenjang->id_jenjang }}" @selected(old('id_jenjang', $soal->id_jenjang) == $jenjang->id_jenjang)>{{ $jenjang->nama_tipe }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="manual-choice-group">
                <label>Pilihan Jawaban</label>
                @foreach(['A', 'B', 'C', 'D'] as $index => $label)
                    @php $choice = $soal->pilihanSoal->firstWhere('label', $label); @endphp
                    <div data-choice-row="{{ $index }}" style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                        <input type="hidden" name="pilihan[{{ $index }}][label]" value="{{ $label }}">
                        <input type="text" name="pilihan[{{ $index }}][teks_pilihan]" value="{{ old("pilihan.$index.teks_pilihan", $choice->teks_pilihan ?? '') }}" placeholder="Pilihan {{ $label }}">
                        <label style="white-space:nowrap; display:flex; align-items:center; gap:4px;">
                            <input type="radio" name="correct_choice" value="{{ $label }}" @checked(old('correct_choice', $soal->pilihanSoal->firstWhere('is_correct', true)->label ?? '') === $label)>
                            Kunci
                        </label>
                    </div>
                @endforeach
                @error('pilihan') <div style="color:#c62828; font-size:13px;">{{ $message }}</div> @enderror
                @error('correct_choice') <div style="color:#c62828; font-size:13px;">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="id_jenis_soal">Jenis Soal</label>
                <select id="id_jenis_soal" name="id_jenis_soal" required>
                    <option value="1" {{ $soal->id_jenis_soal == 1 ? 'selected' : '' }}>Pilihan Ganda</option>
                    <option value="2" {{ $soal->id_jenis_soal == 2 ? 'selected' : '' }}>Essay</option>
                    <option value="3" {{ $soal->id_jenis_soal == 3 ? 'selected' : '' }}>Benar/Salah</option>
                    <option value="4" {{ $soal->id_jenis_soal == 4 ? 'selected' : '' }}>Isian Singkat</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" required>{{ $soal->pertanyaan }}</textarea>
            </div>

            <div class="form-group">
                <label for="foto_soal">Foto Soal</label>
                <input type="file" id="foto_soal" name="foto_soal" accept="image/*">
                @if($soal->foto_soal)
                    <img src="{{ asset('storage/' . $soal->foto_soal) }}" alt="Foto soal" style="max-width: 180px; margin-top: 10px; border-radius: 10px;">
                @endif
                @error('foto_soal')
                    <div style="color: #c62828; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" id="manual-answer-group">
                <label for="jawaban_benar">Jawaban Benar</label>
                <textarea id="jawaban_benar" name="jawaban_benar">{{ old('jawaban_benar', $soal->jawaban_benar) }}</textarea>
            </div>

            <button type="submit">Update Soal</button>
            <a href="{{ route('admin.soal') }}" class="btn-cancel">Batal</a>
        </form>
    </div>
    <script>
        const manualType = document.getElementById('id_jenis_soal');
        const choiceGroup = document.getElementById('manual-choice-group');
        const answerGroup = document.getElementById('manual-answer-group');
        const answerInput = document.getElementById('jawaban_benar');

        function updateManualQuestionType() {
            const type = manualType.value;
            const hasChoices = type === '1' || type === '3';
            choiceGroup.hidden = !hasChoices;
            answerGroup.hidden = hasChoices;
            answerInput.disabled = hasChoices;
            answerInput.required = !hasChoices;

            document.querySelectorAll('[data-choice-row]').forEach((row) => {
                const index = Number(row.dataset.choiceRow);
                const visible = type === '1' || (type === '3' && index < 2);
                row.hidden = !visible;
                row.querySelectorAll('input').forEach((input) => {
                    input.disabled = !visible;
                    if (input.type === 'radio') input.required = type === '1' || type === '3';
                });

                const textInput = row.querySelector('input[type="text"]');
                if (type === '3' && index < 2) {
                    textInput.value = index === 0 ? 'Benar' : 'Salah';
                    textInput.readOnly = true;
                } else {
                    textInput.readOnly = false;
                }
            });
        }

        manualType.addEventListener('change', updateManualQuestionType);
        updateManualQuestionType();
    </script>
</body>

</html>
