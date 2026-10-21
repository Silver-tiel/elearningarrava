@extends('layouts.orangtua')

@section('title', 'Pengaturan Akun - Portal Orang Tua')
@section('breadcrumb', 'Pengaturan')

@push('styles')
<style>
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-input {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px 10px 40px;
        font-size: 14px;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .form-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .form-input-bare {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .form-input-bare:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .input-icon-wrap { position: relative; }
    .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        width: 16px;
        height: 16px;
        pointer-events: none;
    }
    .badge-verified {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .section-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }
    .avatar-wrap {
        position: relative;
        display: inline-block;
    }
    .avatar-online {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background: #22c55e;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #4f46e5;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .1s;
    }
    .btn-primary:hover { background: #4338ca; transform: translateY(-1px); }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .info-note {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }
    .divider-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        margin-bottom: 16px;
    }
    .readonly-badge {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
        font-weight: 600;
        color: #22c55e;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 1px 7px;
        border-radius: 20px;
    }
</style>
@endpush

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[900px] mx-auto">

    {{-- PAGE HEADER --}}
    <div class="mb-6">
        <nav class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
            <span class="text-slate-600 font-medium">Portal Orang Tua</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span>Pengaturan</span>
        </nav>
        <h1 class="text-[22px] font-extrabold text-slate-900">Pengaturan Akun &amp; Preferensi</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola profil data diri wali murid, preferensi notifikasi pemantauan belajar anak, integrasi kontak, serta keamanan akun.</p>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-5">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    {{-- ALERT VALIDATION ERRORS --}}
    @if($errors->any())
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <ul class="text-sm text-red-700 space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('orangtua.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="formPengaturan">
        @csrf
        @method('PUT')

        {{-- ================================================================
        |  PROFIL CARD
        ================================================================ --}}
        <div class="section-card">
            <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                {{-- Avatar --}}
                <div class="avatar-wrap shrink-0">
                    @if($user->foto_profil)
                    <img src="{{ asset('storage/'.$user->foto_profil) }}" alt="Foto Profil"
                         class="w-[72px] h-[72px] rounded-2xl object-cover border-2 border-slate-100 shadow-sm">
                    @else
                    <div class="w-[72px] h-[72px] rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-extrabold text-2xl shadow-md shadow-indigo-500/20">
                        {{ strtoupper(substr($user->nama ?? 'O', 0, 2)) }}
                    </div>
                    @endif
                    <span class="avatar-online"></span>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h2 class="text-[17px] font-bold text-slate-900 leading-tight">{{ $user->nama }}</h2>
                        <span class="badge-verified">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Wali Murid Terverifikasi
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">
                        Wali Murid
                        &bull; Terdaftar sejak {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}
                    </p>
                    <div class="flex flex-wrap gap-4 mt-2 text-[12px] text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Arrava E-Learning
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Sinkronisasi Otomatis
                        </span>
                    </div>
                </div>

                {{-- Upload foto --}}
                <div class="shrink-0">
                    <label for="foto_profil_input"
                           class="btn-secondary cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Ganti Foto
                    </label>
                    <input type="file" id="foto_profil_input" name="foto_profil" accept="image/*" class="hidden" onchange="previewFoto(this)">
                </div>
            </div>
        </div>

        {{-- ================================================================
        |  INFORMASI PRIBADI & KONTAK
        ================================================================ --}}
        <div class="section-card">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-5">
                <div>
                    <h3 class="text-[15px] font-bold text-slate-900">Informasi Pribadi &amp; Kontak Resmi</h3>
                    <p class="text-[12px] text-slate-400 mt-0.5">Data ini digunakan sekolah untuk pelaporan resmi, buku rapor, dan kontak keadaan mendesak.</p>
                </div>
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide whitespace-nowrap mt-1 sm:mt-0">
                    TERAKHIR DIPERBARUI: {{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d M Y') }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama" class="form-label">Nama Lengkap Beserta Gelar</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="nama" name="nama" class="form-input"
                               value="{{ old('nama', $user->nama) }}"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- NISN (hanya baca) --}}
                <div>
                    <label class="form-label">NISN / ID Akun</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        <input type="text" class="form-input" value="{{ $user->nisn ?? '-' }}" readonly style="background:#f8fafc;color:#94a3b8;cursor:not-allowed;">
                        <span class="readonly-badge">Terverifikasi</span>
                    </div>
                    <p class="info-note">ID akun tidak dapat diubah sendiri, hubungi admin.</p>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="form-label">
                        Alamat Surel (Email Utama)
                        <span class="badge-verified ml-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Terverifikasi
                        </span>
                    </label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" id="email" name="email" class="form-input"
                               value="{{ old('email', $user->email) }}"
                               placeholder="email@contoh.com">
                    </div>
                    <p class="info-note">Digunakan untuk menerima rekap rapor digital bulanan &amp; akses reset login.</p>
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label for="nomor_hp" class="form-label">Nomor WhatsApp Aktif</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <input type="text" id="nomor_hp" name="nomor_hp" class="form-input"
                               value="{{ old('nomor_hp', $user->nomor_hp) }}"
                               placeholder="+62 8xx-xxxx-xxxx">
                    </div>
                    <p class="info-note">Tujuan pengiriman notifikasi instan kehadiran &amp; presensi pagi anak.</p>
                    @error('nomor_hp')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status Akun (readonly) --}}
                <div>
                    <label class="form-label">Status Kependudukan / NIK</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <input type="text" class="form-input"
                               value="{{ $user->status_akun ?? 'Aktif' }} (Terverifikasi)"
                               readonly style="background:#f8fafc;color:#94a3b8;cursor:not-allowed;">
                        <span class="readonly-badge">Terverifikasi</span>
                    </div>
                    <p class="info-note">Untuk pembaruan NIK resmi, silakan lampirkan Kartu Keluarga ke Tata Usaha.</p>
                </div>

                {{-- Pekerjaan / Instansi (opsional, tidak ada di db – hanya display) --}}
                {{-- Dipakai sebagai informasi tambahan visible; tidak disimpan karena tidak ada kolom di tabel user --}}

            </div>
        </div>

        {{-- ================================================================
        |  KEAMANAN AKUN
        ================================================================ --}}
        <div class="section-card">
            <h3 class="text-[15px] font-bold text-slate-900 mb-1">Keamanan Akun</h3>
            <p class="text-[12px] text-slate-400 mb-5">Kosongkan jika tidak ingin mengubah kata sandi. Isi keduanya untuk mengganti password.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                <div>
                    <label for="password" class="form-label">Kata Sandi Baru</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Minimal 8 karakter" autocomplete="new-password">
                    </div>
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                               placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================
        |  ACTION BUTTONS
        ================================================================ --}}
        <div class="flex items-center justify-end gap-3 mt-2 pb-8">
            <button type="reset" class="btn-secondary" onclick="return confirm('Reset semua perubahan yang belum disimpan?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Batal / Reset
            </button>
            <button type="submit" id="btnSimpan" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarEl = document.querySelector('.avatar-wrap > img, .avatar-wrap > div');
            if (avatarEl) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Foto Profil';
                img.className = 'w-[72px] h-[72px] rounded-2xl object-cover border-2 border-slate-100 shadow-sm';
                avatarEl.replaceWith(img);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Tombol simpan loading state
document.getElementById('formPengaturan').addEventListener('submit', function() {
    const btn = document.getElementById('btnSimpan');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Menyimpan...';
});
</script>
@endpush
