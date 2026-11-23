<x-layouts.app :seo="$seo">
    <x-ui.page-hero eyebrow="{{ __('About') }}" title="{{ __('A software company focused on businesses in Bangladesh') }}" :breadcrumbs="[['name' => __('Home'), 'url' => route('home')], ['name' => __('About'), 'url' => route('about')]]">
        {{ __('DigiProSoft — Digital Products & Software Solutions — is a software development company based in Dhaka. We build business management products and custom software that help organisations replace paper, spreadsheets and disconnected tools with systems that fit how they actually work.') }}
    </x-ui.page-hero>

    <section class="section" aria-labelledby="mission-heading">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <p class="eyebrow">{{ __('What we believe') }}</p>
                <h2 id="mission-heading" class="text-display-md mt-3">{{ __('Software should fit the business, not the other way around') }}</h2>
            </div>
            <div class="prose-dp lg:col-span-7">
                <p>{{ __('Most small and medium businesses in Bangladesh do not need enterprise software. They need a pharmacy system that understands batches and expiry, a hotel system that stops double bookings, a POS that keeps working when the internet drops, or an online store that accepts bKash and books a courier. They need it to be affordable, supported locally, and to keep working for years.') }}</p>
                <p>{{ __('That is what we build. Our products come from repeated work in the same industries; our custom development starts from how your team actually works. In both cases you get clear pricing, staged delivery and — for custom projects — full ownership of the source code.') }}</p>
                <p>{!! __('Pharmacies can start with :softo — our pharmacy management software at :url. Hotels, schools, retailers and online brands use our other products, or we build custom systems when the workflow is unique.', [
                    'softo' => '<a href="'.e(route('products.show', 'pharmacy-management-system')).'">SoftoPharma</a>',
                    'url' => '<a href="https://softopharma.digiprosoft.com/" target="_blank" rel="noopener">softopharma.digiprosoft.com</a>',
                ]) !!}</p>
                <p>{{ __('We are deliberately focused. Rather than promising everything to everyone, we concentrate on a small number of industries and a proven technology stack, so that what we deliver is dependable.') }}</p>
            </div>
        </div>
    </section>

    <section class="section border-y border-ink-100 bg-ink-50/70" aria-labelledby="values-heading">
        <div class="container-site">
            <x-ui.section-heading eyebrow="{{ __('How we work') }}" title="{{ __('Principles that shape every project') }}" align="center" class="reveal" />
            <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" role="list">
                @foreach([
                    ['compass', __('Understand first'), __('We map the real workflow before proposing a solution. Discovery is never skipped.')],
                    ['file-text', __('Clear scope, honest pricing'), __('Written proposals with deliverables and costs. No hidden charges, no surprise invoices.')],
                    ['rocket', __('Working software early'), __('Staged delivery means you use core features while the rest is built.')],
                    ['code', __('Ownership and openness'), __('You own your code and data. We use widely known technology, not proprietary lock-in.')],
                    ['users', __('Train the people who use it'), __('Counter staff, receptionists and accountants get hands-on training in their language.')],
                    ['refresh', __('Stay after launch'), __('Maintenance plans keep systems secure, fast and improving.')],
                ] as [$icon, $title, $text])
                    <li class="rounded-2xl border border-ink-200 bg-white p-6 shadow-card reveal">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                        <h3 class="mt-5 text-base font-semibold text-ink-900">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="section" aria-labelledby="who-heading">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <p class="eyebrow">{{ __('Who we serve') }}</p>
                <h2 id="who-heading" class="text-display-md mt-3">{{ __('Built for the businesses that keep Bangladesh running') }}</h2>
                <p class="mt-4 text-ink-600">{{ __('Our products and services are designed for small and medium businesses and organisations that want practical digital transformation without enterprise complexity.') }}</p>
                <div class="mt-8">
                    <x-ui.button href="{{ route('products.index') }}">{{ __('Explore products') }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                </div>
            </div>
            <ul class="grid gap-3 sm:grid-cols-2 lg:col-span-7" role="list">
                @foreach([
                    ['pill', __('Pharmacies & medicine wholesalers'), 'pharmacy-management-system'],
                    ['bed', __('Hotels, guest houses & resorts'), 'hotel-management-system'],
                    ['graduation', __('Schools, colleges & coaching centres'), 'school-management-system'],
                    ['receipt', __('Retail shops, supermarkets & restaurants'), 'pos-system'],
                    ['cart', __('Online brands & e-commerce businesses'), 'ecommerce-platform'],
                    ['settings', __('SMEs, distributors & service organisations'), 'custom-business-software'],
                ] as [$icon, $label, $slug])
                    <li>
                        <a href="{{ route('products.show', $slug) }}" class="flex items-center gap-3 rounded-xl border border-ink-200 bg-white p-4 text-sm font-medium text-ink-800 shadow-card transition-colors hover:border-brand-200 hover:bg-brand-50/40">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ink-950 text-white"><x-ui.icon :name="$icon" class="h-4.5 w-4.5" /></span>{{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <x-sections.related eyebrow="{{ __('Services') }}" title="{{ __('What we do') }}" :items="$services" type="service" :moreLabel="__('All services')" :moreHref="route('services.index')" tone="muted" />

    <section class="section" aria-labelledby="stack-heading">
        <div class="container-site grid gap-10 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-5">
                <p class="eyebrow">{{ __('Technology') }}</p>
                <h2 id="stack-heading" class="text-display-sm mt-3">{{ __('A stack chosen for longevity') }}</h2>
                <p class="mt-4 text-ink-600">{{ __('We build primarily with Laravel and PHP, MySQL or PostgreSQL, and Vue.js or lightweight JavaScript with Tailwind CSS. These are mature, widely supported technologies with large talent pools in Bangladesh — which means your software can be maintained by any competent team, not only by us.') }}</p>
            </div>
            <ul class="flex flex-wrap gap-2.5 lg:col-span-7" role="list" aria-label="{{ __('Technologies') }}">
                @foreach(['Laravel', 'PHP 8', 'MySQL', 'PostgreSQL', 'Vue.js', 'Tailwind CSS', 'Vite', 'REST APIs', 'Redis', 'Docker', 'Nginx', 'Cloudflare', 'AWS', 'SSLCommerz', 'bKash API', 'SMS gateways', 'GitHub Actions'] as $tech)
                    <li class="rounded-full border border-ink-200 bg-white px-3.5 py-1.5 text-sm font-medium text-ink-700">{{ $tech }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    <x-cta.final title="{{ __('Let’s talk about your business') }}" text="{{ __('Whether you need a ready product, a custom system or advice on where to start, a free consultation is the easiest first step.') }}" />
</x-layouts.app>
