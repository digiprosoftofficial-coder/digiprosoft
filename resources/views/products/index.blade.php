<x-layouts.app :seo="$seo">
    <x-ui.page-hero
        eyebrow="Products"
        title="Business software products built for Bangladesh"
        :breadcrumbs="[['name' => 'Home', 'url' => route('home')], ['name' => 'Products', 'url' => route('products.index')]]">
        Ready-to-deploy systems for pharmacies, hotels, schools, retail shops and online stores — configured for your business, supported locally, and extendable when you need more.
        <x-slot:actions>
            <x-ui.button href="{{ route('contact.show', ['intent' => 'demo']) }}">Request a demo <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            <x-ui.button href="{{ route('services.show', 'custom-software-development') }}" variant="secondary">Need something custom?</x-ui.button>
        </x-slot:actions>
    </x-ui.page-hero>

    <section class="section" aria-label="Product list">
        <div class="container-site">
            @foreach($categories as $category)
                @php $group = $products->where('category_id', $category->id); @endphp
                @if($group->isNotEmpty())
                    <div class="{{ !$loop->first ? 'mt-16' : '' }}">
                        <div class="max-w-2xl">
                            <h2 class="text-display-sm">{{ $category->name }}</h2>
                            @if($category->description)<p class="mt-2 text-ink-600">{{ $category->description }}</p>@endif
                        </div>
                        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($group as $product)
                                <x-cards.product :product="$product" class="reveal" />
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @php $uncategorised = $products->whereNull('category_id'); @endphp
            @if($uncategorised->isNotEmpty())
                <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($uncategorised as $product)
                        <x-cards.product :product="$product" class="reveal" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="section-tight border-t border-ink-100 bg-ink-50/70" aria-labelledby="compare-heading">
        <div class="container-site grid gap-10 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-5">
                <p class="eyebrow">How it works</p>
                <h2 id="compare-heading" class="text-display-sm mt-3">Product, extended product, or custom build?</h2>
                <p class="mt-4 text-ink-600">Most businesses only need a product configured for them. Some need a module or integration added. A few need something designed from scratch. We recommend the option that fits — read our guide on <a href="{{ route('blog.show', 'custom-software-vs-ready-made-software') }}" class="font-medium text-brand-700 underline underline-offset-4">custom vs ready-made software</a>.</p>
            </div>
            <ol class="grid gap-4 sm:grid-cols-3 lg:col-span-7" role="list">
                @foreach([
                    ['Configure', 'Your items, rates, users, receipts and reports set up in days.'],
                    ['Extend', 'Add a module, report or integration specific to your operation.'],
                    ['Build', 'A tailored system when nothing on the market fits.'],
                ] as $i => [$title, $text])
                    <li class="rounded-2xl border border-ink-200 bg-white p-5 shadow-card">
                        <span class="text-xs font-semibold tracking-widest text-brand-600">OPTION {{ $i + 1 }}</span>
                        <h3 class="mt-2 font-semibold text-ink-900">{{ $title }}</h3>
                        <p class="mt-1.5 text-sm text-ink-600">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <x-cta.final title="See a product with your own data" text="Book a free demo and we will walk through the system using your items, rooms, students or products." primaryLabel="Book a Demo" :primaryHref="route('contact.show', ['intent' => 'demo'])" secondaryLabel="Talk to Us" :secondaryHref="route('contact.show')" />
</x-layouts.app>
