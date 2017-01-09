@extends('layouts.master')

@section('content')
	<div id="center-column" class="col-md-6">
		@include('flash.message')
			@if(count($friends))
				<div class="users-list">

					@foreach($friends as $friend)
						<div class="media listed-object-close">
							<div class="pull-left">		
								<a href="{!! url('/u/'.$friend['username']) !!}"><img class="media-object avatar medium-avatar" src="{!! $friend['user_avatar'] !!}" alt="{!! $friend['first_name'] !!}"></a>
							</div>
							<div class="media-body">
								<h4 class="media-heading">{!! $friend['first_name'] !!}</h4>
								<div class="pull-right">																							
									<a href="#" data-method="DELETE" data-username="{!! $friend['username'] !!}" class="btn btn-primary unfriend-button-3 btn-sm" role="button">Unfriend</a>
								</div>		
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don't have any friends.</div>
			@endif
		</div>
@endsection