<div class="navbar-header aside-md dk">
    <!-- xs & sm screen logo -->
    <a href="{{ route('home') }}" class="navbar-brand btn btn-link visible-xs"><img src="{{ asset('/images/logo_a.png') }}" class="m-r-sm thumb-sm" alt="Medlib"></a>
    <a class="navbar-brand header-xs" href="{{ route('home') }}"><img src="{{ asset('/images/logo.png') }}" class="hidden-xs thumbnail-logo" alt="Medlib"></a>
    <button type="button" class="navbar-toggle visible-xs collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Medlib</span><i class="fa fa-bars fa-lg"></i>
    </button>
</div>
<div id="navbar" class="navbar-collapse collapse">
    <ul id="login-form" class="nav navbar-nav navbar-right hidden-xs navbar-collapse">
        <!-- login user -->
        <li class="dropdown view-desktop" role="presentation">
            <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left"><img class="img-circle" src="{{asset('images/user-avatar.png')}}" alt="...">
                </span>&nbsp;ESPACE PERSONNEL<span></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInUp login-dropdown-menu" id="login-dropdown-menu">
                <li>
                    <div class="row no-margin">
                        <div class="col-md-7 col-sm-7">
                            <div class="form-group"><h4>Se connecter</h4></div>
                            <form class="form" role="login" method="POST"  action="{{ route('auth.login') }}" accept-charset="UTF-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group @if(isset($errors) and $errors->has('email')) has-error @endif">
                                    <label class="label-control" for="email"><span class="label-text">{{ trans('auth.txt.email') }}</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="@if ( Request::has('email') ) Request::old('email') @endif" required />
                                </div>
                                <div class="form-group @if(isset($errors) and $errors->has('password')) has-error @endif">
                                    <label class="label-control" for="password"><span class="label-text">{{ trans('auth.txt.password') }}</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required />
                                    <span class="hideShowPassword-toggle">
                                        <!--<span tabindex="100" title="Click here show/hide password" class="hideShowPassword-toggle-icon">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </span>
                                        <span tabindex="101" title="Check password level security" class="progress-toggle-vertical" style="display: none;">
                                            <span role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar"></span>
                                        </span>-->
                                    </span>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" name="remember_me" class="checkbox-circle" id="remember_me" @if ( Request::has('remember_me') ) checked="checked" @endif />
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
                    <span class="fs-mini">Vous n’arrivez pas à vous connecter ? Avez-vous <a href="{{ route('password.reset') }}">{{ trans('auth.txt.forgot_passwd') }}</a> ?</span>
                </li>
            </ul>
        </li>
        <!--/ login user -->
    </ul>
    <ul class="nav navbar-nav collapse visible-xs nav-user navbar-collapse" aria-expanded="false">
        <form class="form-group visible-xs" method="POST" action="{{ route('auth.login') }}" role="login" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group @if(isset($errors) and $errors->has('email')) has-error @endif" style="margin-top:0px;">
                <div class="connect">{{ trans('auth.txt.email') }}</div>
                <input type="email" id="email" class="form-control" name="email" value="@if ( Request::has('email') ) Request::old('email') @endif" placeholder="{{ trans('auth.txt.email') }}" required />
                <div class="bas">
                    <div class="checkbox checkbox-success" style="font-size:12px;">
                        <input type="checkbox" name="remember_me" class="checkbox-circle" id="remember_me" @if ( Request::has('remember_me') ) checked="checked" @endif />
                        <label for="remember_me">{{ trans('auth.txt.remember_me') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group @if (isset($errors) and $errors->has('password')) has-error @endif" style="margin-top:0px;">
                <div class="connect">{{ trans('auth.txt.password') }}</div>
                <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.txt.password') }}" required />
                <div class="bas">
                    <div class="link-forgot-my-password">
                                <span class="" style="font-size:12px;">
                                <a href="{{ route('password.reset') }}">{{ trans('auth.txt.forgot_passwd') }}</a>
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
