@extends('frontend.layouts.default')

@section('content')
    <main id="main" class="site-main" role="main">
        @if($url === 'kontakti')
            Kontakti html here
        @elseif($url === 'par-mums')
            par mums html here
        @elseif($url === 'piegade')
            piegade html here
        @elseif($url === 'atteikuma-tiesibas')
            atteikuma tiesibas html here
        @elseif($url === 'marketinga-piekrisana')
            marketinga piekrišana html here
        @endif

        @foreach($blocks as $block)
            @if($block['key'] === 'block-hero-search')
                @include('frontend.sections.hero', ['data' => $block['data']])
            @endif
            @if($block['key'] === 'block-icon-text')
                <div class="container">
                    @include('frontend.sections.why_us', ['data' => $block['data']])
                </div>
            @endif
            @if($block['key'] === 'block-popular-categories')
                <div class="container">
                    @include('frontend.sections.category_list', ['data' => $block['data']])
                </div>
            @endif
            @if($block['key'] === 'block-two-banner')
                <div class="container">
                    @include('frontend.sections.two_banners', ['data' => $block['data']])
                </div>
            @endif
            @if($block['key'] === 'block-popular-products')
                <div class="container">
                    @include('frontend.sections.popular_products', ['data' => $block['data']])
                </div>
            @endif
            @if($block['key'] === 'block-recent-posts')
                <div class="container">
                    @include('frontend.sections.newest_posts', ['data' => $block['data']])
                </div>
            @endif
            @if($block['key'] === 'block-newsletter')
                @include('frontend.sections.newsletter', ['data' => $block['data']])
            @endif
            @if($block['key'] === 'block-product-details')
                    @include('frontend.sections.product_details', ['data' => $block['data']])
            @endif
                @if($block['key'] === 'block-cart-items')
                    @include('frontend.sections.cart', ['data' => $block['data']])
                @endif
        @endforeach
</main>
@endsection
