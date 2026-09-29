<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal</title>
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
    </style>
</head>

<body>
    <!-- Form ini dipakai admin untuk menambahkan soal, dengan pilihan jenjang agar soal lebih terarah. -->
    <div class="container">
        <h1>Tambah Soal</h1>
        @if($errors->any())
            <div style="color:#c62828; margin-bottom:16px;">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="id_quiz">ID Quiz</label>
                <input type="number" id="id_quiz" name="id_quiz" value="{{ old('id_quiz') }}" required>
            </div>

            <div class="form-group">
                <label for="id_jenjang">Jenjang</label>
                <select id="id_jenjang" name="id_jenjang" required>
                    <option value="">-- Pilih jenjang --</option>
                    @foreach($jenjangList as $jenjang)
                        <option value="{{ $jenjang->id_jenjang }}" @selected(old('id_jenjang') == $jenjang->id_jenjang)>{{ $jenjang->nama_tipe }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_jenis_soal">Jenis Soal</label>
                <select id="id_jenis_soal" name="id_jenis_soal" required>
                    <option value="1">Pilihan Ganda</option>
                    <option value="2">Essay</option>
                    <option value="3">Benar/Salah</option>
                </select>
            </div>

            <div class="form-group" id="manual-choice-group">
                <label>Pilihan Jawaban</label>
                @foreach(['A', 'B', 'C', 'D'] as $index => $label)
                    <div data-choice-row="{{ $index }}" style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                        <input type="hidden" name="pilihan[{{ $index }}][label]" value="{{ $label }}">
                        <input type="text" name="pilihan[{{ $index }}][teks_pilihan]" value="{{ old("pilihan.$index.teks_pilihan") }}" placeholder="Pilihan {{ $label }}">
                        <label style="white-space:nowrap; display:flex; align-items:center; gap:4px;">
                            <input type="radio" name="correct_choice" value="{{ $label }}" @checked(old('correct_choice') === $label)>
                            Kunci
                        </label>
                    </div>
                @endforeach
                @error('pilihan') <div style="color:#c62828; font-size:13px;">{{ $message }}</div> @enderror
                @error('correct_choice') <div style="color:#c62828; font-size:13px;">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" required>{{ old('pertanyaan') }}</textarea>
            </div>

            <div class="form-group">
                <label for="foto_soal">Foto Soal</label>
                <input type="file" id="foto_soal" name="foto_soal" accept="image/*">
                @error('foto_soal')
                    <div style="color: #c62828; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" id="manual-answer-group">
                <label for="jawaban_benar">Jawaban Benar</label>
                <textarea id="jawaban_benar" name="jawaban_benar" required>{{ old('jawaban_benar') }}</textarea>
            </div>

            <button type="submit">Simpan Soal</button>
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