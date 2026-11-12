@props([
    'label' => null,
    'id' => null,
    'chips' => [],
    'chipClass' => 'student-style-chip',
    'dataAttr' => 'data-value',
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none']) }} @if($id) id="{{ $id }}" @endif>
    @if($label)
        <span class="text-[11px] font-black uppercase tracking-wider text-[#465673] shrink-0 mr-1">{{ $label }}:</span>
    @endif

    @foreach($chips as $chip)
        @php
            $isArr = is_array($chip);
            $value = $isArr ? ($chip['value'] ?? '') : $chip;
            $text = $isArr ? ($chip['label'] ?? $value) : $chip;
            $active = $isArr ? (bool) ($chip['active'] ?? false) : false;
            $href = $isArr ? ($chip['href'] ?? null) : null;
            $baseClasses = $chipClass . ' px-3.5 py-1.5 rounded-full text-[11px] font-extrabold leading-tight transition-all select-none shrink-0 border cursor-pointer';
            $stateClasses = $active
                ? 'is-active bg-[#007FBE] text-white border-[#007FBE] shadow-[0_2px_0_#005580]'
                : 'bg-white text-[#465673] border-[#DCEFFF] hover:bg-[#F0F6FF] hover:text-[#007FBE]';
        @endphp

        @if($href)
            <a href="{{ $href }}"
                {{ $dataAttr }}="{{ $value }}"
                class="{{ $baseClasses }} {{ $stateClasses }} no-underline inline-flex items-center">
                {{ $text }}
            </a>
        @else
            <button type="button"
                {{ $dataAttr }}="{{ $value }}"
                aria-pressed="{{ $active ? 'true' : 'false' }}"
                class="{{ $baseClasses }} {{ $stateClasses }}">
                {{ $text }}
            </button>
        @endif
    @endforeach

    {{ $slot }}
</div>

