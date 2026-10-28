@props([
    'url',
    'title' => 'Dokumen PDF',
    'height' => 'h-[580px]',
    'onComplete' => null
])

@php
    $viewerId = 'pdf_viewer_' . uniqid();
@endphp

{{-- Muat PDF.js library via CDN jika belum ada --}}
<script>
    if (typeof window.pdfjsLib === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
        script.onload = () => {
            window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
            window.dispatchEvent(new Event('pdfjs-ready'));
        };
        document.head.appendChild(script);
    }
</script>

<div id="{{ $viewerId }}" 
     tabindex="0"
     class="custom-pdf-viewer w-full {{ $height }} bg-slate-900 rounded-2xl overflow-hidden shadow-md border border-slate-700 flex flex-col relative select-none focus:outline-none focus:ring-2 focus:ring-blue-500/50">
    
    <!-- Area Canvas Slide (Non-scrollable, fit center) -->
    <div class="pdf-canvas-wrapper flex-1 w-full h-full overflow-hidden flex items-center justify-center relative bg-slate-950 p-2 sm:p-4">
        <!-- Spinner Loading -->
        <div class="pdf-loader absolute inset-0 flex flex-col items-center justify-center bg-slate-950/80 z-20 transition-opacity duration-200">
            <div class="w-10 h-10 border-4 border-blue-500/30 border-t-blue-500 rounded-full animate-spin mb-3"></div>
            <p class="text-xs font-semibold text-slate-300">Memuat Dokumen...</p>
        </div>

        <!-- Canvas Tempat Rendering Halaman PDF -->
        <canvas class="pdf-canvas max-w-full max-h-full object-contain rounded shadow-2xl transition-transform duration-150 ease-out"></canvas>
    </div>

    <!-- Toolbar Bawah (Next & Prev Center, Zoom & Fullscreen Kanan) -->
    <div class="pdf-toolbar bg-slate-900 border-t border-slate-800 px-3 sm:px-5 py-2.5 flex items-center justify-between text-white text-xs z-10 shrink-0">
        
        <!-- Sisi Kiri: Judul Dokumen Ringkas -->
        <div class="flex items-center gap-2 min-w-0 w-1/4">
            <span class="px-2 py-0.5 rounded bg-rose-600/20 text-rose-400 font-bold text-[10px] uppercase tracking-wider border border-rose-500/30 shrink-0">PDF</span>
            <span class="text-slate-400 truncate text-[11px] hidden md:inline" title="{{ $title }}">{{ $title }}</span>
        </div>

        <!-- Bagian Tengah: Navigasi Prev & Next (CENTERED) -->
        <div class="flex items-center justify-center gap-2 sm:gap-3 flex-1">
            <!-- Tombol Sebelumnya (Prev) -->
            <button type="button" class="btn-prev px-3 sm:px-4 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 active:scale-95 disabled:opacity-30 disabled:pointer-events-none border border-slate-700 text-slate-200 font-semibold transition flex items-center gap-1.5 shadow-sm" title="Halaman Sebelumnya (Panah Kiri)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                <span class="hidden sm:inline text-xs">Sebelumnya</span>
            </button>

            <!-- Indikator Halaman -->
            <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-950 rounded-xl border border-slate-800 font-mono text-xs font-semibold">
                <span class="page-num text-blue-400 font-bold">1</span>
                <span class="text-slate-500">/</span>
                <span class="page-count text-slate-300">1</span>
            </div>

            <!-- Tombol Berikutnya (Next) -->
            <button type="button" class="btn-next px-3 sm:px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 active:scale-95 disabled:opacity-30 disabled:pointer-events-none text-white font-semibold transition flex items-center gap-1.5 shadow-sm" title="Halaman Berikutnya (Panah Kanan)">
                <span class="hidden sm:inline text-xs">Berikutnya</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <!-- Sisi Kanan: Kontrol Zoom In/Out & Layar Penuh -->
        <div class="flex items-center justify-end gap-1 sm:gap-1.5 w-1/4">
            <!-- Zoom Out -->
            <button type="button" class="btn-zoom-out p-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 active:scale-95 text-slate-300 border border-slate-700 transition" title="Perkecil (-)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </button>

            <!-- Reset / Teks Zoom -->
            <button type="button" class="btn-zoom-reset px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 active:scale-95 text-slate-300 font-mono text-[11px] border border-slate-700 transition hidden sm:inline" title="Reset Zoom">
                <span class="zoom-text font-bold">Fit</span>
            </button>

            <!-- Zoom In -->
            <button type="button" class="btn-zoom-in p-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 active:scale-95 text-slate-300 border border-slate-700 transition" title="Perbesar (+)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>

            <!-- Fullscreen -->
            <button type="button" class="btn-fullscreen p-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 active:scale-95 text-slate-300 border border-slate-700 transition ml-1" title="Mode Layar Penuh">
                <svg class="w-4 h-4 icon-fullscreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                <svg class="w-4 h-4 icon-exit-fullscreen hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>
