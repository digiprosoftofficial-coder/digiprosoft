<x-layouts.app :seo="$seo">
    <x-ui.page-hero
        eyebrow="{{ __('Portfolio') }}"
        title="{{ __('Selected work and case studies') }}"
        :breadcrumbs="[['name' => __('Home'), 'url' => route('home')], ['name' => __('Portfolio'), 'url' => route('portfolio.index')]]">
        {{ __('Project showcases describing the problem space, the solution DigiProSoft built and the technology behind it. Client names and measured results are only published with the client\'s permission.') }}
    </x-ui.page-hero>

    <section class="section" aria-label="{{ __('Case studies') }}">
        <div class="container-site">
            @if($studies->isEmpty())
                <p class="text-ink-600">{!! __('Case studies are being prepared. In the meantime, explore our :products or :contact for references.', [
                    'products' => '<a href="'.e(route('products.index')).'" class="font-medium text-brand-700 underline underline-offset-4">'.e(__('products')).'</a>',
                    'contact' => '<a href="'.e(route('contact.show')).'" class="font-medium text-brand-700 underline underline-offset-4">'.e(__('contact us')).'</a>',
                ]) !!}</p>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($studies as $study)
                        <x-cards.case-study :study="$study" class="reveal" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta.final title="{{ __('Have a similar project in mind?') }}" text="{{ __('Tell us about your business and we will show you relevant work in more detail during a free consultation.') }}" />
</x-layouts.app>
