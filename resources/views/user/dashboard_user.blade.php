<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - eBooks</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR SISWA (DIPISAH) -->
        @include('header_user.sidebar_user')

        <!-- KONTEN UTAMA -->
        <main class="flex-1 min-w-0 flex flex-col">
            
            <!-- TOPBAR / NAVBAR -->
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-10">
                <h1 class="text-lg font-bold text-gray-900">Dashboard Utama</h1>
                
                <div class="flex items-center gap-5">
                    <!-- Switch Bahasa -->
                    <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <span>ID</span>
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Profile Siswa Topbar -->
                    <div class="flex items-center gap-3">
                        <img class="w-9 h-9 rounded-full object-cover border border-gray-200" src="https://i.pravatar.cc/100?img=12" alt="Fauzan">
                        <div class="text-left">
                            <h4 class="text-xs font-bold text-gray-900 leading-tight">Fauzan Mubarok</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">Siswa Kelas 10</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ISI KONTEN DASHBOARD SISWA -->
            <div class="p-8 space-y-6">
                
                <!-- BANNER WELCOME CARD (BLUE) -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-2xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                    <div class="max-w-xl z-10">
                        <h2 class="text-2xl font-bold flex items-center gap-2">
                            Halo, Fauzan! 👋
                        </h2>
                        <p class="text-xs md:text-sm text-blue-100 mt-2 leading-relaxed">
                            Tetap semangat belajarmu hari ini. Kamu memiliki 2 tugas baru dan 1 quiz menanti untuk diselesaikan. Yuk kejar prestasimu!
                        </p>
                    </div>
                    <!-- Gambar Ilustrasi Banner -->
                    <div class="w-32 h-24 md:w-44 md:h-28 shrink-0 rounded-xl overflow-hidden border-2 border-white/20 shadow-md">
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60" alt="Belajar Banner">
                    </div>
                </div>

                <!-- CARDS STATISTIK KINERJA SISWA -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1: Hari Streak -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-400 uppercase">HARI STREAK</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1 flex items-center gap-1.5">
                            7 Hari 🔥
                        </h3>
                        <span class="inline-block mt-3 text-[11px] font-medium text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md">
                            Konsisten belajar!
                        </span>
                    </div>

                    <!-- Card 2: Poin XP Hari Ini -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-400 uppercase">POIN XP HARI INI</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">+150 XP</h3>
                        <span class="inline-block mt-3 text-[11px] font-medium text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                            XP diperoleh hari ini
                        </span>
                    </div>

                    <!-- Card 3: Persentase Belajar -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-400 uppercase">PERSENTASE BELAJAR</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">87%</h3>
                        <span class="inline-block mt-3 text-[11px] font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">
                            Sangat baik
                        </span>
                    </div>

                    <!-- Card 4: Total XP Akumulatif -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-400 uppercase">TOTAL XP AKUMULATIF</p>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">1,250 XP</h3>
                        <span class="inline-block mt-3 text-[11px] font-medium text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md">
                            Level 12 • Smart Learner
                        </span>
                    </div>

                </div>

                <!-- SECTION TENGAH: PROGRESS MATERI & LATIHAN SOAL -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Kiri: Progress Kelas Aktif (2 Col Span) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Progress Card Matematika -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-bold text-gray-900">Matematika Kelas 10</h3>
                                        <span class="text-xs text-blue-600 font-medium">Materi: Persamaan Kuadrat</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-100 rounded-full mt-3 overflow-hidden">
                                        <div class="h-full bg-blue-600 rounded-full" style="width: 80%"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-gray-400 mt-2">
                                        <span>Progress: Bab 3 dari 10</span>
                                        <span class="font-semibold text-gray-700">80% Selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODUL PELAJARAN GRID -->
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm mb-4">Modul Pelajaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                
                                <!-- Modul Matematika -->
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <span class="text-[11px] text-gray-400">08:00 - 09:30</span>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-900">Matematika</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Tutor: Pak Budi</p>
                                    </div>
                                    <button class="w-full mt-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                                        Mulai Belajar
                                    </button>
                                </div>

                                <!-- Modul Bahasa Inggris -->
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                            </div>
                                            <span class="text-[11px] text-gray-400">10:00 - 11:30</span>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-900">Bahasa Inggris</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Tutor: Miss Jane</p>
                                    </div>
                                    <button class="w-full mt-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                                        Mulai Belajar
                                    </button>
                                </div>

                                <!-- Modul Fisika -->
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <span class="text-[11px] text-gray-400">13:00 - 14:30</span>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-900">Fisika</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Tutor: Bu Retno</p>
                                    </div>
                                    <button class="w-full mt-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                                        Mulai Belajar
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Kanan: Latihan Soal & Pencapaian Terbaru (1 Col Span) -->
                    <div class="space-y-6">
                        
                        <!-- Card Latihan Soal -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-900 text-sm mb-4">Latihan Soal</h3>

                            <div class="space-y-4">
                                <!-- Task 1 -->
                                <div class="flex items-center justify-between pb-3 border-b border-gray-50">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900">PR Trigonometri</h4>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Matematika</p>
                                    </div>
                                    <span class="text-[10px] font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Sisa 2 Jam</span>
                                </div>

                                <!-- Task 2 -->
                                <div class="flex items-center justify-between pb-3 border-b border-gray-50">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900">Latihan Reading 4</h4>
                                        <p class="text-[11px] text-gray-400 mt-0.5">B. Inggris</p>
                                    </div>
                                    <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">Besok, 23:59</span>
                                </div>

                                <!-- Task 3 -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900">Quiz Hukum Newton</h4>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Fisika</p>
                                    </div>
                                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">3 Hari Lagi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Pencapaian Terbaru -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-900 text-sm mb-4">Pencapaian Terbaru</h3>

                            <div class="grid grid-cols-3 gap-2 text-center">
                                <!-- Badge 1 -->
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-lg shadow-sm">
                                        🏅
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-600 mt-2">Scholar</span>
                                </div>

                                <!-- Badge 2 -->
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-lg shadow-sm">
                                        ⚡
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-600 mt-2">Super 7</span>
                                </div>

                                <!-- Badge 3 -->
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg shadow-sm">
                                        🛡️
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-600 mt-2">Expert</span>
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