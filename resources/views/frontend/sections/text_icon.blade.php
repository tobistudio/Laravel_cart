<div class="container">
    <section class="why-us">
        <div class="list">
            @foreach($data['items'] as $item)
                <div class="col">
                    <div class="icon">
                        <img src="{{ $item['icon_image'] }}" alt="{{ $item['title'] }}">
                    </div>

                    <div class="details">
                        <h4 class="heading">{{ $item['title'] }}</h4>
                        {!! $item['description'] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
