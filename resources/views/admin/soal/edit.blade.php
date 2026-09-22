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

        <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST">
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
                    <option value="1" {{ $soal->id_jenjang == 1 ? 'selected' : '' }}>SD</option>
                    <option value="2" {{ $soal->id_jenjang == 2 ? 'selected' : '' }}>SMP</option>
                    <option value="3" {{ $soal->id_jenjang == 3 ? 'selected' : '' }}>SMA</option>
                    <option value="4" {{ $soal->id_jenjang == 4 ? 'selected' : '' }}>Guru</option>
                    <option value="5" {{ $soal->id_jenjang == 5 ? 'selected' : '' }}>Admin</option>
                </select>
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
                <label for="jawaban_benar">Jawaban Benar</label>
                <textarea id="jawaban_benar" name="jawaban_benar">{{ $soal->jawaban_benar }}</textarea>
            </div>

            <button type="submit">Update Soal</button>
            <a href="{{ route('admin.soal') }}" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>

</html>
