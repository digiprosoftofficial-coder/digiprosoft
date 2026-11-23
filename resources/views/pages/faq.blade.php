<x-layouts.app :seo="$seo">
    <x-ui.page-hero eyebrow="{{ __('FAQ') }}" title="{{ __('Frequently asked questions') }}" :breadcrumbs="[['name' => __('Home'), 'url' => route('home')], ['name' => __('FAQ'), 'url' => route('faq')]]">
        {!! __('Straight answers about our products, development services, pricing, timelines and support. If your question is not here, :ask.', [
            'ask' => '<a href="'.e(route('contact.show')).'" class="font-medium text-brand-700 underline underline-offset-4">'.e(__('ask us directly')).'</a>',
        ]) !!}
    </x-ui.page-hero>

    <section class="section" aria-label="{{ __('Questions by topic') }}">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <nav class="min-w-0 lg:col-span-3" aria-label="{{ __('FAQ topics') }}">
                <ul class="-mx-4 flex min-w-0 gap-2 overflow-x-auto px-4 pb-2 [scrollbar-width:thin] lg:sticky lg:top-24 lg:mx-0 lg:flex-col lg:overflow-visible lg:px-0 lg:pb-0" role="list">
                    @foreach($groups as $group => $items)
                        <li class="shrink-0">
                            <a href="#faq-{{ $group }}" class="block rounded-lg border border-ink-200 bg-white px-4 py-2.5 text-sm font-medium text-ink-700 hover:border-brand-200 hover:text-brand-700 lg:border-0 lg:bg-transparent lg:px-3 lg:hover:bg-ink-50">{{ $labels[$group] ?? ucfirst($group) }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="space-y-14 lg:col-span-9">
                @foreach($groups as $group => $items)
                    <div id="faq-{{ $group }}" class="scroll-mt-24">
                        <h2 class="text-display-sm">{{ $labels[$group] ?? ucfirst($group) }}</h2>
                        <x-ui.faq-list :faqs="$items" class="mt-6" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta.final
        title="{{ __('Still have questions?') }}"
        text="{{ __('We are happy to talk through your specific situation. No sales pressure — just clear answers.') }}"
        :primaryLabel="__('Contact Us')" />
</x-layouts.app>
