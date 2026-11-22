@props(['dark' => false])
@php
    $src = $dark
        ? asset('images/brand/digiprosoft-logo-dark.png')
        : asset('images/brand/digiprosoft-logo.png');
@endphp
<img
    {{ $attributes->merge(['class' => 'h-8 w-auto']) }}
    src="{{ $src }}"
    width="{{ $dark ? 498 : 485 }}"
    height="{{ $dark ? 108 : 104 }}"
    alt="{{ \App\Support\Site::name() }}"
    decoding="async"
>
