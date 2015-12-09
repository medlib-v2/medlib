<div class="col-xs-12 col-sm-5 col-md-3">
    <div class="list-group">
        <div class="list-group-item active">
            <span class="menu-heading">Paramètres personnels</span>
        </div>
        <div class="list-group-item">
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li>
                        <div class="profile-userpic">
                            <img src="{{ url('avatars/'. Auth::user()->getAvatar()) }}" class="img-responsive" alt="img_{{ Auth::user()->getFirstNameOrUsername() }}_here">
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">{{ Auth::user()->getName() }}</div>
                            <div class="profile-usertitle-job">{{ Auth::user()->getProfession() }}</div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('profile.show.settings') }}"><i class="glyphicon glyphicon-cog"></i>&nbsp;Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show.admin') }}"><i class="glyphicon glyphicon-user"></i>&nbsp;Paramètres du compte</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show.email') }}"><i class="glyphicon glyphicon-envelope"></i>&nbsp;E-mails</a>
                    </li>
                </ul>
                <!-- END MENU -->
            </div><!--list-group-item-->
        </div> <!-- List-group-->
    </div><!-- col-md-3 -->
</div>