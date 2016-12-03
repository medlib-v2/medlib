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

    <ul class="nav navbar-nav navbar-right be-icons-nav">
        <li class="dropdown">
            <a href="#" role="button" aria-expanded="false" class="be-toggle-right-sidebar">
                <span class="icon fa fa-cog" aria-hidden="true"></span>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                <span class="icon fa fa-bell" aria-hidden="true"></span><span class="indicator"></span>
            </a>
            <ul class="dropdown-menu be-notifications animated fadeInUp">
                <li>
                    <div class="title">Notifications<span class="badge">3</span></div>
                    <div class="list">
                        <div class="be-scroller">
                            <div class="content">
                                <ul>
                                    <li class="notification notification-unread">
                                        <a href="#">
                                            <div class="image"><img src="{{ asset('images/people/a2.jpg') }}" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div><span class="date">2 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="{{ asset('images/people/a3.jpg') }}" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">Joel King</span> is now following you</div><span class="date">2 days ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="{{ asset('images/people/a4.jpg') }}" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">John Doe</span> is watching your main repository</div><span class="date">2 days ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="{{ asset('images/people/a5.jpg') }}" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <span class="text"><span class="user-name">Emily Carter</span> is now following you</span><span class="date">5 days ago</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer"> <a href="#">View all notifications</a></div>
                </li>
            </ul>
        </li>
    </ul>

</div>
<!-- / navbar collapse -->