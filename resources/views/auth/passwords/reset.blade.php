@extends('layouts.master')

@section('title', 'Reset Password')

@section('class') container-fluid @endsection

@section('content')
    <main id="content" class="content" role="main">
        <section class="splash-container reset-password animated fadeInUp">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading">
                    <header class="wrapper text-center">
                        <strong>{{ trans('passwords.reset_password') }}</strong>
                    </header>
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
                    <section class="m-b-lg">
                        {!! Form::open(['method' => 'POST', 'route' => 'password.submit', 'accept-charset' => 'UTF-8', 'role'=> 'form', 'class' => 'form-horizontal']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group xs-pt-20 @if ($errors->has('email')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('auth.txt.email') }}</label>
                                <div class="col-md-8">
                                    {!! Form::email('email', request()->hasSession() ? old('email') : '', [
                                        'placeholder' => trans('auth.txt.email'),
                                        'class' => 'form-control no-border',
                                        'autocomplete' => 'on',
                                        'required',
                                        'tabindex' => 1,
                                        'id'=> 'username'])
                                    !!}
                                    @if (isset($errors) and $errors->has('email')) <p class="help-block"><strong>{{ $errors->first('email') }}</strong></p> @endif
                                </div>
                            </div>

                            <div class="form-group xs-pt-20 @if ($errors->has('password')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('passwords.password_text') }}</label>
                                <div class="col-md-8">
                                    {!! Form::password('password', [
                                        'value' => request()->hasSession() ? old('password') : '',
                                        'id' => 'password_register',
                                        'placeholder' => trans('passwords.password_text'),
                                        'class' => 'form-control',
                                        'pattern'=> '.{6,}',
                                        'required',
                                        'autocomplete'=> 'off',
                                        'tabindex' => 2])
                                    !!}
                                    <span class="hideShowPassword-toggle"></span>
                                    @if (isset($errors) and $errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                </div>
                            </div>

                            <div class="form-group xs-pt-20 @if ($errors->has('password_confirmation')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('passwords.password_confirm_text') }}</label>
                                <div class="col-md-8">
                                    {!! Form::password('password_confirmation', [
                                            'value' => request()->hasSession() ? old('password_confirmation') : '',
                                            'id' => 'password_confirmation',
                                            'placeholder' => trans('passwords.password_confirm_text'),
                                            'class' => 'form-control',
                                            'pattern'=> '.{6,}',
                                            'required',
                                            'autocomplete'=> 'off',
                                            'tabindex' => 3])
                                        !!}
                                    <span class="hideShowPassword-toggle"></span>
                                    @if (isset($errors) and $errors->has('password_confirmation')) <p class="help-block">{{ $errors->first('password_confirmation') }}</p> @endif
                                </div>
                            </div>

                            <div class="form-group xs-pt-5">
                                <div class="col-md-2"></div>
                                <div class="col-md-8"><button type="submit" class="btn btn-block btn-primary btn-block btn-xl">{{ trans('passwords.reset_password') }}</button></div>
                                <div class="col-md-2"></div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
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
                touchSupport: Modernizr.touchevents,
                title: 'Click here show/hide password',
                hideToggleUntil: 'focus'
            });
        });
    </script>
@endsection