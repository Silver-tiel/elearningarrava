<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Edit Modul Pembelajaran">
    <title>Edit Modul Pembelajaran</title>
    <!-- Menggunakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">
    <!-- Header / Bagian Atas -->
    <header class="py-8 px-4 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Edit Modul</h1>
            <p class="mt-2 text-sm text-slate-600">
                Formulir ini digunakan oleh admin untuk mengedit modul pembelajaran.
            </p>
        </div>
    </header>
    <!-- Konten Utama Form -->
    <main class="flex-grow max-w-3xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden p-6 sm:p-8">
            <form action="{{ route('admin.modul.update', $module->id_modul) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- 1. Judul Modul -->
                <div>
                    <label for="judul_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Judul Modul Pembelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="judul_modul" name="judul_modul" value="{{ $module->judul_modul }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                </div>
                <!-- 2. Pilihan Jenis Modul -->
                <div>
                    <label for="id_tipemodul" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenis Modul <span class="text-red-500">*</span>
                    </label>
                    <select id="id_tipemodul" name="id_tipemodul" onchange="toggleInputType()" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($tipeModul as $tipe)
                            <option value="{{ $tipe->id_tipemodul }}" {{ $module->id_tipemodul == $tipe->id_tipemodul ? 'selected' : '' }}>{{ $tipe->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- 3. Pilihan Jenjang Pendidikan -->
                <div>
                    <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select id="id_jenjang" name="id_jenjang" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                        @foreach ($jenjang as $j)
                            <option value="{{ $j->id_jenjang }}" {{ $module->id_jenjang == $j->id_jenjang ? 'selected' : '' }}>{{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- 4. Upload File Materi -->
                <div id="container_file">
                    <label for="file_upload" class="block text-sm font-medium text-slate-700 mb-1">
                        Upload Berkas Materi Baru (Biarkan kosong jika tidak ingin mengubah)
                    </label>
                    <input type="file" id="file_upload" name="file_upload" accept=".pdf,.ppt,.pptx" class="w-full">
                    @if($module->file_materi && $module->tipe_file != 'link')
                        <p class="text-xs mt-1 text-slate-500">File saat ini: <a href="{{ Storage::url($module->file_materi) }}" target="_blank" class="text-blue-500 underline">Lihat File</a></p>
                    @endif
                </div>
                <!-- 5. Input Link Eksternal -->
                <div id="container_link" class="hidden">
                    <label for="file_link" class="block text-sm font-medium text-slate-700 mb-1">
                        Tautan Video / Materi Luar
                    </label>
                    <input type="url" id="file_link" name="file_link" value="{{ $module->tipe_file == 'link' ? $module->file_materi : '' }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                </div>
                <!-- 6. Upload Cover Modul / Thumbnail -->
                <div>
                    <label for="foto_modul" class="block text-sm font-medium text-slate-700 mb-1">
                        Gambar Sampul / Thumbnail Modul (Biarkan kosong jika tidak ingin mengubah)
                    </label>
                    <input type="file" id="foto_modul" name="foto_modul" accept="image/*" class="w-full">
                    @if($module->foto_modul)
                        <img src="{{ Storage::url($module->foto_modul) }}" class="mt-2 w-32 h-32 object-cover rounded-lg border">
                    @endif
                </div>
                <!-- Tombol Aksi / Simpan -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.modul') }}" 
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        function toggleInputType() {
            const tipe = document.getElementById('id_tipemodul').value;
            const containerLink = document.getElementById('container_link');
            if (tipe == 1) { 
                containerLink.classList.remove('hidden');
            } else {
                containerLink.classList.add('hidden');
            }
        }
        toggleInputType();
    </script>
</body>
</html>
