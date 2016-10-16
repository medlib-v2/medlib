@extends('layouts.master')
@section('title', 'Reset Password')

<!-- Main Content -->
@section('content')
    <div class="container-fluid animated fadeInUp">
        <div class="row">
            <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
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
                            <header class="wrapper text-center">
                                <strong>{{ trans('passwords.reset_password') }}</strong>
                            </header>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                {{ csrf_field() }}
                                <label>{{ trans('passwords.reset_password_subtitle') }}</label>
                                <div class="form-group @if (isset($errors) and $errors->has('email')) has-error @endif">
                                    <div class="list-group-item">
                                        <input id="email" type="email" placeholder="{{ trans('auth.txt.email') }}" class="form-control no-border" name="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">{{ trans('passwords.send_reset_password') }}</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection