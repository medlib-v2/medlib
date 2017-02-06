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
                        <a href="{{ route('profile.show.settings') }}"><i class="glyphicon glyphicon-cog"></i>&nbsp;Profil</a>
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