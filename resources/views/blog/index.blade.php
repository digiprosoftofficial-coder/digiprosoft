<x-layouts.app :seo="$seo">
    <x-ui.page-hero
        eyebrow="Blog & insights"
        :title="$page > 1 ? 'Blog — page '.$page : 'Practical guides on business software'"
        :breadcrumbs="[['name' => 'Home', 'url' => route('home')], ['name' => 'Blog', 'url' => route('blog.index')]]">
        Articles for business owners and managers in Bangladesh on choosing, implementing and getting value from software — written from real project experience.
    </x-ui.page-hero>

    <section class="section" aria-label="Articles">
        <div class="container-site">
            @if($featured && $page === 1)
                <article class="group relative grid overflow-hidden rounded-3xl border border-ink-200 bg-white shadow-card transition-shadow hover:shadow-card-hover lg:grid-cols-2">
                    <div class="aspect-[16/9] overflow-hidden bg-ink-100 lg:aspect-auto">
                        <x-ui.image :src="$featured->featured_image" :alt="$featured->featured_image_alt ?? ''" :width="960" :height="540" :priority="true" class="h-full w-full object-cover" />
                    </div>
                    <div class="flex flex-col justify-center p-8 lg:p-12">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-ink-500">
                            <span class="rounded-full bg-brand-50 px-2.5 py-1 font-semibold text-brand-700">Featured</span>
                            @if($featured->category)<span class="font-semibold text-ink-700">{{ $featured->category->name }}</span>@endif
                            <time datetime="{{ $featured->published_at?->toDateString() }}">{{ $featured->published_at?->format('M j, Y') }}</time>
                            <span>· {{ $featured->reading_time }} min read</span>
                        </div>
                        <h2 class="text-display-sm mt-4"><a href="{{ $featured->url() }}" class="after:absolute after:inset-0 focus-visible:outline-none">{{ $featured->title }}</a></h2>
                        <p class="mt-4 text-ink-600">{{ $featured->excerpt }}</p>
                        <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">Read article <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" /></span>
                    </div>
                </article>
            @endif

            @if($categories->isNotEmpty())
                <div class="mt-12 flex flex-wrap items-center gap-2" aria-label="Topics">
                    <span class="text-sm font-medium text-ink-500">Topics:</span>
                    @foreach($categories as $category)
                        <span class="rounded-full border border-ink-200 bg-white px-3 py-1 text-sm text-ink-700">{{ $category->name }} <span class="text-ink-400">({{ $category->posts_count }})</span></span>
                    @endforeach
                </div>
            @endif

            @php $list = ($featured && $page === 1) ? $posts->getCollection()->reject(fn ($p) => $p->id === $featured->id) : $posts->getCollection(); @endphp
            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($list as $post)
                    <x-cards.post :post="$post" class="reveal" />
                @empty
                    <p class="text-ink-600">No articles yet — check back soon.</p>
                @endforelse
            </div>

            @if($posts->hasPages())
                <nav class="mt-12 flex items-center justify-between border-t border-ink-200 pt-6" aria-label="Pagination">
                    <div>
                        @if($posts->onFirstPage())
                            <span class="inline-flex items-center gap-2 text-sm text-ink-400"><x-ui.icon name="arrow-left" class="h-4 w-4" /> Newer</span>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800"><x-ui.icon name="arrow-left" class="h-4 w-4" /> Newer</a>
                        @endif
                    </div>
                    <p class="text-sm text-ink-500">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</p>
                    <div>
                        @if($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800">Older <x-ui.icon name="arrow-right" class="h-4 w-4" /></a>
                        @else
                            <span class="inline-flex items-center gap-2 text-sm text-ink-400">Older <x-ui.icon name="arrow-right" class="h-4 w-4" /></span>
                        @endif
                    </div>
                </nav>
            @endif
        </div>
    </section>

    <x-cta.final title="Want advice for your specific situation?" text="Articles are general by nature. A short conversation about your business gives you a specific recommendation." />
</x-layouts.app>
