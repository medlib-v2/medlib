<header  id="header" class="navbar navbar-default navbar-fixed-top be-top-header box-shadow" role="navigation">
    <nav class="container-fluid">
        @if (Auth::guest())
            @include('layouts.navigation.navbar-user-guest')
        @else
            @include('layouts.navigation.navbar-user-auth')
        @endif
    </nav>
</header>