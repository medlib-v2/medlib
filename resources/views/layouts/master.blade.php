<?php use Greggilbert\Recaptcha\Facades\Recaptcha; ?>
<!DOCTYPE html>
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        @include('layouts.navigation')
        <div class="container-fluid" style="margin-top:10px;">
            <div class="content">
                @yield('content')
            </div>
        </div>
        @include('layouts.footer')

    </body>
</html>