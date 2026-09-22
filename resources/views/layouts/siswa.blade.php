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

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <x-sidebar />

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- TOPBAR / NAVBAR -->
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="flex-1">
                    @yield('header')
                    @yield('header-left')
                </div>
            </header>

            <!-- KONTEN UTAMA -->
            <div class="flex-1">
                @yield('content')
            </div>

        </main>
    </div>

    @stack('scripts')
</body>
</html>
