@props(['features' => [], 'eyebrow' => 'Features', 'title' => 'What’s included', 'intro' => null, 'id' => 'features'])
@if(!empty($features))
<section class="section" aria-labelledby="{{ $id }}-heading" id="{{ $id }}">
    <div class="container-site">
        <x-ui.section-heading :eyebrow="$eyebrow" :title="$title" class="reveal">{{ $intro }}</x-ui.section-heading>
        <ul class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" role="list">
            @foreach($features as $feature)
                <li class="flex flex-col rounded-2xl border border-ink-200 bg-white p-6 shadow-card reveal">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600 ring-1 ring-brand-100"><x-ui.icon :name="$feature['icon'] ?? 'check'" class="h-5 w-5" /></span>
                    <h3 class="mt-4 text-base font-semibold text-ink-900">{{ $feature['title'] }}</h3>
                    @if(!empty($feature['description']))
                        <p class="mt-1.5 text-sm leading-relaxed text-ink-600">{{ $feature['description'] }}</p>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif
