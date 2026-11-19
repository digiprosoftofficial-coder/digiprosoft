<x-layouts.app :seo="$seo">
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-ink-100 bg-ink-50/70">
        <div class="pointer-events-none absolute inset-0 grid-fade" aria-hidden="true"></div>
        <div class="container-site relative grid items-center gap-10 py-14 lg:grid-cols-12 lg:py-20">
            <div class="lg:col-span-6">
                <x-ui.breadcrumbs :items="$breadcrumbs" class="mb-6" />
                <p class="eyebrow">{{ $product->category?->name ?? 'Product' }}</p>
                <h1 class="text-display-lg mt-3">{{ $product->name }}</h1>
                @if($product->tagline)<p class="mt-3 text-xl font-medium text-brand-700">{{ $product->tagline }}</p>@endif
                <p class="mt-5 text-lg leading-relaxed text-ink-600">{{ $product->short_description }}</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    @if(filled($product->website_url))
                        <x-ui.button href="{{ $product->website_url }}" size="lg" target="_blank" rel="noopener">Visit {{ $product->name }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                        <x-ui.button href="{{ route('contact.show', ['intent' => 'demo', 'service' => $product->slug]) }}" variant="secondary" size="lg">Request a Demo</x-ui.button>
                    @else
                        <x-ui.button href="{{ route('contact.show', ['intent' => 'demo', 'service' => $product->slug]) }}" size="lg">Request a Demo <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                        <x-ui.button href="{{ route('contact.show', ['intent' => 'quote', 'service' => $product->slug]) }}" variant="secondary" size="lg">Get a Quote</x-ui.button>
                    @endif
                </div>
                @if(!empty($product->target_audience))
                    <div class="mt-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-500">Built for</p>
                        <ul class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach($product->target_audience as $aud)
                                <li class="rounded-full border border-ink-200 bg-white px-3 py-1 text-sm text-ink-700">{{ $aud }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="lg:col-span-6">
                @php $hero = $product->featured_image ?: ($product->screenshots[0]['src'] ?? null); $heroAlt = $product->featured_image_alt ?: ($product->screenshots[0]['alt'] ?? $product->name.' preview'); @endphp
                <div class="overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-elevated">
                    <x-ui.image :src="$hero" :alt="$heroAlt" :width="1200" :height="750" :priority="true" class="h-auto w-full" fallback="/images/illustrations/dashboard-generic.svg" />
                </div>
            </div>
        </div>
    </section>

    @if(filled($product->website_url))
        <section class="section-tight" aria-labelledby="live-product-heading">
            <div class="container-site">
                <div class="flex flex-col gap-6 rounded-3xl border border-brand-200 bg-gradient-to-br from-brand-50 to-white p-8 sm:flex-row sm:items-center sm:justify-between sm:p-10">
                    <div class="max-w-2xl">
                        <p class="eyebrow">Live product website</p>
                        <h2 id="live-product-heading" class="text-display-sm mt-3">Use {{ $product->name }} online</h2>
                        <p class="mt-3 text-ink-600">{{ $product->name }} has a dedicated product site with demos, pricing and onboarding — built and supported by DigiProSoft.</p>
                    </div>
                    <div class="flex shrink-0 flex-col gap-3 sm:items-end">
                        <x-ui.button href="{{ $product->website_url }}" size="lg" target="_blank" rel="noopener">
                            Open {{ $product->name }} <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </x-ui.button>
                        <a href="{{ $product->website_url }}" class="break-all text-sm font-medium text-brand-700 underline underline-offset-4" target="_blank" rel="noopener">{{ parse_url($product->website_url, PHP_URL_HOST) }}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Overview --}}
    @if($product->description)
        <section class="section-tight" aria-labelledby="overview-heading">
            <div class="container-site grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-4">
                    <p class="eyebrow">Overview</p>
                    <h2 id="overview-heading" class="text-display-sm mt-3">About {{ $product->name }}</h2>
                </div>
                <div class="prose-dp lg:col-span-8">{!! \App\Support\Content\RichText::markdown($product->description) !!}</div>
            </div>
        </section>
    @endif

    <x-sections.problem-solution :problem="$product->problem" :solution="$product->solution" />

    <x-sections.features :features="$product->features ?? []" title="Everything you need to run {{ strtolower($product->category?->name === 'Custom Solutions' ? 'your operation' : 'the business') }}" intro="Core capabilities included in {{ $product->name }}. Additional modules and integrations can be added." />

    <x-sections.benefits :benefits="$product->benefits ?? []" />

    <x-sections.screenshots :screenshots="$product->screenshots ?? []" />

    {{-- Related services --}}
    <x-sections.related eyebrow="Services" title="Services that go with this product" :items="$product->services" type="service" moreLabel="All services" :moreHref="route('services.index')" />

    <x-sections.faq :faqs="$product->faqs ?? []" title="Questions about {{ $product->name }}" />

    <x-sections.related eyebrow="More products" title="Other products you may need" :items="$relatedProducts" type="product" moreLabel="All products" :moreHref="route('products.index')" tone="muted" />

    <x-sections.related eyebrow="From the blog" title="Related reading" :items="$relatedPosts" type="post" moreLabel="Visit the blog" :moreHref="route('blog.index')" />

    <x-cta.final title="See {{ $product->name }} with your own data" text="Book a free demo. We will walk through the system using your real items, rates and workflows, and answer pricing questions clearly." primaryLabel="Book a Demo" :primaryHref="route('contact.show', ['intent' => 'demo', 'service' => $product->slug])" secondaryLabel="Get a Quote" :secondaryHref="route('contact.show', ['intent' => 'quote', 'service' => $product->slug])" />
</x-layouts.app>
