@props(['benefits' => [], 'title' => 'What it means for your business', 'eyebrow' => 'Benefits'])
@if(!empty($benefits))
<section class="section bg-brand-950 text-white" aria-labelledby="benefits-heading">
    <div class="container-site grid gap-10 lg:grid-cols-12 lg:gap-16">
        <div class="lg:col-span-4 reveal">
            <p class="eyebrow text-brand-300 before:bg-brand-300">{{ $eyebrow }}</p>
            <h2 id="benefits-heading" class="text-display-md mt-3 text-white">{{ $title }}</h2>
            @if(trim($slot))<p class="mt-4 text-ink-300">{{ $slot }}</p>@endif
        </div>
        <ul class="grid gap-6 sm:grid-cols-2 lg:col-span-8" role="list">
            @foreach($benefits as $benefit)
                <li class="flex gap-4 rounded-2xl bg-white/5 p-6 ring-1 ring-white/10 reveal">
                    <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent-500/20 text-accent-400"><x-ui.icon name="check" class="h-4 w-4" /></span>
                    <div>
                        <h3 class="text-base font-semibold text-white">{{ $benefit['title'] }}</h3>
                        @if(!empty($benefit['description']))<p class="mt-1.5 text-sm leading-relaxed text-ink-300">{{ $benefit['description'] }}</p>@endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif
