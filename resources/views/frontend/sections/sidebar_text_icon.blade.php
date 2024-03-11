<div class="benefits-block">
    @foreach($data['items'] as $item)
        <div class="benefit">
            <div class="icon">
                <img src="{{ $item['icon_image'] }}" alt="{{ $item['title'] }}">
            </div>

            <span class="name">{{ $item['title'] }}</span>
        </div>
    @endforeach
</div>
