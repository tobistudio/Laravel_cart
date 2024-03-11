@extends('frontend.layouts.default')

@section('content')
    <main id="main" class="site-main" role="main">
        @if(isset($page_header) && $page_header)
            @include('frontend.sections.page_header', ['data' => $page_header])
        @endif

        <div class="{{ isset($sidebar_blocks) && count($sidebar_blocks) > 0 ? 'container' : '' }}">
            <div class="{{ isset($sidebar_blocks) && count($sidebar_blocks) > 0 ? 'content-with-sidebar' : 'content' }}">
                <aside class="sidebar">
                    @foreach($sidebar_blocks as $sidebar_block)
                        @if($sidebar_block['key'] === 'block-icon-text')
                            @include('frontend.sections.sidebar_text_icon', ['data' => $sidebar_block['data']])
                        @endif
                        @if($sidebar_block['key'] === 'block-navigation')
                            @include('frontend.sections.sidebar_navigation', ['data' => $sidebar_block['data']])
                        @endif
                    @endforeach
                </aside>

                <div class="content">
                    @if(isset($blocks))
                        @foreach($blocks as $block)
                            @if($block['key'] === 'block-hero-search')
                                @include('frontend.sections.hero', ['locale' => $extra['locale'], 'vehicle_brands' => $vehicle_brands, 'data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-icon-text')
                                @include('frontend.sections.text_icon', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-table')
                                @include('frontend.sections.table', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-popular-categories')
                                @include('frontend.sections.category_list', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-two-banner')
                                @include('frontend.sections.two_banners', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-popular-products')
                                @include('frontend.sections.popular_products', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-recent-posts')
                                @include('frontend.sections.newest_posts', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-text-image')
                                @include('frontend.sections.text_image', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-text-complex')
                                @include('frontend.sections.text_complex', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-text-simple')
                                @include('frontend.sections.text_simple', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-download')
                                @include('frontend.sections.download', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-list')
                                @include('frontend.sections.list', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-full-width-text-background-image')
                                @include('frontend.sections.full_width_text_background_image', ['data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-contact-details')
                                @include('frontend.sections.contact_details', ['store_information' => $store_information, 'data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-contact-form')
                                @include('frontend.sections.contact_form', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-choose-vehicle')
                                @include('frontend.sections.choose_vehicle', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-product-category')
                                @include('frontend.sections.product_category', ['locale' => $extra['locale'], 'vehicle_brands' => $vehicle_brands, 'data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-product')
                                @include('frontend.sections.product', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-product-compare')
                                @include('frontend.sections.product_compare', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-blog')
                                @include('frontend.sections.blog', ['locale' => $extra['locale'], 'vehicle_brands' => $vehicle_brands, 'data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-blog-post')
                                @include('frontend.sections.blog_post', ['locale' => $extra['locale'], 'vehicle_brands' => $vehicle_brands, 'data' => $block['data']])
                            @endif
                            @if($block['key'] === 'block-cart')
                                @include('frontend.sections.cart', ['data' => $block['data'], 'locale' => $extra['locale']])
                            @endif
                            @if($block['key'] === 'block-profile')
                                @include('frontend.sections.profile', ['locale' => $extra['locale'], 'profile_page_slug' => $profile_page_slug, 'vehicle_brands' => $vehicle_brands])
                            @endif
                            @if($block['key'] === 'purchase-made')
                                @include('frontend.sections.purchase_made', ['locale' => $extra['locale'], 'profile_page_slug' => $profile_page_slug, 'vehicle_brands' => $vehicle_brands])
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @if(isset($newsletter) && $newsletter)
            @include('frontend.sections.newsletter', ['locale' => $extra['locale']])
        @endif
    </main>
@endsection
