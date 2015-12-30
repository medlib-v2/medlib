<div class="st-content">

    <!-- extra div for emulating position:fixed of the menu -->
    <div class="st-content-inner">

        <div class="container-fluid">

            <div class="media media-grid media-clearfix-xs">
                <div class="row">
                    <div class="col-xs-11 col-sm-5 col-md-3">
                        <div class="width-250 width-auto-xs">
                            <div class="panel panel-dashboard widget-user-1 text-center">
                                <div class="profile-userpic">
                                    <img class="img-circle" src="{{ Auth::user()->getAvatar() }}" alt="...">
                                    <h4>{{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong></h4>
                                    <a href="#" class="btn btn-success">Following <i class="fa fa-check-circle fa-fw"></i></a>
                                    <a class="btn btn-primary" href="#"><i class="fa fa-envelope"></i> Send</a>
                                </div>
                                <div class="profile-icons margin-none">
                                    <span><i class="fa fa-users"></i> 372</span>
                                    <span><i class="fa fa-photo"></i> 43</span>
                                    <span><i class="fa fa-video-camera"></i> 3</span>
                                </div>
                                <div class="panel-body-dashboard">
                                    <div class="expandable expandable-indicator-white expandable-trigger">
                                        <div class="expandable-content">
                                            <p>Hi! I'm Adrian the Senior UI Designer at
                                                <strong>MOSAICPRO</strong>. We hope you enjoy the design and quality of Social.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut autem delectus dolorum necessitatibus neque odio quam quas qui quod soluta? Aliquid eius esse minima.</p>
                                            <div class="expandable-indicator"><i></i></div></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="panel panel-dashboard">
                                <div class="panel-heading">
                                    Contact
                                </div>
                                <ul class="icon-list icon-list-block">
                                    <li><i class="fa fa-envelope fa-fw"></i> <a href="#">contact@mosaicpro.biz</a></li>
                                    <li><i class="fa fa-facebook fa-fw"></i> <a href="#">/facebook</a></li>
                                    <li><i class="fa fa-behance fa-fw"></i> <a href="#">/user</a></li>
                                </ul>
                            </div>
                            <!-- /Contact -->
                        </div>
                    </div>
                    <div class="col-xs-11 col-sm-7 col-md-9">
                        <div class="tabbable">
                            <ul class="nav nav-tabs" style="overflow: hidden; outline: none;" tabindex="0">
                                <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-fw fa-picture-o"></i> Photos</a></li>
                                <li class=""><a href="#profile" data-toggle="tab"><i class="fa fa-fw fa-folder"></i> Albums</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home">
                                    <img src="avatars/place1.jpg" alt="image">
                                    <img src="avatars/place2.jpg" alt="image">
                                    <img src="avatars/food1.jpg" alt="image">
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                                        booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente
                                        labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed
                                        echo park.</p>
                                </div>
                                <div class="tab-pane fade" id="dropdown1">
                                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles
                                        etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred
                                        you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                                </div>
                                <div class="tab-pane fade" id="dropdown2">
                                    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life
                                        echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan,
                                        sartorial keffiyeh echo park vegan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-dashboard">
                                    <div class="panel-heading panel-heading-gray">
                                        <a href="#" class="btn btn-white btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                        <i class="fa fa-fw fa-info-circle"></i> About
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled profile-about margin-none">
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
                                                    <div class="col-sm-8">12 January 1990</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Job</span></div>
                                                    <div class="col-sm-8">Specialist</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                                                    <div class="col-sm-8">Male</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
                                                    <div class="col-sm-8">Miami, FL, USA</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Credits</span></div>
                                                    <div class="col-sm-8">249</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-dashboard">
                                    <div class="panel-heading panel-heading-gray">
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-primary btn-xs">Add <i class="fa fa-plus"></i></a>
                                        </div>
                                        <i class="icon-user-1"></i> Friends
                                    </div>
                                    <div class="panel-body">
                                        <ul class="img-grid">
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/guy-6.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/woman-3.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/guy-2.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/guy-9.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/woman-9.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li class="clearfix">
                                                <a href="#">
                                                    <img src="avatars/guy-4.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/guy-1.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/woman-4.jpg" alt="image">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="avatars/guy-6.jpg" alt="image">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-dashboard">
                            <div class="panel-heading panel-heading-gray">
                                <i class="fa fa-bookmark"></i> Public Books
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-dashboard">
                                            <div class="panel-body">
                                                <a href="#" class="h5 margin-none">Climb a Mountain</a>
                                                <div class="text-muted">
                                                    <small><i class="fa fa-calendar"></i> 24/10/2014</small>
                                                </div>
                                            </div>
                                            <a href="#">
                                                <img src="{{ 'avatars/place1-full.jpg' }}" alt="image" class="img-responsive">
                                            </a>
                                            <div class="panel-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor impedit ipsum laborum maiores tempore veritatis....</p>
                                                <div>
                                                    <div class="pull-right">
                                                        <a href="#" class="btn btn-primary btn-xs">read</a>
                                                    </div>

                                                    <a href="#" class="text-muted"> <i class="fa fa-comments"></i> 6</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-dashboard">
                                            <div class="panel-body text-center">
                                                <a href="#" class="h5 margin-none">Vegetarian Pizza</a>
                                                <p class="text-muted"><i class="fa fa-calendar"></i> 24/10/2014</p>
                                                <span class="fa fa-star text-primary"></span>
                                                <span class="fa fa-star text-primary"></span>
                                                <span class="fa fa-star text-primary"></span>
                                                <span class="fa fa-star text-primary"></span>
                                                <span class="fa fa-star-o"></span>
                                            </div>
                                            <a href="#">
                                                <img src="avatars/food1-full.jpg" alt="image" class="img-responsive">
                                            </a>
                                            <div class="panel-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor impedit ipsum laborum maiores tempore veritatis....</p>
                                                <div>
                                                    <div class="pull-right">
                                                        <a href="#" class="btn btn-primary btn-xs">read</a>
                                                    </div>
                                                    <a href="#" class="text-muted"> <i class="fa fa-comments"></i> 6</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-dashboard">
                                            <div class="panel-body">
                                                <div class="pull-right">
                                                    <a href="#" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></a>
                                                </div>
                                                <a href="#" class="h5">Win a Holiday</a>
                                                <div class="text-muted">
                                                    <small><i class="fa fa-calendar"></i> 24/10/2014</small>
                                                </div>
                                            </div>
                                            <a href="#">
                                                <img src="avatars/place2-full.jpg" alt="image" class="img-responsive">
                                            </a>
                                            <ul class="icon-list icon-list-block">
                                                <li><i class="fa fa-calendar fa-fw"></i> <a href="#">1 Week</a></li>
                                                <li><i class="fa fa-users fa-fw"></i> <a href="#"> 2 People</a></li>
                                                <li><i class="fa fa-map-marker fa-fw"></i> <a href="#">Miami, FL, USA</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="ascrail2000" class="nicescroll-rails" style="width: 5px; z-index: auto; cursor: default; position: absolute; top: 76px; left: 1055px; height: 39px; display: none; opacity: 0;">
            <div style="position: relative; top: 0px; float: right; width: 5px; height: 0px; border: 0px; border-radius: 5px; background-color: rgb(22, 174, 159); background-clip: padding-box;"></div>
        </div>
        <div id="ascrail2000-hr" class="nicescroll-rails" style="height: 5px; z-index: auto; top: 110px; left: 290px; position: absolute; cursor: default; display: none; opacity: 0;">
            <div style="position: absolute; top: 0px; height: 5px; width: 0px; border: 0px; border-radius: 5px; left: 0px; background-color: rgb(22, 174, 159); background-clip: padding-box;"></div>
        </div>
    </div>
    <!-- /st-content-inner -->
</div>
