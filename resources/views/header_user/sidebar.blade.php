<aside class="w-64 h-screen sticky top-0 bg-white border-r border-gray-100 flex flex-col justify-between p-4 shrink-0">
    <!-- Section Atas -->
    <div class="space-y-6">
        <!-- Brand Logo -->
        <div class="flex items-center gap-3 px-2">
            <div class="bg-blue-600 text-white font-bold rounded-xl text-xl flex items-center justify-center w-10 h-10 shrink-0">
                eB
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">eBooks</span>
        </div>

        <!-- Menu Navigasi Siswa -->
        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ url('/siswa/dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/dashboard*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Belajar -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/belajar*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Belajar</span>
            </a>

            <!-- Latihan Soal -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/latihan*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Latihan Soal</span>
            </a>

            <!-- Quiz -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/quiz*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Quiz</span>
            </a>

            <!-- Try Out -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/tryout*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                <span>Try Out</span>
            </a>

            <!-- Achievement -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/achievement*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <span>Achievement</span>
            </a>

            <!-- Profil -->
            <a href="#" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->is('siswa/profil*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil</span>
            </a>
        </nav>
    </div>

    <!-- Section Keluar Atas Form -->
    <div class="pt-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full text-left rounded-xl text-red-500 hover:bg-red-50 font-medium text-sm transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>