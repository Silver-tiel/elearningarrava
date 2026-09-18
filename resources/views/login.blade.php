<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- CSS KUSTOM UNTUK HALAMAN LOGIN -->
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .container {
            width: 900px;
            max-width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 40% 60%;
        }

        /* =========================
           BAGIAN KIRI
        ========================= */

        .info {
            background: linear-gradient(160deg, #1565c0, #42a5f5);
            color: white;
            padding: 45px 35px;
        }

        .badge {
            display: inline-block;
            background: #ffd54f;
            color: #37474f;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .info h1 {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .info > p {
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 15px;
        }

        /* GAMIFICATION CARD */

        .reward {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 18px;
            margin-top: 15px;
        }

        .reward h3 {
            font-size: 16px;
            margin-bottom: 7px;
        }

        .reward p {
            font-size: 13px;
            line-height: 1.5;
        }

        /* =========================
           BAGIAN LOGIN
        ========================= */

        .form-section {
            padding: 45px;
        }

        .form-section h2 {
            color: #263238;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #78909c;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #37474f;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            outline: none;
            background: white;
            color: #37474f;
            transition: 0.2s;
        }

        input:focus {
            border-color: #42a5f5;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        input::placeholder {
            color: #b0bec5;
        }

        /* BUTTON */

        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #1565c0, #42a5f5);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
            transition: 0.2s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(21, 101, 192, 0.25);
        }

        /* PENDAFTARAN */

        .register-link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #78909c;
        }

        .register-link a {
            color: #1565c0;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            .container {
                grid-template-columns: 1fr;
            }

            .info {
                padding: 30px;
            }

            .form-section {
                padding: 30px;
            }

            .info h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

<!-- WRAPPER UTAMA HALAMAN LOGIN -->
<div class="container">

    <!-- BAGIAN INFORMASI DI SEBELAH KIRI -->
    <div class="info">

        <span class="badge">
            🏆 WELCOME BACK
        </span>

        <h1>Selamat Datang Kembali!</h1>

        <p>
            Masuk ke akunmu dan lanjutkan perjalananmu.
            Berbagai aktivitas dan pencapaian menunggumu.
        </p>

        <div class="reward">
            <h3>⭐ Lanjutkan Perjalanan</h3>
            <p>
                Masuk kembali untuk melanjutkan aktivitas
                dan mengembangkan progres akunmu.
            </p>
        </div>

        <div class="reward">
            <h3>🎯 Raih Pencapaian</h3>
            <p>
                Selesaikan berbagai aktivitas untuk mendapatkan
                pengalaman dan pencapaian baru.
            </p>
        </div>

        <div class="reward">
            <h3>🚀 Siap Melanjutkan?</h3>
            <p>
                Login sekarang dan kembali ke dalam sistem.
            </p>
        </div>

    </div>


    <!-- FORM LOGIN: tempat email dan password user masuk ke sistem -->
    <div class="form-section">

        <h2>Login ke Akun 🔐</h2>

        <p class="subtitle">
            Masukkan email dan password untuk melanjutkan.
        </p>

        <form action="{{ route('login') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="contoh@email.com"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button type="submit" class="login-btn">
                🚀 Login
            </button>

        </form>


        <div class="register-link">
            Belum punya akun?
            <a href="{{ route('pendaftaran') }}">
                Daftar di sini
            </a>
        </div>

    </div>

</div>

</body>
</html>