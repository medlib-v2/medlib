@extends('layouts.master')

@section('title', 'Settings Email '. Auth::user()->getName())

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <br>
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                        <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content email -->
                @include('users.settings.partials.email')
                        <!-- Ending content email -->
            </div>
        </div>
    </div>
@endsection