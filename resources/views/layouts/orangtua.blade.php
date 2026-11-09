<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Orang Tua - Arrava E-Learning')</title>
    <meta name="description"
        content="@yield('meta_description', 'Portal orang tua untuk memantau perkembangan belajar siswa di Arrava E-Learning.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Nunito Sans"', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        samudra: {
                            DEFAULT: '#007FBE',
                            dark: '#00628E',
                            light: '#DDF3FF',
                            bg: '#F0F6FF',
                            border: '#DCEFFF',
                            shadow: '#B2E7FC',
                        },
                        navy: {
                            ink: '#082765',
                            dark: '#12233F',
                            slate: '#465673',
                            muted: '#72839E',
                        }
                    },
                    boxShadow: {
                        '3d': '0 4px 0 #B2E7FC',
                        '3d-sm': '0 3px 0 #B2E7FC',
                        '3d-btn': '0 3px 0 #00628E',
                        '3d-amber': '0 3px 0 #F59E0B',
                        '3d-emerald': '0 3px 0 #059669',
                    }
                }
            }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,300..900;1,6..12,300..900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #F0F6FF;
            color: #12233F;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .stat-card {
            transition: box-shadow .15s, transform .15s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
            transform: translateY(-1px);
        }

        .chart-bar {
            transition: height .4s ease;
        }

        .progress-bar {
            transition: width .6s ease;
        }

        .badge-tuntas {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-selesai {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-remedial {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* scrollbar thin */
        .thin-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .thin-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#F0F6FF] text-[#12233F] antialiased">
    @include('components.parallax-pixel-effect', ['sidebarOffset' => '15rem'])

    <div class="flex min-h-screen relative z-10">

        {{-- SIDEBAR ORANG TUA --}}
        @include('orangtua.partials.sidebar')

        {{-- MAIN AREA --}}

        <main class="flex-1 min-w-0 flex flex-col lg:ml-60">
            {{-- TOPBAR (Sesuai Tema Arrava Samudra 3D) --}}
            <header
                class="h-16 bg-white/95 backdrop-blur-md border-b border-[#DCEFFF] flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30 shadow-[0_2px_12px_rgba(0,127,190,0.04)]">
                <div class="flex items-center gap-3">
                    <button id="otSidebarToggle" type="button"
                        class="lg:hidden flex h-10 w-10 items-center justify-center rounded-xl border border-[#DCEFFF] text-[#465673] hover:bg-[#F0F6FF] hover:text-[#007FBE] transition"
                        aria-label="Buka Menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    {{-- Breadcrumb --}}
                    <nav class="hidden sm:flex items-center gap-2 text-sm">
                        <span class="text-[#082765] font-extrabold flex items-center gap-1.5">
                            <span>🏠</span> Portal Orang Tua
                        </span>
                        <svg class="w-3.5 h-3.5 text-[#72839E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-[#007FBE] font-bold">@yield('breadcrumb', 'Dashboard')</span>
                    </nav>
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    {{-- Pengaturan Suara --}}
                    @include('components.sound-settings')

                    {{-- Aksi Tambahan / Notifikasi Presensi Khusus Dashboard --}}
                    @yield('header-right')

                    {{-- Avatar + nama orang tua --}}
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-9 h-9 rounded-full bg-[#DDF3FF] ring-2 ring-[#DCEFFF] flex items-center justify-center text-[#007FBE] font-black text-sm shrink-0 shadow-xs">
                            {{ strtoupper(substr(Auth::user()->nama ?? 'O', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <p class="text-sm font-black text-[#082765] leading-none">
                                {{ Auth::user()->nama ?? 'Orang Tua' }}</p>
                            <p class="text-[11px] font-bold text-[#72839E] mt-0.5">Wali Murid</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- KONTEN --}}
            <div class="flex-1">
                @yield('content')
            </div>

        </main>

        {{-- Modal Konfirmasi Logout (Reusable Component) --}}
        @include('components.logout-modal')
        @include('components.hover-effects')

        @stack('scripts')

        <script>
            // ---- Sidebar mobile toggle (Portal Orang Tua) ----
            (function () {
                var sidebar = document.getElementById('otSidebar');
                var backdrop = document.getElementById('otBackdrop');
                var toggle = document.getElementById('otSidebarToggle');
                var closeBtn = document.getElementById('otSidebarClose');
                if (!sidebar || !backdrop) return;

                function openSidebar() {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-100', 'pointer-events-auto');
                }
                function closeSidebar() {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                }

                if (toggle) toggle.addEventListener('click', openSidebar);
                if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
                backdrop.addEventListener('click', closeSidebar);
                window.addEventListener('resize', function () { if (window.innerWidth >= 1024) closeSidebar(); });
            })();
        </script>
    @include('components.niere-widget')
</body>

</html>