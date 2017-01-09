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
        <!-- nabar user no login right -->
        <ul  class="nav navbar-nav navbar-right be-user-nav">
            <!-- login user -->
            <li class="dropdown" role="presentation">
                <a href="#" class="be-user-login-dropdown" id="user-login-dropdown" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="thumb-sm avatar"><img class="img-circle" src="{{asset('images/user-avatar.png')}}" alt="..."/></span>
                    <span class="user-name">ESPACE PERSONNEL</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInUp login-dropdown-menu" id="login-dropdown-menu">
                    <li class="login-form-dropdown">
                        <div class="row no-margin">
                            <div class="col-md-7 col-sm-7">
                                <div class="form-group"><h4>@lang('auth.btn.login')</h4></div>
                                <form class="form-login" role="login" method="POST"  action="{{ route('auth.login') }}" accept-charset="UTF-8">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group @if(isset($errors) and $errors->has('email')) has-error @endif field">
                                        <label class="label-control" for="email"><span class="label-text">{{ trans('auth.txt.email') }}</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="@if ( Request::has('email') ) {{ Request::old('email') }} @endif" required />
                                    </div>
                                    <div class="form-group @if(isset($errors) and $errors->has('password')) has-error @endif field">
                                        <label class="label-control" for="password"><span class="label-text">@lang('auth.txt.password')</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required />
                                        <span class="hideShowPassword-toggle"></span>
                                    </div>
                                    <div class="checkbox checkbox-success">
                                        <label for="remember_me" class="be-checks">
                                            <input type="checkbox" name="remember_me" class="checkbox-circle" id="remember_me" @if ( Request::has('remember_me') ) checked="checked" @endif />
                                            <i class="remember"></i>@lang('auth.txt.remember_me')</label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">@lang('auth.btn.login')</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <div class="or-spacer"><span><i>@lang('auth.txt.spacer_or')</i></span></div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <ul class="login-via">
                                    <li class="info">
                                        <span>@lang('auth.account_dont_have')</span>
                                    </li>
                                    <li class="btn-register">
                                        <a class="btn btn-primary" type="button" href="{{ route('auth.register') }}" id="sign-in">@lang('auth.txt.sing_up')</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="social-buttons">
                                        <a href="{{ route('auth.social', ['provider' => 'facebook']) }}" class="btn btn-block btn-social btn-facebook" role="button" id="sign-in-facebook"><span class="fa fa-facebook"></span>Login via Facebook</a>
                                        <a href="{{ route('auth.social', ['provider' => 'twitter']) }}" class="btn btn-block btn-social btn-twitter" type="button" id="sign-in-twitter"><span class="fa fa-twitter"></span>Login via Twitter</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="panel-footer text-sm">
                        <span class="fs-mini">@lang('auth.login.can_not_login') <a href="{{ route('password.reset') }}">@lang('auth.txt.forgot_password')</a></span>
                    </li>
                </ul>
            </li>
            <!--/ login user -->
        </ul>
        <!-- / nabar user no login right -->

    </div>
    <!-- / navbar collapse -->
