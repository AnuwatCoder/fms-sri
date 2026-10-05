<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if ($seoSetting->keywords)<meta name="keywords" content="{{ $seoSetting->keywords }}">@endif
    @if ($seoSetting->author)<meta name="author" content="{{ $seoSetting->author }}">@endif
    <meta name="robots" content="{{ $seoSetting->robots_content }}">
    <meta name="theme-color" content="#003b71">
    @if ($seoSetting->google_site_verification)<meta name="google-site-verification" content="{{ $seoSetting->google_site_verification }}">@endif
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <meta property="og:locale" content="th_TH">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:site_name" content="{{ $seoSetting->site_name }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ $metaTitle }}">
    <meta name="twitter:card" content="summary_large_image">
    @if ($seoSetting->twitter_site)<meta name="twitter:site" content="{{ $seoSetting->twitter_site }}">@endif
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @vite(['resources/js/app.js'])
    @livewireStyles
</head>
<body>
    @persist('page-progress')
        <div class="page-progress" data-page-progress role="progressbar" aria-label="กำลังโหลดหน้า" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-hidden="true"></div>
    @endpersist
    <a class="skip-link" href="#main-content">ข้ามไปยังเนื้อหาหลัก</a>
    <x-site-header />
    {{ $slot }}
    <x-site-footer />
    @livewireScripts
</body>
</html>
