<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &bigtriangledown; {{config('app.name')}}</title>
    @include('layout.include.styles')
</head>
<body>
@include('layout.include.nav-bar')
<div class="container" id="app-content">
    <div class="row">
        <div class="col-12">
            @yield("content")
        </div>
    </div>
</div>
@include('layout.include.scripts')
@stack('scripts')
</body>
</html>
