@php
    $current = app()->getLocale();
    $supported = config('localization.supported', ['en', 'bn']);
    $labels = ['en' => 'EN', 'bn' => 'বাং'];
@endphp
<div {{ $attributes->class('inline-flex items-center rounded-lg border border-ink-200/90 bg-white p-0.5 text-xs font-semibold shadow-sm') }} role="group" aria-label="{{ __('Language') }}">
    @foreach($supported as $locale)
        <a href="{{ route('locale.switch', $locale) }}"
           hreflang="{{ $locale }}"
           lang="{{ $locale }}"
           class="rounded-md px-2.5 py-1.5 transition-colors {{ $current === $locale ? 'bg-brand-600 text-white' : 'text-ink-600 hover:bg-ink-50 hover:text-ink-950' }}"
           @if($current === $locale) aria-current="true" @endif>
            {{ $labels[$locale] ?? strtoupper($locale) }}
        </a>
    @endforeach
</div>
