<?php use Greggilbert\Recaptcha\Facades\Recaptcha; ?>
<!DOCTYPE html>
<html>
    <head>

        @include('layouts.head')

    </head>
    <body>

        @include('layouts.navigation')

        <div class="container-fluid" ng-app="app" style="margin-top:10px;">
            <div class="content">
                @include('flash.message')
                @yield('content')
            </div>
        </div>

        @include('layouts.footer')

    </body>
</html>