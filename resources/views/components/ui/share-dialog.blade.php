@props(['url', 'title'])
@php
    use App\Support\Site;
    use Illuminate\Support\Uri;

    $shareUrl = Site::absolute($url);
    $dialogId = 'share-dialog-'.substr(hash('sha256', $shareUrl), 0, 12);
    $titleId = $dialogId.'-title';
    $networks = [
        [
            'key' => 'facebook',
            'label' => 'Facebook',
            'icon' => 'facebook',
            'href' => (string) Uri::of('https://www.facebook.com/sharer/sharer.php')->withQuery(['u' => $shareUrl]),
            'class' => 'bg-[#1877F2] text-white',
        ],
        [
            'key' => 'whatsapp',
            'label' => 'WhatsApp',
            'icon' => 'whatsapp',
            'href' => (string) Uri::of('https://wa.me/')->withQuery(['text' => $title.' '.$shareUrl]),
            'class' => 'bg-[#25D366] text-white',
        ],
        [
            'key' => 'linkedin',
            'label' => 'LinkedIn',
            'icon' => 'linkedin',
            'href' => (string) Uri::of('https://www.linkedin.com/sharing/share-offsite/')->withQuery(['url' => $shareUrl]),
            'class' => 'bg-[#0A66C2] text-white',
        ],
        [
            'key' => 'x',
            'label' => 'X',
            'icon' => 'x-social',
            'href' => (string) Uri::of('https://twitter.com/intent/tweet')->withQuery(['url' => $shareUrl, 'text' => $title]),
            'class' => 'bg-ink-950 text-white',
        ],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'print:hidden', 'data-share' => true]) }}>
    <x-ui.button
        type="button"
        variant="primary"
        size="md"
        data-share-open
        aria-expanded="false"
        aria-controls="{{ $dialogId }}"
        aria-haspopup="dialog"
    >
        <x-ui.icon name="share" class="h-5 w-5" />
        Share this article
    </x-ui.button>

    <dialog
        id="{{ $dialogId }}"
        data-share-dialog
        closedby="any"
        aria-labelledby="{{ $titleId }}"
        class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border border-ink-200 bg-white p-6 shadow-elevated backdrop:bg-ink-950/40"
    >
        <div class="flex items-center justify-between gap-3">
            <h2 id="{{ $titleId }}" class="text-lg font-semibold text-ink-900">Share this article</h2>
            <button type="button" data-share-close class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-ink-700 hover:bg-ink-100" aria-label="Close">
                <x-ui.icon name="x" class="h-5 w-5" />
            </button>
        </div>

        <ul class="mt-6 flex flex-wrap justify-center gap-5" role="list">
            @foreach($networks as $network)
                <li>
                    <a
                        href="{{ $network['href'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex flex-col items-center gap-2 text-xs font-medium text-ink-600 hover:text-ink-900"
                    >
                        <span class="flex h-12 w-12 items-center justify-center rounded-full {{ $network['class'] }}">
                            <x-ui.icon :name="$network['icon']" class="h-5 w-5" />
                        </span>
                        {{ $network['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-6 flex items-center gap-2 rounded-full border border-ink-200 bg-ink-50 p-1.5 pl-4">
            <label class="sr-only" for="{{ $dialogId }}-url">Article URL</label>
            <input
                id="{{ $dialogId }}-url"
                type="text"
                readonly
                value="{{ $shareUrl }}"
                data-share-url
                class="min-w-0 flex-1 truncate bg-transparent text-sm text-ink-700 outline-none"
            >
            <button
                type="button"
                data-share-copy
                class="shrink-0 rounded-full bg-ink-900 px-4 py-2 text-sm font-semibold text-white hover:bg-ink-800"
            >
                Copy
            </button>
        </div>
        <p data-share-status class="sr-only" aria-live="polite"></p>
    </dialog>
</div>
