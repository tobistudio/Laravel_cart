<header id="main-header" class="site-header">
    <div class="top-bar">
        <div class="container">
            <ul class="list-nav">
                @foreach($menus['top_menu'] as $top_menu_items)
                    <li><a href="{{ $top_menu_items['url'] }}">{{ $top_menu_items['text'] }}</a></li>
                @endforeach
            </ul>

            <ul class="right-side">
                <li>
                    <a href="mailto:info@rb24.lv">
                        <div class="icon">
                            <img src="/images/front/header-mail-icon.svg" alt="E-Mail">
                        </div>

                        <span>info@rb24.lv</span>
                    </a>
                </li>

                <li>
                    <a href="tel:+37123772424">
                        <div class="icon">
                            <img src="/images/front/header-phone-icon.svg" alt="Phone">
                        </div>

                        <span>+371 23 77 24 24</span>
                    </a>
                </li>

                {{--TODO: Style this one--}}
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
                <header-search></header-search>

                <ul class="user-links">
                    <header-search-mobile></header-search-mobile>
                    <header-auth></header-auth>
                    <header-my-cars></header-my-cars>
                    <header-mini-cart></header-mini-cart>
                </ul>
            </div>

        </div>
    </div>

    <div class="nav-block">
        <div class="container">
            <button type="button" class="product-catalog-btn">
                <div class="icon-holder">
                    <div class="icon"></div>
                </div>

                <span>Preču katalogs</span>
            </button>

            <ul class="main-navbar navbar-nav nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">Eļļas</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Akumulatori</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Spuldzes</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Ķīmija</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Aksesuāri</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Paklāji</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Moto daļas</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Universālās daļas</a>
                </li>
            </ul>
        </div>
    </div>
</header>
