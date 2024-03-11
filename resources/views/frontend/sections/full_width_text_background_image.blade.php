<div class="container">
    <div class="full-width-text-background-image-block">
        <h2 class="block-heading">{{ $data['title'] }}</h2>
        {!! $data['description']  !!}

        <a href="{{ $data['button_link'] }}" class="btn btn-primary">{{ $data['button_text'] }}</a>
    </div>
</div>
