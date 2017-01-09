<!DOCTYPE html>
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        <!-- main -->
        <div class="be-wrapper be-float-sidebar be-header-fixed">
            <!-- header -->
            @include('layouts.navigation')
            <!-- / header -->
            @include('layouts.sidebar.left-sidebar')
            <!-- main content -->
            <main class="be-content">
                <div class="main-content @yield('class')">
                @yield('content')
                @include('layouts.footer')
                </div>
            </main>
            <!-- / end main content -->
            @include('layouts.sidebar.right-sidebar')
        </div>
        <!-- / end main -->
        <!-- The Loader. Is shown when pjax happens -->
        <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin-fast"></i>
        </div>
        <div id="cookiebar"></div>
        <!-- common libraries. required for every page -->
        <script type="text/javascript" src="{{ App::rev('js/jquery.min.js') }}"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ App::rev('js/plugins.vendor.min.js') }}"></script>
        <script src="/js-localization/messages"></script>
        <script type="text/javascript" src="{{ App::rev('js/app.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                Lang.setLocale("{!! app()->getLocale() !!}");
                /**
                 * Medlib Application
                 */
                Medlib.Token = {!! json_encode([
                    'language' => app()->getLocale(),
                    'csrfToken' => csrf_token(),
                    'jwt' => session()->has('jwt-token') ? session()->get('jwt-token') : '',
                    'socket_url' => config('medlib.socket_url')
                    ])
                !!}
                @if (Auth::check())
                Medlib.WebSocket(null);
                @endif
            });
        </script>
        @yield('script')
        <script type="text/javascript">
            function _getCookie() {
                var key = 'medlib_cookie';
                var ca = document.cookie ? document.cookie.split('; ') : [];
                for(var i=0; i < ca.length; i++) {
                    var parts = ca[i].split('='), name = decodeURIComponent(parts.shift()), cookie = parts.join('=');
                    if (key === name) {
                        var result = JSON.parse(cookie);
                        return result;
                        break;
                    }
                }
                return "";
            }
            var cookie = _getCookie();
            //-- check if we do have a cookie already set
            if (cookie !== "") {
                //cookie.cookieSet;
                //cookie.dismissCookie;
                if(cookie.cookieSet) {
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-80732713-1', 'auto');
                    ga('send', 'pageview');
                }
            } else {
                document.write('<script type="text/javascript" src=\'{{ App::rev("js/vue/cookiesbar.min.js") }}\'><\/script>')
            }
        </script>
    </body>
</html>
