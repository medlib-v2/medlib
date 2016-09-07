<?php use Greggilbert\Recaptcha\Facades\Recaptcha; ?>
<!DOCTYPE html>
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        @include('layouts.navigation')
            @yield('content')
        @include('layouts.footer')
    </body>
</html>