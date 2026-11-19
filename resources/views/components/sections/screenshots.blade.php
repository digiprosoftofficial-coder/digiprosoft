@props(['screenshots' => [], 'title' => 'A look inside', 'eyebrow' => 'Screens'])
@if(!empty($screenshots))
<section class="section-tight border-y border-ink-100 bg-ink-50/70" aria-labelledby="screens-heading">
    <div class="container-site">
        <x-ui.section-heading :eyebrow="$eyebrow" :title="$title" class="reveal">
            Representative screens from the system. Layouts and reports are configured for each business during setup.
        </x-ui.section-heading>
        <div class="mt-10 grid gap-6 {{ count($screenshots) > 1 ? 'md:grid-cols-2' : 'max-w-4xl' }}">
            @foreach($screenshots as $shot)
                <figure class="overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-card reveal">
                    <x-ui.image :src="$shot['src']" :alt="$shot['alt'] ?? ''" :width="1200" :height="750" class="h-auto w-full" />
                    @if(!empty($shot['caption']))
                        <figcaption class="border-t border-ink-100 px-5 py-3 text-sm text-ink-600">{{ $shot['caption'] }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif
