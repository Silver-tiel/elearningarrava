<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- CSS KUSTOM UNTUK HALAMAN ADMIN -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e3f2fd, #f5f9ff);
            padding: 40px 20px;
            color: #263238;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
        }

        .topbar {
            background: linear-gradient(160deg, #1565c0, #42a5f5);
            color: white;
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(21, 101, 192, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .topbar p {
            font-size: 14px;
            opacity: 0.9;
        }

        .badge {
            background: #ffd54f;
            color: #37474f;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px 22px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .card h3 {
            font-size: 14px;
            color: #78909c;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .number {
            font-size: 34px;
            font-weight: bold;
            color: #1565c0;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .table-header {
            background: linear-gradient(90deg, #1565c0, #42a5f5);
            color: white;
            padding: 20px 24px;
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #f5f9ff;
            color: #37474f;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            color: #455a64;
            font-size: 15px;
        }

        .status {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            background: #e8f5e9;
            color: #2e7d32;
        }

        @media (max-width: 768px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            th, td {
                padding: 12px 14px;
            }
        }
    </style>
</head>
<body>
    <!-- HALAMAN ADMIN: tampilan ringkasan pengguna dan daftar data -->
    <div class="page">
        <div class="topbar">
            <div>
                <h1>Admin Panel</h1>
                <p>Selamat datang, Admin! Kelola pengguna dan aktivitas sistem.</p>
            </div>
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <a href="{{ route('admin.modul') }}" style="display:inline-block; background:#e3f2fd; color:#1565c0; text-decoration:none; padding:10px 16px; border-radius:999px; font-weight:bold;">Modul</a>
                <a href="{{ route('admin.quiz') }}" style="display:inline-block; background:#e8f5e9; color:#2e7d32; text-decoration:none; padding:10px 16px; border-radius:999px; font-weight:bold;">Quiz</a>
                <span class="badge">ONLINE</span>
            </div>
        </div>

        <!-- KARTU STATISTIK RINGKAS UNTUK ADMIN -->
        <div class="stats">
            <div class="card">
                <h3>Total Pengguna</h3>
                <div class="number">{{ $users->count() }}</div>
            </div>

            <div class="card">
                <h3>Aktif Hari Ini</h3>
                <div class="number">24</div>
            </div>

            <div class="card">
                <h3>Progress</h3>
                <div class="number">87%</div>
            </div>
        </div>

        <!-- TABEL DAFTAR PENGGUNA YANG DIAMBIL DARI DATABASE -->
        <div class="table-card">
            <div class="table-header">Daftar Pengguna</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="status">Aktif</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>