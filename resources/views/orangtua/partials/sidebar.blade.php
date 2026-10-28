@php
    $user = Auth::user();
    $navItems = [
        ['label' => 'Dashboard',        'route' => 'orangtua.dashboard', 'icon' => 'dashboard',   'match' => 'orangtua/dashboard*'],
        ['label' => 'Anak Saya',        'route' => 'orangtua.dashboard', 'icon' => 'child',       'match' => 'orangtua/anak*'],
    ];
@endphp

{{-- Backdrop --}}
<div id="otBackdrop"
     class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden">
</div>

<aside id="otSidebar"
       class="fixed inset-y-0 left-0 z-50 flex h-screen w-60 -translate-x-full flex-col border-r border-slate-100 bg-white shadow-2xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:shadow-none shrink-0">


    {{-- Brand --}}
    <div class="flex items-center justify-between px-4 py-4 border-b border-slate-100">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-md shadow-indigo-500/25">
                A
            </div>
            <div class="leading-tight">
                <p class="text-[15px] font-bold text-slate-900">Arrava</p>
                <p class="text-[11px] text-slate-400">Portal Orang Tua</p>
            </div>
        </div>
        <button id="otSidebarClose" type="button"
                class="lg:hidden flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto thin-scroll px-3 py-4 space-y-0.5">
        {{-- Dashboard --}}
        <a href="{{ route('orangtua.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/dashboard*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Anak Saya --}}
        <a href="{{ route('orangtua.anak-saya') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/anak*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Anak Saya</span>
        </a>

        {{-- Separator --}}
        <div class="pt-3 pb-1 px-2">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400">Akademik</p>
        </div>

        {{-- Perkembangan Nilai --}}
        <a href="{{ route('orangtua.perkembangan-nilai') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/perkembangan*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span>Perkembangan Nilai</span>
        </a>

        {{-- Materi Pembelajaran --}}
        <a href="{{ route('orangtua.materi-pembelajaran') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/materi*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Materi Pembelajaran</span>
        </a>

        {{-- Riwayat Kuis --}}
        <a href="{{ route('orangtua.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-500 hover:bg-slate-50 hover:text-slate-700">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Riwayat Kuis</span>
        </a>

        {{-- Pencapaian --}}
        <a href="{{ route('orangtua.pencapaian') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/pencapaian*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <span>Pencapaian</span>
        </a>

        {{-- Aktivitas Belajar --}}
        <a href="{{ route('orangtua.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-500 hover:bg-slate-50 hover:text-slate-700">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Aktivitas Belajar</span>
        </a>

        {{-- Separator --}}
        <div class="pt-3 pb-1 px-2">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400">Pengaturan &amp; Akun</p>
        </div>

        <!-- {{-- Notifikasi --}}
        <a href="#"
           class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-500 hover:bg-slate-50 hover:text-slate-700">
            <span class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifikasi
            </span>
            <span class="h-2 w-2 rounded-full bg-red-500"></span>
        </a> -->

        {{-- Pengaturan --}}
        <a href="{{ route('orangtua.pengaturan') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                  {{ request()->is('orangtua/pengaturan*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Pengaturan</span>
        </a>
    </nav>

    {{-- Bottom: logout --}}
    <div class="px-3 py-4 border-t border-slate-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-red-50 hover:text-red-600 transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
