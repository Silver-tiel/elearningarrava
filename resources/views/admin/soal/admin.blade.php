<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBooks - Dashboard Admin</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        @include('components.sidebar')

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0 flex flex-col">

            <!-- TOPBAR / NAVBAR -->
            <header
                class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-10">
                <h1 class="text-lg font-bold text-gray-900">Ringkasan Aktivitas Belajar</h1>

                <div class="flex items-center gap-4">
                    <!-- Icon Notifikasi -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                    <!-- Switch Bahasa -->
                    <button
                        class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                        <span>ID</span>
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- KONTEN UTAMA DASHBOARD -->
            <div class="p-8 space-y-6">

                <!-- GREETING SECTION -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        Selamat datang kembali, Admin 👋
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Berikut ringkasan aktivitas dan statistik platform hari ini.
                    </p>
                </div>

                <!-- STATS CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    <!-- Card 1: Total Siswa -->
                    <div
                        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">+12%</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-400">Total Siswa</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-0.5">1.248</h3>
                        </div>
                    </div>

                    <!-- Card 2: Total Guru -->
                    <div
                        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">+8%</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-400">Total Guru</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-0.5">156</h3>
                        </div>
                    </div>

                    <!-- Card 3: Total Orang Tua -->
                    <div
                        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">+15%</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-400">Total Orang Tua</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-0.5">2.450</h3>
                        </div>
                    </div>

                    <!-- Card 4: Total Kelas -->
                    <div
                        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">+4%</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-400">Total Kelas</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-0.5">28</h3>
                        </div>
                    </div>

                </div>

                <!-- MIDDLE SECTION: GRAFIK & SISWA TERBARU -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Grafik Aktivitas Belajar Siswa -->
                    <div
                        class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-900 text-sm">Aktivitas Belajar Siswa</h3>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Lihat Detail</a>
                        </div>

                        <!-- Visual Dummy Grafik Line -->
                        <div class="relative w-full h-48 my-2 flex flex-col justify-end">
                            <svg class="w-full h-full overflow-visible" viewBox="0 0 500 150"
                                preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#3B82F6" stop-opacity="0.2" />
                                        <stop offset="100%" stop-color="#3B82F6" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                                <path
                                    d="M0,110 L70,95 L140,115 L210,80 L280,95 L350,50 L420,60 L490,40 L490,150 L0,150 Z"
                                    fill="url(#chartGradient)" />
                                <path d="M0,110 L70,95 L140,115 L210,80 L280,95 L350,50 L420,60 L490,40" fill="none"
                                    stroke="#3B82F6" stroke-width="3" />
                                <circle cx="490" cy="40" r="4" fill="#3B82F6" stroke="#ffffff" stroke-width="2" />
                            </svg>
                        </div>

                        <!-- Keterangan Hari -->
                        <div class="flex justify-between text-xs text-gray-400 pt-4 border-t border-gray-50">
                            <span>Sen</span>
                            <span>Sel</span>
                            <span>Rab</span>
                            <span>Kam</span>
                            <span>Jum</span>
                            <span>Sab</span>
                            <span>Min</span>
                        </div>
                    </div>

                    <!-- List Siswa Terbaru -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-gray-900 text-sm">Siswa Terbaru</h3>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Lihat Semua</a>
                        </div>

                        <div class="space-y-4">
                            <!-- Siswa 1 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="https://i.pravatar.cc/100?img=11" alt="Ahmad Rayhan">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 leading-tight">Ahmad Rayhan</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Kelas 10 - IPA 1</p>
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400">5 menit yang lalu</span>
                            </div>

                            <!-- Siswa 2 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="https://i.pravatar.cc/100?img=5" alt="Siti Nurhaliza">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 leading-tight">Siti Nurhaliza</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Kelas 11 - IPS 3</p>
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400">12 menit yang lalu</span>
                            </div>

                            <!-- Siswa 3 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="https://i.pravatar.cc/100?img=12" alt="Rudi Santoso">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 leading-tight">Rudi Santoso</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Kelas 12 - IPA 2</p>
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400">1 jam yang lalu</span>
                            </div>

                            <!-- Siswa 4 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="https://i.pravatar.cc/100?img=9" alt="Dewi Lestari">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 leading-tight">Dewi Lestari</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Kelas 10 - IPS 1</p>
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400">2 jam yang lalu</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- BOTTOM SECTION: MATERI TERPOPULER & MODUL TERAKTIF -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Materi Terpopuler -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-sm mb-5">Materi Terpopuler</h3>

                        <div class="space-y-5">
                            <!-- Item 1 -->
                            <div>
                                <div class="flex justify-between text-xs font-semibold mb-1.5">
                                    <span class="text-gray-900">Matematika Suku Banyak</span>
                                    <span class="text-gray-400 font-normal">450 kali diakses</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-600 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>

                            <!-- Item 2 -->
                            <div>
                                <div class="flex justify-between text-xs font-semibold mb-1.5">
                                    <span class="text-gray-900">Bahasa Inggris - Tenses</span>
                                    <span class="text-gray-400 font-normal">389 kali diakses</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-600 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>

                            <!-- Item 3 -->
                            <div>
                                <div class="flex justify-between text-xs font-semibold mb-1.5">
                                    <span class="text-gray-900">Fisika - Optik Geometris</span>
                                    <span class="text-gray-400 font-normal">312 kali diakses</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modul Teraktif -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-sm mb-5">Modul Teraktif</h3>

                        <div class="space-y-4">
                            <!-- Modul 1 -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 leading-tight">IPA Terpadu SMA 10</h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Bab 3 - Sel & Genetika</p>
                                </div>
                            </div>

                            <!-- Modul 2 -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 leading-tight">Bahasa Inggris
                                        Conversation</h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Bab 5 - Dialogues</p>
                                </div>
                            </div>

                            <!-- Modul 3 -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 leading-tight">Kimia Asam Basa</h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Bab 1 - Stoikiometri</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

</body>

</html>