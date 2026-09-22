<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'eBooks' }}</title>
    
</head>
<body class="min-h-screen bg-[#f3f6fa] text-[#172033] antialiased">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="fixed inset-y-0 left-0 z-40 flex w-[240px] flex-col border-r border-[#e1e7ef] bg-white">
            <div class="flex h-[72px] items-center px-4">
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#3d82f6] text-white shadow-sm">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5V5.5Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20.5A2.5 2.5 0 0 1 6.5 18H20"/>
                        </svg>
                    </span>
                    <span class="text-[20px] font-bold tracking-tight text-[#172033]">eBooks</span>
                </a>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-4">
                <a href="{{ route('siswa.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium transition {{ request()->routeIs('siswa.dashboard') ? 'bg-[#edf5ff] font-semibold text-[#3180f7]' : 'text-[#48566d] hover:bg-[#f7f9fc]' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('siswa.modul') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium transition {{ request()->routeIs('siswa.modul') ? 'bg-[#edf5ff] font-semibold text-[#3180f7]' : 'text-[#48566d] hover:bg-[#f7f9fc]' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5V5.5Z"/>
                        <path d="M4 20.5A2.5 2.5 0 0 1 6.5 18H20"/>
                    </svg>
                    Belajar
                </a>

                <a href="{{ route('siswa.materi-video') }}" 
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium transition {{ request()->routeIs('siswa.materi-video') ? 'bg-[#edf5ff] font-semibold text-[#3180f7]' : 'text-[#48566d] hover:bg-[#f7f9fc]' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="m10 9 5 3-5 3V9Z"/>
                    </svg>
                    Materi Video
                </a>

                <a href="{{ route('siswa.latihan-soal') }}" 
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium transition {{ request()->routeIs('siswa.latihan-soal*') ? 'bg-[#edf5ff] font-semibold text-[#3180f7]' : 'text-[#48566d] hover:bg-[#f7f9fc]' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16v16H4z"/>
                        <path d="m8 12 2.5 2.5L16 9"/>
                    </svg>
                    Latihan Soal
                </a>

                <a href="{{ route('siswa.quiz') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium transition {{ request()->routeIs('siswa.quiz') ? 'bg-[#edf5ff] font-semibold text-[#3180f7]' : 'text-[#48566d] hover:bg-[#f7f9fc]' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M9.5 9a2.5 2.5 0 1 1 4.3 1.7c-.9.8-1.8 1.2-1.8 2.3"/>
                        <path d="M12 16.5h.01"/>
                    </svg>
                    Quiz
                </a>
            </nav>

            <div class="px-4 pb-5">
                <div class="border-t border-[#e3e8ef] pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-[14px] font-medium text-red-500 transition hover:bg-red-50">
                            <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 17l5-5-5-5"/>
                                <path d="M15 12H3"/>
                                <path d="M21 19V5a2 2 0 0 0-2-2h-6"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="ml-[240px] min-w-0 flex-1">
            <header class="flex h-[72px] items-center justify-between border-b border-[#e1e7ef] bg-white px-8">
                <div class="min-w-0 flex-1">
                    @yield('header')
                </div>

                <div class="ml-6 flex shrink-0 items-center gap-5">
                    <button class="flex items-center gap-2 text-sm text-[#526078]">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M3 12h18"/>
                            <path d="M12 3c2.5 2.7 3.7 5.7 3.7 9S14.5 18.3 12 21"/>
                            <path d="M12 3C9.5 5.7 8.3 8.7 8.3 12s1.2 6.3 3.7 9"/>
                        </svg>
                        ID
                        <span class="text-xs">⌄</span>
                    </button>

                    <button class="relative flex h-10 w-10 items-center justify-center rounded-full bg-[#f7f9fc] text-[#687892]">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                            <path d="M10 21h4"/>
                        </svg>
                        <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <div class="h-8 w-px bg-[#e4e8ee]"></div>

                    <div class="flex items-center gap-3">
                        @if(!empty(auth()->user()->foto_profil))
                            <img src="{{ asset('storage/'.auth()->user()->foto_profil) }}" class="h-9 w-9 rounded-full object-cover" alt="Profil">
                        @else
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#dbeafe] text-sm font-bold text-[#2563eb]">
                                {{ strtoupper(substr(auth()->user()->nama ?? 'S', 0, 1)) }}
                            </div>
                        @endif
                        <div class="leading-tight">
                            <div class="text-sm font-semibold text-[#172033]">{{ auth()->user()->nama ?? 'Siswa' }}</div>
                            <div class="text-xs text-[#8491a7]">Siswa</div>
                        </div>
                    </div>
                </div>
            </header>

            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
