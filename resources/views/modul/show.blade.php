<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Modul - {{ $modul->judul_modul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $modul->judul_modul }}</h1>
        <p class="text-sm text-slate-500 mb-6">Tipe: {{ $modul->tipeModul->nama_tipe ?? '-' }} | Jenjang: {{ $modul->jenjang->nama_tipe ?? '-' }}</p>
        
        <div class="mt-4">
            @if($modul->tipe_file === 'link')
                <a href="{{ $modul->file_materi }}" target="_blank" class="text-blue-600 underline text-lg">Buka Tautan Materi</a>
            @elseif($modul->file_materi)
                @if(in_array(pathinfo($modul->file_materi, PATHINFO_EXTENSION), ['pdf']))
                    <iframe src="{{ Storage::url($modul->file_materi) }}" class="w-full h-[600px] border rounded" frameborder="0"></iframe>
                @else
                    <a href="{{ Storage::url($modul->file_materi) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded font-medium inline-block">Unduh Materi</a>
                @endif
            @else
                <p class="text-red-500">Materi belum tersedia.</p>
            @endif
        </div>
        
        <div class="mt-8 pt-4 border-t border-slate-200">
            <button onclick="window.history.back()" class="px-5 py-2 bg-slate-200 rounded-lg hover:bg-slate-300 font-medium">Kembali</button>
        </div>
    </div>
</body>
</html>
