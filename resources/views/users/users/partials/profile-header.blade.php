<div class="user-cover profile">
    <div class="wrapper">
        @if($user->is(Auth::user()))
            <div class="v-bottom v-left">
                <a href="#" class="btn btn-cover"><i class="fa fa-pencil"></i></a>
            </div>
            <div class="image">{{ Html::image("/avatars/profile-cover.jpg", Auth::user()->getUsername() ) }}</div>
        @else
        <div class="image">{{ Html::image("/avatars/profile-cover.jpg", $user->getUsername() ) }}</div>
        @endif

        <ul class="friends">
            @if(count($friends) !== 0)
                @foreach( $friends as $friend)
                    <li>
                        <a href="{{ url('/u', ['username' => $friend->getUsername() ]) }}">
                            {{ Html::image($friend->getAvatar(), $friend->getUsername(), ['class' => 'img-responsive'] )  }}
                        </a>
                    </li>
                @endforeach
            @endif
            <li><a href="#" class="group"><i class="fa fa-group"></i></a></li>
        </ul>
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
                <li class=""><a href="#profile"><i class="fa fa-fw fa-user-circle-o"></i> About</a></li>
            </ul>
        </div>
        @if(!$user->is(Auth::user()))
        <div id="profile-menu" class="profile-menu">
            @include("messages.partials.send-email-button")
            @include("users.users.partials.request-button")
        </div>
        @endif
    </div>
</div>
