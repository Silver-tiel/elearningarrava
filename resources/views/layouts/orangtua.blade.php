<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Orang Tua - Arrava E-Learning')</title>
    <meta name="description" content="@yield('meta_description', 'Portal orang tua untuk memantau perkembangan belajar siswa di Arrava E-Learning.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .stat-card { transition: box-shadow .15s, transform .15s; }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); transform: translateY(-1px); }
        .chart-bar { transition: height .4s ease; }
        .progress-bar { transition: width .6s ease; }
        .badge-tuntas   { background:#dcfce7; color:#15803d; }
        .badge-selesai  { background:#dbeafe; color:#1d4ed8; }
        .badge-remedial { background:#fee2e2; color:#b91c1c; }
        /* scrollbar thin */
        .thin-scroll::-webkit-scrollbar { width:4px; }
        .thin-scroll::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:4px; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased">


<div class="flex min-h-screen">

    {{-- SIDEBAR ORANG TUA --}}
    @include('orangtua.partials.sidebar')

    {{-- MAIN AREA --}}
    
    <main class="flex-1 min-w-0 flex flex-col lg:ml-60">    
        {{-- TOPBAR --}}
        <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3">
                <button id="otSidebarToggle" type="button"
                        class="lg:hidden flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition"
                        aria-label="Buka Menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                {{-- Breadcrumb --}}
                <nav class="hidden sm:flex items-center gap-1.5 text-sm text-slate-400">
                    <span class="text-slate-600 font-medium">Portal Orang Tua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span>@yield('breadcrumb', 'Dashboard')</span>
                </nav>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                {{-- Notifikasi placeholder --}}
                <button class="relative flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                {{-- Avatar + nama orang tua --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'O', 0, 2)) }}
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-slate-800 leading-none">{{ Auth::user()->nama ?? 'Orang Tua' }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Wali Murid / Orang Tua</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- KONTEN --}}
        <div class="flex-1">
            @yield('content')
        </div>

    </main>
</div>

<script>
(function () {
    const sidebar  = document.getElementById('otSidebar');
    const backdrop = document.getElementById('otBackdrop');
    const toggle   = document.getElementById('otSidebarToggle');
    const closeBtn = document.getElementById('otSidebarClose');
    if (!sidebar || !backdrop) return;

    function open() {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100', 'pointer-events-auto');
    }
    function close() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100', 'pointer-events-auto');
    }

    toggle?.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    backdrop.addEventListener('click', close);
    window.addEventListener('resize', () => { if (window.innerWidth >= 1024) close(); });
})();
</script>

@stack('scripts')
</body>
</html>
