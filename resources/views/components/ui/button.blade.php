@props([
    'href' => null,
    'variant' => 'primary', // primary | secondary | ghost | white | outline-white
    'size' => 'md',         // sm | md | lg
    'type' => 'button',
])
@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-[background-color,color,box-shadow,transform] duration-200 focus-visible:outline-2 focus-visible:outline-offset-2 disabled:pointer-events-none disabled:opacity-60 select-none';
    $sizes = [
        'sm' => 'h-10 px-4 text-sm',
        'md' => 'h-12 px-6 text-[0.9375rem]',
        'lg' => 'h-13 px-7 text-base',
    ];
    $variants = [
        'primary' => 'bg-brand-600 text-white shadow-[0_1px_0_0_rgb(255_255_255/0.15)_inset,0_8px_16px_-8px_rgb(34_73_230/0.6)] hover:bg-brand-700 active:translate-y-px focus-visible:outline-brand-600',
        'secondary' => 'bg-white text-ink-900 ring-1 ring-inset ring-ink-200 hover:bg-ink-50 hover:ring-ink-300 focus-visible:outline-brand-600',
        'ghost' => 'text-brand-700 hover:bg-brand-50 focus-visible:outline-brand-600',
        'white' => 'bg-white text-brand-950 hover:bg-brand-50 focus-visible:outline-white',
        'outline-white' => 'text-white ring-1 ring-inset ring-white/30 hover:bg-white/10 hover:ring-white/50 focus-visible:outline-white',
    ];
    $classes = $base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']);
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
