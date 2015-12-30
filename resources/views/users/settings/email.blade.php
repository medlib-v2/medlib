@extends('layouts.dashboards.dashboard')

@section('title', 'Settings Email '. Auth::user()->getName())

@section('content')
    <div class="content-wrap">
        <main id="content" class="content" role="main">
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                        <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content email -->
                @include('users.settings.partials.email')
                        <!-- Ending content email -->
            </div>
        </main>
    </div>
@endsection

@section('script')
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ url('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/progressbar.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/script.js') }}"></script>
@endsection