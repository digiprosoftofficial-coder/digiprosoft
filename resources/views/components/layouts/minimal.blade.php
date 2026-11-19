@props(['title', 'code' => null])
@php use App\Support\Site; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ Site::name() }}</title>
    <meta name="robots" content="noindex,follow">
    <meta name="theme-color" content="{{ config('site.branding.theme_color') }}">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh flex flex-col bg-white">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:rounded-md focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">Skip to main content</a>
    <header class="border-b border-ink-100">
        <div class="container-site flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" aria-label="{{ Site::name() }} — home" class="rounded-md"><x-ui.logo class="h-9 w-auto" /></a>
            <nav aria-label="Primary" class="hidden items-center gap-1 sm:flex">
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
                <a href="{{ route('services.index') }}" class="nav-link">Services</a>
                <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                <a href="{{ route('contact.show') }}" class="nav-link">Contact</a>
            </nav>
        </div>
    </header>
    <main id="main-content" class="relative flex flex-1 items-center overflow-hidden" tabindex="-1">
        <div class="pointer-events-none absolute inset-0 grid-fade" aria-hidden="true"></div>
        <div class="container-site relative py-20 text-center">
            <div class="mx-auto max-w-xl">
                @if($code)<p class="text-sm font-semibold tracking-[0.2em] text-brand-600">ERROR {{ $code }}</p>@endif
                <h1 class="text-display-lg mt-3">{{ $title }}</h1>
                <div class="mt-5 text-lg text-ink-600">{{ $slot }}</div>
                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <x-ui.button href="{{ route('home') }}">Back to homepage</x-ui.button>
                    <x-ui.button href="{{ route('contact.show') }}" variant="secondary">Contact us</x-ui.button>
                </div>
                <ul class="mt-10 flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm" role="list">
                    <li><a href="{{ route('products.index') }}" class="font-medium text-ink-700 hover:text-brand-700">Products</a></li>
                    <li><a href="{{ route('services.index') }}" class="font-medium text-ink-700 hover:text-brand-700">Services</a></li>
                    <li><a href="{{ route('portfolio.index') }}" class="font-medium text-ink-700 hover:text-brand-700">Portfolio</a></li>
                    <li><a href="{{ route('blog.index') }}" class="font-medium text-ink-700 hover:text-brand-700">Blog</a></li>
                    <li><a href="{{ route('faq') }}" class="font-medium text-ink-700 hover:text-brand-700">FAQ</a></li>
                </ul>
            </div>
        </div>
    </main>
    <footer class="border-t border-ink-100 py-6 text-center text-xs text-ink-500">
        &copy; {{ now()->year }} {{ Site::legalName() }} — {{ Site::tagline() }}
    </footer>
</body>
</html>
