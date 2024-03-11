<div class="nav-page-block">
    <ul>
        @foreach($data['items'] as $item)
        <li class="{{ $item['page'] === $locale  . '/' . $url ? 'active' : '' }}">
            <a href="{{ $item['link'] ?: $item['page'] }}">{{ $item['title'] }}</a>
        </li>
        @endforeach
    </ul>
</div>
