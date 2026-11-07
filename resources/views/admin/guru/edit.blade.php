@extends('layouts.app')

@section('content')

<div class="p-8">

    <!-- HEADER -->
    <div class="mb-6">

        <a href="{{ route('admin.guru') }}"
            class="text-sm text-indigo-600 hover:text-indigo-700 font-medium inline-flex items-center gap-1">
            <span>←</span> Kembali ke Data Guru
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-3">
            Edit Data & Akun Guru
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Perbarui data guru, foto profil, dan informasi akun login terkait.
        </p>

    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">

        <form action="{{ route('admin.guru.update', $guru->id_guru) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- FOTO PROFIL GURU -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Foto Guru <span class="text-xs font-normal text-slate-400">(Opsional, JPG/PNG/WEBP maks 2MB)</span>
                </label>

                <div class="flex items-center gap-5">
                    <!-- Preview Foto -->
                    <div class="relative w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shrink-0 shadow-inner group">
                        @if($guru->foto_url)
                            <img id="preview-foto" src="{{ $guru->foto_url }}" alt="{{ $guru->nama }}" class="w-full h-full object-cover">
                            <div id="placeholder-foto" class="hidden flex-col items-center justify-center text-slate-400 text-xs text-center p-2">
                                <svg class="w-8 h-8 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Ganti Foto</span>
                            </div>
                        @else
                            <img id="preview-foto" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                            <div id="placeholder-foto" class="flex flex-col items-center justify-center text-slate-400 text-xs text-center p-2">
                                <span class="text-2xl font-bold text-indigo-500 mb-0.5">
                                    {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
                                </span>
                                <span class="text-[10px]">Pilih Foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Input File -->
                    <div class="flex-1">
                        <input
                            type="file"
                            name="foto"
                            id="foto"
                            accept="image/png,image/jpeg,image/webp"
                            onchange="previewImage(this)"
                            class="block w-full text-sm text-slate-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-indigo-50 file:text-indigo-700
                                   hover:file:bg-indigo-100 cursor-pointer">
                        <p class="text-xs text-slate-400 mt-1.5">Pilih file gambar baru jika ingin mengganti foto profil guru.</p>

                        @error('foto')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- NAMA -->
            <div class="mb-5">

                <label for="nama"
                    class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Guru <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="nama"
                    id="nama"
                    value="{{ old('nama', $guru->nama) }}"
                    placeholder="Masukkan nama guru"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 text-sm
                           @error('nama') border-red-500 @enderror">

                @error('nama')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- NIK -->
            <div class="mb-5">

                <label for="nik"
                    class="block text-sm font-semibold text-slate-700 mb-2">
                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="nik"
                    id="nik"
                    value="{{ old('nik', $guru->nik) }}"
                    placeholder="Masukkan NIK 16 digit"
                    maxlength="16"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 text-sm
                           @error('nik') border-red-500 @enderror">

                @error('nik')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- NO TELEPON -->
            <div class="mb-5">

                <label for="no_telepon"
                    class="block text-sm font-semibold text-slate-700 mb-2">
                    No. Telepon / WhatsApp <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="no_telepon"
                    id="no_telepon"
                    value="{{ old('no_telepon', $guru->no_telepon) }}"
                    placeholder="Masukkan nomor telepon"
                    maxlength="13"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 text-sm
                           @error('no_telepon') border-red-500 @enderror">

                @error('no_telepon')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <hr class="my-6 border-gray-200">

            <div class="mb-4">
                <h2 class="text-base font-bold text-slate-800">Informasi Akun Login</h2>
                <p class="text-xs text-slate-500 mt-0.5">Email login dan password untuk akses guru ke platform Arrava.</p>
            </div>

            <!-- EMAIL -->
            <div class="mb-5">

                <label for="email"
                    class="block text-sm font-semibold text-slate-700 mb-2">
                    Email Akun Login <span class="text-red-500">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $guru->user?->email) }}"
                    placeholder="contoh: guru@arrava.id"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 text-sm
                           @error('email') border-red-500 @enderror">

                @error('email')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- PASSWORD (OPTIONAL ON UPDATE) -->
            <div class="mb-6">

                <label for="password"
                    class="block text-sm font-semibold text-slate-700 mb-2">
                    Password Baru <span class="text-xs font-normal text-slate-400">(Kosongkan jika tidak ingin mengubah password)</span>
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Minimal 6 karakter jika ingin diubah"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 text-sm
                           @error('password') border-red-500 @enderror">

                @error('password')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- BUTTON -->
            <div class="flex gap-3 pt-2">

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white font-medium
                           rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.guru') }}"
                    class="px-5 py-2.5 bg-gray-100 text-slate-700 font-medium
                           rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-foto');
        const placeholder = document.getElementById('placeholder-foto');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
