<!DOCTYPE html>
<html id="load" lang="{{ (Session::has('lang')) ? Session::get('lang') : 'fr' }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        <!-- main -->
        <div class="be-wrapper be-float-sidebar be-header-fixed" id="app">
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

            @if(Auth::check())
                <!-- conversations -->
                <conversations :show.sync="showConversations"
                               :all-conversations.sync="allConversations"
                               :conversations.sync="conversations"
                               :user.sync="user"></conversations>
                <!-- chat box -->
                <chatbox v-if="activeConversation"
                         :conversation.sync="activeConversation"
                         :show.sync="showChatbox"
                         :user.sync="user"></chatbox>
            @endif
        </div>
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
                    'jwt' => session()->has('jwt-token') ? session()->get('jwt-token') : '',
                    'socket_url' => config('medlib.socket_url')
                    ])
                !!}
            window.me = {!! Auth::check() ? json_encode(Auth::user()->getUsername()) : json_encode('') !!}
        </script>
        <script type="text/javascript" src="{{ App::rev('/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
        <script type="text/javascript" src="{{ App::rev('/js/plugins.vendor.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js-localization/localization.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js-localization/messages') }}"></script>
        <script type="text/javascript"> Lang.setLocale("{!! app()->getLocale() !!}"); </script>
        <script type="text/javascript" src="{{ App::rev('/js/app.js') }}"></script>
        <script type="text/javascript" src="{{ App::rev('/js/medlib.min.js') }}"></script>
        @yield('script')
        @include('layouts.analytics')
    </body>
</html>
