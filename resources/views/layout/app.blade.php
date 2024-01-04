<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &bigtriangledown; {{config('app.name')}}</title>
    @include('layout.include.styles')
</head>
<body class="d-flex flex-column min-vh-100">
@include('layout.include.nav-bar')
<div class="container flex-grow-1">
    <div class="row">
        <div class="col-12">
            @yield("content")
        </div>
    </div>
</div>
<footer class="mt-4 p-4" style="background: #989696">
    <div class="container text-white text-center">
        <div class="row">
            <div class="col-12">
                <span>Made by aarshit paladiya</span>
            </div>
        </div>
    </div>
</footer>
@include('layout.include.scripts')
@stack('scripts')
</body>
</html>
