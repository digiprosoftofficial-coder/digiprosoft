@php
    use App\Support\Content\Navigation;
    use App\Support\Site;

    $primary = Navigation::primary();
    $products = Navigation::products();
    $services = Navigation::services();
    $isActive = fn (string $pattern) => request()->routeIs($pattern);
@endphp
{{--
    The blurred/translucent bar is an inner element on purpose: `backdrop-filter` on the
    <header> itself would turn it into the containing block for the `position: fixed`
    mobile panel below and clip it to the header's height.
--}}
<header data-site-header class="group/header sticky top-0 z-50">
    <div class="border-b border-transparent bg-white/85 backdrop-blur-md transition-[box-shadow,border-color] duration-300 group-data-scrolled/header:border-ink-200/80 group-data-scrolled/header:shadow-[0_1px_0_0_rgb(15_23_42/0.04),0_8px_24px_-16px_rgb(15_23_42/0.18)]">
    <div class="container-site flex h-16 items-center justify-between gap-4 lg:h-[4.5rem]">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5 rounded-md" aria-label="{{ Site::name() }} — home">
            <x-ui.logo class="h-9 w-auto lg:h-10" />
        </a>

        {{-- Desktop navigation --}}
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
            @foreach($primary as $item)
                @php
                    $menu = match ($item['route']) {
                        'products.index' => $products,
                        'services.index' => $services,
                        default => collect(),
                    };
                @endphp
                @if($menu->isNotEmpty())
                    <div class="relative" data-dropdown>
                        <a href="{{ route($item['route']) }}"
                           class="nav-link inline-flex items-center gap-1"
                           @if($isActive($item['active'])) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </a>
                        <button type="button" data-dropdown-toggle aria-expanded="false" aria-haspopup="true"
                                class="-ml-1.5 rounded-md p-1.5 text-ink-500 hover:bg-ink-100 hover:text-ink-900"
                                aria-label="Open {{ strtolower($item['label']) }} menu">
                            <x-ui.icon name="chevron-down" class="h-4 w-4 transition-transform in-data-open:rotate-180" />
                        </button>
                        <div class="invisible absolute left-1/2 top-full z-50 w-[40rem] -translate-x-1/2 pt-3 opacity-0 transition-[opacity,visibility,transform] duration-200 translate-y-1 in-data-open:visible in-data-open:translate-y-0 in-data-open:opacity-100">
                            <div class="rounded-2xl border border-ink-200/80 bg-white p-3 shadow-elevated">
                                <ul class="grid grid-cols-2 gap-1" role="list">
                                    @foreach($menu as $entry)
                                        <li>
                                            <a href="{{ route($item['route'] === 'products.index' ? 'products.show' : 'services.show', $entry['slug']) }}"
                                               class="group flex items-start gap-3 rounded-xl p-3 transition-colors hover:bg-ink-50 focus-visible:bg-ink-50">
                                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 ring-1 ring-brand-100 group-hover:bg-brand-600 group-hover:text-white">
                                                    <x-ui.icon :name="$entry['icon'] ?? 'package'" class="h-[18px] w-[18px]" />
                                                </span>
                                                <span>
                                                    <span class="block text-sm font-semibold text-ink-900">{{ $entry['name'] }}</span>
                                                    @if($entry['tagline'])
                                                        <span class="mt-0.5 block text-xs leading-snug text-ink-500">{{ $entry['tagline'] }}</span>
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-2 border-t border-ink-100 px-3 pt-3">
                                    <a href="{{ route($item['route']) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800">
                                        View all {{ strtolower($item['label']) }} <x-ui.icon name="arrow-right" class="h-4 w-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route($item['route']) }}" class="nav-link" @if($isActive($item['active'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endif
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            @if($phone = Site::phoneHref())
                <a href="{{ $phone }}" class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-ink-700 hover:bg-ink-100 hover:text-ink-950 xl:inline-flex">
                    <x-ui.icon name="phone" class="h-4 w-4 text-brand-600" /> {{ Site::phone() }}
                </a>
            @endif
            <x-ui.button href="{{ route('contact.show') }}" size="sm" class="whitespace-nowrap max-sm:hidden">
                <span class="md:hidden">Free Consultation</span><span class="hidden md:inline">Get a Free Consultation</span>
            </x-ui.button>

            <button type="button" data-nav-toggle aria-expanded="false" aria-controls="mobile-nav"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-ink-800 hover:bg-ink-100 lg:hidden"
                    aria-label="Open menu">
                <x-ui.icon name="menu" class="h-6 w-6" />
            </button>
        </div>
    </div>
    </div>

    {{-- Mobile navigation panel --}}
    <div id="mobile-nav" data-nav-panel hidden class="group fixed inset-0 z-[60] lg:hidden" role="dialog" aria-modal="true" aria-label="Site navigation">
        <div data-nav-backdrop class="absolute inset-0 bg-ink-950/40 opacity-0 transition-opacity duration-200 group-data-open:opacity-100"></div>
        <div class="absolute inset-y-0 right-0 flex w-[min(100%,24rem)] translate-x-full flex-col bg-white shadow-elevated transition-transform duration-200 ease-out-expo group-data-open:translate-x-0">
            <div class="flex h-16 items-center justify-between border-b border-ink-100 px-5">
                <x-ui.logo class="h-9 w-auto" />
                <button type="button" data-nav-close class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-ink-800 hover:bg-ink-100" aria-label="Close menu">
                    <x-ui.icon name="x" class="h-6 w-6" />
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto px-3 py-4" aria-label="Mobile primary">
                <ul class="space-y-1" role="list">
                    <li><a href="{{ route('home') }}" class="block rounded-lg px-3 py-3 text-base font-medium text-ink-900 hover:bg-ink-50" @if($isActive('home')) aria-current="page" @endif>Home</a></li>
                    @foreach($primary as $item)
                        @php
                            $menu = match ($item['route']) {
                                'products.index' => $products,
                                'services.index' => $services,
                                default => collect(),
                            };
                        @endphp
                        @if($menu->isNotEmpty())
                            <li>
                                <details class="group/d rounded-lg" @if($isActive($item['active'])) open @endif>
                                    <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-3 text-base font-medium text-ink-900 hover:bg-ink-50 [&::-webkit-details-marker]:hidden">
                                        {{ $item['label'] }}
                                        <x-ui.icon name="chevron-down" class="h-5 w-5 text-ink-400 transition-transform group-open/d:rotate-180" />
                                    </summary>
                                    <ul class="mb-2 ml-3 space-y-0.5 border-l border-ink-200 pl-3" role="list">
                                        <li><a href="{{ route($item['route']) }}" class="block rounded-md px-3 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50">All {{ strtolower($item['label']) }}</a></li>
                                        @foreach($menu as $entry)
                                            <li><a href="{{ route($item['route'] === 'products.index' ? 'products.show' : 'services.show', $entry['slug']) }}" class="block rounded-md px-3 py-2 text-sm text-ink-700 hover:bg-ink-50 hover:text-ink-950">{{ $entry['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </details>
                            </li>
                        @else
                            <li><a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-3 text-base font-medium text-ink-900 hover:bg-ink-50" @if($isActive($item['active'])) aria-current="page" @endif>{{ $item['label'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            <div class="space-y-3 border-t border-ink-100 p-5">
                <x-ui.button href="{{ route('contact.show') }}" class="w-full">Get a Free Consultation</x-ui.button>
                @if($wa = Site::whatsappUrl())
                    <x-ui.button href="{{ $wa }}" variant="secondary" class="w-full" rel="noopener" target="_blank">
                        <x-ui.icon name="whatsapp" class="h-5 w-5" /> Chat on WhatsApp
                    </x-ui.button>
                @endif
                @if($phone = Site::phoneHref())
                    <a href="{{ $phone }}" class="flex items-center justify-center gap-2 py-2 text-sm font-medium text-ink-700"><x-ui.icon name="phone" class="h-4 w-4 text-brand-600" /> {{ Site::phone() }}</a>
                @endif
            </div>
        </div>
    </div>
</header>
