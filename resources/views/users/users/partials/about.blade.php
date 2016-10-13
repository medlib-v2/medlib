<div class="clearfix">
    <div class="fade active in">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-3 item">
                <div class="width-250 width-auto-xs">
                    <div class="panel panel-dashboard widget-user-1 text-center box-shadow">
                        <div class="profile-userpic">
                            @if($user->is(Auth::user()->id))
                                <!--<div class="profile-card-icon"><i class="fa fa-graduation-cap"></i></div>-->
                                <img class="img-circle" src="{{ Auth::user()->getAvatar() }}" alt="...">
                                <h4 data-fullname="{{ Auth::user()->getName() }}">{{ Auth::user()->getFirstName() }} <strong>{{ Auth::user()->getLastName() }}</strong></h4>
                                <h4 data-profession="{{ Auth::user()->getProfession() }}"><strong>{{ Auth::user()->getProfession() }}</strong></h4>
                            @else
                                <!--<div class="profile-card-icon"><i class="fa fa-graduation-cap"></i></div>-->
                                <img class="img-circle" src="{{ $user->getAvatar() }}" alt="...">
                                <h4 data-fullname="{{ $user->getName() }}">{{ $user->getFirstName() }} <strong>{{ $user->getLastName() }}</strong></h4>
                                <h4 data-profession="{{ $user->getProfession() }}"><strong>{{ $user->getProfession() }}</strong></h4>

                                @if(Auth::user()->isFriendsWith($user->id))
                                    @include("messages.partials.send-email-button")
                                    <a href="{{ route('friends.del') }}" class="btn btn-danger del-friend-button" data-method="DELETE" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" role="button">
                                        <i class="glyphicon glyphicon-remove"></i> Delete friend
                                    </a>
                                @else
                                    @include("messages.partials.send-email-button")
                                    @if(Auth::user()->sentFriendRequestTo($user->id))
                                        <button class="btn btn-primary btn-success" disabled="disabled" type="submit"><i class="fa fa-check-circle fa-fw"></i> Requested</button>
                                    @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
                                        <a href="{{ route('friends.store') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success add-friend-request-button" role="button">
                                            <i class="fa fa-check-circle fa-fw"></i> Accept friend
                                        </a>
                                    @else
                                        <a href="{{ route('request.post') }}" data-method="POST" data-username="{!! $user->getUsername() !!}" data-token="{{ Session::get('_token') }}" class="btn btn-success send-friend-request-button" role="button"><i class="fa fa-check-circle fa-fw"></i> Add friend</a>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="profile-icons margin-none">
                            <span><i class="fa fa-users"></i> {{ count($friends) }}</span>

                            @if($user->is(Auth::user()->id))
                                <span><i class="fa fa-photo"></i> 430</span>
                                <a href="{{ route('profile.show.settings') }}" class="btn btn-white btn-xs pull-righ"><i class="fa fa-pencil"></i></a>
                            @else
                                <span><i class="fa fa-photo"></i> 302</span>
                            @endif
                            <span><i class="fa fa-video-camera"></i> {{ count($feeds) }}</span>
                        </div>
                        <div class="panel-body-dashboard">
                            <div class="expandable expandable-indicator-white expandable-trigger">
                                <div class="expandable-conten">
                                    <ul class="icon-list icon-list-block">
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><i class="glyphicon glyphicon-calendar"></i></div>
                                                    <div class="col-sm-8">{{ ($user->is(Auth::user()->id)) ? Auth::user()->getBirthDay() : $user->getBirthDay()  }}</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Job</span></div>
                                                    <div class="col-sm-8">{{ ($user->is(Auth::user()->id)) ? Auth::user()->getProfession() : $user->getProfession()  }}</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                                                    <div class="col-sm-8">{{ ($user->is(Auth::user()->id)) ? Auth::user()->getGender() : $user->getGender()  }}</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
                                                    <div class="col-sm-8">{{ ($user->is(Auth::user()->id)) ? Auth::user()->getLocation() : $user->getLocation()  }}</div>
                                                </div>
                                            </li>
                                            <li class="padding-v-5">
                                                <div class="row">
                                                    <div class="col-sm-4"><span class="text-muted">Credits</span></div>
                                                    <div class="col-sm-8">249</div>
                                                </div>
                                            </li>
                                        </ul>
                                    <div class="expandable-indicator"><i></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="panel panel-dashboard box-shadow">
                        <div class="panel-heading">Contact</div>
                        <ul class="icon-list icon-list-block">
                            @if($user->is(Auth::user()->id))
                                <li><i class="fa fa-envelope fa-fw"></i> <a href="#">{{ Auth::user()->getEmail() }}</a></li>
                                <li><i class="fa fa-facebook fa-fw"></i> <a href="#">/facebook</a></li>
                                <li><i class="fa fa-behance fa-fw"></i> <a href="#">/user</a></li>
                            @else
                                <li><i class="fa fa-envelope fa-fw"></i> <a href="#">{{ $user->getEmail() }}</a></li>
                                <li><i class="fa fa-facebook fa-fw"></i> <a href="#">/facebook</a></li>
                                <li><i class="fa fa-behance fa-fw"></i> <a href="#">/user</a></li>
                            @endif
                        </ul>
                    </div>
                    <!-- /Contact -->
                </div>
            </div>
            <!-- public info -->
            <div class="col-xs-12 col-sm-7 col-md-9 item">
                <div class="tabbable">
                    <ul class="nav nav-tabs" style="overflow: hidden; outline: none;" tabindex="0">
                        <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-fw fa-picture-o"></i> Photos</a></li>
                        <li class=""><a href="#albums" data-toggle="tab"><i class="fa fa-fw fa-folder"></i> Albums</a></li>
                    </ul>
                    <div class="tab-content box-shadow">
                        <div class="tab-pane fade active in" id="home">
                            <img src="/avatars/place1.jpg" alt="image">
                            <img src="/avatars/place2.jpg" alt="image">
                            <img src="/avatars/food1.jpg" alt="image">
                        </div>
                        <div class="tab-pane fade" id="albums">
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
                <div class="panel panel-dashboard box-shadow">
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
                                        <img src="{{ url('avatars/place1-full.jpg') }}" alt="image" class="img-responsive">
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
                                        <img src="{{ url('avatars/food1-full.jpg') }}" alt="image" class="img-responsive">
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
                                        <img src="{{ url('avatars/place2-full.jpg') }}" alt="image" class="img-responsive">
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
                <!-- friends  -->
                <div class="panel panel-dashboard box-shadow">
                    <div class="panel-heading panel-heading-gray">
                        <div class="pull-right">
                            <a href="{{ url('profiles/'.$user->getUsername().'/friends') }}" class="btn btn-primary btn-xs">Show all <i class="fa fa-group"></i></a>
                        </div>
                        <i class="icon-user-1"></i> Friends
                    </div>
                    <div class="panel-body">
                        <ul class="img-grid">
                        @if($user->is(Auth::user()->id))
                            @if(Auth::user()->friends()->count() == 0)
                                <li><span class="group"><i class="fa fa-group" style="font-size: 70px;"></i></span></li>
                            @else
                                 @foreach($friends as $friend )
                                    <li><a href="{{ url('/profiles', ['username' => $friend->getUsername() ]) }}"><img src="{{ $friend->getAvatar() }}" alt="image"></a></li>
                                 @endforeach
                            @endif
                        @else
                            @if($user->friends()->count() == 0)
                                 <li><span href="#" class="group"><i class="fa fa-group" style="font-size: 70px;"></i></span></li>
                            @else
                                    @foreach($friends as $friend )
                                        <li><a href="{{ url('/profiles', ['username' => $friend->getUsername() ]) }}"><img src="{{ $friend->getAvatar() }}" alt="image"></a></li>
                                    @endforeach
                                @endif
                        @endif
                        </ul>
                    </div>
                </div>
                <!-- /friends  -->
            </div>
            <!-- / public info -->
        </div>
    </div>
</div>