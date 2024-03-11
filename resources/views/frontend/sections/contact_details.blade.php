<div class="container">
    <div class="contacts-details-block">
        <div class="details">
            <h2 class="section-heading">{{ $data['title'] }}</h2>

{{--            @dump($store_information)--}}
            <div class="blocks-list">
                <div class="block">
                    <ul>
                        @if($store_information['address'])
                            <li class="location"><a href="{{ $store_information['address_url'] }}" target="_blank">{{ $store_information['address'] }}</a></li>
                        @endif
                        @if($store_information['phone_primary'] || $store_information['phone_secondary'])
                            <li class="phone">
                                @if($store_information['phone_primary'])
                                    <a href="mailto:{{ $store_information['phone_primary'] }}">{{ $store_information['phone_primary'] }}</a>
                                @endif
                                @if($store_information['phone_primary'] && $store_information['phone_secondary'])
                                    <span> vai </span>
                                @endif
                                @if($store_information['phone_secondary'])
                                    <a href="mailto:{{ $store_information['phone_primary'] }}">{{ $store_information['phone_primary'] }}</a>
                                @endif
                            </li>
                        @endif
                        @if($store_information['email'])
                            <li class="email"><a href="mailto:{{ $store_information['email'] }}">{{ $store_information['email'] }}</a></li>
                        @endif
                    </ul>
                </div>

                @if(count($store_information['working_hours']) > 0)
                    <div class="block work-time">
                        <h3 class="block-heading">{{ $data['working_hours_title'] }}</h3>
                        <ul>
                            @foreach($store_information['working_hours'] as $working_hours)
                                <li><span>{{ $working_hours['name'] }}</span> {{ $working_hours['value'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(count($store_information['credentials']) > 0)
                    <div class="block company-details">
                        <h3 class="block-heading">{{ $data['credentials_title'] }}</h3>

                        <ul>
                            @foreach($store_information['credentials'] as $credentials)
                                <li><span>{{ $credentials['name'] . ':' }}</span> {{ $credentials['value'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="google-map">
            {!! $data['google_map'] !!}
        </div>
    </div>
</div>
