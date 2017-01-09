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
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p>{{ trans('passwords.reset_password_subtitle') }}</p>

                            <div class="form-group xs-pt-20 @if ($errors->has('email')) has-error @endif">
                                <input type="email" placeholder="{{ trans('auth.txt.email') }}" autocomplete="off" class="form-control no-border" name="email" value="{{-- old('email') --}}">
                            </div>
                            <p class="xs-pt-5 xs-pb-20">{{ trans('auth.txt.forgot_email') }} <a href="{{ url('/site/contact') }}">{{ trans('auth.txt.forgot_email_end') }}</a></p>
                            <div class="form-group xs-pt-5">
                                <button type="submit" class="btn btn-block btn-primary btn-block btn-xl">{{ trans('passwords.send_reset_password') }}</button>
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
