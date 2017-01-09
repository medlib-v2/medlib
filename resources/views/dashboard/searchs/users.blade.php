<div class="item col-md-4 col-sm-6 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="media">
                <div class="pull-left">
                    <img src="{{ url('avatars/' . $user->getAvatar() ) }}" alt="people" class="media-object img-circle" height="50" width="50">
                </div>
                <div class="widget-body">
                    <h4 class="media-heading margin-v-5"><a href="#">{{ $user->getFirstName() }}&nbsp; {{ $user->getLastName() }}</a></h4>
                    <div class="profile-icons">
                        <span><i class="fa fa-users"></i> 372</span>
                        <span><i class="fa fa-photo"></i> 43</span>
                        <span><i class="fa fa-video-camera"></i> 3</span>
                        @if(!$user->getLocation() == null or !$user->getLocation() == "")
                            <span><i class="fa fa-map"></i>{{ $user->getLocation() }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="common-friends">Common Friends</p>
            <div class="user-friend-list">
                <a href="#">
                    <img src="{{ url('avatars/a1.jpg') }}" alt="people" class="img-circle" height="50" width="50">
                </a>
                <a href="#">
                    <img src="{{ url('avatars/a3.jpg') }}" alt="people" class="img-circle" height="50" width="50">
                </a>
                <a href="#">
                    <img src="{{ url('avatars/a6.jpg') }}" alt="people" class="img-circle" height="50" width="50">
                </a>
                <a href="#">
                    <img src="{{ url('avatars/default.jpg') }}" alt="people" class="img-circle" height="50" width="50">
                </a>
            </div>
        </div>
        <div class="panel-footer">
            <a href="#" class="btn btn-default btn-sm">Follow <i class="fa fa-share"></i></a>
        </div>
    </div>
</div>