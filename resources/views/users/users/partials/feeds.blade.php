<div id="center-column" class="col-md-6">

    @include('messages.partials.center-form', [
    'placeholder' => 'What\'s on your mind?',
    'formType' => 'mt',
    'button' => 'Publish',
    'path' => ['user.feeds.store', Auth::user()->getUsername()],
    'postingFeed' => true,
    'senderName' => Auth::user()->getUsername(),
    'senderProfileImage' => Auth::user()->getAvatar()
    ])
</div>