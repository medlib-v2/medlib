@if(Auth::user()->isFriendsWith($user->id))
    <a href="{{ route('friends.del') }}" class="btn btn-danger del-friend-button" data-method="DELETE" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" role="button">
        <i class="glyphicon glyphicon-remove"></i> {{ trans('auth.friends_del') }}</a>
@else
    @if(Auth::user()->sentFriendRequestTo($user->id))
        <button class="btn btn-primary btn-success" disabled="disabled" type="submit"><i class="fa fa-check-circle fa-fw"></i> {{ trans('auth.friends_send_request') }}</button>
    @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
        <a href="{{ route('friends.store') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success add-friend-request-button" role="button">
            <i class="fa fa-check-circle fa-fw"></i> {{ trans('auth.friends_accept_request') }}</a>
    @else
        <a href="{{ route('request.post') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success send-friend-request-button" role="button"><i class="fa fa-check-circle fa-fw"></i> {{ trans('auth.friends_remove_request') }}</a>
    @endif
@endif