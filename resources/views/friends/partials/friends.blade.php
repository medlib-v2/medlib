<div class="col-xs-12 col-md-6 col-lg-4 item">
    <div class="box-shadow">
        <div class="panel panel-default">
            <div class="profile-block">
                <div class="cover overlay cover-image-full">
                    <img src="/avatars/place1-full.jpg" alt="cover">
                    <div class="overlay overlay-full overlay-bg-black">
                        <div class="v-top v-spacing-2">
                            <a href="#" class="icon pull-right">
                                <i class="fa fa-comment"></i>
                            </a>
                            <div class="text-headline text-overlay">{{ $friend->getName() }}</div>
                            <p class="text-overlay">{{ $friend->getProfession() }}</p>
                        </div>
                        <div class="v-bottom">
                            <a href="#">
                                <img src="{{ $friend->getAvatar() }}" alt="{{ $friend->getUsername() }}" class="img-circle avatar">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="profile-icons">
                    <a href="#"><img src="/avatars/guy-4.jpg" alt="people" class="img-circle"></a>
                    <a href="#"><img src="/avatars/woman-6.jpg" alt="people" class="img-circle"></a>
                    <a href="#"><img src="/avatars/woman-9.jpg" alt="people" class="img-circle"></a>
                    <a href="#"><img src="/avatars/guy-7.jpg" alt="people" class="img-circle"></a>
                    <a href="#" class="user-count-circle">12+</a>
                </div>
            </div>
        </div>
    </div>
</div>