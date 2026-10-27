@extends('layouts.siswa')

@section('title', 'Belajar Modul — Arrava E-Learning')

@push('styles')
    <style>
        @keyframes modulCardFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" id="modul-search-input" placeholder="Cari modul, materi, atau topik..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-4 sm:px-8 py-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-[#172033]">Belajar Asikk</h1>
            <p class="mt-1 text-sm text-[#687892]">Pilih materi dan modul pembelajaran untuk meningkatkan pemahamanmu.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2" id="modul-grid">
        @forelse($moduls as $modul)
            @php
                $isVideo = ($modul->id_tipemodul == 1 || $modul->youtube_embed_url);
            @endphp
            <div class="modul-card-item hover-frame group rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md"
                data-title="{{ strtolower($modul->judul_modul) }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative h-[200px] w-full sm:w-[160px] shrink-0 overflow-hidden rounded-xl bg-[#eef2f7]">
                        @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                            <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @elseif($modul->youtube_id)
                            <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center shadow text-sm font-bold pl-0.5">▶</div>
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center text-4xl">{{ $isVideo ? '🎬' : '📚' }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 flex flex-col">
                        <span class="inline-flex self-start rounded-md {{ $isVideo ? 'bg-red-50 text-red-600' : 'bg-[#eaf9f2] text-[#20a978]' }} px-2 py-1 text-[11px] font-semibold">
                            {{ $isVideo ? 'Video Pembelajaran' : ($modul->tipeModul->nama_tipe ?? 'Pelajaran') }}
                        </span>
                        <h2 class="mt-3 text-[16px] font-bold leading-snug text-[#172033]">{{ $modul->judul_modul }}</h2>
                        <p class="mt-1.5 line-clamp-2 text-[13px] leading-5 text-[#687892]">Materi pembelajaran digital untuk siswa {{ $modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? '' }}.</p>
                        <div class="mt-4 flex items-center gap-5 text-xs text-[#65748b]">
                            <span class="flex items-center gap-1.5">▣ {{ $modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? 'Semua kelas' }}</span>
                            <span class="flex items-center gap-1.5">{{ $isVideo ? '▶ Video' : '▤ Dokumen' }}</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-[#e4e8ef] flex justify-between items-center">
                            <p class="text-xs text-[#718098]">{{ $isVideo ? 'Tonton materi video' : 'Materi siap dibaca' }}</p>
                            @if($isVideo)
                                <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
                                class="px-3.5 py-1.5 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition flex items-center gap-1 shadow-sm">
                                    <span>▶</span> Tonton Video
                                </a>
                            @else
                                <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
                                class="px-3.5 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition flex items-center gap-1 shadow-sm">
                                    <span>📖</span> Buka Modul
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Belum ada modul yang tersedia.</div>
        @endforelse
    </div>

    {{-- Dynamic Search Empty State (saat pencarian tidak menemukan hasil) --}}
    <div id="modul-empty-search"
        class="hidden rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
        Tidak ada modul yang cocok dengan kata kunci pencarian Anda.
    </div>

    {{-- Pagination (Minimalis Retro: Tombol Kiri, Nomor & Titik di Tengah, Tombol Kanan) --}}
    @if($moduls->isNotEmpty())
        <div id="modul-pagination-container"
            class="mt-12 mb-6 flex items-center justify-center gap-6 sm:gap-8 select-none">
            {{-- Tombol Previous --}}
            <button type="button" class="nav-btn" id="modul-btn-prev" aria-label="Previous" title="Halaman Sebelumnya">
                <svg><use href="#btn-left"/></svg>
            </button>

            {{-- Indikator Nomor & Titik Halaman --}}
            <div class="flex flex-col items-center justify-center min-w-[50px]">
                <span id="modul-page-current" class="text-3xl sm:text-4xl font-black text-blue-600 tracking-tight leading-none">
                    1
                </span>
                <div id="modul-pagination-dots" class="mt-2 flex items-center justify-center gap-1.5">
                    <!-- Dots di-render dinamis oleh JavaScript -->
                </div>
            </div>

            {{-- Tombol Next --}}
            <button type="button" class="nav-btn" id="modul-btn-next" aria-label="Next" title="Halaman Selanjutnya">
                <svg><use href="#btn-right"/></svg>
            </button>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // =========================================================================
    // Client-side Pagination (Batasan 8 card per halaman) & Live Search Modul
    // =========================================================================
    const MODUL_CARDS_PER_PAGE = 8;
    let currentModulPage = 1;

    const modulCards = Array.from(document.querySelectorAll('.modul-card-item'));
    const modulSearchInput = document.getElementById('modul-search-input');
    const modulEmptySearchEl = document.getElementById('modul-empty-search');
    const modulPaginationContainer = document.getElementById('modul-pagination-container');
    const modulPageCurrentEl = document.getElementById('modul-page-current');
    const modulDotsContainerEl = document.getElementById('modul-pagination-dots');
    const modulBtnPrev = document.getElementById('modul-btn-prev');
    const modulBtnNext = document.getElementById('modul-btn-next');

    function getFilteredModulCards() {
        const query = modulSearchInput ? modulSearchInput.value.toLowerCase().trim() : '';
        if (!query) return modulCards;
        return modulCards.filter(card => {
            const title = (card.getAttribute('data-title') || '').toLowerCase();
            return title.includes(query);
        });
    }

    function renderModulDots(totalPages, currentPage) {
        if (!modulDotsContainerEl) return;
        modulDotsContainerEl.innerHTML = '';
        const count = Math.max(1, totalPages);
        for (let p = 1; p <= count; p++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Halaman ${p}`);
            if (p === currentPage) {
                dot.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-blue-600 scale-125 transition-transform duration-150 pointer-events-none shadow-xs';
            } else {
                dot.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-blue-200 hover:bg-blue-500 transition-colors duration-150 cursor-pointer';
                dot.addEventListener('click', function () {
                    currentModulPage = p;
                    renderModulPagination(true);
                    const grid = document.getElementById('modul-grid');
                    if (grid && window.scrollY > grid.offsetTop) {
                        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
            modulDotsContainerEl.appendChild(dot);
        }
    }

    function renderModulPagination(animate = false) {
        const filtered = getFilteredModulCards();
        const totalItems = filtered.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / MODUL_CARDS_PER_PAGE));

        if (currentModulPage > totalPages) currentModulPage = totalPages;
        if (currentModulPage < 1) currentModulPage = 1;

        const startIndex = (currentModulPage - 1) * MODUL_CARDS_PER_PAGE;
        const endIndex = Math.min(startIndex + MODUL_CARDS_PER_PAGE, totalItems);

        modulCards.forEach(card => card.style.display = 'none');

        if (totalItems === 0) {
            if (modulEmptySearchEl) modulEmptySearchEl.classList.remove('hidden');
            if (modulPaginationContainer) modulPaginationContainer.classList.add('hidden');
        } else {
            if (modulEmptySearchEl) modulEmptySearchEl.classList.add('hidden');
            if (modulPaginationContainer) modulPaginationContainer.classList.remove('hidden');

            for (let i = startIndex; i < endIndex; i++) {
                filtered[i].style.display = '';
                if (animate) {
                    filtered[i].style.animation = 'none';
                    void filtered[i].offsetWidth;
                    filtered[i].style.animation = 'modulCardFadeIn 0.28s ease-out forwards';
                }
            }

            if (modulPageCurrentEl) modulPageCurrentEl.textContent = currentModulPage;
            renderModulDots(totalPages, currentModulPage);

            if (modulBtnPrev) {
                const disabled = currentModulPage <= 1;
                modulBtnPrev.disabled = disabled;
                modulBtnPrev.setAttribute('aria-disabled', disabled ? 'true' : 'false');
            }
            if (modulBtnNext) {
                const disabled = currentModulPage >= totalPages;
                modulBtnNext.disabled = disabled;
                modulBtnNext.setAttribute('aria-disabled', disabled ? 'true' : 'false');
            }
        }
    }

    if (modulBtnPrev) {
        modulBtnPrev.addEventListener('click', function () {
            if (currentModulPage > 1) {
                currentModulPage--;
                renderModulPagination(true);
                const grid = document.getElementById('modul-grid');
                if (grid && window.scrollY > grid.offsetTop) {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }

    if (modulBtnNext) {
        modulBtnNext.addEventListener('click', function () {
            const totalPages = Math.ceil(getFilteredModulCards().length / MODUL_CARDS_PER_PAGE);
            if (currentModulPage < totalPages) {
                currentModulPage++;
                renderModulPagination(true);
                const grid = document.getElementById('modul-grid');
                if (grid && window.scrollY > grid.offsetTop) {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }

    if (modulSearchInput) {
        modulSearchInput.addEventListener('input', function () {
            currentModulPage = 1;
            renderModulPagination(false);
        });
    }

    renderModulPagination(false);
</script>
@endpush
