@extends('layouts.master')

@section('title', 'Settings Profile '. Auth::user()->getName())

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <br>
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                        <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content profile -->
                @include('users.settings.partials.profile')
                        <!-- Ending content profile -->
            </div>
        </div>
    </div>
@endsection