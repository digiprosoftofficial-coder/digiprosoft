@props(['seo'])
@php
    /** @var \App\Support\Seo\SeoMeta $seo */
    $title = $seo->fullTitle();
    $description = $seo->description();
    $canonical = $seo->canonicalUrl();
    $image = $seo->imageUrl();
@endphp
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $seo->robots() }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:site_name" content="{{ \App\Support\Site::name() }}">
<meta property="og:locale" content="{{ config('site.seo.locale') }}">
<meta property="og:type" content="{{ $seo->ogType() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $seo->pageTitle() }} — {{ \App\Support\Site::name() }}">
@if($seo->publishedTime())
<meta property="article:published_time" content="{{ $seo->publishedTime() }}">
@endif
@if($seo->modifiedTime())
<meta property="article:modified_time" content="{{ $seo->modifiedTime() }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
@if($handle = \App\Support\Site::twitterHandle())
<meta name="twitter:site" content="{{ str_starts_with($handle, '@') ? $handle : '@'.$handle }}">
@endif

@if($v = \App\Support\Site::googleVerification())
<meta name="google-site-verification" content="{{ $v }}">
@endif
@if($v = \App\Support\Site::bingVerification())
<meta name="msvalidate.01" content="{{ $v }}">
@endif

<script type="application/ld+json">{!! json_encode($seo->jsonLd(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
