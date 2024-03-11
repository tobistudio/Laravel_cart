@foreach($data['items'] as $item)
    <div class="block payment">
        @if($item['title'] && !$item['hide_title'])
            <h2>{{ $item['title'] }}</h2>
        @endif
        {!! $item['description'] !!}


            @if($item['warning'])
                @foreach($item['blocks'] as $block)
                    <div class="info-warning">{!! $block['description']  !!}</div>
                @endforeach
            @else
                <div class="logo-list">
                    @foreach($item['blocks'] as $block)
                        <div class="logo">
                            <img src="{{ $block['icon_image'] }}" alt="{{ $block['title'] }}">
                        </div>
                    @endforeach
                </div>
            @endif

    </div>
@endforeach
