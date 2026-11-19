<x-layouts.app :seo="$seo">
    <x-ui.page-hero
        eyebrow="Portfolio"
        title="Selected work and case studies"
        :breadcrumbs="[['name' => 'Home', 'url' => route('home')], ['name' => 'Portfolio', 'url' => route('portfolio.index')]]">
        Project showcases describing the problem space, the solution DigiProSoft built and the technology behind it. Client names and measured results are only published with the client's permission.
    </x-ui.page-hero>

    <section class="section" aria-label="Case studies">
        <div class="container-site">
            @if($studies->isEmpty())
                <p class="text-ink-600">Case studies are being prepared. In the meantime, explore our <a href="{{ route('products.index') }}" class="font-medium text-brand-700 underline underline-offset-4">products</a> or <a href="{{ route('contact.show') }}" class="font-medium text-brand-700 underline underline-offset-4">contact us</a> for references.</p>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($studies as $study)
                        <x-cards.case-study :study="$study" class="reveal" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta.final title="Have a similar project in mind?" text="Tell us about your business and we will show you relevant work in more detail during a free consultation." />
</x-layouts.app>
