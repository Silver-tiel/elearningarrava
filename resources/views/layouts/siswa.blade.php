<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'eBooks - Platform Belajar')</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased">
    @include('components.page-loader')
    <x-level-up-modal />
    @include('components.nav-buttons-sprite')

    @php
        $sidebarHidden = ($hideSidebar ?? false) || View::hasSection('hideSidebar');
    @endphp

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        @unless($sidebarHidden)
            <x-sidebar />
        @endunless

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- TOPBAR / NAVBAR -->
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <!-- Tombol Garis 3 (Hamburger Menu) untuk Layar Kecil -->
                    @unless($sidebarHidden)
                        <button data-sidebar-toggle type="button" class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 text-slate-600 hover:bg-slate-50 transition" aria-label="Buka Menu">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endunless

                    <div class="flex-1 min-w-0">
                        @yield('header')
                        @yield('header-left')
                    </div>
                </div>
            </header>

            <!-- KONTEN UTAMA -->
            <div class="flex-1">
                @yield('content')
            </div>

        </main>
    </div>

    @include('components.hover-effects')
    @stack('scripts')
</body>
</html>
