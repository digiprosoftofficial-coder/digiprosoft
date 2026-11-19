@props([
    'eyebrow' => null,
    'title',
    'level' => 'h2',
    'align' => 'left', // left | center
    'size' => 'md',    // md | lg
])
<div {{ $attributes->merge(['class' => 'max-w-2xl '.($align === 'center' ? 'mx-auto text-center' : '')]) }}>
    @if($eyebrow)
        <p class="eyebrow {{ $align === 'center' ? 'justify-center' : '' }}">{{ $eyebrow }}</p>
    @endif
    <{{ $level }} class="{{ $size === 'lg' ? 'text-display-lg' : 'text-display-md' }} mt-3">{{ $title }}</{{ $level }}>
    @if(trim($slot))
        <div class="mt-4 text-lg leading-relaxed text-ink-600">{{ $slot }}</div>
    @endif
</div>
