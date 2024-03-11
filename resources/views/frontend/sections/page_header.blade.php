<section class="page-header-box <?= $data['big'] ? 'big' : '' ?>">
    <div class="container">
        <h1 class="page-title">{{ $data['title'] }}</h1>

        @if($data['description'])
            <div class="sub-text">
                {!! $data['description'] !!}
            </div>
        @endif

        @if($data['breadcrumbs'])
            <ul class="breadcrumb">
            @foreach($data['breadcrumbs'] as $breadcrumb)
                    @if(!$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['slug'] }}">{{ $breadcrumb['name'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                    @endif
            @endforeach
            </ul>
        @endif
    </div>
</section>
