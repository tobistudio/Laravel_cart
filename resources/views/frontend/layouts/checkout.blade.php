<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        @vite(['resources/front/css/style.scss'])
        @stack('styles')
    </head>
    <body>
        <div id="app">
            <header id="main-header" class="site-header checkout-header">
                <div class="mid-block">
                    <div class="container">
                        <a href="{{ $locale ?: '/' }}" class="logo">
                            <img src="/images/front/logo-white.svg" alt="{{ env('APP_NAME') }}">
                        </a>

                        <ul class="right-side">
                            @if($store_information['phone_primary'])
                                <li>
                                    <a href="tel:{{ $store_information['phone_primary'] }}">
                                        <div class="icon">
                                            <img src="/images/front/header-phone-icon.svg" alt="Phone">
                                        </div>

                                        <span>{{ $store_information['phone_primary'] }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </header>

            @yield('content')

            <footer id="main-footer" class="checkout-footer">
                <div class="footer-content">
                    <div class="container">
                        <ul class="footer-nav">
                            @foreach($data['checkout_footer_menu'] as $footer_menu_item)
                                <li><a href="{{ $footer_menu_item['url'] }}">{{ $footer_menu_item['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </footer>
        </div>

        @vite(['resources/js/front/apps.js'])
        @stack('scripts')
    </body>
</html>
