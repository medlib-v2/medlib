@extends('layouts.master')

@section('title', 'Register')

@section('content')
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
                @if($errors->has())
                    <div class="alert alert-danger" role="alert">
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
                <div class=""><h2>Register</h2></div>
                <!-- Register form -->
                <form role="form" method="POST" action="{{ route('auth.register') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                            <label for="first_name" class="sr-only">First Name</label>
                            <input class="form-control input-lg" placeholder="First name" name="first_name" type="text" id="first_name" value="{{ old('first_name') }}" tabindex="1" required>
                            @if ($errors->has('first_name')) <p class="help-block"><strong>{{ $errors->first('first_name') }}</strong></p> @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group @if ($errors->has('last_name')) has-error @endif" >
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Last name" value="{{ old('last_name') }}" tabindex="2" required>
                            @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group @if ($errors->has('username')) has-error @endif">
                            <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" placeholder="login" class="form-control input-lg" tabindex="3" value="{{ old('username') }}" required>
                            @if ($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
                        </div>
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <input type="email"  class="form-control input-lg" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="Email super@cool.com" tabindex="4" varlue="{{ old('email') }}" required>
                            @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                        </div>
                        <div class="form-group @if ($errors->has('email_confirm')) has-error @endif">
                            <input type="email"  class="form-control input-lg" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email_confirm" placeholder="Confirm email super@cool.com" tabindex="4"  required>
                            @if ($errors->has('email_confirm')) <p class="help-block">{{ $errors->first('email_confirm') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <input type="password" name="password" pattern=".{6,}" placeholder="Your password" required autocomplete="off" class="form-control input-lg"  tabindex="5">
                            @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group @if ($errors->has('password_confirm')) has-error @endif">
                            <input type="password" name="password_confirm" pattern=".{6,}" required placeholder="Confirm your password" autocomplete="off" class="form-control input-lg"  tabindex="6">
                            @if ($errors->has('password_confirm')) <p class="help-block">{{ $errors->first('password_confirm') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <div class=""><p><strong>Profession</strong></p></div>
                                <div class="form-group @if ($errors->has('profession')) has-error @endif">
                                    <select name="profession" required  class="form-control input-lg" tabindex="10" style="padding: 5px">
                                        <option value>---Selectonner une prefession---</option>
                                        <option value="studiant">Etudaint</option>
                                        <option value="teacher">Professeur</option>
                                        <option value="researcher">Chercheur</option>
                                    </select>
                                    @if ($errors->has('profession')) <p class="help-block">{{ $errors->first('profession') }}</p> @endif
                                </div>
                            </div>
                            <!-- /Birthday -->
                            <div class="col-md-7">
                                <div class=""><p><strong>Birthday</strong></p></div>
                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                    <div class="form-group @if ($errors->has('day')) has-error @endif">
                                        <select name="day" required  title="Jour" id="birthday_day" class="form-control input-lg" tabindex="11" style="padding: 5px">
                                            <option value>Day</option>
                                            @for ($i = 0; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                    <div class="form-group @if ($errors->has('month')) has-error @endif">
                                        <select name="month" required  title="Mois" id="birthday_month" class="form-control input-lg" tabindex="12" style="padding: 5px">
                                            <option value>Month</option>
                                            @for ($i = 0; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                    <div class="form-group @if ($errors->has('year')) has-error @endif">
                                        <label for="year" class="sr-only">Year</label>
                                        <input class="form-control input-lg" placeholder="Year" pattern="[0-9]{4}" name="year" type="text" id="birthday_year" title="Year" tabindex="13" required>
                                    </div>
                                </div>
                                <a class="mlm _58ms" href="{{ route('auth.reg_birthday') }}" title="Cliquez ici pour plus d’informations" rel="async" role="button">
                                    Pourquoi dois-je indiquer ma date de naissance ?
                                </a>
                            </div>
                            <!-- /Birthday -->
                            <!-- Gender -->
                            <div class="col-md-7">
                                <div class="col-xs-4 col-md-6 col-sm-4">
                                    <div class="radio">
                                        <input type="radio" name="gender" id="radio1" value="woman" checked="">
                                        <label for="radio1">Famme</label>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-6 col-sm-4">
                                    <div class="radio">
                                        <input name="gender" id="radio2" value="man" type="radio">
                                        <label for="radio2">Homme</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /Gender -->
                        </div>
                    </div>
                    <!-- Image profile -->
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
                        <div class="row">
                            {!! Recaptcha::render() !!}
                        </div>
                    </div>
                    <!--  /ReCaptcha -->
                    <!-- Submit btn -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <hr class="colorgraph" style="border-top:1px #ccc solid">
                            <button type="submit" class="btn btn-success col-xs-12 col-sm-12 col-md-12 btn-lg">Sing up</button>
                        </div>
                    </div>
                    <!-- /Submit btn -->
                </form>
                <!-- /Register form -->
            </div>
        </div>
    </div>
@endsection