<!-- SVG Sprite Navigation Buttons (#btn-left & #btn-right) -->
<svg width="0" height="0" class="sr-only" style="position: absolute; width: 0; height: 0; overflow: hidden; pointer-events: none;" aria-hidden="true" focusable="false">
    <defs>
        <symbol id="btn-left" viewBox="0 0 96 96">
            <image href="{{ asset('assets/widget/nextLeftButton.webp') }}" width="96" height="96" style="image-rendering: pixelated; shape-rendering: crispEdges;" />
        </symbol>
        <symbol id="btn-right" viewBox="0 0 96 96">
            <image href="{{ asset('assets/widget/nextRightButton.webp') }}" width="96" height="96" style="image-rendering: pixelated; shape-rendering: crispEdges;" />
        </symbol>
    </defs>
</svg>

<style>
    /* =======================================================
       Retro Pixel Art Navigation Buttons (.nav-btn)
       ======================================================= */
    .nav-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        padding: 0;
        border: none;
        background: transparent;
        cursor: pointer;
        outline: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        position: relative;
        transition: transform 0.16s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.15s ease, filter 0.15s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .nav-btn svg {
        width: 100%;
        height: 100%;
        display: block;
        image-rendering: -moz-crisp-edges;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
        pointer-events: none;
        filter: drop-shadow(0 3px 5px rgba(30, 41, 59, 0.15));
        transition: transform 0.16s cubic-bezier(0.34, 1.56, 0.64, 1), filter 0.16s ease;
    }

    /* Hover effect */
    .nav-btn:hover:not(:disabled):not([aria-disabled="true"]) {
        transform: translateY(-2px);
    }

    .nav-btn:hover:not(:disabled):not([aria-disabled="true"]) svg {
        filter: drop-shadow(0 6px 14px rgba(37, 99, 235, 0.35)) brightness(1.08);
        transform: scale(1.06);
    }

    /* Active press feedback */
    .nav-btn:active:not(:disabled):not([aria-disabled="true"]) {
        transform: translateY(1px);
    }

    .nav-btn:active:not(:disabled):not([aria-disabled="true"]) svg {
        filter: drop-shadow(0 1px 2px rgba(37, 99, 235, 0.2)) brightness(0.94);
        transform: scale(0.94);
    }

    /* Disabled state */
    .nav-btn:disabled,
    .nav-btn[aria-disabled="true"] {
        opacity: 0.35;
        cursor: not-allowed;
        filter: grayscale(85%);
        pointer-events: none;
        transform: none !important;
    }

    /* Focus accessibility */
    .nav-btn:focus-visible {
        border-radius: 12px;
        outline: 2px solid #3b82f6;
        outline-offset: 3px;
    }
</style>

<script>
    /**
     * snap()
     * Menjaga ukuran tombol pas di piksel layar supaya garis border tipisnya tetap rata
     */
    function snapNavButtons() {
        const dpr = window.devicePixelRatio || 1;
        document.querySelectorAll('.nav-btn').forEach(btn => {
            const baseSize = window.innerWidth < 640 ? 58 : 68; // Target base size in CSS px
            const snapped = Math.round(baseSize * dpr) / dpr;
            btn.style.width = snapped + 'px';
            btn.style.height = snapped + 'px';
        });
    }

    if (typeof window.snap !== 'function') {
        window.snap = snapNavButtons;
    }

    window.addEventListener('resize', snapNavButtons);
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', snapNavButtons);
    } else {
        snapNavButtons();
    }
</script>
