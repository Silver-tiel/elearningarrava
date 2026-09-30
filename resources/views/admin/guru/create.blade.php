@extends('layouts.app')

@section('content')

<div class="p-8">

    <!-- HEADER -->
    <div class="mb-6">

        <a href="{{ route('admin.guru') }}"
            class="text-sm text-indigo-600 hover:text-indigo-700">
            ← Kembali ke Data Guru
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-3">
            Tambah Guru
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Tambahkan data guru baru ke dalam sistem.
        </p>

    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <form action="{{ route('admin.guru.store') }}" method="POST">

            @csrf

            <!-- NAMA -->
            <div class="mb-5">

                <label for="nama"
                    class="block text-sm font-medium text-slate-700 mb-2">
                    Nama Guru
                </label>

                <input
                    type="text"
                    name="nama"
                    id="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama guru"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500
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
                    class="block text-sm font-medium text-slate-700 mb-2">
                    NIK
                </label>

                <input
                    type="text"
                    name="nik"
                    id="nik"
                    value="{{ old('nik') }}"
                    placeholder="Masukkan NIK 16 digit"
                    maxlength="16"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500
                           @error('nik') border-red-500 @enderror">

                @error('nik')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- NO TELEPON -->
            <div class="mb-6">

                <label for="no_telepon"
                    class="block text-sm font-medium text-slate-700 mb-2">
                    No. Telepon
                </label>

                <input
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    type="text"
                    name="no_telepon"
                    id="no_telepon"
                    value="{{ old('no_telepon') }}"
                    placeholder="Masukkan nomor telepon"
                    maxlength="13"
                    class="w-full px-4 py-2.5 border border-gray-300
                           rounded-lg focus:outline-none
                           focus:ring-2 focus:ring-indigo-500
                           @error('no_telepon') border-red-500 @enderror">

                @error('no_telepon')
                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- BUTTON -->
            <div class="flex gap-3">

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white
                           rounded-lg hover:bg-indigo-700 transition">
                    Simpan Guru
                </button>

                <a
                    href="{{ route('admin.guru') }}"
                    class="px-5 py-2.5 bg-gray-100 text-slate-700
                           rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection