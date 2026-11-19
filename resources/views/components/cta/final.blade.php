@props([
    'title' => 'Ready to move your business forward?',
    'text' => 'Tell us about your business and what you want to improve. We will suggest the right product or a custom approach, with clear scope and pricing.',
    'primaryLabel' => 'Get a Free Consultation',
    'primaryHref' => null,
    'secondaryLabel' => 'Explore Our Products',
    'secondaryHref' => null,
])
@php
    $primaryHref ??= route('contact.show');
    $secondaryHref ??= route('products.index');
    $wa = \App\Support\Site::whatsappUrl();
@endphp
<section class="section-tight" aria-labelledby="final-cta-heading">
    <div class="container-site">
        <div class="relative overflow-hidden rounded-3xl bg-brand-950 px-6 py-14 text-center sm:px-12 lg:px-20 lg:py-20">
            <div class="pointer-events-none absolute inset-0 grid-fade opacity-60" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -top-40 left-1/2 h-80 w-[40rem] -translate-x-1/2 rounded-full bg-brand-500/30 blur-3xl" aria-hidden="true"></div>
            <div class="relative mx-auto max-w-2xl">
                <h2 id="final-cta-heading" class="text-display-md text-white">{{ $title }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-ink-300">{{ $text }}</p>
                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <x-ui.button :href="$primaryHref" size="lg" class="w-full sm:w-auto">{{ $primaryLabel }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                    <x-ui.button :href="$secondaryHref" variant="outline-white" size="lg" class="w-full sm:w-auto">{{ $secondaryLabel }}</x-ui.button>
                </div>
                @if($wa)
                    <p class="mt-6 text-sm text-ink-400">Prefer chat? <a href="{{ $wa }}" target="_blank" rel="noopener" class="font-medium text-white underline underline-offset-4 hover:text-brand-200">Message us on WhatsApp</a>.</p>
                @endif
            </div>
        </div>
    </div>
</section>
