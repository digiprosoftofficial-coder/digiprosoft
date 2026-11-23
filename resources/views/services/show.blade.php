<x-layouts.app :seo="$seo">
    <x-ui.page-hero :eyebrow="$service->category?->name ?? 'Service'" :title="$service->name" :breadcrumbs="$breadcrumbs" :dark="true">
        {{ $service->short_description }}
        <x-slot:actions>
            <x-ui.button href="{{ route('contact.show', ['intent' => 'quote', 'service' => $service->slug]) }}" variant="white" size="lg">{{ __('Get a Quote') }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            <x-ui.button href="{{ route('contact.show') }}" variant="outline-white" size="lg">Free Consultation</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>

    @if($service->description)
        <section class="section-tight" aria-labelledby="overview-heading">
            <div class="container-site grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-4">
                    <p class="eyebrow">Overview</p>
                    <h2 id="overview-heading" class="text-display-sm mt-3">{{ $service->tagline ?? $service->name }}</h2>
                    @if(!empty($service->technologies))
                        <div class="mt-8">
                            <p class="text-xs font-semibold uppercase tracking-wider text-ink-500">Technologies</p>
                            <ul class="mt-2 flex flex-wrap gap-2" role="list">
                                @foreach($service->technologies as $tech)
                                    <li class="rounded-full border border-ink-200 bg-white px-3 py-1 text-sm text-ink-700">{{ $tech }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="prose-dp lg:col-span-8">{!! \App\Support\Content\RichText::markdown($service->description) !!}</div>
            </div>
        </section>
    @endif

    <x-sections.problem-solution :problem="$service->problem" :solution="$service->solution" />

    <x-sections.features :features="$service->features ?? []" eyebrow="What we deliver" title="What this service includes" />

    {{-- Process --}}
    @if(!empty($service->process))
        <section class="section border-y border-ink-100 bg-ink-50/70" aria-labelledby="process-heading">
            <div class="container-site">
                <x-ui.section-heading eyebrow="Process" title="How a {{ strtolower($service->name) }} project runs" class="reveal">
                    You see working results early and always know what comes next.
                </x-ui.section-heading>
                <ol class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3" role="list">
                    @foreach($service->process as $step)
                        <li class="relative rounded-2xl border border-ink-200 bg-white p-6 shadow-card reveal">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">{{ $step['step'] ?? $loop->iteration }}</span>
                            <h3 class="mt-4 text-base font-semibold text-ink-900">{{ $step['title'] }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-ink-600">{{ $step['description'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    <x-sections.benefits :benefits="$service->benefits ?? []" title="Why it pays off" />

    <x-sections.related eyebrow="Products" title="Products related to this service" :items="$service->products" type="product" moreLabel="All products" :moreHref="route('products.index')" />

    <x-sections.related eyebrow="Portfolio" title="Work involving this service" :items="$caseStudies" type="case-study" moreLabel="View portfolio" :moreHref="route('portfolio.index')" tone="muted" />

    <x-sections.faq :faqs="$service->faqs ?? []" title="Questions about {{ strtolower($service->name) }}" />

    <x-sections.related eyebrow="More services" title="Related services" :items="$relatedServices" type="service" moreLabel="All services" :moreHref="route('services.index')" tone="muted" />

    <x-sections.related eyebrow="From the blog" title="Related reading" :items="$relatedPosts" type="post" moreLabel="Visit the blog" :moreHref="route('blog.index')" />

    <x-cta.final title="Discuss your {{ strtolower($service->name) }} project" text="Share what you have in mind and we will come back with questions, options and a clear next step — no obligation." primaryLabel="Get a Quote" :primaryHref="route('contact.show', ['intent' => 'quote', 'service' => $service->slug])" secondaryLabel="See Our Work" :secondaryHref="route('portfolio.index')" />
</x-layouts.app>
