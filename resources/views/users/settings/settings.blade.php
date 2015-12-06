@extends('layouts.master')

@section('title', 'Profile '. Auth::user()->getName())

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <br>
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                        <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content setting -->
                @include('users.settings.partials.setting')
                        <!-- Ending content setting -->
            </div>
        </div>
    </div>
@endsection