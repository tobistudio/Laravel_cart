@extends('frontend.layouts.error')

@section('content')
    <main id="main" class="site-main" role="main">
        <div class="page-404">
            <div class="container">
                <div class="text">
                    <h1 class="page-title">{{ $data['title'] }}</h1>
                    {!! $data['description'] !!}

                    @php
                        $linkText = 'back_to_home';
                        $link = $locale ?: '/';
                    @endphp
                    <page-link :locale="{{ json_encode($extra['locale']) }}" :link="{{ json_encode($link) }}" :link_text="{{ json_encode($linkText) }}"></page-link>
                </div>
            </div>
        </div>

        @include('frontend.sections.newsletter', ['locale' => $extra['locale']])
    </main>
@endsection
