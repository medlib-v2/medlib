@extends('layouts.master')

@section('title', 'Register')

@section('content')
<main id="content" class="content" role="main">
    <section class="container-fluid animated fadeInUp widget" style="margin-top: 20px;">
        <div class="row" style="padding-right: 10px;">
            <div class="col-md-5">
                <div id="main-title" class="text-center">
                    <a href="{{ route('home') }}"><h2>Medlib a library and social network</h2></a>
                    <img src="{{ url('/images/carte_monde.png') }}" class="img-responsive" alt="Medlib image">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div id="registration-form" class="col-md-6">
                <div class="row">
                    @if (isset($errors) and $errors->has())
                        <div class="alert alert-danger" role="alert">
                            <strong>Whoops!</strong> {{ trans('messages.problems_with_input') }}<br><br>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{!! $error!!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @include('flash.message')
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-12">
                        <h2>Register</h2>

                        <div class="widget-controls">
                            <!--<a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a> -->
                        </div>
                        <header>
                            <br>
                            <h6>Vous avez besoin seulement de 30 secondes pour pofiter de <b>Medlib</b>. Remplissez ceci :</h6>
                            <br>
                        </header>
                    </div>
                    <!-- Register form -->
                    {!! Form::open(['method' => 'POST', 'route' => 'auth.register', 'accept-charset' => 'UTF-8', 'enctype' => 'multipart/form-data', 'role'=> 'form']) !!}
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group @if (isset($errors) and $errors->has('first_name')) has-error @endif">
                                {{ Form::label('First Name', null, ['class' => 'control-label sr-only', 'for' => 'first_name']) }}
                                {!! Form::text('first_name', request()->hasSession() ? old('first_name') : '', [
                                    'placeholder' => 'First name',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '[a-zA-Z]{3,64}',
                                    'required',
                                    'tabindex' => 1,
                                    'id'=> 'first_name'])
                                !!}
                                @if (isset($errors) and $errors->has('first_name')) <p class="help-block"><strong>{{ $errors->first('first_name') }}</strong></p> @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group @if (isset($errors) and $errors->has('last_name')) has-error @endif" >
                                {{ Form::label('Last Name', null, ['class' => 'control-label sr-only', 'for' => 'last_name']) }}
                                {!! Form::text('last_name', request()->hasSession() ? old('last_name') : '', [
                                    'placeholder' => 'First name',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '[a-zA-Z]{3,64}',
                                    'required',
                                    'tabindex' => 2,
                                    'id'=> 'last_name'])
                                !!}
                                @if (isset($errors) and $errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group @if (isset($errors) and $errors->has('username')) has-error @endif">
                                {!! Form::text('username', request()->hasSession() ? old('username'): '', [
                                    'placeholder' => 'login',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '[a-zA-Z0-9]{2,64}',
                                    'required' => 'required',
                                    'tabindex' => 3])
                                !!}
                                @if (isset($errors) and $errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
                            </div>
                            <div class="form-group @if (isset($errors) and $errors->has('email')) has-error @endif">
                                {!! Form::email('email', request()->hasSession() ? old('email') : '', [
                                    'placeholder' => 'Email super@cool.com',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
                                    'required' => 'required',
                                    'tabindex' => 4])
                                !!}
                                @if (isset($errors) and $errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                            </div>
                            <div class="form-group @if (isset($errors) and $errors->has('email_confirm')) has-error @endif">
                                {!! Form::email('email_confirm', request()->hasSession() ? old('email_confirm'): '', [
                                    'placeholder' => 'Confirm email super@cool.com',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
                                    'required' => 'required',
                                    'tabindex' => 5])
                                !!}
                                @if (isset($errors) and $errors->has('email_confirm')) <p class="help-block">{{ $errors->first('email_confirm') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group @if (isset($errors) and $errors->has('password')) has-error @endif">
                                {!! Form::password('password', [
                                    'value' => request()->hasSession() ? old('password') : '',
                                    'placeholder' => 'Your password',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '.{6,}',
                                    'required' => 'required',
                                    'autocomplete'=> 'off',
                                    'tabindex' => 6])
                                !!}
                                @if (isset($errors) and $errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group @if (isset($errors) and $errors->has('password_confirm')) has-error @endif">
                                {!! Form::password('password_confirm', [
                                    'value' => request()->hasSession() ? old('password_confirm') : '',
                                    'placeholder' => 'Confirm your password',
                                    'class' => 'form-control input-lg',
                                    'pattern'=> '.{6,}',
                                    'required' => 'required',
                                    'autocomplete'=> 'off',
                                    'tabindex' => 7])
                                !!}
                                @if (isset($errors) and $errors->has('password_confirm')) <p class="help-block">{{ $errors->first('password_confirm') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class=""><p><strong>Profession</strong></p></div>
                                    <div class="form-group @if (isset($errors) and  $errors->has('profession')) has-error @endif">
                                        {!! Form::select('profession', [
                                            //'' => '---Selectonner une prefession---',
                                            'student' => 'Etudaint',
                                            'teacher' => 'Professeur',
                                            'researcher' => 'Chercheur'], null,
                                            [
                                                'placeholder' => '---Selectonner une prefession---',
                                                'required' => 'required',
                                                'class' => 'form-control input-lg',
                                                'tabindex'=> 8,
                                                'style' => 'padding: 5px'])
                                        !!}
                                        @if (isset($errors) and $errors->has('profession')) <p class="help-block">{{ $errors->first('profession') }}</p> @endif
                                    </div>
                                </div>
                                <!-- /Birthday -->
                                <div class="col-md-7">
                                    <div class=""><p><strong>Date de naissance</strong></p></div>
                                    <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                        <div class="form-group @if (isset($errors) and $errors->has('day')) has-error @endif">
                                            {!! Form::selectRange('day', 1, 31, null, [
                                                'required' => 'required',
                                                'placeholder' => 'Jour',
                                                'title' => 'Jour',
                                                'id' =>'birthday_day',
                                                'class' => 'form-control input-lg',
                                                'tabindex' => 12,
                                                'style' => 'padding: 5px'
                                                ])
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                        <div class="form-group @if (isset($errors) and $errors->has('month')) has-error @endif">
                                            {!! Form::selectMonth('month', null, [
                                                'required' => 'required',
                                                'placeholder' => 'Mois',
                                                'title' => 'Mois',
                                                'id' =>'birthday_month',
                                                'class' => 'form-control input-lg',
                                                'tabindex' => 12,
                                                'style' => 'padding: 5px'
                                                ])
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                        <div class="form-group @if (isset($errors) and $errors->has('year')) has-error @endif">
                                            <label for="year" class="sr-only">Année</label>
                                            <input class="form-control input-lg" placeholder="Année" pattern="[0-9]{4}" name="year" type="text" id="birthday_year" title="Year" tabindex="13" required>
                                        </div>
                                    </div>
                                    <a class="mlm _58ms" href="{{ route('auth.reg_birthday') }}" title="Cliquez ici pour plus d’informations" rel="async" role="button" style="position: relative; margin-left: -285px; clear: both;">
                                        Pourquoi dois-je indiquer ma date de naissance ?
                                    </a>
                                </div>
                                <!-- /Birthday -->
                                <!-- Gender -->
                                <div class="col-md-7">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-8 col-sm-6">
                                                <div class="register-switch">
                                                    <input type="radio" name="gender" value="man" id="sex-male" class="register-switch-input" checked>
                                                    <label for="sex-male" class="register-switch-label"><span class="register-switch-icon-male">&nbsp;</span>&nbsp;Homme</label>
                                                    <input type="radio" name="gender" value="woman" id="sex-female" class="register-switch-input">
                                                    <label for="sex-female" class="register-switch-label"><span class="register-switch-icon-female">&nbsp;</span>&nbsp;Femme</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Gender -->
                            </div>
                        </div>
                        <!-- Image profile -->
                        <!--<div class="input-group">
                                <input type="file" name="file" accept="image/*">
                        </div>-->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="fileupload1"><strong>Profile image</strong></label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">Select file</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="hidden">
                                        <input id="fileupload1" type="file" name="profileimage" required>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <span class="help-block">Please select an image.</span>
                        </div>
                        <!-- /Image profile -->
                        <!-- ReCaptcha -->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {!! Recaptcha::render() !!}
                        </div>
                        <!--  /ReCaptcha -->
                        <!-- Submit btn -->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <hr class="colorgraph" style="border-top:1px #ccc solid">
                                <button type="submit" class="btn btn-success col-xs-12 col-sm-12 col-md-12 btn-lg" style="width: 565px;">{{ trans('auth.txt.sing_up') }}</button>
                            </div>
                        </div>
                        <!-- /Submit btn -->
                        {!! Form::close() !!}
                    <!-- /Register form -->
                </div>
            </div>
        </div>
    </section>
</main>
@endsection