<footer id="main-footer">
    <div class="footer-content">
        <div class="container">
            <div class="footer-cols">
                <div class="col contacts-col">
                    <div class="holder">
                        <div class="logo">
                            <img src="/images/front/footer-logo.svg" alt="{{ env('APP_NAME') }}">
                        </div>

                        <ul class="contacts-list">
                            @if($store_information['address'])
                                <li>
                                <div class="icon">
                                    <img src="/images/front/location-pin-icon.svg" alt="Address">
                                </div>

                                <a href="{{ $store_information['address_url'] }}" target="_blank">{{ $store_information['address'] }}</a>
                            </li>
                            @endif

                            @if($store_information['phone_primary'])
                                <li>
                                <div class="icon">
                                    <img src="/images/front/footer-phone-icon.svg" alt="Phone">
                                </div>

                                <a href="tel:{{ $store_information['phone_primary'] }}">{{ $store_information['phone_primary'] }}</a>
                            </li>
                            @endif

                            @if($store_information['email'])
                                <li>
                                <div class="icon">
                                    <img src="/images/front/footer-mail-icon.svg" alt="E-mail">
                                </div>

                                <a href="mailto:{{ $store_information['email'] }}">{{ $store_information['email'] }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <ul class="social-media">
                        @if($store_information['facebook'])
                            <li>
                                <a href="{{ $store_information['facebook'] }}" target="_blank">
                                    <img src="/images/front/footer-fb-icon.svg" alt="Facebook">
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                @foreach($menus['footer_menu'] as $footer_menu_items)
                    @if(isset($footer_menu_items['children']) && count($footer_menu_items['children']) > 0)
                    <div class="col">
                        <h4 class="col-heading">{{ $footer_menu_items['text'] }}</h4>

                        <ul>
                            @foreach($footer_menu_items['children'] as $children)
                                <li><a href="{{ $children['url'] }}">{{ $children['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                @endforeach

                <div class="col time-col">
                    @if(count($store_information['working_hours']) > 0)
                        <h4 class="col-heading">Darba laiks</h4>

                        <ul>
                            @foreach($store_information['working_hours'] as $wh)
                                <li><span>{{ $wh['name'] }}</span>{{ $wh['value'] }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="mid-section">
                <div class="logos">
                    <div class="block">
                        <h4 class="block-heading">Apmaksa</h4>

                        <ul class="list d-flex">
                            <li>
                                <img src="/images/front/footer-swedbank-logo.svg" alt="Swedbank">
                            </li>

                            <li>
                                <img src="/images/front/footer-citadele-logo.svg" alt="Citadele">
                            </li>

                            <li>
                                <img src="/images/front/footer-luminor-logo.svg" alt="Luminor">
                            </li>

                            <li>
                                <img src="/images/front/footer-seb-logo.svg" alt="SEB">
                            </li>

                            <li>
                                <img src="/images/front/footer-visa-logo.svg" alt="Visa">
                            </li>

                            <li>
                                <img src="/images/front/footer-master-card-logo.svg" alt="Master Card">
                            </li>
                        </ul>
                    </div>

                    <div class="block">
                        <h4 class="block-heading">Piegāde</h4>

                        <ul class="list d-flex">
                            <li>
                                <img src="/images/front/footer-omniva-logo.svg" alt="Omniva">
                            </li>

                            <li>
                                <img src="/images/front/footer-dpd-logo.svg" alt="DPD">
                            </li>

                            <li>
                                <img src="/images/front/footer-itella-logo.svg" alt="Itella">
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="alliance-text">
                    <div class="logo">
                        <img src="/images/front/logo-tec-alliance.svg" alt="Tec Alliance">
                    </div>

                    <p>Aizliegts kopēt šeit redzamos datus, it īpaši pilno datu bāzi. Stingri aizliegts dublēt datus un datubāzi, kā arī tos izplatīt un/vai uzdot trešajām personām iesaistīties šādās darbībās bez iepriekšējas TecDoc piekrišanas. Jebkāda satura izmantošana veidā, kas nav atļauts ar īpašu pilnvarojumu, ir autortiesību pārkāpums, un to pārkāpēji tiks sodīti.</p>
                </div>
            </div>
        </div>

        <div class="copyrights">
            <div class="container">
                <span> &copy; 2023 SIA RB Motors.</span> Interneta veikalu izstrādāja <a href="https://www.wdmarket.lv" target="_blank">WD Market</a>
            </div>
        </div>
    </div>
</footer>
