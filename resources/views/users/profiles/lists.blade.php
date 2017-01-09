<li>
    <div class="user-info">
        <div class="user-name">{{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong></div>
        @if(Auth::user()->isOnline())
            <div class="user-position online">@lang('auth.available')</div>
        @else
            <div class="user-position offline">@lang('auth.unavailable')</div>
        @endif
    </div>
</li>
<li><a href="{{ route('profile.user.show', Auth::user()->getUsername()) }}" class="text-small"><span class="glyphicon glyphicon-user"></span>&nbsp;Afficher mon profil</a></li>
<li><a href="{{ route('dashboard.home') }}" class="text-small"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Dashbord</a></li>
<li><a href="{{ route('profile.show.settings') }}"><span class="glyphicon glyphicon-lock"></span>&nbsp;Paramètres</a></li>
<li><a href="{{ route('auth.logout') }}"><i class="glyphicon glyphicon-off"></i>&nbsp;Se déconnecter</a></li>