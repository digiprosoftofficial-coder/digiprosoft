@props(['problem' => null, 'solution' => null])
@if($problem || $solution)
<section class="section-tight" aria-labelledby="problem-solution-heading">
    <div class="container-site">
        <h2 id="problem-solution-heading" class="sr-only">The problem and our solution</h2>
        <div class="grid gap-6 lg:grid-cols-2">
            @if($problem)
                <div class="rounded-2xl border border-ink-200 bg-ink-50/70 p-7 lg:p-9 reveal">
                    <p class="eyebrow">The problem</p>
                    <div class="prose-dp mt-4">{!! \App\Support\Content\RichText::markdown($problem) !!}</div>
                </div>
            @endif
            @if($solution)
                <div class="rounded-2xl border border-brand-200 bg-brand-50/60 p-7 lg:p-9 reveal">
                    <p class="eyebrow">Our solution</p>
                    <div class="prose-dp mt-4">{!! \App\Support\Content\RichText::markdown($solution) !!}</div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
