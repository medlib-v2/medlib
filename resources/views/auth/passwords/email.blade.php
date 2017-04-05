@extends('layouts.master')

@section('title', 'Reset Password')

@section('class') container-fluid @endsection

@section('content')
    <main id="content" class="content" role="main">
        <section class="splash-container forgot-password animated fadeInUp">
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
                        {!! Form::open(['method' => 'POST', 'route' => 'password.post', 'accept-charset' => 'UTF-8', 'role'=> 'form', 'class' => 'form-horizontal']) !!}
                            <p>{{ trans('passwords.reset_password_subtitle') }}</p>

                            <div class="form-group xs-pt-20 @if ($errors->has('email')) has-error @endif">
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
                            <p class="xs-pt-5 xs-pb-20">{{ trans('auth.txt.forgot_email') }} <a href="{{ route('contact.show') }}">{{ trans('auth.txt.forgot_email_end') }}</a></p>
                            <div class="form-group xs-pt-5">
                                <button type="submit" class="btn btn-block btn-primary btn-block btn-xl">{{ trans('passwords.send_reset_password') }}</button>
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
