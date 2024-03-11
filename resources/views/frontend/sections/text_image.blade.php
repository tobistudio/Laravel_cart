<div class="container">
    <div class="text-image-block {{ $data['margin_bottom'] ? 'margin-bottom' : '' }}">
        @if($data['image_right'])
            <div class="text">
                <h2 class="block-heading">{{ $data['title'] }}</h2>

                <div class="short-text">
                    {!! $data['description'] !!}
                </div>

                @if(count($data['text_items']) > 0)
                    @if($data['vertical_text_items'])
                        <div class="features-list">
                            @foreach($data['text_items'] as $text_item)
                                <div class="feature">
                                    <h3 class="name">{{ $text_item['name'] }}</h3>
                                    <div class="details">
                                        <p>{{ $text_item['value'] }}</p>
                                    </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="statistics">
                            @foreach($data['text_items'] as $text_item)
                                <div class="stat-col">
                                    <span class="amount">{{ $text_item['value'] }}</span>
                                    <p>{{ $text_item['name'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
            <div class="image">
                <img src="{{ $data['image'] }}" alt="{{ $data['title'] }}">
            </div>
        @else
            <div class="image">
                <img src="{{ $data['image'] }}" alt="{{ $data['title'] }}">
            </div>
            <div class="text">
                <h2 class="block-heading">{{ $data['title'] }}</h2>

                <div class="short-text">
                    {!! $data['description'] !!}
                </div>

                @if(count($data['text_items']) > 0)
                    @if($data['vertical_text_items'])
                        <div class="features-list">
                            @foreach($data['text_items'] as $text_item)
                                <div class="feature">
                                    <h3 class="name">{{ $text_item['name'] }}</h3>
                                    <div class="details">
                                        <p>{{ $text_item['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="statistics">
                            @foreach($data['text_items'] as $text_item)
                                <div class="stat-col">
                                    <span class="amount">{{ $text_item['value'] }}</span>
                                    <p>{{ $text_item['name'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>
