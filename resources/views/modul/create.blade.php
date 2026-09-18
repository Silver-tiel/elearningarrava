<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Modul</title>
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
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
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
        input, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d0d7de;
            border-radius: 10px;
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
    <!-- Form ini digunakan untuk menambahkan modul baru ke sistem pembelajaran. -->
    <div class="container">
        <h1>Tambah Modul</h1>

        <form action="{{ route('modul.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="judul_modul">Judul Modul</label>
                <input type="text" id="judul_modul" name="judul_modul" required>
            </div>

            <div class="form-group">
                <label for="id_tipemodul">Jenis Modul</label>
                <select id="id_tipemodul" name="id_tipemodul" required>
                    <option value="1">Video</option>
                    <option value="2">PDF</option>
                    <option value="3">Artikel</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_jenjang">Jenjang</label>
                <select id="id_jenjang" name="id_jenjang" required>
                    <option value="1">SD</option>
                    <option value="2">SMP</option>
                    <option value="3">SMA</option>
                </select>
            </div>

            <div class="form-group">
                <label for="file_materi">File Materi</label>
                <input type="text" id="file_materi" name="file_materi">
            </div>

            <div class="form-group">
                <label for="tipe_file">Tipe File</label>
                <input type="text" id="tipe_file" name="tipe_file">
            </div>

            <button type="submit">Simpan Modul</button>
        </form>
    </div>
</body>
</html>
