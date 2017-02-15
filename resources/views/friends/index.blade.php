@extends('layouts.master')

@if($user->is(Auth::user()))
	@section('title', 'Friends ' . Auth::user()->getName())
@else
	@section('title', 'Friends ' . $user->getName())
@endif

@section('class') container-fluid @endsection

@section('content')
	<main id="content" class="content content-profile" role="main">
		<section class="user-profile">
			<div class="container-fluid">
				<div id="center-column" class="col-md-6">
					@include('flash.message')
					@if(count($friends))
						<div class="users-list">
							<friends-list :friends.sync="users" :user.sync="user"></friends-list>

							@foreach($friends as $friend)
								<div class="media listed-object-close">
									<div class="pull-left">
										<a href="{{ route('profile.user.show', ['username' => $friend['username']]) }}"><img class="media-object avatar medium-avatar" src="{{ $friend['user_avatar']  }}" alt="{{ $friend['first_name'] }}"></a>
									</div>
									<div class="media-body">
										<h4 class="media-heading">{{ $friend['first_name'] }}</h4>
										<div class="pull-right">
											<a href="{{ route('request.del') }}" data-method="DELETE" data-username="{{ $friend['username'] }}" data-token="{{ Session::get('_token') }}" class="btn btn-primary btn-danger del-friend-button btn-sm" role="button">
												<i class="glyphicon glyphicon-remove"></i>&nbsp;Unfriend</a>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don't have any friends.</div>
					@endif
				</div>
			</div>
		</section>
	</main>
@endsection