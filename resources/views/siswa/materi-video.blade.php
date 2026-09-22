@extends('layouts.siswa')

@section('header')
<h1 class="text-[20px] font-bold text-[#172033]">{{ $modul->jenjang->nama_jenjang ?? 'Materi Video' }}</h1>
@endsection

@section('content')
<div class="h-[calc(100vh-72px)] p-8">
    <div class="grid h-full grid-cols-[340px_minmax(0,1fr)] gap-6">
        <section class="overflow-hidden rounded-2xl border border-[#dce4ed] bg-white">
            <div class="px-5 pb-3 pt-5"><h2 class="text-[16px] font-bold">Daftar Materi</h2></div>
            <div class="space-y-1 px-3 pb-4">
                @forelse($modul->materiVideo as $index => $item)
                    <button class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left {{ request('v') == $item->id_materi || ($index == 0 && !request('v')) ? 'bg-[#edf5ff] text-[#3180f7]' : 'text-[#52617a] hover:bg-[#f7f9fc]' }}">
                        @if($item->status == 'draft')
                            <span class="text-[#9aacc4]">♙</span>
                        @else
                            <span>▷</span>
                        @endif
                        <span class="flex-1 text-[13px] font-medium">{{ sprintf('%02d', $index+1) }}. {{ $item->judul }}</span>
                        <span class="text-xs text-[#8797ae]">{{ $item->durasi ?? '00:00' }}</span>
                    </button>
                @empty
                    <div class="px-3 py-4 text-center text-sm text-[#8797ae]">Belum ada video.</div>
                @endforelse
            </div>
        </section>

        <section class="min-w-0">
            <div class="relative aspect-video max-h-[400px] overflow-hidden rounded-2xl bg-[#15261b]">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-[38px] font-semibold text-[#9af3ca] md:text-[42px]">ax² + bx + c = 0</div>
                        <div class="mt-3 text-[17px] text-white/90">x = (-b ± √(b² − 4ac)) / 2a</div>
                    </div>
                </div>
                <div class="absolute bottom-4 left-4 right-4 flex h-12 items-center gap-4 rounded-xl bg-black/50 px-4">
                    <button class="text-white">▷</button>
                    <div class="h-1 flex-1 rounded-full bg-white/30"><div class="h-full w-[28%] rounded-full bg-white/70"></div></div>
                    <span class="text-[11px] text-white">04:12 / 15:30</span>
                    <span class="text-white">⛶</span>
                </div>
            </div>

            <div class="mt-6 flex items-start justify-between gap-5">
                <div>
                    <h1 class="text-[23px] font-bold text-[#172033]">{{ $modul->judul_modul }}</h1>
                    <p class="mt-1 text-[13px] text-[#687892]">{{ $modul->tipeModul->nama_tipe ?? '' }} • {{ $modul->jenjang->nama_jenjang ?? '' }}</p>
                </div>
                <div class="flex gap-3">
                    <button class="rounded-lg border border-[#dce4ed] bg-white px-4 py-2 text-[13px] font-medium text-[#52617a]">Sebelumnya</button>
                    <button class="rounded-lg bg-[#3d82f6] px-5 py-2 text-[13px] font-semibold text-white">Selanjutnya</button>
                </div>
            </div>

            <div class="mt-4 border-b border-[#dce4ed]">
                <div class="flex gap-7">
                    <button class="relative py-3 text-[14px] font-medium text-[#3180f7]">Overview<span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#3180f7]"></span></button>
                    <button class="py-3 text-[14px] text-[#52617a]">Catatan</button>
                    <button class="py-3 text-[14px] text-[#52617a]">Bookmark</button>
                </div>
            </div>

            <p class="max-w-[850px] pt-4 text-[14px] leading-6 text-[#52617a]">Pada bab ini, kamu akan mempelajari cara menyelesaikan persamaan kuadrat dengan mudah. Kita akan membedah karakteristik akar-akar menggunakan nilai Diskriminan (D) serta trik cepat menghafal rumus ABC yang melegenda. Silakan unduh modul rangkuman di menu bookmark jika diperlukan.</p>
        </section>
    </div>
</div>
@endsection
