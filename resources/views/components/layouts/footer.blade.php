@php
    use App\Support\Content\Navigation;
    use App\Support\Site;

    $products = Navigation::products();
    $services = Navigation::services();
    $socials = Site::socials();
    $socialIcons = ['facebook' => 'facebook', 'instagram' => 'instagram', 'linkedin' => 'linkedin', 'youtube' => 'youtube', 'x' => 'x-social', 'github' => 'github'];
    $socialLabels = ['facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube', 'x' => 'X (Twitter)', 'github' => 'GitHub'];
@endphp
<footer class="relative mt-auto bg-brand-950 text-ink-300" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="container-site">
        <div class="grid gap-12 py-16 lg:grid-cols-12 lg:gap-8 lg:py-20">
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="inline-flex rounded-md" aria-label="{{ Site::name() }} — home">
                    <x-ui.logo :dark="true" class="h-10 w-auto" />
                </a>
                <p class="mt-4 text-base font-medium text-white">{{ Site::tagline() }}</p>
                <p class="mt-3 max-w-sm text-sm leading-relaxed text-ink-400">
                    Business management software, websites, e-commerce platforms and custom solutions for businesses in Bangladesh and beyond.
                </p>
                <ul class="mt-6 space-y-2.5 text-sm" role="list">
                    @if(Site::email())
                        <li><a href="mailto:{{ Site::email() }}" class="inline-flex items-center gap-2.5 hover:text-white"><x-ui.icon name="mail" class="h-4 w-4 text-brand-400" />{{ Site::email() }}</a></li>
                    @endif
                    @if(Site::phone())
                        <li><a href="{{ Site::phoneHref() }}" class="inline-flex items-center gap-2.5 hover:text-white"><x-ui.icon name="phone" class="h-4 w-4 text-brand-400" />{{ Site::phone() }}</a></li>
                    @endif
                    @if(Site::whatsappUrl())
                        <li><a href="{{ Site::whatsappUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2.5 hover:text-white"><x-ui.icon name="whatsapp" class="h-4 w-4 text-brand-400" />WhatsApp</a></li>
                    @endif
                    <li class="inline-flex items-center gap-2.5"><x-ui.icon name="map-pin" class="h-4 w-4 text-brand-400" />{{ collect([Site::address()['city'] ?? null, 'Bangladesh'])->filter()->unique()->implode(', ') }}</li>
                </ul>
                @if($socials)
                    <ul class="mt-6 flex items-center gap-2" role="list" aria-label="Social media">
                        @foreach($socials as $key => $url)
                            <li>
                                <a href="{{ $url }}" target="_blank" rel="noopener" class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/5 text-ink-300 ring-1 ring-white/10 hover:bg-white/10 hover:text-white" aria-label="{{ Site::name() }} on {{ $socialLabels[$key] ?? ucfirst($key) }}">
                                    <x-ui.icon :name="$socialIcons[$key] ?? 'globe'" class="h-4.5 w-4.5" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <nav class="grid grid-cols-2 gap-8 sm:grid-cols-4 lg:col-span-8" aria-label="Footer">
                <div>
                    <h3 class="text-sm font-semibold text-white">Products</h3>
                    <ul class="mt-4 space-y-2.5 text-sm" role="list">
                        @foreach($products as $p)
                            <li><a href="{{ route('products.show', $p['slug']) }}" class="hover:text-white">{{ $p['name'] }}</a></li>
                        @endforeach
                        <li><a href="{{ route('products.index') }}" class="font-medium text-brand-300 hover:text-white">All products</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Services</h3>
                    <ul class="mt-4 space-y-2.5 text-sm" role="list">
                        @foreach($services as $s)
                            <li><a href="{{ route('services.show', $s['slug']) }}" class="hover:text-white">{{ $s['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Company</h3>
                    <ul class="mt-4 space-y-2.5 text-sm" role="list">
                        <li><a href="{{ route('about') }}" class="hover:text-white">About DigiProSoft</a></li>
                        <li><a href="{{ route('seo.landing', 'software-development-company-bangladesh') }}" class="hover:text-white">Software company in BD</a></li>
                        <li><a href="{{ route('seo.landing', 'custom-software-development-bangladesh') }}" class="hover:text-white">Custom software</a></li>
                        <li><a href="{{ route('seo.landing', 'pharmacy-management-software-bangladesh') }}" class="hover:text-white">Pharmacy software</a></li>
                        <li><a href="{{ route('portfolio.index') }}" class="hover:text-white">Portfolio</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-white">Blog &amp; insights</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Get started</h3>
                    <ul class="mt-4 space-y-2.5 text-sm" role="list">
                        <li><a href="{{ route('contact.show', ['intent' => 'quote']) }}" class="hover:text-white">Request a quote</a></li>
                        <li><a href="{{ route('contact.show', ['intent' => 'demo']) }}" class="hover:text-white">Book a product demo</a></li>
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white">Free consultation</a></li>
                    </ul>
                    <h3 class="mt-8 text-sm font-semibold text-white">Legal</h3>
                    <ul class="mt-4 space-y-2.5 text-sm" role="list">
                        <li><a href="{{ route('privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="flex flex-col gap-3 border-t border-white/10 py-6 text-xs text-ink-400 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ Site::legalName() }}. All rights reserved.</p>
            <p>{{ Site::name() }} — {{ Site::tagline() }}</p>
        </div>
    </div>
</footer>
