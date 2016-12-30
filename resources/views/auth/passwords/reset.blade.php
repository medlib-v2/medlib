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
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group xs-pt-20 @if ($errors->has('email')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('auth.txt.email') }}</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" placeholder="{{ trans('auth.txt.email') }}" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group xs-pt-20 @if ($errors->has('password')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('passwords.password_text') }}</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" placeholder="{{ trans('passwords.password_text') }}" name="password">
                                </div>
                            </div>

                            <div class="form-group xs-pt-20 @if ($errors->has('password')) has-error @endif">
                                <label class="col-md-4 control-label">{{ trans('passwords.password_confirm_text') }}</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" placeholder="{{ trans('passwords.password_confirm_text') }}" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group xs-pt-5">
                                <div class="col-md-2"></div>
                                <div class="col-md-8"><button type="submit" class="btn btn-block btn-primary btn-block btn-xl">{{ trans('passwords.reset_password') }}</button></div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
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
                touchSupport: Modernizr.touch,
                title: 'Click here show/hide password',
                hideToggleUntil: 'focus'
            });
        });
    </script>
@endsection