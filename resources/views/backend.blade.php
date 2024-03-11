<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
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

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" media="all">

        <style>
            html {
                font-family: Public Sans,sans-serif,-apple-system,blinkmacsystemfont,Segoe UI,roboto,Helvetica Neue,arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol;
                line-height: 1.5;
                font-size: 1rem;
                text-rendering: optimizeLegibility;
                -moz-osx-font-smoothing: grayscale;
                word-break: normal;
                -moz-tab-size: 4;
                tab-size: 4;
                margin: 0;
                padding: 0;
            }

            body {
                margin: 0;
            }

            *, ::after, ::before {
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>
        <div id="app"></div>

        @vite(['resources/js/app.js'])
    </body>
</html>
