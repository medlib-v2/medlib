<div class="display_box" align="left">
    <img src="{{ url('avatars/' . $users->getAvatar() ) }}" />
    {{ $users->getFirstName() }}&nbsp;
    {{ $users->getLastName() }}<br/>
    {{ $users->getLocation() }}
</div>