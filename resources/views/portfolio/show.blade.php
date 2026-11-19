<x-layouts.app :seo="$seo">
    <x-ui.page-hero :eyebrow="$study->category?->name ?? 'Case study'" :title="$study->title" :breadcrumbs="$breadcrumbs" :dark="true">
        {{ $study->summary }}
    </x-ui.page-hero>

    <section class="section-tight" aria-label="Project overview">
        <div class="container-site grid gap-12 lg:grid-cols-12">
            <aside class="lg:col-span-4 lg:order-2">
                <div class="lg:sticky lg:top-24 space-y-6">
                    <dl class="divide-y divide-ink-200 rounded-2xl border border-ink-200 bg-white shadow-card">
                        @if($study->industry)
                            <div class="px-5 py-4"><dt class="text-xs font-semibold uppercase tracking-wider text-ink-500">Industry</dt><dd class="mt-1 font-medium text-ink-900">{{ $study->industry }}</dd></div>
                        @endif
                        @if($study->client_type)
                            <div class="px-5 py-4"><dt class="text-xs font-semibold uppercase tracking-wider text-ink-500">Client type</dt><dd class="mt-1 font-medium text-ink-900">{{ $study->client_type }}</dd></div>
                        @endif
                        @if($study->product)
                            <div class="px-5 py-4"><dt class="text-xs font-semibold uppercase tracking-wider text-ink-500">Product</dt><dd class="mt-1"><a href="{{ $study->product->url() }}" class="font-medium text-brand-700 underline underline-offset-4">{{ $study->product->name }}</a></dd></div>
                        @endif
                        @if($study->services->isNotEmpty())
                            <div class="px-5 py-4"><dt class="text-xs font-semibold uppercase tracking-wider text-ink-500">Services</dt>
                                <dd class="mt-1 flex flex-wrap gap-x-3 gap-y-1">@foreach($study->services as $s)<a href="{{ $s->url() }}" class="text-sm font-medium text-brand-700 underline underline-offset-4">{{ $s->name }}</a>@endforeach</dd></div>
                        @endif
                        @if(!empty($study->technologies))
                            <div class="px-5 py-4"><dt class="text-xs font-semibold uppercase tracking-wider text-ink-500">Technologies</dt>
                                <dd class="mt-2 flex flex-wrap gap-1.5">@foreach($study->technologies as $tech)<span class="rounded-md bg-ink-100 px-2 py-1 text-xs font-medium text-ink-700">{{ $tech }}</span>@endforeach</dd></div>
                        @endif
                    </dl>
                    <div class="rounded-2xl bg-brand-950 p-6 text-white">
                        <h2 class="text-lg font-semibold text-white">Need something similar?</h2>
                        <p class="mt-2 text-sm text-ink-300">We can walk you through this system in detail and discuss how it would fit your business.</p>
                        <x-ui.button href="{{ route('contact.show', ['intent' => 'demo']) }}" variant="white" class="mt-5 w-full">Book a Demo</x-ui.button>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-8 lg:order-1">
                @if($study->problem)
                    <h2 class="text-display-sm">The challenge</h2>
                    <div class="prose-dp mt-4">{!! \App\Support\Content\RichText::markdown($study->problem) !!}</div>
                @endif
                @if($study->solution)
                    <h2 class="text-display-sm mt-12">What we built</h2>
                    <div class="prose-dp mt-4">{!! \App\Support\Content\RichText::markdown($study->solution) !!}</div>
                @endif
                @if(!empty($study->features))
                    <h2 class="text-display-sm mt-12">Key features</h2>
                    <ul class="mt-5 grid gap-3 sm:grid-cols-2" role="list">
                        @foreach($study->features as $feature)
                            <li class="flex gap-3 rounded-xl border border-ink-200 bg-white p-4 text-sm text-ink-800">
                                <x-ui.icon name="check-circle" class="mt-0.5 h-4.5 w-4.5 shrink-0 text-accent-500" /> {{ is_array($feature) ? $feature['title'] : $feature }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if($study->outcome)
                    <h2 class="text-display-sm mt-12">Outcome</h2>
                    <div class="prose-dp mt-4">{!! \App\Support\Content\RichText::markdown($study->outcome) !!}</div>
                @endif
            </div>
        </div>
    </section>

    <x-sections.screenshots :screenshots="$study->screenshots ?? []" title="Screens from the project" />

    <x-sections.related eyebrow="More work" title="Other case studies" :items="$related" type="case-study" moreLabel="View portfolio" :moreHref="route('portfolio.index')" />

    <x-cta.final />
</x-layouts.app>
