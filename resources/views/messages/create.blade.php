@extends('layouts.dashboards.dashboard')

@section('title', 'Sending private message to '.$user->getName())

@section('stylesheet')
	<link href="{{ url('css/messages.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
	<div class="content-wrap">
		<br><br><br><br>
		<div id="center-column" class="col-md-6">
			@include('messages.partials.center-form', [
            'placeholder' => 'Send a private message to ' .$user->getName().'...',
            'formType' => 'message-form',
            'button' => 'Submit',
            'path' => 'message.store',
            'sendingMessage' => true,
            'userId' => $user->id,
            'currentUserId' => $currentUser->id,
            'currentUserProfileimage' => $currentUser->getAvatar(),
            'currentUsername' => $currentUser->getUsername()
            ])

		</div>
	</div>
@endsection

@section('script')
@endsection