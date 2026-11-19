@props([
    'eyebrow' => null,
    'title',
    'breadcrumbs' => [],
    'dark' => false,
])
<section class="relative overflow-hidden {{ $dark ? 'bg-brand-950 text-white' : 'border-b border-ink-100 bg-ink-50/70' }}">
    @if($dark)
        <div class="pointer-events-none absolute inset-0 grid-fade opacity-50" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -top-32 right-0 h-80 w-80 rounded-full bg-brand-500/25 blur-3xl" aria-hidden="true"></div>
    @else
        <div class="pointer-events-none absolute inset-0 grid-fade" aria-hidden="true"></div>
    @endif
    <div class="container-site relative py-14 lg:py-20">
        <x-ui.breadcrumbs :items="$breadcrumbs" :light="$dark" class="mb-6" />
        <div class="max-w-3xl">
            @if($eyebrow)
                <p class="eyebrow {{ $dark ? 'text-brand-300 before:bg-brand-300' : '' }}">{{ $eyebrow }}</p>
            @endif
            <h1 class="text-display-lg mt-3 {{ $dark ? 'text-white' : '' }}">{{ $title }}</h1>
            @if(trim($slot))
                <div class="mt-5 text-lg leading-relaxed {{ $dark ? 'text-ink-300' : 'text-ink-600' }}">{{ $slot }}</div>
            @endif
            @isset($actions)
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">{{ $actions }}</div>
            @endisset
        </div>
    </div>
</section>
