@props([
    'seo',
    'bodyClass' => '',
    'flash' => true,
])
@php
    use App\Support\Site;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <x-seo.meta :seo="$seo" />

    <meta name="theme-color" content="{{ config('site.branding.theme_color') }}">
    <meta name="application-name" content="{{ Site::name() }}">
    <meta name="apple-mobile-web-app-title" content="{{ Site::name() }}">
    <meta name="format-detection" content="telephone=no">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-partials.analytics />
</head>
<body class="min-h-dvh flex flex-col {{ $bodyClass }}">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:rounded-md focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white focus:shadow-elevated">
        Skip to main content
    </a>

    <x-layouts.header />

    <main id="main-content" class="flex-1" tabindex="-1">
        @if($flash)
            <x-partials.flash />
        @endif
        {{ $slot }}
    </main>

    <x-layouts.footer />
    <x-cta.whatsapp-float />
</body>
</html>
