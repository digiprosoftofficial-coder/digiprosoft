<x-layouts.app :seo="$seo">
    <article>
        <header class="relative overflow-hidden border-b border-ink-100 bg-ink-50/70">
            <div class="pointer-events-none absolute inset-0 grid-fade" aria-hidden="true"></div>
            <div class="container-site relative py-14 lg:py-20">
                <x-ui.breadcrumbs :items="$breadcrumbs" class="mb-6" />
                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-ink-500">
                        @if($post->category)<span class="font-semibold text-brand-700">{{ $post->category->name }}</span><span aria-hidden="true">·</span>@endif
                        <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('F j, Y') }}</time>
                        <span aria-hidden="true">·</span>
                        <span>{{ __(':n min read', ['n' => $post->reading_time]) }}</span>
                    </div>
                    <h1 class="text-display-lg mt-4">{{ $post->title }}</h1>
                    <p class="mt-5 text-lg leading-relaxed text-ink-600">{{ $post->excerpt }}</p>
                    <div class="mt-6 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-950 text-sm font-bold text-white" aria-hidden="true">{{ \Illuminate\Support\Str::of($post->author?->name ?? 'D')->substr(0, 1) }}</span>
                        <div class="text-sm">
                            <p class="font-semibold text-ink-900">{{ $post->author?->name ?? \App\Support\Site::name() }}</p>
                            <p class="text-ink-500">{{ \App\Support\Site::name() }} — {{ \App\Support\Site::tagline() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-site grid gap-12 py-14 lg:grid-cols-12 lg:py-20">
            <div class="lg:col-span-8">
                @if($post->featured_image)
                    <figure class="mb-10 overflow-hidden rounded-2xl border border-ink-200 bg-ink-100">
                        <x-ui.image :src="$post->featured_image" :alt="$post->featured_image_alt ?? ''" :width="1200" :height="675" :priority="true" class="h-auto w-full" />
                    </figure>
                @endif
                <div class="prose-dp max-w-none">{!! \App\Support\Content\RichText::html($post->content) !!}</div>

                @if($post->tags->isNotEmpty())
                    <ul class="mt-10 flex flex-wrap gap-2" role="list" aria-label="Tags">
                        @foreach($post->tags as $tag)
                            <li class="rounded-full border border-ink-200 bg-white px-3 py-1 text-sm text-ink-600">#{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-10">
                    <x-ui.share-dialog :url="$seo->canonicalUrl()" :title="$post->title" />
                </div>

                <div class="mt-10 rounded-2xl border border-ink-200 bg-ink-50/70 p-6">
                    <p class="text-sm font-semibold text-ink-900">About the author</p>
                    <p class="mt-2 text-sm leading-relaxed text-ink-600">Written by the {{ \App\Support\Site::name() }} team — software engineers and consultants building business management systems, websites and custom software for organisations in Bangladesh.</p>
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="space-y-6 lg:sticky lg:top-24">
                    @if($post->products->isNotEmpty() || $post->services->isNotEmpty())
                        <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-card">
                            <h2 class="text-sm font-semibold uppercase tracking-wider text-ink-500">Mentioned in this article</h2>
                            <ul class="mt-4 space-y-3" role="list">
                                @foreach($post->products as $product)
                                    <li><a href="{{ $product->url() }}" class="group flex items-start gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 ring-1 ring-brand-100"><x-ui.icon :name="$product->icon ?? 'package'" class="h-4.5 w-4.5" /></span>
                                        <span><span class="block text-sm font-semibold text-ink-900 group-hover:text-brand-700">{{ $product->name }}</span><span class="block text-xs text-ink-500">Product</span></span>
                                    </a></li>
                                @endforeach
                                @foreach($post->services as $service)
                                    <li><a href="{{ $service->url() }}" class="group flex items-start gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ink-950 text-white"><x-ui.icon :name="$service->icon ?? 'code'" class="h-4.5 w-4.5" /></span>
                                        <span><span class="block text-sm font-semibold text-ink-900 group-hover:text-brand-700">{{ $service->name }}</span><span class="block text-xs text-ink-500">Service</span></span>
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="rounded-2xl bg-brand-950 p-6 text-white">
                        <h2 class="text-lg font-semibold text-white">Talk to us about your business</h2>
                        <p class="mt-2 text-sm text-ink-300">Free consultation — we will suggest the most practical software approach for your situation.</p>
                        <x-ui.button href="{{ route('contact.show') }}" variant="white" class="mt-5 w-full">Get a Free Consultation</x-ui.button>
                    </div>
                </div>
            </aside>
        </div>
    </article>

    <x-sections.related eyebrow="Keep reading" title="Related articles" :items="$related" type="post" moreLabel="All articles" :moreHref="route('blog.index')" tone="muted" />

    <x-cta.final />
</x-layouts.app>
