@props(['faqs' => [], 'title' => 'Frequently asked questions', 'eyebrow' => 'FAQ'])
@if(!empty($faqs) && count($faqs))
<section class="section" aria-labelledby="faq-section-heading">
    <div class="container-site grid gap-10 lg:grid-cols-12 lg:gap-16">
        <div class="lg:col-span-4">
            <x-ui.section-heading :eyebrow="$eyebrow" :title="$title" class="reveal">{{ $slot }}</x-ui.section-heading>
            <p class="mt-6 text-sm text-ink-600 reveal">Have a different question? <a href="{{ route('contact.show') }}" class="font-semibold text-brand-700 underline underline-offset-4">Ask us directly</a> or browse <a href="{{ route('faq') }}" class="font-semibold text-brand-700 underline underline-offset-4">all FAQs</a>.</p>
        </div>
        <div class="lg:col-span-8 reveal">
            <x-ui.faq-list :faqs="$faqs" />
        </div>
    </div>
</section>
@endif
