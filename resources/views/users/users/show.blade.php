@extends('layouts.dashboards.dashboard')

@if($user->is(Auth::user()->id))
	@section('title', 'Profile ' . Auth::user()->getName())
@else
	@section('title', 'Profile ' . $user->getName())
@endif

@section('content')
	<div class="content-wrap">
		<main id="content" class="content-dashboard" role="main">
			@include('users.users.partials.public')
		</main>
	</div>
@endsection

@section('script')
	<script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js') }}"></script>
@endsection