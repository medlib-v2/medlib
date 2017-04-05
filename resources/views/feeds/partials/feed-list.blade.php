<section class="event" id="feed-id-{!! $feed->id !!}">
	<span class="thumb-sm avatar pull-left mr-sm">
		<a href="{{ route('profile.user.show', ['username' => $feed->user->getUsername()]) }}" class="pull-left">
			<img src="{{ $feed->user->getAvatar() }}" alt="{{ $feed->user->getNameOrUsername() }}" class="img-circle">
		</a>
	</span>
	<h4 class="event-heading">
		<a href="{{ route('profile.user.show', ['username' => $feed->user->getUsername()]) }}">{{ $feed->user->getName() }}</a>
	</h4>
	<p class="fs-sm text-muted">{!! $feed->getPublishAt() !!}</p>
	<p class="fs-mini content">{{ $feed->getContent() }}</p>
	@if($feed->getImagePath() != null)
	<p class="event-image">
		<img src="{{ $feed->getImagePath() }}" alt="">
	</p>
	@endif
	<footer>
		<div class="clearfix">
			<ul class="post-links list-inline mt-sm pull-left pull-xs-left">
				<li><a href="#">1 hour</a></li>
				<li><a href="{{ route('user.feeds.like', ['username'=> ($feed->user->id !== Auth::user()->id) ? $feed->user->getUsername() : Auth::user()->getUsername(), 'status_id' => $feed->getFeedId()])}}"><span class="text-danger"><i class="fa fa-heart-o"></i> {{ $feed->likes()->count() }} Like</span></a></li>
				<li><a href="#">Comment</a></li>
			</ul>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a1.jpg"></a></span>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a5.jpg"></a></span>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a3.jpg"></a></span>
		</div>
		<ul class="post-comments mt-sm">
			@foreach ($feed->comments() as $reply)
				<li>
					<span class="thumb-xs avatar pull-left mr-sm">
						<a href="{{ route('profile.index',['username'=> $reply->user->getUsername()]) }}" class="pull-left">
							<img src="{{ $reply->user->getAvatar() }}" alt="{{ $reply->user->getNameOrUsername() }}" class="img-circle">
						</a>
					</span>
					<div class="comment-body">
						<h6 class="author fw-semi-bold"><a href="{{ route('profile.index', ['username'=> $reply->user->getUsername()]) }}">{{$reply->user->getName()}}</a> <small>{{ $reply->getPublishAt() }}</small></h6>
						<p>{{$reply->getContent()}}</p>
						<ul class="list-inline">
							<li><a href="{{route('user.feeds.like', ['username' => ($reply->user->id !== Auth::user()->id) ? $feed->user->getUsername() : Auth::user()->getUsername(), 'status_id' => $reply->id])}}"><span class="text-danger"><i class="fa fa-heart-o"></i> {{ $reply->likes()->count() }} Like</span></a></li>
							<li><a href="#">Comment</a></li>
						</ul>
					</div>
				</li>
			@endforeach
			<li>
				<span class="thumb-xs avatar pull-left mr-sm"><img class="img-circle" src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->getUsername() }}"></span>
				<div class="comment-body">
					<form role="form" action="{{ route('user.feeds.comment',['username' => Auth::user()->getUsername(),'status_id' => $feed->id]) }}" method="Post">
						{!! csrf_field() !!}
						<div class="form-group{{ $errors->has("comment-{$feed->id}") ? ' has-error':"" }}">
							<input class="form-control input-sm" name="comment-{{$feed->id}}" type="text" placeholder="Write your comment...">
							@if ($errors->has("reply-{$feed->id}"))
								<span class="help-block">{{ $errors->first("comment-{$feed->id}" ) }}</span>
							@endif
						</div>
					</form>
				</div>
			</li>
		</ul>
	</footer>
</section>

<section class="event">
	<span class="thumb-sm avatar pull-left mr-sm">
	  <img class="img-circle" src="/avatars/a5.jpg" alt="...">
	</span>
	<h4 class="event-heading">
		<a href="#">Bob Nilson</a> <small><a href="#">@nils</a></small>
	</h4>
	<p class="fs-sm text-muted">February 22, 2014 at 01:59 PM</p>
	<p class="fs-mini content">There is no such thing as maturity. There is instead an ever-evolving process of maturing. Because when there is a maturity, there is ...</p>
	<footer>
		<ul class="post-links">
			<li><a href="#">1 hour</a></li>
			<li>
				<a href="#"><span class="text-danger"><i class="fa fa-heart"></i> Like</span></a>
			</li>
			<li><a href="#">Comment</a></li>
		</ul>
	</footer>
</section>
<section class="event">
	<h4 class="event-heading"><a href="#">Jessica Smith</a> <small>@jess</small></h4>
	<p class="fs-sm text-muted">February 22, 2014 at 01:59 PM</p>
	<p class="fs-min content">Check out this awesome photo I made in Italy last summer. Seems it was lost somewhere deep inside my brand new HDD 40TB. Thanks god I found it!</p>
	<footer>
		<div class="clearfix">
			<ul class="post-links mt-sm pull-left">
				<li><a href="#">1 hour</a></li>
				<li><a href="#"><span class="text-danger"><i class="fa fa-heart-o"></i> Like</span></a></li>
				<li><a href="#">Comment</a></li>
			</ul>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a1.jpg"></a></span>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a5.jpg"></a></span>
			<span class="thumb thumb-sm pull-right"><a href="#"><img class="img-circle" src="/avatars/a3.jpg"></a></span>
		</div>
		<ul class="post-comments mt-sm">
			<li>
				<span class="thumb-xs avatar pull-left mr-sm"><img class="img-circle" src="/avatars/a1.jpg" alt="..."></span>
				<div class="comment-body">
					<h6 class="author fw-semi-bold">Ignacio Abad <small>6 mins ago</small></h6>
					<p>Hey, have you heard anything about that?</p>
				</div>
			</li>
			<li>
				<span class="thumb-xs avatar pull-left mr-sm"><img class="img-circle" src="/avatars/a1.jpg" alt="..."></span>
				<div class="comment-body"><input class="form-control input-sm" type="text" placeholder="Write your comment..."></div>
			</li>
		</ul>
	</footer>
</section>