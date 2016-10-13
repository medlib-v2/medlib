@extends('layouts.dashboards.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="content-wrap">
        <main id="content" class="content" role="main">
            Dashboard
        </main>
    </div>
@endsection

@section('script')
    @include('dashboard.scripts.home')
@endsection