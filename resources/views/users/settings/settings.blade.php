@extends('layouts.master')

@section('title', 'Profile '. Auth::user()->getName())

@section('class') container-fluid @endsection

@section('content')
    <main id="content" class="content" role="main">
        <section class="user-settings">
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                @include('users.settings.partials.menusettings')
                <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content setting -->
                @include('users.settings.partials.setting')
                <!-- Ending content setting -->
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        /**
         * Medlib Application
         *
         */
        $(document).ready(function(){
            Medlib.BeSelect(null);
        });
    </script>
@endsection