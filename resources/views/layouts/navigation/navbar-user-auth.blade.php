    <!-- navbar header -->
    <div class="navbar-header aside-md bg-dark">
        <!-- brand logo -->
        <div class="navbar-brand text-lt">
            <a href="{{ route('home') }}" ><img class="be-logo" alt="Medlib"/></a>
        </div>
        <!-- / brand logo -->
    </div>
    <!-- / navbar header -->

    <!-- navbar collapse -->
    <div id="navbar" class="be-right-navbar collapse navbar-collapse bg-white-only">
        <!-- buttons -->
        <ul class="nav navbar-nav be-navbar-toggle hidden-xs">
            <li><a class="be-toggle-left-sidebar" href="#"
                   data-sn-action="toggle-navigation-state"
                   title="" data-placement="bottom"
                   data-tooltip=""
                   data-original-title="Turn on/off sidebar collapsing"><i class="fa fa-bars fa-lg"></i></a></li>
        </ul>
        <!-- / buttons -->
        <ul class="nav navbar-nav navbar-right be-user-nav">
            <!-- user profile -->
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                    <img class="img-circle" data-src="js/holder.js/32%x32%" src="{{ url(Auth::user()->getAvatar()) }}" alt="{{ Auth::user()->getFirstName() }}">
                    <span class="user-name">{{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong></span>
                </a>
                <ul role="menu" class="dropdown-menu animated fadeInUp" id="notifications-dropdown-menu">
                    @include('users.profiles.lists')
                </ul>
            </li>
            <!-- / user profile -->
        </ul>
        <notifications link-notifications="{{ route('notifications.show') }}"></notifications>
    </div>
    <!-- / navbar collapse -->