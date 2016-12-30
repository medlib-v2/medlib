@extends('layouts.master')

@section('title', 'Login')

@section('class') container-fluid @endsection

@section('content')
<main id="content" class="content" role="main">
    <section class="splash-container animated fadeInUp">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading">
                <header class="wrapper text-center">
                    <strong>{{ trans('auth.user_title_login') }}</strong>
                </header>
                <span class="splash-description">{{ trans('auth.user_information_login') }}</span>
            </div>
            <div class="panel-body">
                @include('flash.message')
                @if (isset($errors) and $errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Whoops!</strong> {{ trans('messages.problems_with_input') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                         @endforeach
                    </ul>
                </div>
                @endif
                {!! Form::open(['method' => 'POST', 'route' => 'auth.submit', 'accept-charset' => 'UTF-8', 'role'=> 'form']) !!}
                    <div class="form-group @if (isset($errors) and $errors->has('email')) has-error @endif">
                        {!! Form::email('email', request()->hasSession() ? old('email') : '', [
                            'placeholder' => trans('auth.txt.email'),
                            'class' => 'form-control no-border',
                            'autocomplete' => 'off',
                            'required',
                            'tabindex' => 1,
                            'id'=> 'username'])
                        !!}
                        @if (isset($errors) and $errors->has('email')) <p class="help-block"><strong>{{ $errors->first('email') }}</strong></p> @endif
                    </div>
                    <div class="form-group @if (isset($errors) and $errors->has('password')) has-error @endif">
                        {!! Form::password('password', [
                            'id' => 'password',
                            'placeholder' => trans('auth.txt.password'),
                            'class' => 'form-control no-border',
                            'pattern'=> '.{6,}',
                            'required' => 'required',
                            'autocomplete'=> 'off',
                            'tabindex' => 6])
                        !!}
                        <span class="hideShowPassword-toggle"></span>
                        @if (isset($errors) and $errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                    </div>
                    <div class="form-group row login-tools">
                        <div class="col-xs-6 login-remember">
                            <div class="checkbox">
                                <label for="remember" class="be-checks">
                                    <input type="checkbox" name="remember_me" id="remember">
                                    <i class="remember"></i>{{ trans('auth.txt.remember_me') }}</label>
                            </div>
                        </div>
                        <div class="col-xs-6 login-forgot-password"><a href="{{ route('password.reset') }}" class="btn btn-link">{{ trans('auth.btn.forgot_password') }}</a></div>
                    </div>
                    <div class="form-group login-submit">
                        <button data-dismiss="modal" type="submit" class="btn btn-success btn-block btn-xl">{{ trans('auth.btn.login') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="line line-dashed"></div>
        <div class="splash-footer"><span>{{ trans('auth.txt.dont_have_account') }} <a href="{{ route('auth.register') }}">{{ trans('auth.txt.sing_up') }}</a></span></div>
    </section>
</main>
@endsection

@section('script')
    <!-- page specific js -->
    <script type="text/javascript">
        $(document).ready(function(){
            /**
             * Medlib Application
             */
            Medlib.InputField(null);
            Medlib.Password('#password', {
                innerToggle: true,
                touchSupport: Modernizr.touch,
                title: 'Click here show/hide password',
                hideToggleUntil: 'focus'
            });
        });
    </script>
@endsection