</div>

<script>
(function() {
    const viewer = document.getElementById('{{ $viewerId }}');
    if (!viewer) return;

    const wrapper = viewer.querySelector('.pdf-canvas-wrapper');
    const canvas = viewer.querySelector('.pdf-canvas');
    const ctx = canvas.getContext('2d');
    const loader = viewer.querySelector('.pdf-loader');
    const pageNumSpan = viewer.querySelector('.page-num');
    const pageCountSpan = viewer.querySelector('.page-count');
    const btnPrev = viewer.querySelector('.btn-prev');
    const btnNext = viewer.querySelector('.btn-next');
    const btnZoomIn = viewer.querySelector('.btn-zoom-in');
    const btnZoomOut = viewer.querySelector('.btn-zoom-out');
    const btnZoomReset = viewer.querySelector('.btn-zoom-reset');
    const zoomText = viewer.querySelector('.zoom-text');
    const btnFullscreen = viewer.querySelector('.btn-fullscreen');
    const iconFullscreen = viewer.querySelector('.icon-fullscreen');
    const iconExitFullscreen = viewer.querySelector('.icon-exit-fullscreen');

    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let zoomScale = null; // null = Fit to container
    let renderTask = null;

    function initViewer() {
        if (!window.pdfjsLib) {
            window.addEventListener('pdfjs-ready', initViewer, { once: true });
            return;
        }

        const url = @json($url);
        if (!url) {
            loader.innerHTML = '<p class="text-xs text-rose-400">URL Berkas tidak ditemukan.</p>';
            return;
        }

        pdfjsLib.getDocument({
            url: url,
            cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
            cMapPacked: true,
        }).promise.then(doc => {
            pdfDoc = doc;
            pageCountSpan.textContent = pdfDoc.numPages;
            renderPage(pageNum);
        }).catch(err => {
            console.error('Gagal memuat PDF:', err);
            loader.innerHTML = '<p class="text-xs text-rose-400 px-4 text-center">Gagal memuat berkas PDF. Pastikan format berkas valid.</p>';
        });
    }

    function renderPage(num) {
        pageRendering = true;
        loader.classList.remove('opacity-0', 'pointer-events-none');

        if (renderTask) {
            renderTask.cancel();
            renderTask = null;
        }

        pdfDoc.getPage(num).then(page => {
            const containerWidth = wrapper.clientWidth - 24;
            const containerHeight = wrapper.clientHeight - 24;

            // Dapatkan ukuran asli halaman pada scale 1.0
            const unscaledViewport = page.getViewport({ scale: 1.0 });

            // Hitung scale agar pas dengan kontainer layar (Fit Screen tanpa scroll)
            const widthScale = containerWidth / unscaledViewport.width;
            const heightScale = containerHeight / unscaledViewport.height;
            const fitScale = Math.min(widthScale, heightScale);

            // Terapkan scale (Fit atau Zoom manual)
            const currentScale = zoomScale !== null ? fitScale * zoomScale : fitScale;
            const viewport = page.getViewport({ scale: currentScale });

            // Support retina / high-DPI display
            const outputScale = window.devicePixelRatio || 1;
            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width = Math.floor(viewport.width) + "px";
            canvas.style.height = Math.floor(viewport.height) + "px";

            const transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

            const renderContext = {
                canvasContext: ctx,
                transform: transform,
                viewport: viewport
            };

            renderTask = page.render(renderContext);

            renderTask.promise.then(() => {
                pageRendering = false;
                loader.classList.add('opacity-0', 'pointer-events-none');

                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            }).catch(err => {
                if (err.name !== 'RenderingCancelledException') {
                    console.error('Error render halaman:', err);
                }
            });

            // Update UI Toolbar
            pageNumSpan.textContent = num;
            btnPrev.disabled = (num <= 1);
            btnNext.disabled = (num >= pdfDoc.numPages);
            updateZoomUI();

            // Callback ketika mencapai halaman terakhir
            if (num >= pdfDoc.numPages) {
                @if(!empty($onComplete))
                    if (typeof window['{{ $onComplete }}'] === 'function') {
                        window['{{ $onComplete }}']();
                    }
                @endif
                viewer.dispatchEvent(new CustomEvent('pdf-complete', { detail: { page: num, total: pdfDoc.numPages } }));
            }
        });
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    // Tombol Navigasi Bawah
    btnPrev.addEventListener('click', onPrevPage);
    btnNext.addEventListener('click', onNextPage);

    // Navigasi Keyboard (Panah Kiri & Kanan)
    viewer.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            onPrevPage();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            onNextPage();
        }
    });

    function updateZoomUI() {
        const currentPct = zoomScale !== null ? Math.round(zoomScale * 100) : 100;
        if (zoomText) {
            zoomText.textContent = (zoomScale === null) ? 'Fit' : currentPct + '%';
        }
        if (btnZoomIn) {
            const isMax = (zoomScale !== null && zoomScale >= 1.0);
            btnZoomIn.disabled = isMax;
            btnZoomIn.classList.toggle('opacity-30', isMax);
            btnZoomIn.classList.toggle('pointer-events-none', isMax);
        }
        if (btnZoomOut) {
            const isMin = (zoomScale !== null && zoomScale <= 0.25);
            btnZoomOut.disabled = isMin;
            btnZoomOut.classList.toggle('opacity-30', isMin);
            btnZoomOut.classList.toggle('pointer-events-none', isMin);
        }
    }

    // Kontrol Zoom In & Out (Maksimal 100% / 1.0 dan Minimal 25% / 0.25)
    btnZoomIn.addEventListener('click', () => {
        if (zoomScale === null) zoomScale = 1.0;
        if (zoomScale >= 1.0) return;
        zoomScale = Math.min(Math.round((zoomScale + 0.25) * 100) / 100, 1.0);
        updateZoomUI();
        queueRenderPage(pageNum);
    });

    btnZoomOut.addEventListener('click', () => {
        if (zoomScale === null) zoomScale = 1.0;
        if (zoomScale <= 0.25) return;
        zoomScale = Math.max(Math.round((zoomScale - 0.25) * 100) / 100, 0.25);
        updateZoomUI();
        queueRenderPage(pageNum);
    });

    btnZoomReset.addEventListener('click', () => {
        zoomScale = null;
        updateZoomUI();
        queueRenderPage(pageNum);
    });

    // Mode Fullscreen (Layar Penuh)
    btnFullscreen.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            if (viewer.requestFullscreen) {
                viewer.requestFullscreen();
            } else if (viewer.webkitRequestFullscreen) {
                viewer.webkitRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    });

    document.addEventListener('fullscreenchange', () => {
        const isFs = !!document.fullscreenElement;
        iconFullscreen.classList.toggle('hidden', isFs);
        iconExitFullscreen.classList.toggle('hidden', !isFs);

        // Render ulang halaman saat ukuran layar berganti ke/dari fullscreen
        setTimeout(() => {
            if (pdfDoc) queueRenderPage(pageNum);
        }, 150);
    });

    // Render ulang saat window resize agar selalu pas di layar
    window.addEventListener('resize', () => {
        if (pdfDoc && zoomScale === null) {
            queueRenderPage(pageNum);
        }
    });

    // Jalankan inisialisasi
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initViewer);
    } else {
        initViewer();
    }
})();
</script>

