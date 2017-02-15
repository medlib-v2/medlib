@extends('layouts.master')

@section('title', 'Feeds ' . Auth::user()->getName())

@section('content')
	<div class="content-wrap">
		<div class="pace  pace-inactive">
			<div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
				<div class="pace-progress-inner"></div>
			</div>
			<div class="pace-activity"></div>
		</div>
		<main id="content" class="content" role="main">
			@include('flash.message')
			<div id="main-feed" class="row">
				<div id="center-column" class="col-md-6">

					@include('messages.partials.center-form', [
					'placeholder' => 'What\'s on your mind?',
					'formType' => 'mt',
					'button' => 'Publish',
					'path' => ['user.feeds.store', Auth::user()->getUsername()],
					'postingFeed' => true,
					'sender_name' => Auth::user()->getUsername(),
					'sender_profile_image' => Auth::user()->getAvatar()
					])

					<div class="feed-list" data-feedcount="{!! $feedsCount !!}">
						<div id="loader"></div>

						@if($feeds->count())

							@foreach($feeds as $feed)

								@include('feeds.partials.feed-list')

							@endforeach
						@else
							<div class="alert alert-info no-feeds-info" role="alert">
								<span class="glyphicon glyphicon-info-sign"></span> You haven't posted anything yet.
							</div>
						@endif
					</div>
				</div>
			</div>
		</main>
	</div>
@stop