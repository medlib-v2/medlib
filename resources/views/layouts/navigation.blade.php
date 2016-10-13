<!-- <nav class="bg-white header header-md navbar navbar-default navbar-fixed-top-xs box-shadow"> -->
<nav class="bg-white header header-md navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- .navbar-header contains links seen on xs & sm screens -->
        <div class="navbar-header aside-md dk">
            @if (Auth::guest())
            <!-- xs & sm screen logo -->
            <a href="{{ route('home') }}" class="navbar-brand btn btn-link visible-xs">
                <img src="{{ asset('/images/logo_a.png') }}" class="m-r-sm thumb-sm" alt="Medlib">
            </a>
            <a class="navbar-brand header-xs" href="{{ route('home') }}">
                <img src="{{ asset('/images/logo.png') }}" class="hidden-xs thumbnail-logo" alt="Medlib">
            </a>
            <button type="button" class="navbar-toggle visible-xs collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Medlib</span>
                    <i class="fa fa-bars fa-lg"></i>
                </button> @else
            <ul class="nav navbar-nav">
                <li>
                    <a class="hidden-sm hidden-xs" id="nav-state-toggle" href="#" title="Turn on/off" data-placement="bottom">
                        <i class="fa fa-bars fa-lg"></i>
                    </a>
                    <a class="visible-sm visible-xs" id="nav-collapse-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                        <span class="rounded rounded-lg bg-gray text-white visible-xs"><i class="fa fa-bars fa-lg"></i></span>
                        <i class="fa fa-bars fa-lg hidden-xs"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right visible-xs">
                <li>
                    <!-- toggles chat -->
                    <a href="#" data-toggle="chat-sidebar">
                        <span class="rounded rounded-lg bg-gray text-white"><i class="fa fa-globe fa-lg"></i></span>
                    </a>
                </li>
            </ul>
            @endif
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul id="login-form" class="nav navbar-nav collapse navbar-right  m-n hidden-xs nav-user navbar-collapse">
                @if (Auth::guest())
                <!-- login user -->
                <li class="dropdown view-desktop" role="presentation">
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                                    <img class="img-circle" src="{{asset('images/user-avatar.png')}}" alt="...">
                                </span>&nbsp;ESPACE PERSONNEL</strong>
                        </span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInUp login-dropdown-menu" id="login-dropdown-menu">
                        <li>
                            <div class="row no-margin">
                                <div class="col-md-7 col-sm-7">
                                    <div class="form-group">
                                        <h4>Se connecter</h4></div>
                                    <form class="form" role="form" method="POST" action="{{ route('auth.login') }}" accept-charset="UTF-8" id="form-login" role="login">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group @if (isset($errors) and $errors->has('email')) has-error @endif">
                                            <label class="label-control" for="email"><span class="label-text">{{ trans('auth.txt.email') }}</span></label>
                                            <input type="email" class="form-control" id="email" required value="{{-- old('email') ? old('email'):'' --}}">
                                        </div>
                                        <div class="form-group @if (isset($errors) and $errors->has('password')) has-error @endif">
                                            <label class="label-control" for="password"><span class="label-text">{{ trans('auth.txt.password') }}</span></label>
                                            <input type="password" class="form-control" id="password" required>
                                            <span class="hideShowPassword-toggle">
                                                        <!--<span tabindex="100" title="Click here show/hide password" class="hideShowPassword-toggle-icon">
                                                            <i class="glyphicon glyphicon-eye-open"></i>
                                                        </span> -->
                                            <!--<span tabindex="101" title="Check password level security" class="progress-toggle-vertical" style="display: none;">
                                                            <span role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar"></span>
                                                        </span>-->
                                            </span>
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input name="remember_me" class="checkbox-circle" id="remember_me" checked="{{-- old('remember_me', '') ? ' checked' : '' --}}" type="checkbox">
                                            <label for="remember_me"><span class="remember">{{ trans('auth.txt.remember_me') }}</span></label>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">{{ trans('auth.btn.login') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <div class="or-spacer"><span><i>OU</i></span></div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <ul class="login-via">
                                        <li class="info">
                                            <span>Si vous ne possédez pas déjà un compte cliquez sur le bouton ci-dessous pour créer votre compte.</span>
                                        </li>
                                        <li class="">
                                            <a class="btn btn-primary" type="button" href="{{ route('auth.register') }}" id="sign-in">{{ trans('auth.txt.sing_up') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li class="social-buttons">
                                            <button class="btn btn-facebook" type="button" id="sign-in-facebook">Facebook</button>
                                            <button class="btn btn-twitter" type="button" id="sign-in-twitter">Twitter</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel-footer text-sm">
                            <span class="fs-mini">Vous n’arrivez pas à vous connecter ? Avez-vous <a href="{{ url('/password/email') }}">{{ trans('auth.txt.forgot_passwd') }}</a> ?</span>
                        </li>
                    </ul>
                </li>
                <!--/ login user -->
                @else
                <div class="collapse navbar-collapse" style="padding-left: 51px;">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown view-desktop" role="presentation">
                            <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                                <span class="thumb-sm avatar pull-left">
                                    <img class="img-circle" data-src="js/holder.js/80%x80%" width="65" src="{{ Auth::user()->getAvatar() }}" alt="..."/>
                                </span>&nbsp;Philip <strong>Smith {{-- Auth::user()->getNameOrUsername() --}}</strong>&nbsp;<span class="circle bg-warning fw-bold">13</span>
                                <b class="caret"></b>
                            </a>
                            <div class="dropdown-menu animated fadeInUp" id="notifications-dropdown-menu">
                                @include('notifications.master')
                            </div>
                        </li>
                        <li class="dropdown view-desktop" role="presentation">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('profile.show') }}" class="text-small"><span class="glyphicon glyphicon-cog"></span>&nbsp;Afficher mon profil</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-user"></i> &nbsp; Mon Compte</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Bibliothèque</a></li>
                                <li><a href="#">Messages &nbsp;&nbsp;<span class="badge badge-danger animated bounceIn">9</span></a></li>
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
                <!-- img de profile -->
                <li class="dropdown view-desktop" role="presentation">

                </li>
                @endif
            </ul>
            <ul class="nav navbar-nav collapse visible-xs nav-user navbar-collapse" aria-expanded="false">
                <form class="form-group visible-xs" method="POST" action="{{ route('auth.login') }}" role="login">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if ($errors->has('email')) has-error @endif" style="margin-top:0px;">
                        <div class="connect">{{ trans('auth.txt.email') }}</div>
                        <input type="text" id="prepended-input" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.txt.email') }}" required />
                        <div class="bas">
                            <div class="checkbox checkbox-success" style="font-size:12px;">
                                <input type="checkbox" name="remember_me" class="checkbox-circle" id="remember_me" checked="{{ old('remember_me') ? ' checked' : '' }}" />
                                <label for="remember_me">{{ trans('auth.txt.remember_me') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('password')) has-error @endif" style="margin-top:0px;">
                        <div class="connect">{{ trans('auth.txt.password') }}</div>
                        <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.txt.password') }}" required />
                        <div class="bas">
                            <div class="link-forgot-my-password">
                                <span class="" style="font-size:12px;">
                                <a href="{{ url('/password/email') }}">{{ trans('auth.txt.forgot_passwd') }}</a>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:15px;">
                        <div class="bas">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-user"></span>
                                {{ trans('auth.btn.login') }}
                            </button>
                            <div class="bas" style="margin-top:10px;">
                                <div class="link-sing-in">
                                    <span><a class="text-default" style="font-size:12px;" href="{{ route('auth.register') }}">{{ trans('auth.txt.sing_up') }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </ul>
        </div>
    </div>
    <!-- / .navbar-header contains links seen on xs & sm screens -->
</nav>