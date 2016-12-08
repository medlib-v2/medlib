@extends('layouts.master')

@section('title', 'Sending private message to '. $user->getName())

@section('class') container-fluid @endsection

@section('stylesheet')
	<link href="{{ url('css/messages.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
	<main id="content" class="content" role="main">
	<section class="content-wrap">
		<br><br><br><br>
		<div class="row">
			<div id="center-column" class="col-md-6">
				@include('messages.partials.center-form', [
                'placeholder' => 'Send a private message to ' . $user->getName().'...',
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
	</section>
	</main>
@endsection

@section('script')
@endsection