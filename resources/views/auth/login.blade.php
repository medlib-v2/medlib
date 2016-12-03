@extends('layouts.master')

@section('title', 'Register')

@section('class') container-fluid @endsection

@section('content')
<main id="content" class="content" role="main">
    <section class="splash-container animated fadeInUp">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading">
                <header class="wrapper text-center">
                    <strong>Sign in to get in touch</strong>
                </header>
                <span class="splash-description">Please enter your user information.</span>
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
                <form role="form" method="POST" action="{{ route('auth.submit') }}" accept-charset="UTF-8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input id="username" type="email" placeholder="Username"  autocomplete="off" class="form-control no-border" name="email" value="{{-- old('email') --}}">
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" placeholder="Password" class="form-control no-border" name="password">
                    </div>
                    <div class="form-group row login-tools">
                        <div class="col-xs-6 login-remember">
                            <div class="checkbox">
                                <label for="remember" class="be-checks">
                                    <input type="checkbox" name="remember_me" id="remember">
                                    <i class="remember"></i>Se souvenir de moi</label>
                            </div>
                        </div>
                        <div class="col-xs-6 login-forgot-password"><a href="{{ route('password.reset') }}" class="btn btn-link">Forgot Password?</a></div>
                    </div>
                    <div class="form-group login-submit">
                        <button data-dismiss="modal" type="submit" class="btn btn-success btn-block btn-xl">Sign me in</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="line line-dashed"></div>
        <div class="splash-footer"><span>Don't have an account? <a href="{{ route('auth.register') }}">Sign Up</a></span></div>
    </section>
</main>
@endsection