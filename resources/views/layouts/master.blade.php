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
    </body>
</html>
