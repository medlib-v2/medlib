@extends('layouts.master')

@section('title', 'Settings Profile '. Auth::user()->getName())

@section('class') container-fluid @endsection

@section('content')
    <main id="content" class="content" role="main">
        <section class="user-settings">
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content profile -->
                @include('users.settings.partials.profile')
                <!-- Ending content profile -->
            </div>
        </section>
    </main>
@endsection

@section('script')

@endsection