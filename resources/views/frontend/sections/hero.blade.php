<section class="hero" style="background:url(' {{ env('APP_URL') . $data['background_image'] }} ') center center no-repeat; background-size: cover;">
    <div class="container">
        <div class="heading-wrapper">
            <h2 class="section-heading">{{ $data['title'] }}</h2>
            {!! $data['description'] !!}
        </div>

        <div class="form">
            @if($data['plate_number_search'])
                <div class="car-number">
                <div class="form-group d-flex">
                    <div class="country">
                        <div>
                            <img src="/images/front/eu-stars.png" alt="">
                            <span class="name">LV</span>
                        </div>
                    </div>

                    <input type="text" name="" class="form-control" placeholder="AA 1234">
                </div>

                <button type="submit" class="search-btn btn btn-primary"></button>
            </div>
            @endif

            @if($data['plate_number_search'])
                <div class="mobile-sep">
                <span>vai</span>
            </div>
            @endif

            <div class="car-parameters">
                <div class="form-group w-210">
                    <select name="" id="" class="form-control">
                        <option value="" disabled selected hidden>Izvēlies auto marku</option>
                        <option value="Option 1">Option 1</option>
                        <option value="Option 2">Option 2</option>
                        <option value="Option 3">Option 3</option>
                    </select>
                </div>

                <div class="form-group w-150 mobile-hidden">
                    <input type="number" name="" class="form-control" placeholder="Gads">
                </div>

                <div class="form-group w-220 mobile-hidden">
                    <input type="text" name="" class="form-control" placeholder="Modelis">
                </div>

                <div class="form-group w-220 mobile-hidden">
                    <input type="text" name="" class="form-control" placeholder="Dzinējs">
                </div>

                <button type="submit" class="search-btn btn btn-primary"></button>
            </div>
        </div>

        @if($data['show_vehicle_brands'])
            <div class="popular-brands">
                <div class="block-heading">{{ $data['vehicle_brands_title'] }}</div>

                <div class="swiper popular-brands-swiper">
                    <div class="swiper-wrapper">
                        @foreach($data['vehicle_brands'] as $vehicle_brand)
                            <div class="swiper-slide">
                                <a href="{{ $vehicle_brand['slug'] }}" class="brand">{{ $vehicle_brand['name'] }}</a>
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
