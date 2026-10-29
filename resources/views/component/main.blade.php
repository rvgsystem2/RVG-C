<!DOCTYPE html>
<html lang="en"><head>
    @php
        $seo = $seos ?? null;
        // dd($seos);
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    @if (!empty($seo?->meta_title))
        <meta name="title" content="{{ $seo->meta_title }}">
    @endif

    @if (!empty($seo?->title))
        <title>{{ $seo->title }}</title>
    @elseif(!empty($seo?->meta_title))
        <title>{{ $seo->meta_title }}</title>
    @endif

    <!-- Standard SEO -->
    @if (!empty($seo?->meta_description))
        <meta name="description" content="{{ $seo->meta_description }}">
    @endif

    @if (!empty($seo?->meta_keywords))
        <meta name="keywords" content="{{ $seo->meta_keywords }}">
    @endif

    @if (!empty($seo?->robots))
        <meta name="robots" content="{{ $seo->robots }}">
    @endif

    @if (!empty($seo?->author))
        <meta name="author" content="{{ $seo->author }}">
    @endif

    <!-- Canonical & Language -->
    @if (!empty($seo?->canonical_url))
        <link rel="canonical" href="{{ $seo->canonical_url }}">
    @endif

    @if (!empty($seo?->locale))
        <meta name="language" content="{{ $seo->locale }}">
        <meta http-equiv="Content-Language" content="{{ $seo->locale }}">
    @endif

    <!-- Alternate hreflang -->
    @if (!empty($seo?->alternate_url))
        <link rel="alternate" hreflang="{{ $seo->alternate_href_lang ?? 'en' }}" href="{{ $seo->alternate_url }}">
    @endif

    <!-- Region, Country, Timezone -->
    @if (!empty($seo?->country))
        <meta name="country" content="{{ $seo->country }}">
    @endif
    @if (!empty($seo?->region))
        <meta name="region" content="{{ $seo->region }}">
    @endif
    @if (!empty($seo?->timezone))
        <meta name="timezone" content="{{ $seo->timezone }}">
    @endif

    <!-- Breadcrumb & Page Type -->
    @if (!empty($seo?->breadcrumb_title))
        <meta name="breadcrumb" content="{{ $seo->breadcrumb_title }}">
    @endif

    @if (!empty($seo?->content_type))
        <meta name="content_type" content="{{ $seo->content_type }}">
    @endif

    @if (!empty($seo?->page_type))
        <meta name="page_type" content="{{ $seo->page_type }}">
    @endif

    <!-- Sitemap Hints -->
    @if (!empty($seo?->priority))
        <meta name="priority" content="{{ $seo->priority }}">
    @endif

    @if (!empty($seo?->changefreq))
        <meta name="changefreq" content="{{ $seo->changefreq }}">
    @endif

    <!-- Open Graph -->
    @if (!empty($seo?->og_title))
        <meta property="og:title" content="{{ $seo->og_title }}">
    @endif

    @if (!empty($seo?->og_description))
        <meta property="og:description" content="{{ $seo->og_description }}">
    @endif

    @if (!empty($seo?->og_image))
        <meta property="og:image" content="{{ asset('storage/' . $seo->og_image) }}">
        <meta property="og:image:secure_url" content="{{ asset('storage/' . $seo->og_image) }}">
    @endif

    @if (!empty($seo?->og_type))
        <meta property="og:type" content="{{ $seo->og_type }}">
    @endif

    @if (!empty($seo?->og_url))
        <meta property="og:url" content="{{ $seo->og_url }}">
    @endif

    <!-- Twitter Card -->
    @if (!empty($seo?->twitter_card))
        <meta name="twitter:card" content="{{ $seo->twitter_card }}">
    @endif

    @if (!empty($seo?->twitter_title))
        <meta name="twitter:title" content="{{ $seo->twitter_title }}">
    @endif

    @if (!empty($seo?->twitter_description))
        <meta name="twitter:description" content="{{ $seo->twitter_description }}">
    @endif

    @if (!empty($seo?->twitter_image))
        <meta name="twitter:image" content="{{ asset('storage/' . $seo->twitter_image) }}">
    @endif

    @if (!empty($seo?->twitter_site))
        <meta name="twitter:site" content="{{ $seo->twitter_site }}">
    @endif

    @if (!empty($seo?->twitter_creator))
        <meta name="twitter:creator" content="{{ $seo->twitter_creator }}">
    @endif

    <!-- Focus Keyword -->
    @if (!empty($seo?->focus_keyword))
        <meta name="focus_keyword" content="{{ $seo->focus_keyword }}">
    @endif


  {{-- @if(!empty($seo?->meta_tags))
    @php
      // Sirf meta/link allow; baaki strip so koi style/script ghuske content print na kare
      $safeMeta = preg_replace('/<(?!\/?(?:meta|link)\b)[^>]*>/i', '', $seo->meta_tags);
    @endphp
    {!! $safeMeta !!}
@endif --}}

    {{-- JSON-LD: escape closing script --}}
    @if (!empty($seo?->structured_data_json))
        @php $jsonLd = str_replace('</script>', '<\/script>', $seo->structured_data_json); @endphp
        <script type="application/ld+json">{!! $jsonLd !!}</script>
    @endif


@if(empty($seo?->title) && empty($seo?->meta_title))<title>Real Victory Groups — Design. Build. Grow.</title>@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('logo.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('front-asset/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
@vite(['resources/css/premium.css', 'resources/js/premium.js'])
@stack('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D28Z1KG941"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config','G-D28Z1KG941');</script>
</head><body>
<a class="rvg-skip" href="#main-content">Skip to content</a>
@include('component.header')
@if(session('success'))<div class="rvg-alert" role="status">{{ session('success') }}</div>@endif
@if(session('error'))<div class="rvg-alert" role="alert">{{ session('error') }}</div>@endif
@if($errors->any())<div class="rvg-alert" role="alert"><strong>Please check your details.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<main id="main-content" class="@yield('page_class', 'rvg-legacy')">@yield('content')</main>
@include('component.footer')
<button class="rvg-backtop" data-backtop aria-label="Back to top">↑</button>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body></html>