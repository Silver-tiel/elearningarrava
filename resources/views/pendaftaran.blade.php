<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pendaftaran</title>

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

        /* BAGIAN KIRI */

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

        /* BAGIAN FORM */

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
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: #37474f;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            outline: none;
            background: white;
            color: #37474f;
            transition: 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #42a5f5;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        input::placeholder {
            color: #b0bec5;
        }

        .error-message {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 6px;
            display: block;
            font-weight: 600;
        }

        .input-error {
            border-color: #d32f2f !important;
            background: #fff5f5;
        }

        .alert-error {
            background: #fff1f1;
            border: 1px solid #f5c2c7;
            color: #b42318;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-error ul {
            margin: 8px 0 0 18px;
        }

        /* BUTTON */

        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(21, 101, 192, 0.25);
        }

        /* LOGIN */

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #78909c;
        }

        .login-link a {
            color: #1565c0;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
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

<div class="container">

    <!-- BAGIAN INFORMASI -->
    <div class="info">

        <span class="badge">
            🏆 LEVEL 1
        </span>

        <h1>Mulai Perjalananmu!</h1>

        <p>
            Buat akun baru dan mulai perjalananmu.
            Lengkapi data pendaftaran untuk mendapatkan
            akses ke sistem.
        </p>

        <div class="reward">
            <h3>⭐ Dapatkan XP</h3>
            <p>
                Selesaikan pendaftaran dan dapatkan
                <strong>+100 XP</strong> sebagai langkah pertama.
            </p>
        </div>

        <div class="reward">
            <h3>🎯 Pilih Jenjangmu</h3>
            <p>
                Pilih jenjang pendidikan yang sesuai
                dengan kebutuhanmu.
            </p>
        </div>

        <div class="reward">
            <h3>🚀 Mulai Sekarang</h3>
            <p>
                Setelah mendaftar, kamu dapat langsung
                menggunakan akun untuk masuk ke sistem.
            </p>
        </div>

    </div>


    <!-- FORM PENDAFTARAN -->
    <div class="form-section">

        <h2>Buat Akun Baru 🚀</h2>

        <p class="subtitle">
            Lengkapi data berikut untuk mendaftar.
        </p>

        @if ($errors->any())
            <div class="alert-error">
                <div>Silakan perbaiki data berikut:</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaranBaru') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama kamu"
                    class="{{ $errors->has('nama') ? 'input-error' : '' }}"
                    required
                >
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="id_jenjang">Jenjang</label>

                <select
                    id="id_jenjang"
                    name="id_jenjang"
                    class="{{ $errors->has('id_jenjang') ? 'input-error' : '' }}"
                    required
                >
                    <option value="">Pilih Jenjang</option>

                    @foreach($jenjang as $tipe_jenjang)

                        <option
                            value="{{ $tipe_jenjang->id_jenjang }}"
                            {{ old('id_jenjang') == $tipe_jenjang->id_jenjang ? 'selected' : '' }}
                        >
                            {{ $tipe_jenjang->nama_tipe }}
                        </option>

                    @endforeach

                </select>
                @error('id_jenjang')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Buat password"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>


            <button type="submit" class="register-btn">
                🎮 Daftar & Mulai
            </button>

        </form>


        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">
                Login di sini
            </a>
        </div>

    </div>

</div>

</body>
</html>