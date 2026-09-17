<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran</title>
</head>
<body>
    <h1>Pendaftaran</h1>
    <p>Selamat datang di halaman pendaftaran!</p>
    <form action="{{ route('pendaftaranBaru') }}" method="POST">
        @csrf
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required><br><br>

        <label for="id_jenjang">Jenjang:</label>
        <select id="id_jenjang" name="id_jenjang" required>
            <option value="">Pilih Jenjang</option>
            @foreach($jenjang as $tipe_jenjang)
                <option value="{{ $tipe_jenjang->id_jenjang }}" {{ old('id_jenjang') == $tipe_jenjang->id_jenjang ? 'selected' : '' }}>
                    {{ $tipe_jenjang->nama_tipe }}
                </option>
            @endforeach
        </select><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>