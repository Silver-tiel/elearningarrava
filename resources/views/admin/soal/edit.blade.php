@extends('layouts.app')

@section('title', 'Edit Soal - Bank Soal Arrava')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.soal') }}"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-white hover:bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200 transition shadow-xs">
            <span>← Bank Soal</span>
        </a>
        <h1 class="text-lg font-extrabold text-slate-900">Edit Soal: {{ $soal->kode_soal ?? '#' . $soal->id_soal }}</h1>
    </div>
@endsection

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
    {{-- Heading --}}
    <div class="mb-7 flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-[#007FBE] border border-[#B2E7FC] text-xs font-extrabold mb-2">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>{{ $soal->id_quiz ? 'Soal Kuis' : 'Bank Soal Mandiri' }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Perbarui Pertanyaan
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Kode Soal: <span class="font-mono font-bold text-slate-700">{{ $soal->kode_soal ?? '-' }}</span>
            </p>
        </div>

        <form action="{{ route('soal.destroy', $soal->id_soal) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition cursor-pointer">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Hapus Soal</span>
            </button>
        </form>
    </div>

    {{-- Alert Error / Warning --}}
    @if(session('warning_dungeon'))
        <div class="mb-6 p-4 rounded-2xl bg-amber-50 border-2 border-amber-200 text-amber-900 flex items-start gap-3 shadow-xs">
            <span class="text-xl">⚠️</span>
            <div class="text-sm font-bold leading-relaxed">{{ session('warning_dungeon') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border-2 border-rose-200 text-rose-800 flex items-start gap-3 shadow-xs">
            <span class="text-xl">⚠️</span>
            <div class="text-sm">
                <p class="font-extrabold">Mohon periksa kembali form berikut:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5 font-semibold">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @php
        $currentJenisId = (int) old('id_jenis_soal', $soal->id_jenis_soal ?? 1);
        $isDungeonQuiz = $soal->quiz && $soal->quiz->isDungeon();
    @endphp

    <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- CARD 1: Kategori & Lokasi --}}
        <section class="bg-white rounded-3xl border-2 border-[#E6F1FC] p-6 sm:p-7 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                <span>🎯</span>
                <span>Tujuan & Kategori Soal</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-5">
                {{-- Kuis Terkait (bisa dipindah atau dilepas ke Bank Soal) --}}
                <div class="sm:col-span-2 md:col-span-1">
                    <label for="id_quiz" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Kuis Terkait
                    </label>
                    <select id="id_quiz" name="id_quiz"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="">-- [Bank Soal - Standalone] --</option>
                        @foreach($quizList as $q)
                            @php $isDng = $q->isDungeon(); @endphp
                            <option value="{{ $q->id_quiz }}"
                                data-is-dungeon="{{ $isDng ? '1' : '0' }}"
                                data-mapel="{{ $q->id_mapel }}"
                                data-jenjang="{{ $q->id_jenjang }}"
                                @selected(old('id_quiz', $soal->id_quiz) == $q->id_quiz)>
                                {{ $q->judul }} {{ $isDng ? '🛡️ [Dungeon]' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mata Pelajaran --}}
                <div>
                    <label for="id_mapel" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_mapel" name="id_mapel" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id_mapel }}" data-jenjang="{{ $mapel->id_jenjang ?? '' }}" data-name="{{ $mapel->nama_mapel }}" @selected(old('id_mapel', $soal->id_mapel ?? $soal->quiz?->id_mapel) == $mapel->id_mapel)>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenjang --}}
                <div>
                    <label for="id_jenjang" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Jenjang
                    </label>
                    <select id="id_jenjang" name="id_jenjang"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="">-- Semua Jenjang / Umum --</option>
                        @foreach($jenjangList as $jenjang)
                            <option value="{{ $jenjang->id_jenjang }}" @selected(old('id_jenjang', $soal->id_jenjang ?? $soal->quiz?->id_jenjang) == $jenjang->id_jenjang)>
                                {{ $jenjang->nama_tipe ?? $jenjang->nama_jenjang }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Tingkat Kesulitan --}}
                <div>
                    <label for="tingkat_soal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Tingkat Kesulitan
                    </label>
                    <select id="tingkat_soal" name="tingkat_soal"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="mudah" @selected(old('tingkat_soal', $soal->tingkat_soal ?? 'sedang') === 'mudah')>Mudah (10 Poin)</option>
                        <option value="sedang" @selected(old('tingkat_soal', $soal->tingkat_soal ?? 'sedang') === 'sedang')>Sedang (20 Poin)</option>
                        <option value="sulit" @selected(old('tingkat_soal', $soal->tingkat_soal ?? 'sedang') === 'sulit')>Sulit (30 Poin)</option>
                    </select>
                    <p id="bs-note" class="text-[11px] text-amber-600 font-bold mt-1.5 hidden">
                        * Soal Benar/Salah pada Dungeon hanya berlaku di tingkat Mudah.
                    </p>
                </div>

                {{-- Jenis Soal --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Jenis Soal <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_jenis_soal" name="id_jenis_soal" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="1" @selected($currentJenisId === 1)>Pilihan Ganda (A, B, C, D)</option>
                        <option value="3" @selected($currentJenisId === 3)>Benar / Salah</option>
                        <option value="2" @selected($currentJenisId === 2)>Isian Singkat (Essay)</option>
                    </select>
                </div>
            </div>

            {{-- Peruntukan Bank Soal --}}
            <div class="mt-4">
                <label for="kategori_bank" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Peruntukan Soal
                </label>
                <select id="kategori_bank" name="kategori_bank"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                    <option value="umum" @selected(old('kategori_bank', $soal->kategori_bank ?? 'umum') === 'umum')>Umum / Latihan &amp; Dungeon</option>
                    <option value="ujian" @selected(old('kategori_bank', $soal->kategori_bank ?? 'umum') === 'ujian')>Khusus Ujian (Terlindungi dari Dungeon)</option>
                </select>
                <p class="text-[11px] text-slate-500 mt-1">
                    Soal bertanda Khusus Ujian tidak akan muncul sebagai saran pada pembuatan kuis Dungeon.
                </p>
            </div>
        </section>

        {{-- CARD 2: Pertanyaan & Foto --}}
        <section class="bg-white rounded-3xl border-2 border-[#E6F1FC] p-6 sm:p-7 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#007FBE]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Teks Pertanyaan &amp; Gambar</span>
            </h3>

            {{-- Textarea Pertanyaan --}}
            <div class="mb-5">
                <label for="pertanyaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Teks Pertanyaan <span class="text-rose-500">*</span>
                </label>
                <textarea id="pertanyaan" name="pertanyaan" rows="4" required
                    placeholder="Tuliskan pertanyaan di sini..."
                    class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE] transition">{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                @error('pertanyaan') <p class="text-xs text-rose-600 font-bold mt-1.5">{{ $message }}</p> @enderror
            </div>

            {{-- Foto Soal --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Foto / Gambar Soal (Opsional)
                </label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl border-2 border-dashed border-[#B2E7FC] bg-[#F0F6FF] hover:bg-[#E6F1FC] text-[#007FBE] text-xs font-bold cursor-pointer transition">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Ganti Foto</span>
                        <input type="file" id="foto_soal" name="foto_soal" accept="image/*" class="hidden">
                    </label>
                    <span id="fotoFileName" class="text-xs text-slate-500 font-medium">
                        {{ $soal->foto_soal ? 'Sudah ada foto terpasang' : 'Belum ada file dipilih (Maks 2MB)' }}
                    </span>
                </div>

                {{-- Image Preview Box --}}
                <div id="imagePreviewContainer" class="mt-3 {{ $soal->foto_soal ? '' : 'hidden' }}">
                    <div class="relative inline-block">
                        <img id="imagePreview"
                            src="{{ $soal->foto_soal ? asset('storage/' . $soal->foto_soal) : '' }}"
                            alt="Pratinjau Foto"
                            class="max-h-48 rounded-2xl border-2 border-slate-200 object-contain bg-slate-50 shadow-xs">
                        <button type="button" id="removeFotoBtn"
                            class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 hover:bg-rose-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow transition cursor-pointer">
                            ✕
                        </button>
                    </div>
                </div>
                @error('foto_soal') <p class="text-xs text-rose-600 font-bold mt-1.5">{{ $message }}</p> @enderror
            </div>
        </section>

        {{-- CARD 3: Pilihan Jawaban & Kunci --}}
        <section id="choiceCardSection" class="bg-white rounded-3xl border-2 border-[#E6F1FC] p-6 sm:p-7 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-1 flex items-center gap-2">
                <span>🔑</span>
                <span>Pilihan & Kunci Jawaban</span>
            </h3>
            <p class="text-xs text-slate-500 mb-4" id="choiceCardSubtitle">
                Tentukan teks pilihan dan tandai satu opsi sebagai kunci jawaban yang benar.
            </p>

            @php
                $choicesFromDb = $soal->pilihanSoal->keyBy('label');
                $correctChoiceValue = old('correct_choice', $soal->jawaban_benar ?? 'A');
            @endphp

            {{-- Pilihan Ganda & Benar/Salah Container --}}
            <div id="choicesList" class="space-y-3">
                @foreach(['A', 'B', 'C', 'D'] as $index => $label)
                    @php
                        $dbChoice = $choicesFromDb->get($label);
                        $defaultText = $dbChoice?->teks_pilihan ?? '';
                        $isTetapBawah = $dbChoice?->tetap_di_bawah ?? false;
                    @endphp
                    <div data-choice-row="{{ $index }}"
                        class="choice-item flex flex-col sm:flex-row sm:items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 transition bg-white">
                        <input type="hidden" name="pilihan[{{ $index }}][label]" value="{{ $label }}">

                        <div class="flex items-center gap-2 flex-1">
                            <span class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center shrink-0 border border-slate-200 choice-label-badge">
                                {{ $label }}
                            </span>
                            <input type="text"
                                name="pilihan[{{ $index }}][teks_pilihan]"
                                value="{{ old("pilihan.$index.teks_pilihan", $defaultText) }}"
                                placeholder="Teks pilihan {{ $label }}..."
                                class="choice-text-input flex-1 px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            {{-- Radio Kunci --}}
                            <label class="correct-choice-label inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 text-xs font-bold cursor-pointer transition select-none">
                                <input type="radio" name="correct_choice" value="{{ $label }}"
                                    class="correct-choice-radio sr-only"
                                    @checked($correctChoiceValue === $label)>
                                <span class="correct-indicator text-sm">○</span>
                                <span>Kunci Benar</span>
                            </label>

                            {{-- Checkbox Tetap di bawah --}}
                            <label class="choice-fixed-label inline-flex items-center gap-1.5 text-xs text-slate-500 font-bold cursor-pointer select-none"
                                title="Pilihan ini tidak akan diacak posisinya (misal: 'Semua jawaban benar')">
                                <input type="checkbox" name="pilihan[{{ $index }}][tetap_di_bawah]" value="1"
                                    class="rounded text-[#007FBE] focus:ring-0"
                                    @checked(old("pilihan.$index.tetap_di_bawah", $isTetapBawah))>
                                <span class="hidden sm:inline">Tetap di bawah</span>
                                <span class="sm:hidden">Fixed</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Input Isian Singkat --}}
            <div id="essayInputContainer" class="hidden">
                <label for="jawaban_benar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Kunci Jawaban Singkat <span class="text-rose-500">*</span>
                </label>
                <textarea id="jawaban_benar" name="jawaban_benar" rows="3"
                    placeholder="Tuliskan kunci jawaban teks yang benar..."
                    class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">{{ old('jawaban_benar', $soal->jawaban_benar) }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Siswa akan dinilai benar jika jawaban mendekati atau persis dengan kunci ini.</p>
            </div>

            @error('pilihan') <p class="text-xs text-rose-600 font-bold mt-2">{{ $message }}</p> @enderror
            @error('correct_choice') <p class="text-xs text-rose-600 font-bold mt-2">{{ $message }}</p> @enderror
            @error('jawaban_benar') <p class="text-xs text-rose-600 font-bold mt-2">{{ $message }}</p> @enderror
        </section>

        {{-- CARD 4: Poin & Durasi --}}
        <section class="bg-white rounded-3xl border-2 border-[#E6F1FC] p-6 sm:p-7 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#007FBE]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Poin &amp; Durasi Pengerjaan</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="poin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Poin Soal
                    </label>
                    <input type="number" id="poin" name="poin" min="0" max="1000"
                        value="{{ old('poin', $soal->poin ?? 10) }}"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                </div>

                <div>
                    <label for="durasi_detik" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Durasi Timer (Detik)
                    </label>
                    <input type="number" id="durasi_detik" name="durasi_detik" min="5" max="600"
                        value="{{ old('durasi_detik', $soal->durasi_detik ?? 20) }}"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                </div>
            </div>

            @php
                $cloneCount = \Illuminate\Support\Facades\Schema::hasColumn('soal', 'parent_soal_id')
                    ? $soal->clonedSoal()->count()
                    : 0;
            @endphp
            @if($cloneCount > 0)
                <div class="mt-4 p-3.5 rounded-2xl bg-sky-50 border border-[#B2E7FC]">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="sync_clones" value="1" class="mt-0.5 rounded text-[#007FBE] focus:ring-0 w-4 h-4">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            <strong class="block text-slate-900">Sinkronkan ke {{ $cloneCount }} soal salinan di kuis terkait</strong>
                            Perbarui juga teks pertanyaan, opsi jawaban, kunci, poin, dan durasi pada salinan soal yang sudah masuk ke kuis aktif.
                        </span>
                    </label>
                </div>
            @endif
        </section>

        {{-- Submit Bar --}}
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('admin.soal') }}"
                class="px-5 py-3 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-[#007FBE] hover:bg-[#00689E] text-white font-extrabold text-sm shadow-[0_4px_0_#005580] transition hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quizSelect = document.getElementById('id_quiz');
    const mapelSelect = document.getElementById('id_mapel');
    const jenjangSelect = document.getElementById('id_jenjang');
    const tingkatSelect = document.getElementById('tingkat_soal');
    const jenisSelect = document.getElementById('id_jenis_soal');
    const bsNote = document.getElementById('bs-note');

    const choiceRows = Array.from(document.querySelectorAll('[data-choice-row]'));
    const essayInputContainer = document.getElementById('essayInputContainer');
    const essayTextarea = document.getElementById('jawaban_benar');
    const choicesList = document.getElementById('choicesList');
    const choiceCardSubtitle = document.getElementById('choiceCardSubtitle');

    const fotoInput = document.getElementById('foto_soal');
    const fotoFileName = document.getElementById('fotoFileName');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('imagePreview');
    const removeFotoBtn = document.getElementById('removeFotoBtn');

    function applyJenjangMapelFilter(jenjangSelectEl, mapelSelectEl) {
        if (!jenjangSelectEl || !mapelSelectEl) return;
        const jenjangId = parseInt(jenjangSelectEl.value) || 0;
        const currentVal = mapelSelectEl.value;
        let currentValid = false;
        const smaOnlyIds = [11, 12, 13];
        const ipaUmumId = 4;

        Array.from(mapelSelectEl.options).forEach(opt => {
            if (!opt.value) {
                opt.hidden = false;
                return;
            }
            const mapelId = parseInt(opt.value);
            const mapelJenjang = opt.getAttribute('data-jenjang') ? parseInt(opt.getAttribute('data-jenjang')) : null;
            const mapelName = (opt.getAttribute('data-name') || opt.text || '').toLowerCase();
            let visible = true;

            const isSmaOnly = mapelJenjang === 3 || smaOnlyIds.includes(mapelId) ||
                mapelName.includes('fisika') || mapelName.includes('kimia') || mapelName.includes('biologi');
            const isIpaIpsUmum = mapelId === 4 || mapelId === 5 ||
                mapelName.includes('ilmu pengetahuan alam') || mapelName.includes('ilmu pengetahuan sosial');

            if (jenjangId === 1 || jenjangId === 2) {
                if (isSmaOnly) visible = false;
            } else if (jenjangId === 3) {
                if (isIpaIpsUmum) visible = false;
            }

            opt.hidden = !visible;
            opt.disabled = !visible;

            if (opt.value === currentVal && visible) {
                currentValid = true;
            }
        });

        if (!currentValid && currentVal) {
            mapelSelectEl.value = '';
        }
    }

    if (jenjangSelect && mapelSelect) {
        jenjangSelect.addEventListener('change', () => applyJenjangMapelFilter(jenjangSelect, mapelSelect));
        applyJenjangMapelFilter(jenjangSelect, mapelSelect);
    }

    // Auto-update mapel and jenjang when quiz is selected
    quizSelect.addEventListener('change', function () {
        const opt = quizSelect.options[quizSelect.selectedIndex];
        if (opt && opt.value) {
            const optMapel = opt.dataset.mapel;
            const optJenjang = opt.dataset.jenjang;
            if (optMapel && mapelSelect) mapelSelect.value = optMapel;
            if (optJenjang && jenjangSelect) jenjangSelect.value = optJenjang;
        }
        checkDungeonState();
    });

    function checkDungeonState() {
        let isDungeon = false;
        if (quizSelect.value) {
            const opt = quizSelect.options[quizSelect.selectedIndex];
            isDungeon = opt ? opt.dataset.isDungeon === '1' : false;
        }

        const currentJenis = jenisSelect.value;
        if (isDungeon && currentJenis === '3') {
            tingkatSelect.value = 'mudah';
            Array.from(tingkatSelect.options).forEach(opt => {
                if (opt.value === 'sedang' || opt.value === 'sulit') opt.disabled = true;
            });
            bsNote.classList.remove('hidden');
        } else {
            Array.from(tingkatSelect.options).forEach(opt => opt.disabled = false);
            bsNote.classList.add('hidden');
        }
    }

    function updateJenisSoalUI() {
        const currentJenis = jenisSelect.value;

        if (currentJenis === '1') {
            // Pilihan Ganda (A, B, C, D)
            choicesList.classList.remove('hidden');
            essayInputContainer.classList.add('hidden');
            essayTextarea.required = false;
            choiceCardSubtitle.textContent = 'Isi opsi A, B, C, D dan pilih satu jawaban benar sebagai kunci.';

            choiceRows.forEach(row => {
                row.classList.remove('hidden');
                row.querySelectorAll('input').forEach(inp => inp.disabled = false);
                const textInput = row.querySelector('.choice-text-input');
                textInput.readOnly = false;
                row.querySelector('.choice-fixed-label').classList.remove('hidden');
            });
        } else if (currentJenis === '3') {
            // Benar / Salah (A = Benar, B = Salah)
            choicesList.classList.remove('hidden');
            essayInputContainer.classList.add('hidden');
            essayTextarea.required = false;
            choiceCardSubtitle.textContent = 'Pilih apakah pernyataan ini Benar atau Salah sebagai kunci.';

            choiceRows.forEach((row, idx) => {
                if (idx < 2) {
                    row.classList.remove('hidden');
                    row.querySelectorAll('input').forEach(inp => inp.disabled = false);
                    const textInput = row.querySelector('.choice-text-input');
                    textInput.value = idx === 0 ? 'Benar' : 'Salah';
                    textInput.readOnly = true;
                    row.querySelector('.choice-fixed-label').classList.add('hidden');
                } else {
                    row.classList.add('hidden');
                    row.querySelectorAll('input').forEach(inp => inp.disabled = true);
                }
            });
        } else {
            // Isian Singkat
            choicesList.classList.add('hidden');
            essayInputContainer.classList.remove('hidden');
            essayTextarea.required = true;
            choiceCardSubtitle.textContent = 'Tuliskan teks jawaban singkat yang benar.';
            choiceRows.forEach(row => {
                row.querySelectorAll('input').forEach(inp => inp.disabled = true);
            });
        }

        updateCorrectChoiceBadges();
        checkDungeonState();
    }

    jenisSelect.addEventListener('change', updateJenisSoalUI);

    function updateCorrectChoiceBadges() {
        const checkedRadio = document.querySelector('.correct-choice-radio:checked');
        const checkedVal = checkedRadio ? checkedRadio.value : null;

        document.querySelectorAll('.correct-choice-label').forEach(label => {
            const radio = label.querySelector('.correct-choice-radio');
            const indicator = label.querySelector('.correct-indicator');
            const row = label.closest('.choice-item');
            if (radio && radio.value === checkedVal) {
                label.className = 'correct-choice-label inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-emerald-500 bg-emerald-50 text-emerald-800 text-xs font-extrabold cursor-pointer transition select-none';
                indicator.textContent = '✓';
                if (row) {
                    row.classList.add('border-emerald-300', 'bg-emerald-50/20');
                    row.classList.remove('border-slate-200');
                }
            } else {
                label.className = 'correct-choice-label inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-slate-200 bg-white text-slate-500 text-xs font-bold cursor-pointer transition select-none hover:bg-slate-50';
                indicator.textContent = '○';
                if (row) {
                    row.classList.remove('border-emerald-300', 'bg-emerald-50/20');
                    row.classList.add('border-slate-200');
                }
            }
        });
    }

    document.querySelectorAll('.correct-choice-radio').forEach(radio => {
        radio.addEventListener('change', updateCorrectChoiceBadges);
    });

    // Image Preview Handler
    if (fotoInput) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                fotoFileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (removeFotoBtn) {
        removeFotoBtn.addEventListener('click', function () {
            fotoInput.value = '';
            previewImg.src = '';
            fotoFileName.textContent = 'Foto dihapus. Klik simpan untuk menerapkan.';
            previewContainer.classList.add('hidden');
        });
    }

    // Init
    updateJenisSoalUI();
    checkDungeonState();
});
</script>
@endpush
