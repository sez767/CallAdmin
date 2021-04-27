<!DOCTYPE html>
<html style="background-color: transparent" lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@stack('html-class')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- Scripts --}}
    @stack('head-scripts')

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    {{-- Styles --}}
    <link href="{{ mix($stylesheet ?? 'css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">

    @stack('head-after')
</head>
<body>

<div id="app">

    @yield('content')

</div>

@stack('bottom')

</body>
</html>
