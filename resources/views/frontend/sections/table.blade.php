@foreach($data['items'] as $item)
    <div class="info-table-block">
        <h2 class="block-heading">{{ $item['title'] }}</h2>

        <div class="inner-content">
            @foreach($item['blocks'] as $item_block)
                    @if($item_block['vertical'])
                        <div>
                            <span class="text-block-name">{{ $item_block['title'] }}</span>

                            @foreach($item_block['items'] as $item_block_item)
                                    @if($item_block_item['warning'])
                                        <div class="{{ $item_block_item['warning'] ? 'info-warning' : '' }}">
                                            <h5>{{ $item_block_item['title'] }}</h5>

                                            {!! $item_block_item['description'] !!}
                                        </div>
                                    @else
                                        <h3>{{ $item_block_item['title'] }}</h3>

                                        {!! $item_block_item['description'] !!}
                                    @endif
                            @endforeach
                        </div>
                    @else
                        <table class="table stores-addresses {{ isset($item_block['no_border']) && $item_block['no_border'] ? 'no-border' : '' }}">
                            <tbody>
                            <tr>
                                @foreach($item_block['items'] as $item_block_item)
                                    <td class="{{ $item_block_item['logo'] ? 'logo' : ($item_block_item['address'] ? 'address' : '') }}">
                                        @if($item_block_item['logo'])
                                            <img src="{{ $item_block_item['logo_image'] }}" alt="{{ $item_block_item['title'] }}">
                                        @elseif($item_block_item['address'])
                                            <span class="text-block-name">{{ $item_block_item['title'] }}</span>

                                            <span class="address-name"><a href="{{ $item_block_item['address_link'] }}" target="blank">{{ $item_block_item['address_text'] }}</a></span>
                                        @else
                                            @if($item_block_item['warning'])
                                                <div class="info-warning">
                                                    <h5>{{ $item_block_item['title'] }}</h5>

                                                    {!! $item_block_item['description'] !!}
                                                </div>
                                            @else
                                                <span class="text-block-name">{{ $item_block_item['title'] }}</span>

                                                {!! $item_block_item['description'] !!}
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    @endif
            @endforeach
        </div>
    </div>
@endforeach
