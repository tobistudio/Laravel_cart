<header id="main-header" class="site-header">
    <div class="top-bar">
        <div class="container">
            <ul class="list-nav">
{{--                @foreach($menus['top_menu'] as $top_menu_item)--}}
{{--                    <li><a href="{{ $top_menu_item['url'] }}">{{ $top_menu_item['text'] }}</a></li>--}}
{{--                @endforeach--}}
            </ul>

            <ul class="right-side">
                @if($store_information['email'])
                    <li>
                        <a href="mailto:{{ $store_information['email'] }}">
                            <div class="icon">
                                <img src="/images/front/header-mail-icon.svg" alt="E-Mail">
                            </div>

                            <span>{{ $store_information['email'] }}</span>
                        </a>
                    </li>
                @endif

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

                <li class="lang-bar">
                    <div class="active">
                        <img src="{{ $languages['active']['flag'] }}" class="flag" alt="{{ $languages['active']['name'] }}"/>
                        <span class="name">{{ $languages['active']['name'] }}</span>
                    </div>
                    <div class="language-switcher">
                        @foreach($languages['data'] as $language)
                            @if($language['active'])
                                <div class="language active">
                                    <img src="{{ $language['flag'] }}" class="flag" alt="{{ $language['name'] }}"/>
                                    <span class="name">{{ $language['name'] }}</span>
                                </div>
                            @else
                                <a href="{{ $language['slug'] }}" title="{{ $language['name'] }}" class="language">
                                    <img src="{{ $language['flag'] }}" class="flag" alt="{{ $language['name'] }}"/>
                                    <span class="name">{{ $language['name'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="mid-block">
        <div class="container">
            <button type="button" class="product-catalog-btn mobile">
                <div class="icon-holder">
                    <div class="icon"></div>
                </div>
            </button>

            <a href="{{ $locale ?: '/' }}" class="logo">
                <img src="/images/front/logo.svg" alt="{{ env('APP_NAME') }}">
            </a>

            <div class="right-side-holder d-flex">
                <header-search :locale="{{ json_encode($extra['locale']) }}"></header-search>

                <ul class="user-links">
                    <header-search-mobile :locale="{{ json_encode($extra['locale']) }}"></header-search-mobile>
                    <header-auth :locale="{{ json_encode($extra['locale']) }}" :profile_page_slug="{{ json_encode($profile_page_slug) }}"></header-auth>
                    <header-my-cars :locale="{{ json_encode($extra['locale']) }}" :vehicle_brands="{{ json_encode($vehicle_brands) }}"></header-my-cars>
                    <header-mini-cart :locale="{{ json_encode($extra['locale']) }}"></header-mini-cart>
                </ul>
            </div>

        </div>
    </div>

    <div class="nav-block">
        <div class="container">
            <header-catalog-button :locale="{{ json_encode($extra['locale']) }}"></header-catalog-button>

            <ul class="main-navbar navbar-nav nav">
                @foreach($menus['main_menu'] as $main_menu_item)
                    <li class="nav-item">
                        <a href="{{ $main_menu_item['url'] }}">{{ $main_menu_item['text'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>
