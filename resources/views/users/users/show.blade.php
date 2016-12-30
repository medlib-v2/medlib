@extends('layouts.master')

@if($user->is(Auth::user()))
	@section('title', 'Profile ' . Auth::user()->getName())
@else
	@section('title', 'Profile ' . $user->getName())
@endif

@section('class') container-fluid @endsection

@section('content')
	<main id="content" class="content content-profile" role="main">
		<section class="user-profile">
		@include('users.users.partials.public')
		<!-- Feeds content -->
		<div class="feed-list" data-feed-count="1">
			<div id="loader"></div>
		</div>
		<!-- /Feeds content -->
		</section>
	</main>
@endsection

@section('script')
	<!-- page specific js -->
	<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=places"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.js"></script>
	<!--<script src="{{ asset('vendor/gmaps/gmaps.js') }}"></script>-->
	<script type="text/javascript">
		$(document).ready(function(){
			/**
			 * Medlib Application
			 */
			Medlib.Pushed(null);
			Medlib.FriendRequest(null);
			Medlib.FormElements(null);
		});
	</script>
@endsection