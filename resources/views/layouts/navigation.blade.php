<nav class="bg-white header header-md navbar navbar-default" role="navigation">
    <div class="container-fluid">
        @if (Auth::guest())
            @include('layouts.navigation.navbar-user-guest')
        @else
            @include('layouts.navigation.navbar-user-auth')
        @endif
    </div>
</nav>