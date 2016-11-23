<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}" xmlns="http://www.w3.org/1999/xhtml">
    <head>
    @include('layouts.head')
    </head>
    <body>
        @include('layouts.dashboards.sidebar')

        @include('layouts.navigation')

        @include('layouts.dashboards.chat')

        @yield('content')

        @include('layouts.dashboards.footer')
    </body>
</html>