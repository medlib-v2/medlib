<div class="chat-contacts">
    <div class="chat-sections">
        <div class="be-scroller">
            <div class="content">
                <h2>Recent</h2>
                <div class="contact-list contact-list-recent">
                    <div class="user"><a href="#"><img src="{{ asset('images/people/a1.jpg') }}" alt="Avatar">
                            <div class="user-data"><span class="status away"></span><span class="name">Claire Sassu</span><span class="message">Can you share the...</span></div></a></div>
                    <div class="user"><a href="#"><img src="{{ asset('images/people/a2.jpg') }}" alt="Avatar">
                            <div class="user-data"><span class="status"></span><span class="name">Maggie jackson</span><span class="message">I confirmed the info.</span></div></a></div>
                    <div class="user"><a href="#"><img src="{{ asset('images/people/a3.jpg') }}" alt="Avatar">
                            <div class="user-data"><span class="status offline"></span><span class="name">Joel King</span><span class="message">Ready for the meeti...</span></div></a></div>
                </div>
                <h2>Contacts</h2>
                <div id="friend-side-list" class="contact-list">
                    @if(Auth::user()->friends()->count())
                        @foreach(Auth::user()->friends()->get() as $friend)
                            @if($friend->isAvailableToChat())
                                @if($friend->isOnline())
                                    <div class="user">
                                        <a href="#" id="chat-list-user-{!! $friend->id !!}" data-user-id="{!! $friend->id !!}" data-profile-image="{!! $friend->getAvatar() !!}" data-first-name ="{!! $friend->getUsername() !!}">
                                            <img src="{!! $friend->getAvatar() !!}" alt="{!! $friend->getUsername() !!}">
                                            <div class="user-data2">
                                                <span class="status"></span>
                                                <span class="name">{!! $friend->getName() !!}</span>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <div class="user">
                                        <a href="#" data-userid="{!! $friend->id !!}">
                                            <img src="{!! $friend->getAvatar() !!}" alt="{!! $friend->getUsername() !!}">
                                            <div class="user-data2">
                                                <span class="status offline"></span>
                                                <span class="name">{!! $friend->getName() !!}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="user disabled">
                                    <a href="#" data-userid="{!! $friend->id !!}">
                                        <img src="{!! $friend->getAvatar() !!}" alt="{!! $friend->getUsername() !!}">
                                        <div class="user-data2">
                                            <span class="status"></span>
                                            <span class="name">{!! $friend->getName() !!}</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div id="no-friend-chat-alert" class="user disabled" role="alert">
                            <div class="notice">
                                <span class="glyphicon glyphicon-info-sign"></span> @lang('auth.friends_dont_have')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-input">
        <input type="text" placeholder="Search..." name="q"><span class="fa fa-search"></span>
    </div>
</div>
<div class="chat-window">
    <div class="title">
        <div class="user"><img src="{{ asset('images/people/a2.jpg') }}" alt="Avatar">
            <h2>Maggie jackson</h2><span>Active 1h ago</span>
        </div><span class="icon return fa fa-chevron-left"></span>
    </div>
    <div class="chat-messages">
        <div class="be-scroller">
            <div class="content">
                <ul>
                    <li class="friend">
                        <div class="msg">Hello</div>
                    </li>
                    <li class="self">
                        <div class="msg">Hi, how are you?</div>
                    </li>
                    <li class="friend">
                        <div class="msg">Good, I'll need support with my pc</div>
                    </li>
                    <li class="self">
                        <div class="msg">Sure, just tell me what is going on with your computer?</div>
                    </li>
                    <li class="friend">
                        <div class="msg">I don't know it just turns off suddenly</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="chat-input">
        <div class="input-wrapper"><span class="photo fa fa-camera"></span>
            <input type="text" placeholder="Message..." name="q" autocomplete="off"><span class="send-msg fa fa-mail-send"></span>
        </div>
    </div>
</div>