@php
    $sidebarHidden = ($hideSidebar ?? false) || View::hasSection('hideSidebar');
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arrava - Platform Belajar')</title>
    <!-- Google Fonts: Nunito Sans & Plus Jakarta Sans (Sesuai Arrava Mobile) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito+Sans:ital,opsz,wght@0,6..12,300..900;1,6..12,300..900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Nunito Sans"', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Fredoka"', 'sans-serif'],
                    },
                    colors: {
                        ink: '#0f3a5f',
                        paper: '#f7fcff',
                        samudra: {
                            DEFAULT: '#007FBE',
                            dark: '#00628E',
                            light: '#DDF3FF',
                            bg: '#F0F6FF',
                            border: '#DCEFFF',
                            shadow: '#B2E7FC',
                        },
                        navy: {
                            ink: '#12233F',
                            slate: '#465673',
                            muted: '#72839E',
                        }
                    },
                    boxShadow: {
                        'card': '0 8px 0 #0f3a5f',
                        'btn': '0 5px 0 #0f3a5f',
                        'btn-down': '0 1px 0 #0f3a5f',
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
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #F0F6FF;
            color: #12233F;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#F0F6FF] text-[#12233F] font-sans antialiased {{ $sidebarHidden ? 'sidebar-hidden' : '' }}">
    @include('components.page-loader')
    <x-level-up-modal />
    @include('components.nav-buttons-sprite')
    @include('components.parallax-pixel-effect', ['sidebarOffset' => '16rem'])

    <div class="flex min-h-screen relative z-10">

        <!-- SIDEBAR -->
        @unless($sidebarHidden)
            <x-sidebar />
        @endunless

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0 flex flex-col relative z-10">

            <!-- TOPBAR / NAVBAR (Sesuai Tema Arrava Mobile) -->
            <header
                class="min-h-16 bg-white/95 backdrop-blur-md border-b border-[#DCEFFF] flex items-center justify-between gap-3 px-4 py-2 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-[0_2px_12px_rgba(0,127,190,0.04)]">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <!-- Tombol Garis 3 (Hamburger Menu) untuk Layar Kecil -->
                    @unless($sidebarHidden)
                        <button data-sidebar-toggle type="button"
                            class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#DCEFFF] text-[#465673] hover:bg-[#F0F6FF] hover:text-[#007FBE] transition"
                            aria-label="Buka Menu">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @endunless

                    <div class="flex flex-1 min-w-0 items-center justify-between gap-4">
                        @yield('header')
                        @yield('header-left')
                    </div>
                </div>

                <!-- Bagian Kanan Header: Pengaturan Suara & Aksi Tambahan -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0 ml-2 sm:ml-4">
                    @include('components.sound-settings')
                    @yield('header-right')
                    @auth
                        @php
                            $headerUser = Auth::user();
                        @endphp
                        <a href="{{ route('siswa.profil') }}" class="group flex items-center gap-2 rounded-xl border border-[#DCEFFF] bg-[#F0F6FF]/70 px-2 py-1.5 transition hover:border-[#007FBE] sm:px-2.5" title="Profil {{ $headerUser->nama }}">
                            <span class="hidden max-w-32 truncate text-sm font-bold text-[#082765] lg:block">
                                {{ $headerUser->nama }}
                            </span>
                            <span class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white ring-2 ring-[#DCEFFF] transition group-hover:ring-[#007FBE] overflow-hidden shadow-xs">
                                @if(!empty($headerUser->foto_profil_url))
                                    <img src="{{ $headerUser->foto_profil_url }}" alt="{{ $headerUser->nama }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-extrabold text-[#007FBE] group-hover:scale-110 transition">
                                        {{ strtoupper(substr($headerUser->nama ?? 'U', 0, 1)) }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    @endauth
                </div>
            </header>

            <!-- KONTEN UTAMA -->
            <div class="flex-1 relative z-10">
                @yield('content')
            </div>

        </main>
    </div>

    @include('components.hover-effects')
    @include('components.logout-modal')
    @if(!View::hasSection('hideNiere') && empty($hideNiere) && request()->routeIs('siswa.dashboard'))
        @include('components.niere-widget')
    @endif
    @stack('scripts')
</body>

</html>