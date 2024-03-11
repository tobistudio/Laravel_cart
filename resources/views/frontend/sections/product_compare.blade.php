<section class="hero category">
    <div class="container">
        <div class="heading-wrapper">
            <h2 class="section-heading">{{ $data['title'] }}</h2>
        </div>
    </div>
</section>

<product-compare :locale="{{ json_encode($locale) }}" :data="{{ json_encode($data) }}" ></product-compare>
<newsletter :locale="{{ json_encode($locale) }}"></newsletter>
