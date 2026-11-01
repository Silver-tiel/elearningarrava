@php
    $activeTab = $activeTab ?? 'overview';
    $soalCount = isset($modul->soalModul) ? $modul->soalModul->count() : 0;
    $isQuizLulus = isset($progres) && $progres->quiz_lulus;
@endphp
<div class="mt-5 border-b border-[#dce4ed]">
    <div class="flex gap-7">
        <button type="button" data-tab="overview"
                class="tab-btn tab-btn-overview relative py-3 text-[13px] font-bold transition
                       {{ $activeTab === 'overview' ? 'text-indigo-600' : 'text-[#52617a] hover:text-indigo-600' }}">
            Overview
            <span class="tab-indicator absolute bottom-0 left-0 right-0 h-[2px] bg-indigo-600 {{ $activeTab === 'overview' ? '' : 'hidden' }}"></span>
        </button>

        <button type="button" data-tab="catatan"
                class="tab-btn tab-btn-catatan relative py-3 text-[13px] font-bold transition
                       {{ $activeTab === 'catatan' ? 'text-indigo-600' : 'text-[#52617a] hover:text-indigo-600' }}">
            Catatan
            <span class="tab-indicator absolute bottom-0 left-0 right-0 h-[2px] bg-indigo-600 {{ $activeTab === 'catatan' ? '' : 'hidden' }}"></span>
        </button>

        <button type="button" data-tab="kuis"
                class="tab-btn tab-btn-kuis relative py-3 text-[13px] font-bold transition flex items-center gap-1.5
                       {{ $activeTab === 'kuis' ? 'text-indigo-600' : 'text-[#52617a] hover:text-indigo-600' }}">
            <span>Kuis Modul</span>
            @if($isQuizLulus)
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">✓ Lulus</span>
            @elseif($soalCount > 0)
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700">{{ $soalCount }} Soal</span>
            @endif
            <span class="tab-indicator absolute bottom-0 left-0 right-0 h-[2px] bg-indigo-600 {{ $activeTab === 'kuis' ? '' : 'hidden' }}"></span>
        </button>
    </div>
</div>
