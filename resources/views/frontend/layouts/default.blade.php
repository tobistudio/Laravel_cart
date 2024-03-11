<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <title>{{ $meta_data['title'] }}</title>

        <meta name="description" content="{{ $meta_data['description'] }}">
        <meta name="og:type" content="{{ $meta_data['og:type'] }}">
        <meta name="og:title" content="{{ $meta_data['og:title'] }}">
        <meta name="og:description" content="{{ $meta_data['og:description'] }}">
        <meta name="og:url" content="{{ $meta_data['og:url'] }}">
        <meta name="og:image" content="{{ $meta_data['og:image'] }}">
        <meta name="og:image:type" content="{{ $meta_data['og:image:type'] }}">
        <meta name="og:image:width" content="{{ $meta_data['og:image:width'] }}">
        <meta name="og:image:height" content="{{ $meta_data['og:image:height'] }}">
        <meta name="twitter:card" content="{{ $meta_data['twitter:card'] }}">
        <meta name="twitter:title" content="{{ $meta_data['twitter:title'] }}">
        <meta name="twitter:description" content="{{ $meta_data['twitter:description'] }}">
        <meta name="twitter:image" content="{{ $meta_data['twitter:image'] }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500;600&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        <title></title>
        @vite(['resources/front/css/style.scss'])
        @stack('styles')
    </head>
    <body>
        <div id="app">
            @include('frontend.components.header', ['store_information' => $store_information])

            @yield('content')

            @include('frontend.components.footer', ['store_information' => $store_information])

            <auth-popup :extra="{{ json_encode($extra) }}"></auth-popup>
            <catalog-navigation :locale="{{ json_encode($extra['locale']) }}"></catalog-navigation>
            <compare :locale="{{ json_encode($extra['locale']) }}"></compare>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        @vite(['resources/front/js/app.js'])

        @vite(['resources/js/front/apps.js'])
        @stack('scripts')
    </body>
</html>
