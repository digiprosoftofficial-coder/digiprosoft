@props(['product', 'headingLevel' => 'h3'])
<article {{ $attributes->merge(['class' => 'group relative flex h-full flex-col rounded-2xl border border-ink-200 bg-white p-6 shadow-card transition-[box-shadow,transform,border-color] duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover motion-reduce:transform-none']) }}>
    <div class="flex items-start justify-between gap-4">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100 transition-colors group-hover:bg-brand-600 group-hover:text-white">
            <x-ui.icon :name="$product->icon ?? 'package'" class="h-6 w-6" />
        </span>
        @if($product->category)
            <span class="rounded-full bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-600">{{ $product->category->name }}</span>
        @endif
    </div>
    <{{ $headingLevel }} class="mt-5 text-lg font-semibold text-ink-950">
        <a href="{{ $product->url() }}" class="after:absolute after:inset-0 after:rounded-2xl focus-visible:outline-none">{{ $product->name }}</a>
    </{{ $headingLevel }}>
    @if($product->tagline)
        <p class="mt-1 text-sm font-medium text-brand-700">{{ $product->tagline }}</p>
    @endif
    <p class="mt-3 flex-1 text-[0.9375rem] leading-relaxed text-ink-600">{{ $product->short_description }}</p>
    @if(!empty($product->target_audience))
        <ul class="mt-4 flex flex-wrap gap-1.5" role="list" aria-label="{{ __('Built for') }}">
            @foreach(array_slice($product->target_audience, 0, 3) as $aud)
                <li class="rounded-md bg-ink-50 px-2 py-1 text-xs text-ink-600 ring-1 ring-inset ring-ink-200/70">{{ $aud }}</li>
            @endforeach
        </ul>
    @endif
    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
        {{ __('View product') }} <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transform-none" />
    </span>
</article>
