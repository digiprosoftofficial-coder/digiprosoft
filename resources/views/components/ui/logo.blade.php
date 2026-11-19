@props(['dark' => false])
@php
    $src = $dark
        ? asset('images/brand/digiprosoft-logo-dark.png')
        : asset('images/brand/digiprosoft-logo.png');
@endphp
<img
    {{ $attributes->merge(['class' => 'h-8 w-auto']) }}
    src="{{ $src }}"
    width="688"
    height="77"
    alt="{{ \App\Support\Site::name() }}"
    decoding="async"
>
