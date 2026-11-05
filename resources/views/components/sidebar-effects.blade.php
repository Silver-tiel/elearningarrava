<style>
    /* =======================================================
       Sidebar Pop-up Icon Tween & Floating Effect
       ======================================================= */
    .sidebar-menu-item {
        position: relative;
        overflow: visible !important;
        transition: background-color 0.18s ease, color 0.18s ease, transform 0.12s ease;
    }

    .sidebar-menu-item:active {
        transform: scale(0.98);
    }

    /* Container pembungkus icon pop-up di sisi kanan link */
    .sidebar-pop-wrap {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 20;
        line-height: 0;
    }

    /* Kotak pop-up dengan spring tween entry (scale 0.25 -> 1) */
    .sidebar-pop-box {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.25) translateY(6px) rotate(-8deg);
        transform-origin: center right;
        transition: opacity 0.28s cubic-bezier(0.34, 1.56, 0.64, 1),
                    transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        will-change: transform, opacity;
    }

    /* Tampil saat menu di-hover */
    .sidebar-menu-item:hover .sidebar-pop-box {
        opacity: 1;
        transform: scale(1.08) translateY(0) rotate(0deg);
    }

    /* Tampil saat menu sedang aktif di halaman saat ini */
    .sidebar-menu-item.is-active .sidebar-pop-box,
    .sidebar-menu-item[data-active="true"] .sidebar-pop-box {
        opacity: 1;
        transform: scale(1) translateY(0) rotate(0deg);
    }

    /* Sedikit membesar jika menu aktif di-hover lagi */
    .sidebar-menu-item.is-active:hover .sidebar-pop-box,
    .sidebar-menu-item[data-active="true"]:hover .sidebar-pop-box {
        transform: scale(1.08) translateY(0) rotate(0deg);
    }

    /* Gambar Icon Pixel Retro */
    .sidebar-pop-img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
        filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.18));
        pointer-events: none;
        user-select: none;
    }

    /* Animasi melayang / bobbing terus-menerus saat icon muncul (Opsi 4) */
    .sidebar-menu-item:hover .sidebar-pop-img,
    .sidebar-menu-item.is-active .sidebar-pop-img,
    .sidebar-menu-item[data-active="true"] .sidebar-pop-img {
        animation: sidebarIconBobFloat 2.2s ease-in-out infinite;
    }

    @keyframes sidebarIconBobFloat {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-4px) rotate(0.8deg);
        }
    }

    /* Tactile press feedback pada icon pop-up saat tombol diklik */
    .sidebar-menu-item:active .sidebar-pop-box {
        transform: scale(0.92) translateY(2px);
        transition: transform 0.08s ease;
    }

    /* =======================================================
       Sidebar Pixel Snow Scene Widget (Inspired by VS Code Pets)
       ======================================================= */
    .sidebar-snow-card {
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .sidebar-snow-card:active {
        transform: scale(0.98);
    }
    .sidebar-snow-pixel-img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
        image-rendering: -moz-crisp-edges;
        image-rendering: crisp-edges;
    }
</style>
