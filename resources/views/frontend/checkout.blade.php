@extends('frontend.layouts.checkout')

@section('content')
    <main id="main" class="site-main" role="main">
            <div class="content">
                @include('frontend.sections.checkout', ['data' => $data, 'locale' => $extra['locale']])
            </div>
    </main>
@endsection
