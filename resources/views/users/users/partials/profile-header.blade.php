<div class="cover profile">
    <div class="wrapper">
        @if($user->is(Auth::user()->id))
        <div class="image">
            <img src="/avatars/profile-cover.jpg" alt="{{ Auth::user()->getUsername() }}">
        </div>
        @else
        <div class="image">
            <img src="/avatars/profile-cover.jpg" alt="{{ $user->getUsername() }}">
        </div>
        @endif

        @if($user->is(Auth::user()->id))
        <ul class="friends">
            @if(count($friends) == 0)
                <li><a href="#" class="group"><i class="fa fa-group"></i></a></li>
            @else
                @foreach( $friends as $friend)
                <li>
                    <a href="{{ url('/profiles', ['username' => $friend->getUsername() ]) }}">
                        <img src="{{ $friend->getAvatar() }}" alt="{{ $friend->getUsername() }}" class="img-responsive">
                    </a>
                </li>
                @endforeach
            @endif
        </ul>
        @else
        <ul class="friends">
            @if(count($friends) == 0)
                <li><a href="#" class="group"><i class="fa fa-group"></i></a></li>
            @else
                @foreach( $friends as $friend)
                <li>
                    <a href="#">
                        <img src="{{ $friend->getAvatar() }}" alt="{{ $friend->getUsername() }}" class="img-responsive">
                    </a>
                </li>
                @endforeach
            @endif
        </ul>
        @endif
    </div>
    <div class="cover-info">
        @if($user->is(Auth::user()->id))
        <div class="avatar">
            <img src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->getUsername() }}" id="img-{{ Auth::user()->getUsername() }}">
        </div>
        <div class="name"><a href="#">{{ Auth::user()->getName() }}</a></div>
        @else
        <div class="avatar">
            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getUsername() }}" id="img-{{ $user->getUsername() }}">
        </div>
        <div class="name"><a href="#">{{ $user->getName() }}</a></div>
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
