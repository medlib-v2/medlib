<div class="cover profile">
    <div class="wrapper">
        @if($user->is(Auth::user()))
        <div class="image">
            {{ Html::image("/avatars/profile-cover.jpg", Auth::user()->getUsername() )  }}
        </div>
        @else
        <div class="image">
            {{ Html::image("/avatars/profile-cover.jpg", $user->getUsername() )  }}
        </div>
        @endif

        <ul class="friends">
            <li><a href="#" class="group"><i class="fa fa-group"></i></a></li>
            @if(count($friends) !== 0)
                @foreach( $friends as $friend)
                    <li>
                        <a href="{{ url('/u', ['username' => $friend->getUsername() ]) }}">
                            {{ Html::image($friend->getAvatar(), $friend->getUsername(), ['class' => 'img-responsive'] )  }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        <div id="profile-menu" class="profile-menu">
            @include("messages.partials.send-email-button")
            @if(Auth::user()->isFriendsWith($user->id))
                <a href="{{ route('friends.del') }}" class="btn btn-danger del-friend-button" data-method="DELETE" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" role="button">
                    <i class="glyphicon glyphicon-remove"></i> Retirer de la liste d’amis
                </a>
            @else
                @if(Auth::user()->sentFriendRequestTo($user->id))
                    <button class="btn btn-primary btn-success" disabled="disabled" type="submit"><i class="fa fa-check-circle fa-fw"></i> Invitation envoyée</button>
                @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
                    <a href="{{ route('friends.store') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success add-friend-request-button" role="button">
                        <i class="fa fa-check-circle fa-fw"></i> Accepter l'invitation
                    </a>
                @else
                    <a href="{{ route('request.post') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success send-friend-request-button" role="button"><i class="fa fa-check-circle fa-fw"></i> Ajouter de la liste d’amis</a>
                @endif
            @endif
            <div class="ossn-profile-extra-menu dropdown">
                <div class="">
                    <a role="button" data-toggle="dropdown" class="btn-action" data-target="#" aria-expanded="false"><i class="fa fa-sort-desc"></i></a><ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu"><li><a class="profile-menu-extra-poke" href="http://opensource.dev/action/poke/user?user=2&amp;ossn_ts=1479985134&amp;ossn_token=797f46440218ac7e410d07e84c761ea0">Poke</a></li><li><a class="profile-menu-extra-block" href="http://opensource.dev/action/block/user?user=2&amp;ossn_ts=1479985134&amp;ossn_token=797f46440218ac7e410d07e84c761ea0">Bloquer</a></li></ul></div>
            </div>
        </div>
    </div>
    <div class="cover-info">
        @if($user->is(Auth::user()))
        <div class="avatar">
            {{ Html::image(Auth::user()->getAvatar(), Auth::user()->getUsername(), ['id' => "img-". Auth::user()->getUsername()] ) }}
        </div>
        <div class="name">{{ HTML::link('#', Auth::user()->getName() )}}</div>
        @else
        <div class="avatar">
            {{ Html::image($user->getAvatar(), $user->getUsername(), ['id' => "img-". $user->getUsername()] ) }}
        </div>
        <div class="name">{{ HTML::link('#', $user->getName() )}}</div>
        @endif
        <div class="tabbable">
            <ul class="nav cover-nav" style="overflow: hidden; outline: none;" tabindex="0">
                <li class="active"><a href="#feed" ><i class="fa fa-fw icon-ship-wheel"></i> Timeline</a></li>
                <li class=""><a href="#friends"><i class="fa fa-fw fa-users"></i> Friends</a></li>
                <li class=""><a href="#profile"><i class="fa fa-fw icon-user-1"></i> About</a></li>
            </ul>
        </div>
    </div>
</div>
