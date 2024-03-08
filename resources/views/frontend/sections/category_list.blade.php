<section class="cat-list section">
    <div class="list">
        @foreach($data['items'] as $item)
            @if($item['product_category'])
                <a href="{{ $item['product_category']['slug'] }}" class="category">
                    <div class="image">
                        <img src="{{ $item['product_category_image'] }}" alt="{{ $item['title'] ?: $item['product_category']['name'] }}">
                    </div>

                    <h2 class="cat-name">{{ $item['title'] ?: $item['product_category']['name'] }}</h2>
                </a>
            @endif
        @endforeach
    </div>
</section>
