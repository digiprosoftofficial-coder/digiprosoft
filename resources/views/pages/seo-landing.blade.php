@php
    $resolveCta = function (?array $cta): ?array {
        if (! is_array($cta)) {
            return null;
        }
        if (! empty($cta['url'])) {
            return ['label' => $cta['label'], 'href' => $cta['url'], 'external' => true];
        }
        if (! empty($cta['route'])) {
            return [
                'label' => $cta['label'],
                'href' => route($cta['route'], $cta['params'] ?? []),
                'external' => false,
            ];
        }

        return null;
    };
    $primary = $resolveCta($page['primary_cta'] ?? null);
    $secondary = $resolveCta($page['secondary_cta'] ?? null);
@endphp
<x-layouts.app :seo="$seo">
    <x-ui.page-hero :eyebrow="$page['eyebrow'] ?? null" :title="$page['h1']" :breadcrumbs="$breadcrumbs">
        {{ $page['intro'] }}
        <x-slot:actions>
            @if($primary)
                <x-ui.button
                    href="{{ $primary['href'] }}"
                    size="lg"
                    :target="$primary['external'] ? '_blank' : null"
                    :rel="$primary['external'] ? 'noopener' : null"
                >
                    {{ $primary['label'] }} <x-ui.icon name="arrow-right" class="h-4 w-4" />
                </x-ui.button>
            @endif
            @if($secondary)
                <x-ui.button
                    href="{{ $secondary['href'] }}"
                    variant="secondary"
                    size="lg"
                    :target="$secondary['external'] ? '_blank' : null"
                    :rel="$secondary['external'] ? 'noopener' : null"
                >
                    {{ $secondary['label'] }}
                </x-ui.button>
            @endif
        </x-slot:actions>
    </x-ui.page-hero>

    @foreach($page['sections'] ?? [] as $section)
        <section class="section{{ $loop->even ? ' border-y border-ink-100 bg-ink-50/70' : '' }}" aria-labelledby="seo-section-{{ $loop->index }}">
            <div class="container-site grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-4">
                    <h2 id="seo-section-{{ $loop->index }}" class="text-display-sm">{{ $section['heading'] }}</h2>
                </div>
                <div class="prose-dp lg:col-span-8">{!! \App\Support\Content\RichText::markdown($section['body']) !!}</div>
            </div>
        </section>
    @endforeach

    @if($featuredProduct)
        <section class="section" aria-labelledby="featured-product-heading">
            <div class="container-site">
                <div class="rounded-3xl border border-brand-200 bg-brand-50/60 p-8 sm:p-10">
                    <p class="eyebrow">Live product</p>
                    <h2 id="featured-product-heading" class="text-display-sm mt-3">{{ $featuredProduct->name }}</h2>
                    <p class="mt-3 max-w-2xl text-ink-600">{{ $featuredProduct->short_description }}</p>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        @if(filled($featuredProduct->website_url))
                            <x-ui.button href="{{ $featuredProduct->website_url }}" size="lg" target="_blank" rel="noopener">
                                Visit {{ $featuredProduct->name }} <x-ui.icon name="arrow-right" class="h-4 w-4" />
                            </x-ui.button>
                        @endif
                        <x-ui.button href="{{ route('products.show', $featuredProduct) }}" variant="secondary" size="lg">
                            Full product details
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($products->isNotEmpty())
        <section class="section border-y border-ink-100 bg-ink-50/70" aria-label="Products">
            <div class="container-site">
                <x-ui.section-heading eyebrow="Products" title="Business software you can deploy" align="center" />
                <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" role="list">
                    @foreach($products as $product)
                        <li>
                            <x-cards.product :product="$product" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @if($services->isNotEmpty())
        <section class="section" aria-label="Services">
            <div class="container-site">
                <x-ui.section-heading eyebrow="Services" title="Development services" align="center" />
                <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" role="list">
                    @foreach($services as $service)
                        <li class="rounded-2xl border border-ink-200 bg-white p-6 shadow-card">
                            <h3 class="text-lg font-semibold text-ink-950">
                                <a href="{{ route('services.show', $service) }}" class="hover:text-brand-700">{{ $service->name }}</a>
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-ink-600">{{ $service->short_description }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    <x-sections.faq :faqs="$page['faqs'] ?? []" title="Questions people ask" />

    <x-cta.final
        title="Tell us what you want to build"
        text="Share your business and goals. We will recommend a DigiProSoft product, SoftoPharma, or a custom approach — with clear next steps."
        primaryLabel="Contact DigiProSoft"
        :primaryHref="route('contact.show')"
        secondaryLabel="All products"
        :secondaryHref="route('products.index')"
    />
</x-layouts.app>
