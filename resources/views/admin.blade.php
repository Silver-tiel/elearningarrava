<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <p>Selamat datang, Admin!</p>

    <h2>Daftar Pengguna</h2>

    @foreach($users as $user)
        <p>{{ $user->nama }} - {{ $user->email }}</p>
    @endforeach
</body>
</html>