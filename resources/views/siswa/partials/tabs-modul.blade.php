@php $activeTab = $activeTab ?? 'overview'; @endphp
<div class="mt-5 border-b border-[#dce4ed]">
    <div class="flex gap-7">
        <a href="{{ route('siswa.modul.materi', $modul->id_modul) }}"
           class="relative py-3 text-[13px] font-bold transition
                  {{ $activeTab === 'overview' ? 'text-[#3180f7]' : 'text-[#52617a] hover:text-[#3180f7]' }}">
            Overview
            @if($activeTab === 'overview')
                <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#3180f7]"></span>
            @endif
        </a>

        <button type="button" data-tab="catatan"
                class="tab-catatan relative py-3 text-[13px] font-bold transition
                       {{ $activeTab === 'catatan' ? 'text-[#3180f7]' : 'text-[#52617a] hover:text-[#3180f7]' }}">
            Catatan
            @if($activeTab === 'catatan')
                <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#3180f7]"></span>
            @endif
        </button>

        <a href="{{ route('siswa.modul.latihan', $modul->id_modul) }}"
           class="relative py-3 text-[13px] font-bold transition
                  {{ $activeTab === 'latihan' ? 'text-[#3180f7]' : 'text-[#52617a] hover:text-[#3180f7]' }}">
            Latihan Soal
            @if($activeTab === 'latihan')
                <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#3180f7]"></span>
            @endif
        </a>
    </div>
</div>
