<section class="popular-products" id="popular-products-carousel">
    <h2 class="section-heading">{{ $data['title'] }}</h2>

    <div class="products-swiper-wrapper">
        <div class="swiper products-swiper">
            <div class="swiper-wrapper">
                @foreach($data['items'] as $item)
                    <div class="swiper-slide">
                        <div class="product-card">
                            @if($item['manufacturer'])
                                <a href="{{ $item['slug'] }}" class="manufacturer">
                                    <img src="{{ $item['manufacturer']['image'] }}" alt="{{ $item['manufacturer']['name'] }}">
                                </a>
                            @endif

                            <a href="{{ $item['slug'] }}" class="image">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">


                                @if(count($item['labels']) > 0)
                                    <div class="product-label">
                                        @foreach($item['labels'] as $label)
                                        <div class="label {{ $label['key'] }}">{{ $label['name'] }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </a>

                            <div class="details">
                                <h3 class="name">
                                    <a href="{{ $item['slug'] }}">{{ $item['name'] }}</a>
                                </h3>

                                <div class="product-code">Preces kods: {{ $item['sku'] }}</div>

                                <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>

                                <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>

                                <div class="price">
                                    @if($item['special_price'])
                                        <span class="new-price">{{ '€' . $item['special_price'] }}</span>
                                        <span class="old-price">{{ '€' . $item['price'] }}</span>

                                        <span class="discount">-{{ $item['discount_percentage'] }}%</span>
                                    @else
                                        {{ '€' . $item['price'] }}
                                    @endif
                                </div>

                                <div class="add-to-cart">
                                    <div class="form">
                                        <div class="form-group d-flex checkbox">
                                            <input id="compare-1" name="checkbox" type="checkbox">
                                            <label for="compare-1">Pievienot salīdzināšanai (0/3)</label>
                                        </div>

                                        <button type="button" class="cart-btn btn btn-primary">Ielikt grozā</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="swiper-pagination"></div>

        <div class="swiper-nav">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
