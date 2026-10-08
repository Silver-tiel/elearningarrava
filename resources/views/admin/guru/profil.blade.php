@extends('layouts.app')

@section('content')
<div class="p-8 space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Profil Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Informasi akun Anda yang terdaftar di Bimbel Arrava.</p>
    </div>

    <!-- PROFILE CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Banner + Avatar -->
        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
            <div class="absolute -bottom-12 left-8">
                <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center">
                    @if($user->foto_profil && Storage::disk('public')->exists($user->foto_profil))
                        <img src="{{ asset('storage/' . $user->foto_profil) }}"
                             alt="{{ $user->nama }}"
                             class="w-full h-full rounded-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-indigo-600">
                            {{ strtoupper(substr($user->nama ?? 'G', 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="pt-16 pb-8 px-8">

            <h2 class="text-xl font-bold text-slate-800">{{ $user->nama ?? '-' }}</h2>
            <p class="text-sm text-slate-500 mt-0.5">Guru</p>

            <div class="mt-6 grid gap-5 md:grid-cols-2">

                <!-- Email -->
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Email</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $user->email ?? '-' }}</p>
                    </div>
                </div>

                <!-- Nomor HP -->
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Nomor HP</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $user->nomor_hp ?? '-' }}</p>
                    </div>
                </div>

                <!-- Status Akun -->
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Status Akun</p>
                        <p class="text-sm font-semibold mt-0.5">
                            @if(($user->status_akun ?? 'aktif') === 'aktif')
                                <span class="inline-flex items-center gap-1 text-green-600">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-red-600">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Nonaktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Bergabung Sejak -->
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Bergabung Sejak</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">
                            {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

