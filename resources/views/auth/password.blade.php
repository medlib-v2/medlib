@extends('layouts.master')

@section('title', 'Reset Password')

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
                                <strong>Reset Password</strong>
                            </header>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label>Enter your email address and we will send you a link to reset your password.</label>
                                <div class="form-group @if ($errors->has('email')) has-error @endif">
                                    <div class="list-group-item">
                                        <input type="email" placeholder="Enter your email address" class="form-control no-border" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Send password reset email</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection