@props([
    'title',
    'eyebrow' => 'Related',
    'items',            // collection of models
    'type',             // product | service | case-study | post
    'moreLabel' => null,
    'moreHref' => null,
    'tone' => 'light',  // light | muted
    'id' => null,
])
@php $id ??= 'related-'.$type; @endphp
@if($items->isNotEmpty())
<section class="section-tight {{ $tone === 'muted' ? 'border-y border-ink-100 bg-ink-50/70' : '' }}" aria-labelledby="{{ $id }}-heading" id="{{ $id }}">
    <div class="container-site">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <x-ui.section-heading :eyebrow="$eyebrow" :title="$title" class="reveal" />
            @if($moreHref)
                <a href="{{ $moreHref }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800 reveal">{{ $moreLabel }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></a>
            @endif
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $item)
                @switch($type)
                    @case('product') <x-cards.product :product="$item" class="reveal" /> @break
                    @case('service') <x-cards.service :service="$item" :compact="true" class="reveal" /> @break
                    @case('case-study') <x-cards.case-study :study="$item" class="reveal" /> @break
                    @case('post') <x-cards.post :post="$item" class="reveal" /> @break
                @endswitch
            @endforeach
        </div>
    </div>
</section>
@endif
