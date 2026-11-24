@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Tingkat Kelas</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-5xl">
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Kelola Tingkat Kelas per Jenjang</h2>
        <p class="text-sm text-slate-500 mt-1">Atur tingkatan kelas untuk setiap jenjang (SD, SMP, SMA). Tingkatan ini digunakan untuk profil siswa dan filter konten pembelajaran (kuis dan modul).</p>
    </div>

    <!-- Form Tambah Tingkat Kelas -->
    <form method="POST" action="{{ route('admin.tingkat-kelas.store') }}" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 mb-8 grid gap-4 sm:grid-cols-4 items-end shadow-sm">
        @csrf
        <div>
            <label for="id_jenjang" class="block text-sm font-medium text-slate-700 mb-1">Jenjang</label>
            <select id="id_jenjang" name="id_jenjang" required class="w-full h-11 rounded-xl border border-slate-300 px-3 text-sm bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
                <option value="">— Pilih Jenjang —</option>
                @foreach($jenjangList as $j)
                    <option value="{{ $j->id_jenjang }}" @selected(old('id_jenjang') == $j->id_jenjang)>{{ $j->nama_tipe }}</option>
                @endforeach
            </select>
            @error('id_jenjang')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama Tingkat Kelas</label>
            <input id="nama" name="nama" value="{{ old('nama') }}" required maxlength="50" placeholder="Contoh: Kelas 1, Kelas 7, Kelas 10"
                   class="w-full h-11 rounded-xl border border-slate-300 px-4 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
            @error('nama')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1">Urutan (Opsional)</label>
            <input id="urutan" name="urutan" type="number" min="1" value="{{ old('urutan') }}" placeholder="Auto"
                   class="w-full h-11 rounded-xl border border-slate-300 px-4 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
        </div>

        <div class="sm:col-span-4 flex justify-end">
            <button type="submit" class="h-11 px-6 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tingkat Kelas
            </button>
        </div>
    </form>

    <!-- Daftar per Jenjang -->
    @foreach($jenjangList as $jenjang)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6 shadow-sm">
            <div class="px-6 py-4 bg-slate-50 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-700 font-bold text-sm">
                        {{ $jenjang->nama_tipe }}
                    </span>
                    <h3 class="font-bold text-slate-800 text-base">Jenjang {{ $jenjang->nama_tipe }}</h3>
                </div>
                <span class="text-xs font-medium text-slate-500">
                    {{ $jenjang->tingkatKelas->count() }} Tingkat Kelas
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50/60 text-slate-500 text-left border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 w-20">Urutan</th>
                            <th class="px-6 py-3">Nama Kelas</th>
                            <th class="px-6 py-3 w-32">Status</th>
                            <th class="px-6 py-3 text-right w-44">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jenjang->tingkatKelas as $tk)
                            <tr class="hover:bg-slate-50/80 transition" id="row-tk-{{ $tk->id_tingkat }}">
                                <td class="px-6 py-3 font-semibold text-slate-500">{{ $tk->urutan }}</td>
                                <td class="px-6 py-3 font-bold text-slate-800">{{ $tk->nama }}</td>
                                <td class="px-6 py-3">
                                    @if($tk->aktif)
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Aktif</span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Tombol Edit Modal/Inline -->
                                        <button type="button"
                                                onclick="openEditModal({{ $tk->id_tingkat }}, '{{ addslashes($tk->nama) }}', {{ $tk->urutan }}, {{ $tk->id_jenjang }}, {{ $tk->aktif ? 'true' : 'false' }})"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-600 hover:bg-blue-50 border border-blue-200 transition">
                                            Edit
                                        </button>

                                        <!-- Form Hapus -->
                                        <form method="POST" action="{{ route('admin.tingkat-kelas.destroy', $tk->id_tingkat) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus tingkat kelas {{ $tk->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-slate-400 text-sm">
                                    Belum ada tingkat kelas untuk jenjang {{ $jenjang->nama_tipe }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Edit Tingkat Kelas -->
<div id="editModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
            <h3 class="font-bold text-slate-800 text-lg">Edit Tingkat Kelas</h3>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id_jenjang" name="id_jenjang" value="">

            <div>
                <label for="edit_nama" class="block text-sm font-medium text-slate-700 mb-1">Nama Tingkat Kelas</label>
                <input id="edit_nama" name="nama" required maxlength="50"
                       class="w-full h-11 rounded-xl border border-slate-300 px-4 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
            </div>

            <div>
                <label for="edit_urutan" class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                <input id="edit_urutan" name="urutan" type="number" min="1" required
                       class="w-full h-11 rounded-xl border border-slate-300 px-4 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="edit_aktif" name="aktif" value="1" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                <label for="edit_aktif" class="text-sm font-medium text-slate-700">Tingkat kelas aktif</label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, nama, urutan, idJenjang, aktif) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    form.action = `/admin/tingkat-kelas/${id}`;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_urutan').value = urutan;
    document.getElementById('edit_id_jenjang').value = idJenjang;
    document.getElementById('edit_aktif').checked = aktif;
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
