@extends('layouts.dashboards.dashboard')

@if($user->is(Auth::user()))
	@section('title', 'Profile ' . Auth::user()->getName())
@else
	@section('title', 'Profile ' . $user->getName())
@endif

@section('content')
	<div class="content-wrap">
		<main id="content" class="content-dashboard" role="main">
			@include('users.users.partials.public')
			<!-- Feeds content -->
			<div class="feed-list" data-feedcount="1">
				<div id="loader"></div>

			</div>
			<!-- /Feeds content -->
		</main>
	</div>
@endsection

@section('script')
	<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=places"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.js"></script>
	<script src="{{ asset('vendor/gmaps/gmaps.js') }}"></script>
	<script src="{{ asset('js/pushed.js') }}"></script>
@endsection