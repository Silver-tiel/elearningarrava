@extends('layouts.siswa')

@section('title', 'Profil Pengguna - eBooks')

@section('header')
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-lg font-bold text-slate-800">Profil Pengguna</h1>
        <div class="hidden w-full max-w-xs items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs text-slate-400 md:flex">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
            </svg>
            <span>Cari materi, tugas, atau kelas...</span>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-full bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @if (session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Profil belum dapat disimpan:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid items-start gap-5 xl:grid-cols-12">
                <div class="space-y-5 xl:col-span-7">
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div class="h-20 w-20 shrink-0">
                                @if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil))
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($user->foto_profil) }}"
                                        alt="Foto profil {{ $user->nama }}"
                                        class="h-20 w-20 rounded-full object-cover ring-4 ring-slate-100"
                                    >
                                @else
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-blue-50 text-2xl font-bold text-blue-600 ring-4 ring-slate-100">
                                        {{ strtoupper(substr($user->nama ?? 'S', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="truncate text-xl font-bold text-slate-900">{{ $user->nama }}</h2>
                                <p class="mt-1 break-all text-sm text-slate-400">
                                    {{ $user->email }}
                                    <span class="px-1">•</span>
                                    {{ $user->jenjang->nama_tipe ?? 'Siswa Terdaftar' }}
                                </p>
                                <div class="mt-3 flex flex-wrap items-center gap-3">
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">Siswa</span>
                                    <button
                                        type="button"
                                        data-open-profile-modal
                                        class="text-xs font-semibold text-blue-600 underline underline-offset-2 hover:text-blue-700"
                                    >
                                        Edit Profil Saya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-bold text-slate-900">Data Pribadi &amp; Sekolah</h2>
                                <p class="mt-1 text-sm text-slate-500">Informasi yang tersimpan pada akun Anda.</p>
                            </div>
                            <button
                                type="button"
                                data-open-profile-modal
                                class="shrink-0 rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-600 transition hover:bg-blue-50"
                            >
                                Edit Profil
                            </button>
                        </div>

                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Username</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $user->username ?: 'Belum diisi' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Email</dt>
                                <dd class="mt-1 break-all text-sm font-medium text-slate-700">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Nomor Induk Siswa Nasional (NISN)</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $user->nisn ?: 'Belum diisi' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Jenjang Akademik</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $user->jenjang->nama_tipe ?? 'Belum diisi' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Asal Sekolah</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $user->asal_sekolah ?: 'Belum diisi' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-400">Nomor Handphone</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $user->nomor_hp ?: 'Belum diisi' }}</dd>
                            </div>
                        </dl>
                    </section>
                </div>

                <div class="space-y-5 xl:col-span-5">
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <h2 class="text-base font-bold text-slate-900">Statistik Capaian Akademik</h2>
                        <div class="mt-5 flex items-center gap-4 border-b border-slate-100 pb-5">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-blue-50 text-lg font-bold text-blue-600">
                                {{ $averageScore !== null ? $averageScore . '%' : '—' }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Rata-rata nilai kuis</p>
                                @if ($averageScore !== null)
                                    <p class="mt-1 text-xs leading-relaxed text-slate-400">
                                        Berdasarkan {{ $scoreSummary->jumlah_kuis }} hasil kuis yang tersimpan.
                                    </p>
                                @else
                                    <p class="mt-1 text-xs leading-relaxed text-slate-400">Nilai akan tampil setelah Anda menyelesaikan kuis.</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-slate-500">Kuis diselesaikan</span>
                            <span class="font-semibold text-slate-700">{{ $scoreSummary->jumlah_kuis }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-slate-500">Total poin</span>
                            <span class="font-semibold text-slate-700">{{ number_format($scoreSummary->poin_didapat) }}</span>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-base font-bold text-slate-900">Tanda Penghargaan Milikmu</h2>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">{{ $achievements->count() }}</span>
                        </div>

                        @if ($achievements->isNotEmpty())
                            <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                                @foreach ($achievements as $achievement)
                                    <li class="flex min-w-0 items-center gap-3 rounded-xl bg-slate-50 p-3 transition hover:bg-slate-100/70">
                                        @php
                                            $gambarAch = $achievement->achievement?->gambar_achivement;
                                        @endphp
                                        @if ($gambarAch && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarAch))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($gambarAch) }}"
                                                 alt="{{ $achievement->nama }}"
                                                 class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-amber-100 shadow-sm bg-white">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-500 shadow-sm" aria-hidden="true">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3z"/>
                                                </svg>
                                            </span>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate text-xs font-semibold text-slate-800">{{ $achievement->nama }}</p>
                                            <p class="mt-0.5 text-[11px] text-slate-400">Diraih: {{ $achievement->waktu_pencapaian?->format('d M Y') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-4 rounded-xl bg-slate-50 px-4 py-5 text-center text-sm text-slate-400">
                                Belum ada penghargaan. Terus belajar untuk meraih pencapaian pertamamu!
                            </p>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

    <dialog
        id="profile-edit-modal"
        aria-labelledby="profile-modal-title"
        data-open-on-load="{{ $errors->any() ? 'true' : 'false' }}"
        class="m-auto max-h-[90vh] w-[calc(100%-2rem)] max-w-2xl overflow-y-auto rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/50"
    >
        <div class="sticky top-0 z-10 flex items-start justify-between border-b border-slate-100 bg-white px-5 py-4 sm:px-6">
            <div>
                <h2 id="profile-modal-title" class="text-lg font-bold text-slate-900">Edit Profil</h2>
                <p class="mt-1 text-sm text-slate-500">Perbarui data pribadi dan sekolah Anda.</p>
            </div>
            <button type="button" data-close-profile-modal aria-label="Tutup popup" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white px-5 py-5 sm:px-6">
            @csrf
            @method('PUT')

            <div>
                <label for="foto_profil" class="mb-1.5 block text-xs font-semibold text-slate-500">Foto Profil</label>
                <input
                    id="foto_profil"
                    name="foto_profil"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                >
                <p class="mt-1 text-xs text-slate-400">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                @error('foto_profil')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="username" class="mb-1.5 block text-xs font-semibold text-slate-500">Username</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username', $user->username) }}"
                    autocomplete="username"
                    required
                    maxlength="50"
                    placeholder="Masukkan username"
                    class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                >
                @error('username')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="nama" class="mb-1.5 block text-xs font-semibold text-slate-500">Nama Lengkap</label>
                <input
                    id="nama"
                    type="text"
                    value="{{ $user->nama }}"
                    readonly
                    aria-describedby="nama-readonly-note"
                    class="h-11 w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 text-sm text-slate-500"
                >
                <p id="nama-readonly-note" class="mt-1 text-xs text-slate-400">Nama terikat ke akun dan tidak dapat diubah.</p>
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-xs font-semibold text-slate-500">Email</label>
                <input
                    id="email"
                    type="email"
                    value="{{ $user->email }}"
                    readonly
                    aria-describedby="email-readonly-note"
                    class="h-11 w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 text-sm text-slate-500"
                >
                <p id="email-readonly-note" class="mt-1 text-xs text-slate-400">Email terikat ke akun dan tidak dapat diubah.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nisn" class="mb-1.5 block text-xs font-semibold text-slate-500">Nomor Induk Siswa Nasional (NISN)</label>
                    <input
                        id="nisn"
                        type="text"
                        value="{{ $user->nisn }}"
                        readonly
                        aria-describedby="nisn-readonly-note"
                        class="h-11 w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 text-sm text-slate-500"
                    >
                    <p id="nisn-readonly-note" class="mt-1 text-xs text-slate-400">NISN terikat ke data siswa dan tidak dapat diubah.</p>
                </div>

                <div>
                    <label for="id_jenjang" class="mb-1.5 block text-xs font-semibold text-slate-500">Jenjang Akademik</label>
                    <input
                        id="id_jenjang"
                        type="text"
                        value="{{ $user->jenjang->nama_tipe ?? 'Belum ditentukan' }}"
                        readonly
                        aria-describedby="jenjang-readonly-note"
                        class="h-11 w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-3.5 text-sm text-slate-500"
                    >
                    <p id="jenjang-readonly-note" class="mt-1 text-xs text-slate-400">Jenjang akademik dikelola oleh pihak sekolah/sistem.</p>
                </div>
            </div>

            <div>
                <label for="nomor_hp" class="mb-1.5 block text-xs font-semibold text-slate-500">Nomor Handphone</label>
                <input
                    id="nomor_hp"
                    name="nomor_hp"
                    type="tel"
                    inputmode="tel"
                    value="{{ old('nomor_hp', $user->nomor_hp) }}"
                    maxlength="20"
                    class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                >
                @error('nomor_hp')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <button type="button" data-close-profile-modal class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </dialog>
@endsection

@push('scripts')
    <script>
        const profileEditModal = document.getElementById('profile-edit-modal');

        document.querySelectorAll('[data-open-profile-modal]').forEach((button) => {
            button.addEventListener('click', () => profileEditModal.showModal());
        });

        document.querySelectorAll('[data-close-profile-modal]').forEach((button) => {
            button.addEventListener('click', () => profileEditModal.close());
        });

        profileEditModal.addEventListener('click', (event) => {
            if (event.target === profileEditModal) profileEditModal.close();
        });

        if (profileEditModal.dataset.openOnLoad === 'true') profileEditModal.showModal();
    </script>
@endpush