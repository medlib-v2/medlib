<nav class="bg-white header header-md navbar navbar-default navbar-fixed-top-xs box-shadow">
    <div class="container-fluid">
        <!-- .navbar-header contains links seen on xs & sm screens -->
        <div class="navbar-header aside-md dk">
            <a href="{{ route('home') }}" class="navbar-brand btn btn-link visible-xs" style="padding: 10px 15px;">
                <img  src="{{ asset('/images/logo_a.png') }}" class="m-r-sm thumb-sm" alt="Medlib">
            </a>
            <a class="navbar-brand header-xs" href="{{ route('home') }}">
                <img  src="{{ asset('/images/logo.png') }}" class="hidden-xs thumbnail-logo" alt="Medlib">
            </a>
            <button type="button" class="navbar-toggle visible-xs" data-toggle="dropdown" data-target=".user">
                <span class="sr-only">Medlib</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- / .navbar-header contains links seen on xs & sm screens -->
        <!-- xs & sm screen logo -->
        <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user open">
            @if (Auth::guest())
                    <!-- login user -->
            <li class="dropdown view-desktop" role="presentation">
                <form class="navbar-form navbar-right" method="POST" action="{{ route('auth.login') }}" role="login">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if ($errors->has('email')) has-error @endif" style="margin-top:0px;">
                        <div class="connect">E-mail</div>
                        <input type="text" id="prepended-input" class="form-control" name="email" style="min-width:200px;" value="{{ old('email') }}" placeholder="Your email" required />
                        <div class="bas">
                            <div class="checkbox checkbox-success" style="font-size:12px;">
                                <input type="checkbox" name="remember_me" class="checkbox-circle"  id="remember_me" checked="{{ old('remember_me') ? ' checked' : '' }}"/>
                                <label for="remember_me">Remember me</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('password')) has-error @endif" style="margin-top:0px;">
                        <div class="connect">Password</div>
                        <input type="password" class="form-control" name="password" placeholder="Password" required />
                        <div class="bas">
                            <div class="link-forgot-my-password">
                            <span class="" style="font-size:12px;">
                                <a href="{{ url('/password/email') }}">Forgot your password ?</a>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:15px;">
                        <div class="bas">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-user"></span>
                                Log in
                            </button>
                            <div class="bas" style="margin-top:10px;">
                                <div class="link-sing-in">
                                    <span><a class="text-default" style="font-size:12px;" href="{{ route('auth.register') }}">S'inscrire</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </li>
            @else
            <!-- img de profile -->
            <li class="col-md-12">
            <li class="dropdown view-desktop" role="presentation">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-controls="{{ Auth::user()->getNameOrUsername() }}">
                    <img class="img-circle" data-src="js/holder.js/80%x80%" width="65" src="{{ Auth::user()->getAvatar() }}"/>
                    <!--<span class="caret quote"><i class="fa fa-quote-left"></i></span>-->
                </a>
                <ul class="dropdown-menu menu" role="menu" style="border-radius:10px;">
                    <li class="text-center" style="margin-top:10px">
                        <img class="img-circle" data-src="js/holder.js/80%x80%" width="90" src="{{ Auth::user()->getAvatar() }}"/>
                        <div>{{ Auth::user()->getNameOrUsername() }} </div>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('profile.show') }}" class="text-small"><span class="glyphicon glyphicon-cog"></span>&nbsp;Afficher mon profil</a></li>
                    <li><a href="{{ route('dashboard.home') }}" class="text-small"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Dashbord</a></li>
                    <li><a href="{{ route('profile.show.settings') }}"><span class="glyphicon glyphicon-lock"></span>&nbsp;Paramètres</a></li>
                    <li><a href="{{ route('auth.logout') }}"><i class="glyphicon glyphicon-off"></i>&nbsp;Se déconnecter</a></li>
                </ul>
            </li>
            </li>
            @endif
        </ul>
        <!-- / xs & sm screen logo -->
    </div>
</nav>