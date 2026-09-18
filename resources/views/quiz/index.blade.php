<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f9ff;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        h1 {
            color: #1565c0;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background: #2e7d32;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background: #e8f5e9;
        }
    </style>
</head>
<body>
    <!-- Halaman daftar kuis untuk menampilkan soal atau evaluasi pembelajaran. -->
    <div class="container">
        <h1>Daftar Quiz</h1>

        <!-- Tombol untuk menambah kuis baru. -->
        <a href="{{ route('quiz.create') }}" class="btn">Tambah Quiz</a>

        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Tingkat</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->judul }}</td>
                        <td>{{ $quiz->id_tipequiz }}</td>
                        <td>{{ $quiz->id_tingkatquiz }}</td>
                        <td>{{ $quiz->hasil_quiz ?? 'Belum ada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
