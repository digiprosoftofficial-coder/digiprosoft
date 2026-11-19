@props(['study', 'headingLevel' => 'h3'])
<article {{ $attributes->merge(['class' => 'group relative flex h-full flex-col overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-card transition-[box-shadow,transform,border-color] duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover motion-reduce:transform-none']) }}>
    <div class="aspect-[16/10] overflow-hidden bg-ink-100">
        <x-ui.image :src="$study->featured_image" :alt="$study->featured_image_alt ?? $study->title" :width="800" :height="500" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03] motion-reduce:transform-none" />
    </div>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap items-center gap-2 text-xs">
            @if($study->industry)<span class="rounded-full bg-brand-50 px-2.5 py-1 font-medium text-brand-700">{{ $study->industry }}</span>@endif
            @if($study->client_type)<span class="text-ink-500">{{ $study->client_type }}</span>@endif
        </div>
        <{{ $headingLevel }} class="mt-3 text-lg font-semibold text-ink-950">
            <a href="{{ $study->url() }}" class="after:absolute after:inset-0 after:rounded-2xl focus-visible:outline-none">{{ $study->title }}</a>
        </{{ $headingLevel }}>
        <p class="mt-2 flex-1 text-[0.9375rem] leading-relaxed text-ink-600">{{ $study->summary }}</p>
        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">Read case study <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transform-none" /></span>
    </div>
</article>
