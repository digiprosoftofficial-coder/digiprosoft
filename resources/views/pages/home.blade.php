<x-layouts.app :seo="$seo">
    {{-- 1. Hero --}}
    <section class="relative overflow-hidden bg-white" aria-labelledby="hero-heading">
        <div class="pointer-events-none absolute inset-0 grid-fade" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-x-0 top-0 h-[32rem] glow" aria-hidden="true"></div>
        <div class="container-site relative grid items-center gap-12 pb-16 pt-14 lg:grid-cols-12 lg:gap-8 lg:pb-24 lg:pt-20">
            <div class="lg:col-span-6 xl:col-span-6">
                <p class="eyebrow animate-fade-up">Software company in Dhaka, Bangladesh</p>
                <h1 id="hero-heading" class="text-display-xl mt-4 animate-fade-up [animation-delay:60ms]">
                    Digital Solutions That Move Your Business Forward
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-600 animate-fade-up [animation-delay:120ms] sm:text-xl">
                    We build modern software, websites, e-commerce platforms, and business solutions that help organizations automate operations, save time, and grow.
                </p>
                <div class="mt-8 flex flex-col gap-3 animate-fade-up [animation-delay:180ms] sm:flex-row">
                    <x-ui.button href="{{ route('contact.show') }}" size="lg">Get a Free Consultation <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                    <x-ui.button href="{{ route('products.index') }}" variant="secondary" size="lg">Explore Our Products</x-ui.button>
                </div>
                <ul class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-ink-600 animate-fade-up [animation-delay:240ms]" role="list">
                    <li class="inline-flex items-center gap-2"><x-ui.icon name="check-circle" class="h-4.5 w-4.5 text-accent-500" /> Ready-to-deploy business products</li>
                    <li class="inline-flex items-center gap-2"><x-ui.icon name="check-circle" class="h-4.5 w-4.5 text-accent-500" /> Custom development with source code ownership</li>
                    <li class="inline-flex items-center gap-2"><x-ui.icon name="check-circle" class="h-4.5 w-4.5 text-accent-500" /> Local training and support</li>
                </ul>
            </div>
            <div class="relative lg:col-span-6">
                <div class="relative mx-auto max-w-xl animate-fade-up [animation-delay:200ms] lg:max-w-none">
                    <div class="overflow-hidden rounded-2xl border border-ink-200/80 bg-white shadow-elevated">
                        <x-ui.image src="/images/illustrations/hero-dashboard.svg" alt="Illustration of a DigiProSoft business dashboard showing sales, stock and orders" :width="1200" :height="800" :priority="true" class="h-auto w-full" />
                    </div>
                    <div class="absolute -bottom-5 -left-3 hidden rounded-xl border border-ink-200 bg-white px-4 py-3 shadow-card-hover sm:block lg:-left-8">
                        <p class="text-xs font-medium text-ink-500">Built for</p>
                        <p class="mt-0.5 text-sm font-semibold text-ink-900">Pharmacies · Hotels · Schools · Retail · E-commerce</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Trust / credibility --}}
    <section class="border-y border-ink-100 bg-ink-50/60" aria-labelledby="trust-heading">
        <div class="container-site py-10">
            <h2 id="trust-heading" class="sr-only">Why businesses work with DigiProSoft</h2>
            <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" role="list">
                @foreach([
                    ['shield', 'Transparent scope & pricing', 'Written proposals before work starts. No hidden charges.'],
                    ['code', 'You own the code and data', 'Full source code and documentation handed over on custom projects.'],
                    ['headset', 'Local support in Bangla & English', 'Training, WhatsApp and phone support from a Dhaka-based team.'],
                    ['lock', 'Secure, maintainable stack', 'Laravel, MySQL and modern tooling that any competent team can maintain.'],
                ] as [$icon, $title, $text])
                    <li class="flex gap-4 reveal">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-brand-600 shadow-card ring-1 ring-ink-200/70"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                        <div>
                            <h3 class="text-sm font-semibold text-ink-900">{{ $title }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- 3. What DigiProSoft does --}}
    <section class="section" aria-labelledby="what-heading">
        <div class="container-site">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5">
                    <x-ui.section-heading eyebrow="What we do" title="Software products and development services for growing businesses" class="reveal">
                        DigiProSoft — Digital Products &amp; Software Solutions — helps organisations in Bangladesh replace paper, spreadsheets and disconnected tools with software that fits how they work.
                    </x-ui.section-heading>
                    <div class="mt-8 flex flex-wrap gap-3 reveal">
                        <x-ui.button href="{{ route('about') }}" variant="secondary">About DigiProSoft</x-ui.button>
                        <x-ui.button href="{{ route('services.index') }}" variant="ghost">All services <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                    </div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:col-span-7">
                    @foreach([
                        ['package', 'Business management products', 'Pharmacy, hotel, school, POS and e-commerce systems that are ready to deploy and configured for your business.', route('products.index'), 'See products'],
                        ['code', 'Custom software development', 'Management systems, portals, ERPs and internal tools designed around your processes.', route('services.show', 'custom-software-development'), 'Custom development'],
                        ['globe', 'Websites & e-commerce', 'Fast, secure, search-friendly websites and online stores with local payments and delivery.', route('services.show', 'web-development'), 'Web development'],
                        ['zap', 'Automation & integration', 'Connect systems, automate approvals and reports, and remove repetitive manual work.', route('services.show', 'business-automation'), 'Business automation'],
                    ] as [$icon, $title, $text, $href, $label])
                        <a href="{{ $href }}" class="group flex flex-col rounded-2xl border border-ink-200 bg-white p-6 shadow-card transition-[box-shadow,border-color,transform] hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover reveal motion-reduce:transform-none">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100 group-hover:bg-brand-600 group-hover:text-white"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                            <h3 class="mt-5 text-lg font-semibold text-ink-950">{{ $title }}</h3>
                            <p class="mt-2 flex-1 text-[0.9375rem] leading-relaxed text-ink-600">{{ $text }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">{{ $label }} <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transform-none" /></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 4. Featured products --}}
    @if($products->isNotEmpty())
    <section class="section bg-ink-50/70" aria-labelledby="products-heading">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-ui.section-heading eyebrow="Products" title="Ready-to-deploy software for your type of business" class="reveal">
                    Each product is configured for your items, rates, users and reports — and can be extended when your business needs more.
                </x-ui.section-heading>
                <x-ui.button href="{{ route('products.index') }}" variant="secondary" class="reveal shrink-0">All products <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <x-cards.product :product="$product" class="reveal" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 5. Business solutions by industry --}}
    <section class="section" aria-labelledby="solutions-heading">
        <div class="container-site">
            <x-ui.section-heading eyebrow="Business solutions" title="Solutions for the businesses we know best" align="center" class="reveal">
                We focus on a small number of industries so the software reflects real day-to-day operations, not generic assumptions.
            </x-ui.section-heading>
            <ul class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6" role="list">
                @foreach([
                    ['pill', 'Pharmacies', 'Batch, expiry and dues', 'pharmacy-management-system'],
                    ['bed', 'Hotels & resorts', 'Rooms, folios, housekeeping', 'hotel-management-system'],
                    ['graduation', 'Schools & colleges', 'Fees, exams, parent SMS', 'school-management-system'],
                    ['receipt', 'Retail & restaurants', 'Billing and inventory', 'pos-system'],
                    ['cart', 'Online brands', 'Own your online store', 'ecommerce-platform'],
                    ['settings', 'SMEs & organisations', 'Tailored management systems', 'custom-business-software'],
                ] as [$icon, $title, $text, $slug])
                    <li class="reveal">
                        <a href="{{ route('products.show', $slug) }}" class="group flex h-full flex-col items-center rounded-2xl border border-ink-200 bg-white p-6 text-center shadow-card transition-[box-shadow,border-color] hover:border-brand-200 hover:shadow-card-hover">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-ink-950 text-white transition-colors group-hover:bg-brand-600"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                            <span class="mt-4 text-sm font-semibold text-ink-900">{{ $title }}</span>
                            <span class="mt-1 text-xs text-ink-500">{{ $text }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- 6. Services --}}
    @if($services->isNotEmpty())
    <section class="section bg-brand-950 text-white" aria-labelledby="services-heading">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl reveal">
                    <p class="eyebrow text-brand-300 before:bg-brand-300">Services</p>
                    <h2 id="services-heading" class="text-display-md mt-3 text-white">Development services from discovery to long-term support</h2>
                    <p class="mt-4 text-lg leading-relaxed text-ink-300">When a product is not the right fit, we design and build what you need — and keep it running afterwards.</p>
                </div>
                <x-ui.button href="{{ route('services.index') }}" variant="outline-white" class="reveal shrink-0">All services <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            </div>
            <ul class="mt-12 grid gap-px overflow-hidden rounded-2xl bg-white/10 ring-1 ring-white/10 sm:grid-cols-2 lg:grid-cols-4" role="list">
                @foreach($services->take(8) as $service)
                    <li class="reveal">
                        <a href="{{ $service->url() }}" class="group flex h-full flex-col bg-brand-950 p-6 transition-colors hover:bg-brand-900/80 focus-visible:bg-brand-900/80">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10 text-brand-200 ring-1 ring-white/10 group-hover:bg-brand-500 group-hover:text-white"><x-ui.icon :name="$service->icon ?? 'code'" class="h-5 w-5" /></span>
                            <h3 class="mt-5 text-base font-semibold text-white">{{ $service->name }}</h3>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-400">{{ $service->tagline ?? \Illuminate\Support\Str::limit($service->short_description, 90) }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-300 group-hover:text-white">Learn more <x-ui.icon name="arrow-right" class="h-4 w-4" /></span>
                        </a>
                    </li>
                @endforeach
                @if($services->count() < 8)
                    <li class="reveal">
                        <a href="{{ route('contact.show') }}" class="group flex h-full flex-col justify-between bg-brand-600 p-6 transition-colors hover:bg-brand-500">
                            <h3 class="text-lg font-semibold text-white">Not sure what you need?</h3>
                            <p class="mt-2 text-sm text-brand-100">Describe your situation and we will suggest the most practical route.</p>
                            <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-white">Talk to us <x-ui.icon name="arrow-right" class="h-4 w-4" /></span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </section>
    @endif

    {{-- 7. Why DigiProSoft --}}
    <section class="section" aria-labelledby="why-heading">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <x-ui.section-heading eyebrow="Why DigiProSoft" title="A software partner, not just a vendor" class="reveal">
                    We would rather deliver one system that your team uses every day than ten features nobody asked for.
                </x-ui.section-heading>
                <div class="mt-8 reveal">
                    <x-ui.button href="{{ route('contact.show') }}">Start a conversation <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                </div>
            </div>
            <ul class="grid gap-x-8 gap-y-8 sm:grid-cols-2 lg:col-span-7" role="list">
                @foreach([
                    ['compass', 'We start with your workflow', 'Discovery sessions map how work really happens before anything is designed.'],
                    ['layers', 'Products where they fit, custom where they don’t', 'Honest advice on whether a ready product, an extension or a custom build serves you best.'],
                    ['rocket', 'Working software early', 'Staged delivery means you use core features in weeks, not at the end of a long project.'],
                    ['users', 'Training for real users', 'Counter staff, receptionists and accountants are trained on their actual tasks.'],
                    ['shield', 'Security and backups by default', 'Role-based access, encrypted handling of sensitive data and tested backups.'],
                    ['refresh', 'Support after launch', 'Maintenance plans with defined response times keep systems secure and improving.'],
                ] as [$icon, $title, $text])
                    <li class="flex gap-4 reveal">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 ring-1 ring-brand-100"><x-ui.icon :name="$icon" class="h-5 w-5" /></span>
                        <div>
                            <h3 class="text-base font-semibold text-ink-900">{{ $title }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- 8. Technology stack --}}
    <section class="border-y border-ink-100 bg-ink-50/70" aria-labelledby="stack-heading">
        <div class="container-site py-14">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-md reveal">
                    <p class="eyebrow">Technology</p>
                    <h2 id="stack-heading" class="text-display-sm mt-3">A proven, maintainable stack</h2>
                    <p class="mt-3 text-ink-600">We choose widely supported technologies so your software stays secure and any competent team can maintain it.</p>
                </div>
                <ul class="flex flex-wrap gap-2.5 reveal lg:max-w-2xl lg:justify-end" role="list" aria-label="Technologies we use">
                    @foreach(['Laravel', 'PHP 8', 'MySQL', 'PostgreSQL', 'Vue.js', 'Tailwind CSS', 'REST APIs', 'Redis', 'Docker', 'Nginx', 'Cloudflare', 'AWS', 'SSLCommerz', 'bKash API', 'SMS gateways'] as $tech)
                        <li class="rounded-full border border-ink-200 bg-white px-3.5 py-1.5 text-sm font-medium text-ink-700">{{ $tech }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- 9. Development process --}}
    <section class="section" aria-labelledby="process-heading">
        <div class="container-site">
            <x-ui.section-heading eyebrow="How we work" title="A clear process from first call to launch" align="center" class="reveal">
                You always know what happens next, what it costs and when you will see working software.
            </x-ui.section-heading>
            <ol class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6" role="list">
                @foreach([
                    ['Discovery', 'We learn your business, goals and constraints.'],
                    ['Proposal', 'Written scope, timeline and pricing.'],
                    ['Design', 'Screens and flows reviewed with you.'],
                    ['Build', 'Staged delivery with your feedback.'],
                    ['Launch', 'Deployment, data migration and training.'],
                    ['Support', 'Maintenance and improvements.'],
                ] as $i => [$title, $text])
                    <li class="relative rounded-2xl border border-ink-200 bg-white p-6 shadow-card reveal">
                        <span class="text-xs font-semibold tracking-widest text-brand-600">STEP {{ $i + 1 }}</span>
                        <h3 class="mt-2 text-base font-semibold text-ink-900">{{ $title }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 10. Portfolio / case studies --}}
    @if($caseStudies->isNotEmpty())
    <section class="section bg-ink-50/70" aria-labelledby="work-heading">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-ui.section-heading eyebrow="Portfolio" title="Selected work" class="reveal">
                    Project showcases describing the problem, the solution and the technology behind it.
                </x-ui.section-heading>
                <x-ui.button href="{{ route('portfolio.index') }}" variant="secondary" class="reveal shrink-0">View portfolio <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($caseStudies as $study)
                    <x-cards.case-study :study="$study" class="reveal" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 11. FAQ --}}
    @if($faqs->isNotEmpty())
    <section class="section" aria-labelledby="faq-heading">
        <div class="container-site grid gap-10 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <x-ui.section-heading eyebrow="FAQ" title="Common questions" class="reveal">
                    Straight answers about how we work, pricing and support.
                </x-ui.section-heading>
                <div class="mt-6 reveal">
                    <a href="{{ route('faq') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800">All questions <x-ui.icon name="arrow-right" class="h-4 w-4" /></a>
                </div>
            </div>
            <div class="lg:col-span-8 reveal">
                <x-ui.faq-list :faqs="$faqs" />
            </div>
        </div>
    </section>
    @endif

    {{-- 12. Blog / insights --}}
    @if($posts->isNotEmpty())
    <section class="section border-t border-ink-100" aria-labelledby="insights-heading">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-ui.section-heading eyebrow="Insights" title="Practical guides on business software" class="reveal" />
                <x-ui.button href="{{ route('blog.index') }}" variant="secondary" class="reveal shrink-0">Visit the blog <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <x-cards.post :post="$post" class="reveal" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 13. Final CTA --}}
    <x-cta.final />
</x-layouts.app>
