@props([
    'title' => 'FMS Portal',
    'description' => 'ศูนย์รวมระบบสารสนเทศ งานแผนยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์',
])

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <title>{{ $title }} | FMS Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=noto-sans-thai:400,500,600,700|prompt:500,600,700" rel="stylesheet">
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
