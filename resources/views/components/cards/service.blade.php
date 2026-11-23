@props(['service', 'headingLevel' => 'h3', 'compact' => false])
<article {{ $attributes->merge(['class' => 'group relative flex h-full flex-col rounded-2xl border border-ink-200 bg-white shadow-card transition-[box-shadow,transform,border-color] duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover motion-reduce:transform-none '.($compact ? 'p-5' : 'p-6 lg:p-7')]) }}>
    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-ink-950 text-white transition-colors group-hover:bg-brand-600">
        <x-ui.icon :name="$service->icon ?? 'code'" class="h-5 w-5" />
    </span>
    <{{ $headingLevel }} class="mt-5 text-lg font-semibold text-ink-950">
        <a href="{{ $service->url() }}" class="after:absolute after:inset-0 after:rounded-2xl focus-visible:outline-none">{{ $service->name }}</a>
    </{{ $headingLevel }}>
    <p class="mt-2 flex-1 text-[0.9375rem] leading-relaxed text-ink-600">{{ $service->short_description }}</p>
    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
        {{ __('Learn more') }} <x-ui.icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transform-none" />
    </span>
</article>
