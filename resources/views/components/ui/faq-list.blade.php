@props(['faqs', 'open' => false])
{{-- Native <details> keeps this accessible and JS-free. --}}
<div {{ $attributes->merge(['class' => 'divide-y divide-ink-200 rounded-2xl border border-ink-200 bg-white']) }}>
    @foreach($faqs as $i => $faq)
        @php
            $q = is_array($faq) ? $faq['question'] : $faq->question;
            $a = is_array($faq) ? $faq['answer'] : $faq->answer;
        @endphp
        <details class="group px-5 sm:px-6" @if($open && $i === 0) open @endif>
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 py-5 text-left text-base font-semibold text-ink-900 [&::-webkit-details-marker]:hidden">
                <span>{{ $q }}</span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-ink-100 text-ink-600 transition-[transform,background-color] group-open:rotate-45 group-open:bg-brand-600 group-open:text-white" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                </span>
            </summary>
            <div class="prose-dp pb-6 text-[0.9875rem]">{!! \App\Support\Content\RichText::markdown($a) !!}</div>
        </details>
    @endforeach
</div>
