@if($usersWhoRequested->count())
	<div class="users-list">
		@foreach($usersWhoRequested as $user)
			<div class="item col-md-4 col-sm-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="media">
							<div class="pull-left">
								<img src="{{ url($user->getAvatar()) }}" alt="people" class="media-object img-circle" height="50" width="50" alt="{!! $user->getFirstName() !!}">
							</div>
							<div class="widget-body">
								<h4 class="media-heading margin-v-5"><a href="{{ url('/users/'.$user->getUsername()) }}" data-fullname="{{ $user->getName() }}">{{ $user->getFirstName() }}&nbsp; {{ $user->getLastName() }}</a></h4>
								<div class="profile-icons">
									<span><i class="fa fa-users"></i> {{ $user->friends()->count() }}</span>
									<span><i class="fa fa-photo"></i> 43</span>
									<span><i class="fa fa-video-camera"></i> {{ $user->feeds()->count() }}</span>
									<span><i class="fa fa-map"></i>{{ $user->getLocation() }}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="widget panel-body">
						<p class="common-friends">Common Friends</p>
						<div class="user-friend-list">
							<a href="#">
								<img src="{{ url('avatars/a1.jpg') }}" alt="people" class="img-circle" height="50" width="50">
							</a>
							<a href="#">
								<img src="{{ url('avatars/a3.jpg') }}" alt="people" class="img-circle" height="50" width="50">
							</a>
							<a href="#">
								<img src="{{ url('avatars/a6.jpg') }}" alt="people" class="img-circle" height="50" width="50">
							</a>
							<a href="#">
								<img src="{{ url('avatars/default.jpg') }}" alt="people" class="img-circle" height="50" width="50">
							</a>
						</div>
					</div>
					<div class="panel-footer">
						<a href="{{ route('friends.store') }}" data-method="POST" data-username="{{ $user->getUsername() }}" data-token="{{ Session::get('_token') }}" class="btn btn-primary btn-success accept-friend-button btn-sm" role="button">
							<i class="fa fa-check-circle fa-fw"></i>&nbsp;Accept</a>
						<a href="{!! route('request.del') !!}" data-method="DELETE" data-username="{{ $user->getUsername() }}" data-token="{{ Session::get('_token') }}" class="btn btn-primary btn-danger del-friend-button btn-sm" role="button">
							<i class="glyphicon glyphicon-remove"></i>&nbsp;Decline</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="paginator text-center">
		{!! $usersWhoRequested->render() !!}
	</div>
@else
	<div class="alert alert-info" role="alert">
		<span class="glyphicon glyphicon-info-sign"></span> You don't have any friend requests.
	</div>
@endif