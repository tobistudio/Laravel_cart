@foreach($data['items'] as $item)
    <div class="list-block" id="{{ $item['block_id'] }}">
        <h2 class="content-heading">{{ $item['title'] }}</h2>
        {!! $item['description'] !!}
    </div>
@endforeach
