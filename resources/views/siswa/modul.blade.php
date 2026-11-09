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
        .nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: #ffffff;
            border: 2px solid #B2E7FC;
            box-shadow: 0 3px 0 #B2E7FC;
            color: #007FBE;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .nav-btn:hover:not(:disabled) {
            background: #DDF3FF;
            transform: translateY(-1px);
            box-shadow: 0 4px 0 #B2E7FC;
        }
        .nav-btn:active:not(:disabled) {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #B2E7FC;
        }
        .nav-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            border-color: #E2E8F0;
            box-shadow: none;
            color: #94A3B8;
        }
        .nav-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }
    </style>
@endpush

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#72839E]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" id="modul-search-input" placeholder="Cari modul, materi, atau topik..." class="h-10 w-full rounded-2xl bg-[#F0F6FF] border-2 border-[#DCEFFF] pl-11 pr-4 text-sm font-semibold text-[#12233F] outline-none placeholder:text-[#72839E] focus:bg-white focus:border-[#007FBE] focus:ring-4 focus:ring-[#DDF3FF] transition shadow-[0_2px_0_#DCEFFF]">
</div>
@endsection

@section('content')
<div class="px-4 sm:px-8 py-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-heading font-black tracking-tight text-[#082765]">Belajar Asik 📚</h1>
                @if(Auth::user()?->jenjang)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#DDF3FF] text-[#007FBE] text-xs font-bold rounded-full border border-[#B2E7FC] shadow-xs">
                        <span>🎓</span> Jenjang {{ Auth::user()->jenjang->nama_tipe }}
                    </span>
                @endif
            </div>
            <p class="mt-1 text-sm font-semibold text-[#465673]">
                @if(Auth::user()?->jenjang)
                    Menampilkan modul dan materi pembelajaran interaktif khusus untuk jenjang <strong>{{ Auth::user()->jenjang->nama_tipe }}</strong>.
                @else
                    Pilih materi dan modul pembelajaran untuk meningkatkan pemahamanmu.
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2" id="modul-grid">
        @forelse($moduls as $modul)
            @php
                $isVideo = ($modul->id_tipemodul == 1 || $modul->youtube_embed_url);
            @endphp
            <div class="modul-card-item hover-frame group rounded-2xl border-2 border-[#DCEFFF] bg-white p-3.5 sm:p-4 transition-all duration-200 hover:-translate-y-1 hover:border-[#007FBE] hover:shadow-[0_5px_0_#007FBE] shadow-[0_3px_0_#B2E7FC]"
                data-title="{{ strtolower($modul->judul_modul) }}">
                <div class="flex flex-col sm:flex-row gap-3.5 items-stretch">
                    <!-- Thumbnail Box (Compact) -->
                    <div class="relative h-[120px] sm:h-[125px] w-full sm:w-[135px] shrink-0 overflow-hidden rounded-xl bg-[#DDF3FF] border border-[#B2E7FC]">
                        @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                            <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @elseif($modul->youtube_id)
                            <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/25 flex items-center justify-center">
                                <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center shadow-md text-xs font-black pl-0.5 border-2 border-white">▶</div>
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center text-3xl select-none">{{ $isVideo ? '🎬' : '📚' }}</div>
                        @endif
                    </div>

                    <!-- Content & Action Area (Snug & Shortened) -->
                    <div class="min-w-0 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Header Badges: Tipe & Jenjang -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center rounded-full {{ $isVideo ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-[#DDF3FF] text-[#007FBE] border border-[#B2E7FC]' }} px-2.5 py-0.5 text-[10.5px] font-bold">
                                    {{ $isVideo ? '🎬 Video' : ($modul->tipeModul->nama_tipe ?? '📖 Pelajaran') }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-[#72839E]">
                                    <span>🏫</span> {{ $modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? 'Semua' }}
                                </span>
                            </div>

                            <!-- Judul Modul -->
                            <h2 class="mt-1 text-sm sm:text-[15px] font-heading font-black leading-snug text-[#082765] group-hover:text-[#007FBE] transition-colors line-clamp-1" title="{{ $modul->judul_modul }}">
                                {{ $modul->judul_modul }}
                            </h2>

                            <!-- Deskripsi Singkat -->
                            <p class="mt-0.5 line-clamp-2 text-xs leading-relaxed font-semibold text-[#465673]">
                                {{ $modul->deskripsi ?: ('Materi pembelajaran digital untuk siswa ' . ($modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? 'semua kelas') . '.') }}
                            </p>
                        </div>

                        <!-- Footer: Keterangan Format & Tombol Aksi 3D -->
                        <div class="mt-2.5 pt-2 border-t border-[#DCEFFF] flex items-center justify-between gap-2">
                            <span class="text-[11px] font-semibold text-[#72839E] flex items-center gap-1">
                                <span>{{ $isVideo ? '▶' : '📄' }}</span> {{ $isVideo ? 'Video Belajar' : 'Dokumen Modul' }}
                            </span>
                            @if($isVideo)
                                <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-black rounded-xl shadow-[0_2.5px_0_#be123c] active:translate-y-0.5 active:shadow-none transition flex items-center gap-1.5 shrink-0">
                                    <span>▶</span> Tonton Video
                                </a>
                            @else
                                <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
                                    class="px-3 py-1.5 bg-[#007FBE] hover:bg-[#00679A] text-white text-xs font-black rounded-xl shadow-[0_2.5px_0_#005580] active:translate-y-0.5 active:shadow-none transition flex items-center gap-1.5 shrink-0">
                                    <span>📖</span> Buka Modul
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl sm:rounded-3xl border-2 border-dashed border-[#B2E7FC] bg-white p-12 text-center text-sm font-semibold text-[#465673] shadow-[0_4px_0_#DCEFFF]">
                <div class="text-4xl mb-2">📚</div>
                @if(Auth::user()?->jenjang)
                    Belum ada modul yang tersedia untuk jenjang {{ Auth::user()->jenjang->nama_tipe }}.
                @else
                    Belum ada modul yang tersedia.
                @endif
            </div>
        @endforelse
    </div>

    {{-- Dynamic Search Empty State (saat pencarian tidak menemukan hasil) --}}
    <div id="modul-empty-search"
        class="hidden rounded-2xl sm:rounded-3xl border-2 border-dashed border-[#B2E7FC] bg-white p-12 text-center text-sm font-semibold text-[#465673] shadow-[0_4px_0_#DCEFFF]">
        <div class="text-4xl mb-2">🔍</div>
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
                <span id="modul-page-current" class="text-3xl sm:text-4xl font-heading font-black text-[#007FBE] tracking-tight leading-none">
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
                dot.className = 'w-2 h-2 rounded-full bg-[#007FBE] scale-125 transition-transform duration-150 pointer-events-none shadow-xs';
            } else {
                dot.className = 'w-2 h-2 rounded-full bg-[#B2E7FC] hover:bg-[#007FBE] transition-colors duration-150 cursor-pointer';
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
