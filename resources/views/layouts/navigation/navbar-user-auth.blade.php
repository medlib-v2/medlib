<div class="navbar-header">
    <ul>
        <li>
            <a class="hidden-sm hidden-xs" id="nav-state-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                <i class="fa fa-bars fa-lg"></i>
            </a>
            <a class="visible-sm visible-xs" id="nav-collapse-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                <span class="visible-xs"><i class="fa fa-bars fa-lg"></i></span>
                <i class="fa fa-bars fa-lg hidden-xs"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('home') }}" class="navbar-brand btn btn-link visible-xs">
                <img src="{{ asset('/images/logo_a.png') }}" class="m-r-sm thumb-sm" alt="Medlib">
            </a>
        </li>
    </ul>

<!--
<ul class="nav navbar-nav navbar-left visible-xs">
    <li>
        <!-- toggles chat --
        <a href="#" data-toggle="chat-sidebar">
            <span class="rounded rounded-lg bg-gray text-white"><i class="fa fa-globe fa-lg"></i></span>
        </a>
    </li>
</ul>
-->
</div>
<div id="navbar" class="navbar-collapse collapse">
    <ul id="auth-form" class="nav navbar-nav navbar-right m-n hidden-xs  navbar-collapse">
        <!-- user profile -->
        <li class="dropdown view-desktop" role="presentation">
            <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left"><img class="img-circle" data-src="js/holder.js/80%x80%" width="65" src="{{ url(Auth::user()->getAvatar()) }}" alt="..."/>
                </span>&nbsp;{{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong>&nbsp;<span class="circle bg-warning fw-bold">13</span>
                <b class="caret"></b>
            </a>
            <div class="dropdown-menu animated fadeInUp" id="notifications-dropdown-menu">
                @include('notifications.master')
            </div>
        </li>
        <!-- user profile /-->
        <li class="dropdown view-desktop" role="presentation">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('profile.user.show', Auth::user()->getUsername()) }}" class="text-small"><span class="glyphicon glyphicon-cog"></span>&nbsp;Afficher mon profil</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-user"></i>&nbsp;Mon Compte</a></li>
                <li class="divider"></li>
                <li><a href="#">Bibliothèque</a></li>
                <li><a href="#">Messages&nbsp;&nbsp;<span class="badge badge-danger animated bounceIn">9</span></a></li>
                <li><a href="{{ route('dashboard.home') }}" class="text-small"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Dashbord</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('profile.show.settings') }}"><span class="glyphicon glyphicon-lock"></span>&nbsp;Paramètres</a></li>
                <li><a href="{{ route('auth.logout') }}"><!-- <i class="fa fa-sign-out"></i> --><i class="glyphicon glyphicon-off"></i>&nbsp;Se déconnecter</a></li>
            </ul>
        </li>
        <li>
            <a href="#" data-toggle="chat-sidebar">
                <i class="glyphicon glyphicon-comment"></i>
                <i class="chat-notification-sing animated bounceIn"></i>
            </a>
            <div id="chat-notification" class="chat-notification animated fadeOut hide">
                <div class="chat-notification-inner">
                    <h6 class="title">
                                        <span class="thumb-xs">
                                            <img src="{{ asset('images/people/a6.jpg') }}" class="img-circle mr-xs pull-left">
                                        </span>Jess Smith
                    </h6>
                    <p class="text">Hey! What's up?</p>
                </div>
            </div>
        </li>
    </ul>
</div>
