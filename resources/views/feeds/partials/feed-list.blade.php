<section class="event" id="feedid{!! $feed->id !!}">
	<span class="thumb-sm avatar pull-xs-left mr-sm"><img class="img-circle" src="{!! $feed->user->getAvatar() !!}" alt="{!! $feed->user->getUsername() !!}"></span>
	<h5 class="event-heading"><a href="{!! url('/profiles/'.$feed->user->getUsername()) !!}">{!! $feed->user->getName() !!}</a></h5>
	<p class="text-muted">{!! $feed->created_at->diffForHumans() !!}</p>
	<p>{!! $feed->getContent() !!}</p>
	<footer>
		<div class="clearfix">
			<ul class="post-links mt-sm pull-xs-left">
				<li><a href="#">1 hour</a></li>
				<li><a href="#"><span class="text-danger"><i class="fa fa-heart-o"></i> Like</span></a></li>
				<li><a href="#">Comment</a></li>
			</ul>

			<span class="thumb thumb-sm pull-xs-right">
				<a href="#"><img class="img-circle" src="demo/img/people/a1.jpg"></a>
			</span>
			<span class="thumb thumb-sm pull-xs-right">
				<a href="#"><img class="img-circle" src="demo/img/people/a5.jpg"></a>
			</span>
			<span class="thumb thumb-sm pull-xs-right">
				<a href="#"><img class="img-circle" src="demo/img/people/a3.jpg"></a>
			</span>
		</div>
		<ul class="post-comments mt-sm">
			<li>
				<span class="thumb-xs avatar pull-xs-left mr-sm">
					<img class="img-circle" src="demo/img/people/a1.jpg" alt="...">
				</span>
				<div class="comment-body">
					<h6 class="author fw-semi-bold fs-sm">Ignacio Abad <small>6 mins ago</small></h6>
					<p>Hey, have you heard anything about that?</p>
				</div>
			</li>
			<li>
				<span class="thumb-xs avatar pull-xs-left mr-sm">
					<img class="img-circle" src="img/avatar.png" alt="...">
				</span>
				<div class="comment-body">
					<input class="form-control form-control-sm" type="text" placeholder="Write your comment...">
				</div>
			</li>
		</ul>
	</footer>
</section>