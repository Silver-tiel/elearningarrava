@php
    $user = Auth::user();
    $role = $user->role ?? 'siswa';
@endphp

<aside class="w-64 h-screen sticky top-0 bg-white border-r border-gray-100 flex flex-col justify-between p-4 shrink-0">

    <!-- Top Section -->
    <div class="space-y-6">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-2">
            <div class="bg-blue-600 text-white font-bold rounded-xl text-xl flex items-center justify-center w-10 h-10 shrink-0 shadow-md shadow-blue-500/20">
                eB
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">
                eBooks
            </span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">

            {{-- ================= ADMIN ================= --}}
            @if ($role === 'admin')

                <a href="{{ route('admin') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('admin') || request()->is('admin/dashboard*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>

                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.modul') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('admin/modul*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18 5.754 18 7.5 18s3.332.477 4.5 1.253">
                        </path>
                    </svg>

                    <span>Modul</span>
                </a>

                <a href="{{ route('admin.quiz') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('admin/quiz*') || request()->is('admin/soal*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>

                    <span>Quiz</span>
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-slate-500 hover:bg-gray-50 transition">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857">
                        </path>
                    </svg>

                    <span>Guru</span>
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-slate-500 hover:bg-gray-50 transition">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10">
                        </path>
                    </svg>

                    <span>Hasil Belajar</span>
                </a>


            {{-- ================= GURU ================= --}}
            @elseif ($role === 'guru')

                <a href="{{ route('guru.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('guru/dashboard*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3">
                        </path>
                    </svg>

                    <span>Dashboard</span>
                </a>

                <a href="{{ route('guru.modul') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('guru/modul*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13">
                        </path>
                    </svg>

                    <span>Modul</span>
                </a>

                <a href="{{ route('guru.quiz') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('guru/quiz*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3">
                        </path>
                    </svg>

                    <span>Quiz</span>
                </a>

                <a href="{{ route('guru.hasil') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('guru/hasil*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6">
                        </path>
                    </svg>

                    <span>Hasil Belajar</span>
                </a>


            {{-- ================= SISWA ================= --}}
            @elseif ($role === 'siswa')

                <a href="{{ route('siswa.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('siswa/dashboard*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3">
                        </path>
                    </svg>

                    <span>Dashboard</span>
                </a>

                <a href="{{ route('siswa.modul') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('siswa/modul*') || request()->is('siswa/belajar*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5">
                        </path>
                    </svg>

                    <span>Belajar</span>
                </a>

                <a href="{{ route('siswa.quiz') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition
                   {{ request()->is('siswa/quiz*')
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-slate-500 hover:bg-gray-50' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8.228 9c.549-1.165 2.03-2 3.772-2">
                        </path>
                    </svg>

                    <span>Quiz</span>
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-slate-500 hover:bg-gray-50 transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14">
                        </path>
                    </svg>

                    <span>Profil</span>
                </a>

            @endif

        </nav>
    </div>


    <!-- Bottom Section -->
    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">

        <div class="flex items-center gap-3 overflow-hidden">

            <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 shrink-0">
                {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
            </div>

            <div class="truncate">
                <h4 class="text-sm font-semibold text-gray-900 leading-tight truncate">
                    {{ $user->nama ?? 'User' }}
                </h4>

                <p class="text-xs text-gray-400 capitalize truncate">
                    {{ $role }}
                </p>
            </div>

        </div>

        <form action="{{ route('logout') }}" method="POST" class="shrink-0">
            @csrf

            <button type="submit"
                    class="text-slate-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition"
                    title="Logout">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>

            </button>
        </form>

    </div>

</aside>