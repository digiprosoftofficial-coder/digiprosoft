@props([
    'src' => null,
    'alt' => '',
    'width' => null,
    'height' => null,
    'priority' => false, // true for the LCP image only
    'fallback' => '/images/illustrations/placeholder-abstract.svg',
])
@php
    $resolved = $src ?: $fallback;
    $isDecorative = trim((string) $alt) === '';
@endphp
<img src="{{ $resolved }}"
     alt="{{ $alt }}"
     @if($width) width="{{ $width }}" @endif
     @if($height) height="{{ $height }}" @endif
     loading="{{ $priority ? 'eager' : 'lazy' }}"
     decoding="{{ $priority ? 'sync' : 'async' }}"
     @if($priority) fetchpriority="high" @endif
     @if($isDecorative) role="presentation" @endif
     {{ $attributes }}>
