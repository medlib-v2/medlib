@if(Request::path() == 'messages/compose/'.$user->getUsername())
	<a href="{!! url('users', ['username' => $user->getUsername()]) !!}" class="btn btn-primary" role="button"> Back</a>
@else
	<a href="{!! url('messages/compose', ['username' => $user->getUsername()]) !!}" class="btn btn-primary" role="button"><i class="fa fa-envelope"></i> Message</a>
@endif