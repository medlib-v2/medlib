<!DOCTYPE html>
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        <!-- main -->
        <div id="app"></div>
        <!-- / end main -->
        <!-- The Loader. Is shown when pjax happens -->
        <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin-fast"></i>
        </div>
        <div id="cookiebar"></div>
        <!-- common libraries. required for every page -->
        <script type="text/javascript">
            window.Setting = {!! json_encode([
                'language' => app()->getLocale(),
                'csrfToken' => csrf_token(),
                'socket_url' => config('medlib.socket_url'),
                'datasource' => $datasource
            ]) !!}
        </script>
        <script type="text/javascript" src="{{ asset('/js-localization/localization.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js-localization/messages') }}"></script>
        <script type="text/javascript"> Lang.setLocale("{!! app()->getLocale() !!}"); </script>
        <script type="text/javascript" src="{{ App::rev('/js/app.js') }}"></script>
        @include('layouts.analytics')
    </body>
</html>
