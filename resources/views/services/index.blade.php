<x-layouts.app :seo="$seo">
    <x-ui.page-hero
        eyebrow="Services"
        title="Software development services in Bangladesh"
        :breadcrumbs="[['name' => 'Home', 'url' => route('home')], ['name' => 'Services', 'url' => route('services.index')]]">
        From custom management systems and websites to automation, APIs and long-term maintenance — delivered with clear scope, staged releases and full ownership of your code.
        <x-slot:actions>
            <x-ui.button href="{{ route('contact.show') }}">Get a Free Consultation <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            <x-ui.button href="{{ route('portfolio.index') }}" variant="secondary">See our work</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>

    <section class="section" aria-label="Service list">
        <div class="container-site grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
                <x-cards.service :service="$service" class="reveal" />
            @endforeach
        </div>
    </section>

    <section class="section-tight border-t border-ink-100 bg-ink-50/70" aria-labelledby="engage-heading">
        <div class="container-site">
            <x-ui.section-heading eyebrow="How we engage" title="Three ways to work with us" align="center" class="reveal" />
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach([
                    ['file-text', 'Fixed-scope project', 'A defined deliverable, timeline and price. Best for websites, product deployments and clearly specified systems.'],
                    ['layers', 'Phased development', 'Larger systems delivered in planned stages, each with its own scope and budget, so value arrives early.'],
                    ['refresh', 'Ongoing support', 'Monthly maintenance plans with response times and improvement hours for software we built or took over.'],
                ] as [$icon, $title, $text])
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-card reveal">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600 ring-1 ring-brand-100"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                        <h3 class="mt-4 font-semibold text-ink-900">{{ $title }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta.final title="Tell us what you are trying to improve" text="A short conversation is usually enough to suggest the right approach and give you an idea of scope and cost." />
</x-layouts.app>
