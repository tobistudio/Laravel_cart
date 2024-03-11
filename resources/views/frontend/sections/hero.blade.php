<section class="hero" style="background:url(' {{ env('APP_URL') . $data['background_image'] }} ') center center no-repeat; background-size: cover;">
    <div class="container">
        <div class="heading-wrapper">
            <h2 class="section-heading">{{ $data['title'] }}</h2>
            {!! $data['description'] !!}
        </div>

        <hero-vehicle-search :locale="{{ json_encode($locale) }}" :vehicle_brands="{{ json_encode($vehicle_brands) }}" :data="{{ json_encode($data) }}" :is_category="false"></hero-vehicle-search>

        @if($data['show_vehicle_brands'])
            <div class="popular-brands">
                <div class="block-heading">{{ $data['vehicle_brands_title'] }}</div>

                <div class="swiper popular-brands-swiper">
                    <div class="swiper-wrapper">
                        @foreach($data['popular_vehicle_brands'] as $popular_vehicle_brand)
                            <div class="swiper-slide">
                                <a href="{{ $popular_vehicle_brand['slug'] }}" class="brand">{{ $popular_vehicle_brand['name'] }}</a>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-nav">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
