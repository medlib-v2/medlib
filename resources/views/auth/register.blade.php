@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <div class="content">
        <div class="container">
                <div class="col-md-7 fond-register welcome"></div>
                <div class="col-md-5 navbar-right">
                    <div class="login-box">

                        @if ($errors->has())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                        <!-- register form -->
                        <form role="form" method="POST" action="{{ route('auth.register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row"><h2>Register</h2></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                                        <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Your first name" value="{{ old('first_name') }}" tabindex="1" required>
                                        @if ($errors->has('first_name')) <p class="help-block"><strong>{{ $errors->first('first_name') }}</strong></p> @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group @if ($errors->has('last_name')) has-error @endif" >
                                        <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Your last name" value="{{ old('last_name') }}" tabindex="2" required>
                                        @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group @if ($errors->has('username')) has-error @endif">
                                    <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" placeholder="Votre login" class="form-control input-lg" tabindex="3" value="{{ old('username') }}" required>
                                    @if ($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
                                </div>
                                <div class="form-group @if ($errors->has('email')) has-error @endif">
                                    <input type="email"  class="form-control input-lg" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="Your email super@cool.com" tabindex="4" varlue="{{ old('email') }}" required>
                                    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                </div>

                                <div class="form-group @if ($errors->has('email_confirm')) has-error @endif">
                                    <input type="email"  class="form-control input-lg" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email_confirm" placeholder="Confirm your email super@cool.com" tabindex="4"  required>
                                    @if ($errors->has('email_confirm')) <p class="help-block">{{ $errors->first('email_confirm') }}</p> @endif
                                </div>
                            </div>

                            <div class="row">
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
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="">Profession</div>
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
                                <div class="col-md-7">
                                    <div class="">Date of Birth</div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="birthday_day" required  title="Jour" id="day" class="form-control input-lg" tabindex="11" style="padding: 5px">
                                                <option value="0" selected="1">Day</option>
                                                @for ($i = 0; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="birthday_month" required  title="Mois" id="month" class="form-control input-lg" tabindex="12" style="padding: 5px">
                                                <option value>Month</option>
                                                @for ($i = 0; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="birthday_year" required  title="Année" id="year" class="form-control input-lg" tabindex="13" style="padding: 1px">
                                                <option value>Year</option>
                                                @for ($i = date("Y")-100; $i <= date("Y"); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <a class="mlm _58ms" href="{{ route('auth.reg_birthday') }}" title="Cliquez ici pour plus d’informations" rel="async" role="button">
                                        Pourquoi dois-je indiquer ma date de naissance ?
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="radio">
                                        <input type="radio" name="gender" id="user_gender" value="woman" checked="">
                                        <label for="woman">Famme</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="radio">
                                        <input name="gender" id="user_gender" value="man" type="radio">
                                        <label for="man">Homme</label>
                                    </div>
                                </div>
                            </div>

                            <!-- show the ReCaptcha -->
                            <div class="row">
                                {!! Recaptcha::render() !!}
                            </div>
                            <div class="form-group">
                                <hr class="colorgraph" style="border-top:1px #ccc solid">
                                <button type="submit" class="btn btn-success col-md-12 btn-lg ">Sing up</button>
                            </div>
                        </form>
                        <!-- register form -->

                    </div><!-- Login box-->
                </div><!-- col-md-6-->
            </div><!-- Container-->
    </div><!-- Content-->
@endsection