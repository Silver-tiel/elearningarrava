@props([
    'title' => null,
    'icon' => null,
    'countId' => null,
    'countText' => null,
    'searchId' => 'studentStyleSearch',
    'searchName' => 'q',
    'searchValue' => '',
    'searchPlaceholder' => 'Cari...',
    'searchOnInput' => null,
    'resetId' => null,
    'resetUrl' => null,
    'showReset' => false,
    'showSearchClear' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-gradient-to-b from-[#AEE3F9]/55 via-[#E6F3FF]/65 to-white/95 p-4 sm:p-5 shadow-[0_4px_0_#DCEFFF] space-y-3.5']) }}>
    @if($title || $countText || $resetId || $resetUrl || isset($headerActions))
        <div class="flex flex-wrap items-center justify-between gap-2.5">
            @if($title)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#DCEFFF] shadow-xs">
                    @if($icon)
                        <span class="text-sm leading-none">{{ $icon }}</span>
                    @endif
                    <span class="text-xs font-black text-[#007FBE]">{{ $title }}</span>
                </div>
            @else
                <div></div>
            @endif

            <div class="flex flex-wrap items-center gap-2">
                @isset($headerActions)
                    {{ $headerActions }}
                @endisset

                @if($countText !== null)
                    <span @if($countId) id="{{ $countId }}" @endif
                        class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-[#DCEFFF] text-[11px] font-extrabold text-[#465673] shadow-xs">
                        {{ $countText }}
                    </span>
                @endif

                @if($resetUrl && !$resetId)
                    <a href="{{ $resetUrl }}"
                        class="{{ $showReset ? 'inline-flex' : 'hidden' }} items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-[#B2E7FC] text-[11px] font-extrabold text-[#007FBE] hover:bg-[#DDF3FF] transition shadow-xs">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset Filter</span>
                    </a>
                @elseif($resetId)
                    <button type="button" id="{{ $resetId }}"
                        @if($resetUrl) data-reset-url="{{ $resetUrl }}" @endif
                        class="{{ $showReset ? 'inline-flex' : 'hidden' }} items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-[#B2E7FC] text-[11px] font-extrabold text-[#007FBE] hover:bg-[#DDF3FF] transition shadow-xs cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset Filter</span>
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- Kolom Pencarian Gaya Siswa --}}
    <div class="relative">
        <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#007FBE]" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-4-4" />
        </svg>
        <input
            type="text"
            id="{{ $searchId }}"
            name="{{ $searchName }}"
            value="{{ $searchValue }}"
            placeholder="{{ $searchPlaceholder }}"
            @if($searchOnInput) oninput="{{ $searchOnInput }}" @endif
            autocomplete="off"
            class="h-11 w-full rounded-2xl bg-white border-2 border-[#DCEFFF] pl-11 {{ $showSearchClear ? 'pr-10' : 'pr-4' }} text-xs sm:text-sm font-semibold text-[#12233F] outline-none placeholder:text-[#94A3B8] focus:border-[#007FBE] focus:ring-4 focus:ring-[#DDF3FF] transition shadow-[0_2px_0_#DCEFFF]">
        @if($showSearchClear)
            <button type="button"
                id="{{ $searchId }}Clear"
                aria-label="Bersihkan pencarian"
                class="{{ trim((string) $searchValue) !== '' ? 'inline-flex' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 h-6 w-6 items-center justify-center rounded-full bg-[#F0F6FF] text-[#465673] hover:bg-[#DDF3FF] hover:text-[#007FBE] text-xs font-black transition cursor-pointer">
                ✕
            </button>
        @endif
    </div>

    {{ $slot }}
</div>

@once
    <script>
        window.ArravaStudentFilter = window.ArravaStudentFilter || {
            activeClasses: ['is-active', 'bg-[#007FBE]', 'text-white', 'border-[#007FBE]', 'shadow-[0_2px_0_#005580]'],
            inactiveClasses: ['bg-white', 'text-[#465673]', 'border-[#DCEFFF]', 'hover:bg-[#F0F6FF]', 'hover:text-[#007FBE]'],

            setActiveChip(container, activeValue, attrName = 'data-value') {
                if (!container) return;
                const target = String(activeValue ?? '').toLowerCase();
                container.querySelectorAll('[' + attrName + ']').forEach(btn => {
                    const val = String(btn.getAttribute(attrName) ?? '').toLowerCase();
                    const isActive = val === target;
                    this.activeClasses.forEach(cls => btn.classList.toggle(cls, isActive));
                    this.inactiveClasses.forEach(cls => btn.classList.toggle(cls, !isActive));
                    btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
            },

            matchesJenjangFilter(itemJenjang, selectedFilter) {
                const selected = String(selectedFilter ?? '').trim().toLowerCase();
                if (!selected || selected === 'semua' || selected === 'semua jenjang' || selected === 'all') {
                    return true;
                }
                const item = String(itemJenjang ?? '').trim().toLowerCase();
                if (selected === 'umum') {
                    return item === '' || item === 'umum' || item === 'semua jenjang' || item === 'semua';
                }
                return item === selected;
            },

            bindSearchClear(inputEl, clearBtnEl, onChange) {
                if (!inputEl) return;
                const syncClearBtn = () => {
                    if (!clearBtnEl) return;
                    const hasText = inputEl.value.trim() !== '';
                    clearBtnEl.classList.toggle('hidden', !hasText);
                    clearBtnEl.classList.toggle('inline-flex', hasText);
                };
                inputEl.addEventListener('input', () => {
                    syncClearBtn();
                    if (typeof onChange === 'function') onChange();
                });
                if (clearBtnEl) {
                    clearBtnEl.addEventListener('click', () => {
                        inputEl.value = '';
                        syncClearBtn();
                        if (typeof onChange === 'function') onChange();
                        inputEl.focus();
                    });
                }
                syncClearBtn();
            }
        };
    </script>
@endonce
