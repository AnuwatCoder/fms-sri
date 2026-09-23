@props(['title', 'eyebrow', 'description', 'icon'])

<section class="page-hero" aria-labelledby="page-title">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb page-hero__breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        <div class="page-hero__heading">
            <span class="page-hero__icon" aria-hidden="true"><i class="bi {{ $icon }}"></i></span>
            <div>
                <p>{{ $eyebrow }}</p>
                <h1 id="page-title">{{ $title }}</h1>
                <div>{{ $description }}</div>
            </div>
        </div>
    </div>
</section>
