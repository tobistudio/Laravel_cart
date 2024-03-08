<footer id="main-footer">
    <div class="footer-content">
        <div class="container">
            <div class="footer-cols">
                <div class="col contacts-col">
                    <div class="holder">
                        <div class="logo">
                            <img src="/images/front/footer-logo.svg" alt="">
                        </div>

                        <ul class="contacts-list">
                            <li>
                                <div class="icon">
                                    <img src="/images/front/location-pin-icon.svg" alt="">
                                </div>

                                <a href="https://maps.app.goo.gl/mqFBiQjN57yDriXeA" target="_blank">Rūpniecības iela 39a, Jelgava, LV-3008</a>
                            </li>

                            <li>
                                <div class="icon">
                                    <img src="/images/front/footer-phone-icon.svg" alt="">
                                </div>

                                <a href="tel:+37123772424">+371 237 72 424</a>
                            </li>

                            <li>
                                <div class="icon">
                                    <img src="/images/front/footer-mail-icon.svg" alt="">
                                </div>

                                <a href="mailto:info@rb24.lv">info@rb24.lv</a>
                            </li>
                        </ul>
                    </div>

                    <ul class="social-media">
                        <li>
                            <a href="#" target="_blank">
                                <img src="/images/front/footer-fb-icon.svg" alt="">
                            </a>
                        </li>
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
                    <h4 class="col-heading">Darba laiks</h4>

                    <ul>
                        <li><span>I-V</span> 8:30 - 18:00</li>
                        <li><span>VI</span> 9:00 - 16:00</li>
                        <li><span>VII</span> 10:00 - 14:00</li>
                    </ul>
                </div>
            </div>

            <div class="mid-section">
                <div class="logos">
                    <div class="block">
                        <h4 class="block-heading">Apmaksa</h4>

                        <ul class="list d-flex">
                            <li>
                                <img src="/images/front/footer-swedbank-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-citadele-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-luminor-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-seb-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-visa-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-master-card-logo.svg" alt="">
                            </li>
                        </ul>
                    </div>

                    <div class="block">
                        <h4 class="block-heading">Piegāde</h4>

                        <ul class="list d-flex">
                            <li>
                                <img src="/images/front/footer-omniva-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-dpd-logo.svg" alt="">
                            </li>

                            <li>
                                <img src="/images/front/footer-itella-logo.svg" alt="">
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="alliance-text">
                    <div class="logo">
                        <img src="/images/front/logo-tec-alliance.svg" alt="">
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
