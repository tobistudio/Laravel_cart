<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    @if(env('APP_ENV') !== 'production')
        <meta name="robots" content="noindex">
    @endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>{{ env('APP_NAME') }}</title>

    @stack('styles')
</head>
<body>
<div style="display: flex;flex-direction: column;justify-content: center;align-items: center;height: 100vh;">
    <div style="width: 100vw;margin: 5px;text-align: center;">
        <img src="{{ asset('images/rb24-logo.png') }}" alt="RB Motors">
    </div>
    <div style="width: 100vw;margin: 5px;text-align: center;">
        <h1>New website under development</h1>
        <p>Please click <a href="https://rb24.lv">here</a> to continue to current RB Motors online store</p>
    </div>
</div>

@stack('scripts')
</body>
</html>

