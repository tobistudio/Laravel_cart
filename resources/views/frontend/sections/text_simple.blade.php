@foreach($data['items'] as $item)
    <div class="text-block">
        <h2 class="content-heading">{{ $item['title'] }}</h2>
        {!! $item['description'] !!}
    </div>
@endforeach
