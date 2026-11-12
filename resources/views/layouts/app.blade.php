<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arrava - Platform Belajar')</title>
    <!-- Google Fonts: Nunito Sans & Plus Jakarta Sans (Sesuai Arrava Siswa & Mobile) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,300..900;1,6..12,300..900&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CDN Tailwind CSS -->
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
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #F0F6FF;
            color: #12233F;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#F0F6FF] text-[#12233F] font-sans antialiased">
    @include('components.page-loader')
    @include('components.nav-buttons-sprite')
    @include('components.parallax-pixel-effect', ['sidebarOffset' => '16rem'])

    <div class="flex min-h-screen relative z-10">

        <!-- SIDEBAR -->
        <x-sidebar />

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0 flex flex-col relative z-10">

            <!-- TOPBAR / NAVBAR (Sesuai Tema Arrava Samudra 3D) -->
            <header
                class="h-16 bg-white/95 backdrop-blur-md border-b border-[#DCEFFF] flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-[0_2px_12px_rgba(0,127,190,0.04)]">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <button data-sidebar-toggle type="button"
                        class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#DCEFFF] text-[#465673] hover:bg-[#F0F6FF] hover:text-[#007FBE] transition"
                        aria-label="Buka Menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1 min-w-0">
                        @yield('header')
                    </div>
                </div>

                <!-- Bagian Kanan Header: Pengaturan Suara & Avatar Profil -->
                <div class="flex items-center gap-3 shrink-0 ml-4">
                    @include('components.sound-settings')
                    @yield('header-right')
                    @auth
                        @php $headerUser = Auth::user(); @endphp
                        <div class="group relative flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white ring-2 ring-[#DCEFFF] overflow-hidden shadow-xs" title="{{ $headerUser->nama }}">
                            @if(!empty($headerUser->foto_profil_url))
                                <img src="{{ $headerUser->foto_profil_url }}" alt="{{ $headerUser->nama }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-xs font-black text-[#007FBE]">
                                    {{ strtoupper(substr($headerUser->nama ?? 'U', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    @endauth
                </div>
            </header>

            <!-- KONTEN UTAMA -->
            <div class="flex-1">
                @yield('content')
            </div>

        </main>
    </div>

    @include('components.hover-effects')
    @include('components.logout-modal')
    @stack('scripts')
</body>

</html>