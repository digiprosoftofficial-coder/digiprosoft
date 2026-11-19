@props(['title', 'updated', 'breadcrumbs' => []])
<x-ui.page-hero eyebrow="Legal" :title="$title" :breadcrumbs="$breadcrumbs">
    Last updated: <time datetime="{{ $updated }}">{{ \Illuminate\Support\Carbon::parse($updated)->format('F j, Y') }}</time>
</x-ui.page-hero>
<section class="section">
    <div class="container-site">
        <div class="prose-dp mx-auto max-w-3xl">{{ $slot }}</div>
    </div>
</section>
