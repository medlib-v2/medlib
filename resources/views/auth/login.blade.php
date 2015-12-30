@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="container-fluid animated fadeInUp">
    <div class="row">
        <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if ($errors->has())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <section class="m-b-lg">
                        <header class="wrapper text-center">
                            <strong>Sign in to get in touch</strong>
                        </header>
                        <form role="form" method="POST" action="{{ url('/login') }}" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <input type="email" placeholder="Email" class="form-control no-border" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="list-group-item">
                                        <input type="password" placeholder="Password" class="form-control no-border" name="password">
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <input id="checkbox1" type="checkbox" name="remember" class="form-control no-border">
                                            <label for="checkbox1">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                                <div class="text-center m-t m-b">
                                    <a href="{{ url('/password/email') }}" class="btn btn-link">
                                        <small>Forgot Your Password?</small>
                                    </a>
                                </div>
                                <div class="line line-dashed"></div>
                                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                                <a href="{{ route('auth.register') }}" class="btn btn-lg btn-default btn-block">Create an account</a>
                            </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection