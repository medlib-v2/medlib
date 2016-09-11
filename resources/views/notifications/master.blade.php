<section class="panel notifications">
    <header class="panel-heading">
        <ul class="notifications-list-menu mb-sm">
            <li class="notifications-list-menu-item"><strong class="text-align-center">Vous avez 13 notifications</strong></li>
            <li class="notifications-list-actions">
                <div class="active">
                    <i class="glyphicon glyphicon-bell notification-icon"></i>
                    <a href="#" data-ajax-trigger="change" data-ajax-load="assets/ajax/notifications.html" data-ajax-target="#notifications-list"></a>
                </div>
                <div class="">
                    <i class="glyphicon glyphicon-folder-close"></i>
                    <a href="#" data-ajax-trigger="change" data-ajax-load="assets/ajax/messages.html" data-ajax-target="#notifications-list"></a>
                </div>
            </li>
        </ul>
    </header>
    <!-- notification list with .thin-scroll which styles scrollbar for webkit -->
    <div id="notifications-list" class="list-group thin-scroll">
        <div class="list-group-item">
                                                     <span class="thumb-sm pull-left mr clearfix">
                                                         <img class="img-circle" src="assets/img/people/a3.jpg" alt="...">
                                                     </span>
            <p class="no-margin overflow-hidden">1 new user just signed up! Check out
                <a href="#">Monica Smith</a>'s account.
                <time class="help-block no-margin">2 mins ago</time>
            </p>
        </div>
        <a class="list-group-item" href="#">
                                                     <span class="thumb-sm pull-left mr">
                                                         <i class="glyphicon glyphicon-upload fa-lg"></i>
                                                     </span>
            <p class="text-ellipsis no-margin">
                2.1.0-pre-alpha just released. </p>
            <time class="help-block no-margin">5h ago</time>
        </a>
        <a class="list-group-item" href="#">
                                                     <span class="thumb-sm pull-left mr">
                                                         <i class="fa fa-bolt fa-lg"></i>
                                                     </span>
            <p class="text-ellipsis no-margin">
                Server load limited. </p>
            <time class="help-block no-margin">7h ago</time>
        </a>
        <div class="list-group-item">
                                                     <span class="thumb-sm pull-left mr clearfix">
                                                         <img class="img-circle" src="assets/img/people/a5.jpg" alt="...">
                                                     </span>
            <p class="no-margin overflow-hidden">
                User <a href="#">Jeff</a> registered&nbsp;&nbsp;
                <button class="btn btn-xs btn-success">Allow</button>
                <button class="btn btn-xs btn-danger">Deny</button>
                <time class="help-block no-margin">12:18 AM</time>
            </p>
        </div>
        <div class="list-group-item">
                                                     <span class="thumb-sm pull-left mr">
                                                         <i class="fa fa-shield fa-lg"></i>
                                                     </span>
            <p class="no-margin overflow-hidden">
                Instructions for changing your Envato Account password. Please
                check your account <a href="#">security page</a>.
                <time class="help-block no-margin">12:18 AM</time>
            </p>
        </div>
        <a class="list-group-item" href="#">
                                                     <span class="thumb-sm pull-left mr">
                                                         <span class="rounded bg-primary rounded-lg">
                                                             <i class="fa fa-facebook text-white"></i>
                                                         </span>
                                                     </span>
            <p class="text-ellipsis no-margin">
                New <strong>76</strong> facebook likes received.</p>
            <time class="help-block no-margin">15 Apr 2014</time>
        </a>
        <a class="list-group-item" href="#">
                                                     <span class="thumb-sm pull-left mr">
                                                         <span class="circle circle-lg bg-gray-dark">
                                                             <i class="fa fa-circle-o text-white"></i>
                                                         </span>
                                                     </span>
            <p class="text-ellipsis no-margin">
                Dark matter detected.</p>
            <time class="help-block no-margin">15 Apr 2014</time>
        </a>
    </div>
    <footer class="panel-footer text-sm">
        <!-- ajax-load button. loads assets/ajax/notifications.php to #notifications-list
             when clicked -->
        <button class="btn btn-xs btn-link pull-right" id="load-notifications-btn" data-ajax-load="assets/ajax/notifications.php" data-ajax-target="#notifications-list" data-loading-text="<i class='fa fa-refresh fa-spin mr-xs'></i> Loading...">
            <i class="fa fa-refresh"></i>
        </button>
        <span class="fs-mini">Synced at: 21 Apr 2014 18:36</span>
    </footer>
</section>