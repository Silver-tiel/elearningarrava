<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Modul</title>
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
            background: #1565c0;
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
            background: #eaf4ff;
        }
    </style>
</head>
<body>
    <!-- Halaman daftar modul yang dipakai untuk menampilkan materi pembelajaran. -->
    <div class="container">
        <h1>Daftar Modul</h1>

        <!-- Tombol untuk menambah modul baru. -->
        <a href="{{ route('modul.create') }}" class="btn">Tambah Modul</a>

        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Jenis</th>
                    <th>Jenjang</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($moduls as $modul)
                    <tr>
                        <td>{{ $modul->judul_modul }}</td>
                        <td>{{ $modul->id_tipemodul }}</td>
                        <td>{{ $modul->id_jenjang }}</td>
                        <td>{{ $modul->progressModul ?? 'Belum mulai' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
