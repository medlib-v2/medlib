@extends('layouts.dashboards.dashboard')

@section('title', 'Profile ' . Auth::user()->getName())

@section('content')
    <div class="content-wrap">
        <main id="content" class="content" role="main">
            @include('users.users.partials.profile')
        </main>
    </div>
@endsection

@section('script')
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js') }}"></script>
@endsection