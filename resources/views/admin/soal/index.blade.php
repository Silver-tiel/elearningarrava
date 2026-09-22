<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Soal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f9ff;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 1100px;
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
            background: #1565c0;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
        }
        .btn-edit {
            background: #ffa000;
            padding: 6px 12px;
            font-size: 14px;
        }
        .btn-delete {
            background: #d32f2f;
            padding: 6px 12px;
            font-size: 14px;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #eaf4ff;
        }
    </style>
</head>
<body>
    <!-- Halaman daftar soal untuk menampilkan pertanyaan yang dikelompokkan per jenjang. -->
    <div class="container">
        <h1>Daftar Soal</h1>

        <!-- Tombol untuk menambah soal baru. -->
        <a href="{{ route('soal.create') }}" class="btn">Tambah Soal</a>

        <table>
            <thead>
                <tr>
                    <th>ID Quiz</th>
                    <th>Jenjang</th>
                    <th>Jenis Soal</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban Benar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($soals as $soal)
                    <tr>
                        <td>{{ $soal->id_quiz }}</td>
                        <td>{{ $soal->id_jenjang }}</td>
                        <td>{{ $soal->id_jenis_soal }}</td>
                        <td>{{ $soal->pertanyaan }}</td>
                        <td>{{ $soal->jawaban_benar }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('soal.edit', $soal->id_soal) }}" class="btn btn-edit">Edit</a>
                                <form action="{{ route('soal.destroy', $soal->id_soal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
