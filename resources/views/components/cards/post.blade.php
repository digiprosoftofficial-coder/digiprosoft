@props(['post', 'headingLevel' => 'h3', 'featured' => false])
<article {{ $attributes->merge(['class' => 'group relative flex h-full flex-col overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-card transition-[box-shadow,transform,border-color] duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover motion-reduce:transform-none']) }}>
    <div class="aspect-[16/9] overflow-hidden bg-ink-100">
        <x-ui.image :src="$post->featured_image" :alt="$post->featured_image_alt ?? ''" :width="800" :height="450" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03] motion-reduce:transform-none" />
    </div>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-ink-500">
            @if($post->category)<span class="font-semibold text-brand-700">{{ $post->category->name }}</span>@endif
            <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('M j, Y') }}</time>
            <span aria-hidden="true">·</span>
            <span>{{ __(':n min read', ['n' => $post->reading_time]) }}</span>
        </div>
        <{{ $headingLevel }} class="mt-3 {{ $featured ? 'text-2xl' : 'text-lg' }} font-semibold leading-snug text-ink-950">
            <a href="{{ $post->url() }}" class="after:absolute after:inset-0 after:rounded-2xl focus-visible:outline-none">{{ $post->title }}</a>
        </{{ $headingLevel }}>
        <p class="mt-2 flex-1 text-[0.9375rem] leading-relaxed text-ink-600 {{ $featured ? '' : 'line-clamp-3' }}">{{ $post->excerpt }}</p>
        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">{{ __('Read article') }} <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transform-none" /></span>
    </div>
</article>
