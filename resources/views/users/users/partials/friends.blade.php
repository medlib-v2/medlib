<div class="row" data-toggle="isotope" style="position: relative; height: 762px;">
    @if($user->is(Auth::user()))
        @if(count($friends) == 0)
            @include('friends.partials.no-friends')
        @else
            @foreach($friends as $friend )
                @include('friends.partials.friends')
            @endforeach
        @endif
    @else
        @if(count($friends) == 0)
            @include('friends.partials.no-friends')
        @else
            @foreach($friends as $friend )
                @include('friends.partials.friends')
            @endforeach
        @endif
    @endif
</div>