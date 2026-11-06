@extends('layouts.app')

@section('content')

<div class="p-6 sm:p-8 space-y-6">

    <!-- HEADER & ACTION -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Guru
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola data pengajar, foto profil, dan akun login guru di Bimbel Arrava.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.guru.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold text-sm
                      hover:bg-indigo-700 transition shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Guru & Akun</span>
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between shadow-2xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
    </div>
    @endif

    <!-- FILTER & PENCARIAN -->
    <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-md">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" oninput="filterCards()" placeholder="Cari nama, email, atau NIK guru..."
                   class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                Total: <span id="total-count">{{ $gurus->count() }}</span> Guru
            </span>
        </div>
    </div>

    <!-- GRID CARD FOTO GURU -->
    @if($gurus->isNotEmpty())
        <div id="guruGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($gurus as $guru)
                <div class="guru-card bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group"
                     data-nama="{{ strtolower($guru->nama) }}"
                     data-email="{{ strtolower($guru->user?->email ?? '') }}"
                     data-nik="{{ $guru->nik }}">

                    <!-- BANNER ATAS DENGAN STATUS -->
                    <div class="h-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 relative p-3.5 flex justify-between items-start">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                            <span>Pengajar</span>
                        </span>

                        @if($guru->user && $guru->user->status_akun === 'Aktif')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/90 text-white shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                <span>Aktif</span>
                            </span>
                        @elseif($guru->user && $guru->user->status_akun === 'Nonaktif')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-500/90 text-white shadow-2xs">
                                <span>Nonaktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/90 text-white shadow-2xs">
                                <span>Tanpa Akun</span>
                            </span>
                        @endif
                    </div>

                    <!-- FOTO GURU (CARD PHOTO) -->
                    <div class="relative px-5 pt-0 pb-2">
                        <div class="-mt-12 flex justify-center">
                            <div class="w-24 h-24 rounded-2xl ring-4 ring-white shadow-md bg-white overflow-hidden flex items-center justify-center shrink-0">
                                @if($guru->foto_url)
                                    <img src="{{ $guru->foto_url }}"
                                         alt="{{ $guru->nama }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-blue-100 flex items-center justify-center text-indigo-600 text-3xl font-extrabold font-sans">
                                        {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- IDENTITAS GURU -->
                        <div class="text-center mt-3">
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-indigo-600 transition truncate" title="{{ $guru->nama }}">
                                {{ $guru->nama }}
                            </h3>
                            <p class="text-xs text-slate-500 flex items-center justify-center gap-1.5 mt-0.5 truncate" title="{{ $guru->user?->email }}">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="truncate">{{ $guru->user?->email ?? 'Belum ada email' }}</span>
                            </p>
                        </div>

                        <!-- DETAIL INFO (NIK & NO TELP) -->
                        <div class="mt-4 space-y-1.5">
                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">NIK</span>
                                <span class="text-slate-700 font-mono font-semibold">{{ $guru->nik }}</span>
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">No. HP</span>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $guru->no_telepon) }}"
                                   target="_blank"
                                   title="Kirim Pesan WhatsApp"
                                   class="text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1 hover:underline">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                                    </svg>
                                    <span>{{ $guru->no_telepon }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER AKSI TOMBOL -->
                    <div class="mt-auto px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2">
                        <!-- EDIT BUTTON -->
                        <a href="{{ route('admin.guru.edit', $guru->id_guru) }}"
                           class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit Data</span>
                        </a>

                        <!-- HAPUS BUTTON -->
                        <form action="{{ route('admin.guru.destroy', $guru->id_guru) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru {{ $guru->nama }} beserta akun loginnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    title="Hapus Guru"
                                    class="py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition flex items-center justify-center shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <div id="noResults" class="hidden bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-xs">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-base font-bold text-slate-700">Guru tidak ditemukan</p>
            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>
    @else
        <!-- KOSONG (EMPTY STATE) -->
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Guru</h3>
            <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                Belum ada pengajar yang ditambahkan ke sistem. Tambahkan guru baru untuk mengelola kelas dan kuis.
            </p>
            <a href="{{ route('admin.guru.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition shadow-sm">
                <span>+ Tambah Guru Pertama</span>
            </a>
        </div>
    @endif

</div>

<script>
    function filterCards() {
        const query = document.getElementById('searchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.guru-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const nama = card.getAttribute('data-nama');
            const email = card.getAttribute('data-email');
            const nik = card.getAttribute('data-nik');

            if (nama.includes(query) || email.includes(query) || nik.includes(query)) {
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
    }
</script>

@endsection
