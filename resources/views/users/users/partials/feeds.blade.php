<div id="center-column" class="col-md-6">

    @include('messages.partials.center-form', [
    'placeholder' => 'What\'s on your mind?',
    'formType' => 'mt',
    'button' => 'Publish',
    'path' => ['user.feeds.store', Auth::user()->getUsername()],
    'posting_feed' => true,
    'sender_name' => Auth::user()->getUsername(),
    'sender_profile_image' => Auth::user()->getAvatar()
    ])
</div>