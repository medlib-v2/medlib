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
			<div class="container-fluid">
				@include('users.users.partials.public')
				<!-- Feeds content -->
				<div class="feed-list" data-feed-count="{!! $feeds->count() !!}">
					<div id="loader"></div>
					<div class="row">
						<div class="col-md-3 col-sm-2 hidden-xs no-padding"></div>
						<div class="col-md-6 col-sm-8">
							<section class="activities">
								@if($feeds->count())
									@foreach($feeds as $feed)
										@include('feeds.partials.feed-list')
									@endforeach
									{{$feeds->render()}}
								@else
									<div class="alert alert-info no-feeds-info" role="alert">
										<span class="glyphicon glyphicon-info-sign"></span> You haven't posted anything yet.
									</div>
								@endif
							</section>
						</div>
						<div class="col-md-3 col-sm-2 hidden-xs no-padding"></div>
					</div>
				</div>
				<!-- /Feeds content -->
			</div>
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