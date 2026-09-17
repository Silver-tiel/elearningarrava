<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @auth
        @if(Auth::user()->id_tipeuser == 1) <!-- admin-->
            <h1>Selamat datang, Admin!</h1>
            <p>Anda memiliki akses penuh ke sistem.</p>
            <p>Menuju halaman admin <a href="{{ route('admin') }}">di sini</a></p>
        @endif
    @endauth

</body>
</html>