<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Quiz</title>
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
            color: #2e7d32;
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
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d0d7de;
            border-radius: 10px;
        }

        button {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Form ini dipakai oleh admin untuk menambahkan kuis baru ke sistem. -->
    <div class="container">
        <h1>Tambah Quiz</h1>

        <form action="{{ route('admin.quiz') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="judul">Judul Quiz</label>
                <input type="text" id="judul" name="judul" required>
            </div>

            <div class="form-group">
                <label for="id_tipequiz">Tipe Quiz</label>
                <select id="id_tipequiz" name="id_tipequiz" required>
                    <option value="1">Harian</option>
                    <option value="2">Ulangan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_tingkatquiz">Tingkat Kesulitan</label>
                <select id="id_tingkatquiz" name="id_tingkatquiz" required>
                    <option value="1">Mudah</option>
                    <option value="2">Sedang</option>
                    <option value="3">Sulit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="hasil_quiz">Hasil Quiz</label>
                <input type="text" id="hasil_quiz" name="hasil_quiz">
            </div>

            <button type="submit">Simpan Quiz</button>
        </form>
    </div>
</body>

</html>