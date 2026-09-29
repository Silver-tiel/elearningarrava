@extends('layouts.app')

@section('content')

<div class="p-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Guru
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Kelola data guru yang terdaftar di Bimbel Arrava.
            </p>
        </div>

        <a href="{{ route('admin.guru.create') }}"
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg
                  hover:bg-indigo-700 transition">
            + Tambah Guru
        </a>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg bg-green-100
                    text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
    @endif

    <!-- CARD TABEL -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-slate-800">
                Daftar Guru
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">
                    <tr class="text-left text-slate-600">

                        <th class="px-6 py-4 font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Nama Guru
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            NIK
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            No. Telepon
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($gurus as $guru)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 text-slate-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $guru->nama }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $guru->nik }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $guru->no_telepon }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex gap-2">

                                <!-- EDIT -->
                                <a
                                    href="{{ route('admin.guru.edit', $guru->id_guru) }}"
                                    class="px-3 py-1.5 text-sm rounded-lg
                                               bg-yellow-100 text-yellow-700
                                               hover:bg-yellow-200 transition">
                                    Edit
                                </a>

                                <!-- HAPUS -->
                                <form
                                    action="{{ route('admin.guru.destroy', $guru->id_guru) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-1.5 text-sm rounded-lg
                                                   bg-red-100 text-red-700
                                                   hover:bg-red-200 transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-10 text-center text-slate-500">

                            Belum ada data guru.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection