@extends('layouts.app')

@section('content')
<div class="p-8 max-w-4xl mx-auto space-y-6">

    <!-- HEADER & BREADCRUMB -->
    <div>
        <a href="{{ route('admin.achievement') }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Penghargaan
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-2">
            Buat Achievement Baru
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Tambahkan lencana penghargaan yang otomatis diberikan kepada siswa ketika mencapai target poin tertentu.
        </p>
    </div>

    <!-- ERROR ALERT GLOBAL -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <p class="font-semibold">Mohon periksa kesalahan input berikut:</p>
            <ul class="mt-1.5 list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.achievement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- NAMA ACHIEVEMENT -->
            <div>
                <label for="nama_achivement" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Achievement / Penghargaan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="nama_achivement"
                       id="nama_achivement"
                       value="{{ old('nama_achivement') }}"
                       required
                       maxlength="255"
                       placeholder="Contoh: Bintang Penjelajah Sains, Master Kuis Matematika"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('nama_achivement') border-red-400 bg-red-50/50 @enderror">
                <p class="mt-1 text-xs text-slate-400">Nama lencana yang akan tampil di profil dan sertifikasi siswa.</p>
                @error('nama_achivement')
                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- MINIMAL POIN ACHIEVEMENT -->
            <div>
                <label for="minimal_poin_achivement" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Minimal Poin yang Diperlukan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number"
                           name="minimal_poin_achivement"
                           id="minimal_poin_achivement"
                           value="{{ old('minimal_poin_achivement', 100) }}"
                           required
                           min="0"
                           step="1"
                           placeholder="100"
                           class="w-full pl-4 pr-16 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('minimal_poin_achivement') border-red-400 bg-red-50/50 @enderror">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-sm font-medium">
                        Poin
                    </div>
                </div>
                <p class="mt-1 text-xs text-slate-400">
                    Siswa dengan total poin kuis yang mencapai angka ini akan otomatis menerima penghargaan ini.
                </p>
                @error('minimal_poin_achivement')
                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- GAMBAR ACHIEVEMENT (UPLOAD) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Gambar / Lencana Achievement <span class="text-red-500">*</span>
                </label>

                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/70">
                    <!-- PREVIEW BOX -->
                    <div class="w-24 h-24 rounded-2xl border border-slate-200 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-sm relative group">
                        <img id="preview-image"
                             src=""
                             alt="Preview"
                             class="w-full h-full object-cover hidden">
                        <div id="preview-placeholder" class="text-center p-2 text-slate-400">
                            <svg class="w-8 h-8 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-[10px] block mt-1">Preview</span>
                        </div>
                    </div>

                    <!-- UPLOAD INPUT -->
                    <div class="flex-1 w-full">
                        <input type="file"
                               name="gambar_achivement"
                               id="gambar_achivement"
                               required
                               accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer transition">
                        <p class="mt-2 text-xs text-slate-400">
                            Format yang didukung: <strong>PNG, JPG, JPEG, WebP, SVG</strong>. Ukuran maksimal <strong>2 MB</strong>. Disarankan gambar rasio persegi (1:1) dengan resolusi minimal 200x200 px.
                        </p>
                        @error('gambar_achivement')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Deskripsi Penghargaan (Opsional)
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="3"
                          maxlength="1000"
                          placeholder="Jelaskan arti penghargaan ini, tantangan yang diselesaikan, atau pesan motivasi untuk siswa..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition @error('deskripsi') border-red-400 bg-red-50/50 @enderror">{{ old('deskripsi') }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Maksimal 1.000 karakter.</p>
                @error('deskripsi')
                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- STATUS AKTIF -->
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox"
                       name="is_active"
                       id="is_active"
                       value="1"
                       @checked(old('is_active', '1') == '1')
                       class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Aktifkan penghargaan ini segera untuk siswa
                </label>
            </div>

            <!-- SUBMIT BUTTONS -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.achievement') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-sm font-semibold text-white shadow-sm transition">
                    Simpan Achievement
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const inputGambar = document.getElementById('gambar_achivement');
    const previewImg = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');

    if (inputGambar) {
        inputGambar.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    previewPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
                previewImg.classList.add('hidden');
                previewPlaceholder.classList.remove('hidden');
            }
        });
    }
</script>
@endpush
@endsection
