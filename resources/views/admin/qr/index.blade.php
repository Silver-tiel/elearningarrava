@extends('layouts.app')

@section('header')
<div class="flex items-center gap-3 min-w-0">
    <div class="min-w-0">
        <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
            QR Presensi Siswa
        </h1>
        <p class="text-xs text-slate-500 truncate">
            Manajemen dan regenerasi QR code presensi siswa
        </p>
    </div>
</div>
@endsection

@section('content')
<div class="p-6 sm:p-8 space-y-6">

    @include('guru.presensi._flash')

    <!-- HEADER & DESKRIPSI -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Kelola QR Siswa</h2>
            <p class="text-sm text-slate-500 mt-1">
                Buat ulang QR jika bocor atau hilang. QR lama langsung otomatis tidak berlaku demi keamanan presensi.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                Total: <span id="total-count">{{ $siswa->total() }}</span> Siswa
            </span>
        </div>
    </div>

    <!-- PENCARIAN & FILTER -->
    <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs">
        <form method="GET" action="{{ route('admin.qr') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="q" name="q" value="{{ $cari }}" oninput="filterCards()" placeholder="Cari nama, email, atau NISN siswa..."
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-xl font-semibold text-sm hover:bg-blue-700 transition shadow-xs">
                    Cari
                </button>
                @if($cari !== '')
                    <a href="{{ route('admin.qr') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-semibold text-sm hover:bg-slate-50 transition text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- GRID CARD QR SISWA -->
    @if($siswa->isNotEmpty())
        <div id="qrGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($siswa as $s)
                <div class="qr-card bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group"
                     data-nama="{{ strtolower($s->nama) }}"
                     data-email="{{ strtolower($s->email ?? '') }}"
                     data-nisn="{{ $s->nisn ?? '' }}">

                    <!-- BANNER ATAS DENGAN STATUS QR & JENJANG -->
                    <div class="h-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 relative p-3.5 flex justify-between items-start">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                            <span>{{ $s->jenjang->nama_tipe ?? 'Siswa' }}</span>
                        </span>

                        @if($s->qr_dibuat_pada)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/90 text-white shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                <span>QR Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/90 text-white shadow-2xs">
                                <span>Belum Dibuat</span>
                            </span>
                        @endif
                    </div>

                    <!-- FOTO SISWA (CARD PHOTO OVERLAPPING) -->
                    <div class="relative px-5 pt-0 pb-2">
                        <div class="-mt-12 flex justify-center">
                            <div class="w-24 h-24 rounded-2xl ring-4 ring-white shadow-md bg-white overflow-hidden flex items-center justify-center shrink-0">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     src="{{ !empty($s->foto_profil) ? \Illuminate\Support\Facades\Storage::url($s->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($s->nama) . '&background=EFF6FF&color=2563EB' }}"
                                     alt="{{ $s->nama }}">
                            </div>
                        </div>

                        <!-- IDENTITAS SISWA -->
                        <div class="text-center mt-3">
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-blue-600 transition truncate" title="{{ $s->nama }}">
                                {{ $s->nama }}
                            </h3>
                            <p class="text-xs text-slate-500 flex items-center justify-center gap-1.5 mt-0.5 truncate" title="{{ $s->email }}">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="truncate">{{ $s->email ?? 'Siswa Arrava' }}</span>
                            </p>
                        </div>

                        <!-- DETAIL INFO (NISN, QR DIBUAT, STATUS) -->
                        <div class="mt-4 space-y-1.5">
                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">NISN</span>
                                <span class="text-slate-700 font-mono font-semibold">{{ $s->nisn ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">QR Dibuat</span>
                                <span class="text-slate-700 font-medium" title="{{ $s->qr_dibuat_pada ? $s->qr_dibuat_pada->format('d M Y H:i:s') : '' }}">
                                    {{ $s->qr_dibuat_pada ? $s->qr_dibuat_pada->format('d M Y H:i') : 'Belum dibuat' }}
                                </span>
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">Status Akun</span>
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full {{ ($s->status_akun ?? 'Aktif') === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $s->status_akun ?? 'Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER AKSI TOMBOL BUAT ULANG QR -->
                    <div class="mt-auto px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.qr.regenerate', $s->id_user) }}"
                              data-nama="{{ $s->nama }}"
                              onsubmit="return confirm('Buat ulang QR untuk ' + this.dataset.nama + '? QR lama tidak akan berlaku lagi.')"
                              class="w-full">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 px-3 text-xs font-semibold rounded-xl bg-white border border-amber-300 text-amber-800 hover:bg-amber-50 active:bg-amber-100 transition flex items-center justify-center gap-1.5 shadow-2xs">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>Buat Ulang QR</span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- STATE KOSONG SAAT PENCARIAN INSTAN TIDAK ADA HASIL -->
        <div id="noResults" class="hidden bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-xs">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-base font-bold text-slate-700">Siswa tidak ditemukan</p>
            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>

        <!-- PAGINASI -->
        <div class="mt-6">
            {{ $siswa->links() }}
        </div>
    @else
        <!-- STATE KOSONG (DATABASE KOSONG) -->
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Siswa tidak ditemukan</h3>
            <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1">
                Tidak ada data siswa yang cocok dengan kriteria pencarian saat ini.
            </p>
            @if($cari !== '')
                <a href="{{ route('admin.qr') }}" class="mt-4 inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold text-xs hover:bg-blue-700 transition">
                    Reset Pencarian
                </a>
            @endif
        </div>
    @endif

</div>

<script>
    function filterCards() {
        const query = document.getElementById('q').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.qr-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const nama = card.getAttribute('data-nama') || '';
            const email = card.getAttribute('data-email') || '';
            const nisn = card.getAttribute('data-nisn') || '';

            if (nama.includes(query) || email.includes(query) || nisn.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('noResults');
        if (noResults) {
            if (visibleCount === 0 && cards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        const countEl = document.getElementById('total-count');
        if (countEl) {
            countEl.textContent = visibleCount;
        }
    }
</script>
@endsection
