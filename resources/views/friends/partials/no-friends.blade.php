<div class="col-md-6 col-lg-4 item" style="position: absolute; left: 0px; top: 0px;">
    <div class="alert alert-info no-feeds-info" role="alert">
        @if($user->is(Auth::user()))
        <span class="glyphicon glyphicon-info-sign"></span>You don't have any friends.
        @else
        <span class="glyphicon glyphicon-info-sign"></span> {{ $user->getFirstName() }} has't any friends.
        @endif
    </div>
</div>