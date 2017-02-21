@extends('layouts.master')

@section('title', 'Notifications')

@section('class') container-fluid @endsection

@section('content')

    <main id="content" class="content content-profile" role="main">
        <section class="user-profile">
            <div class="container-fluid">
                <div id="center-column" class="col-md-6">
                    @include('flash.message')
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">@lang('app.notifications')</div>
                        @foreach($notifications as $notification)
                            <div class="media listed-object-close">
                              @if(isset($notification->data['username']))
                                <div class="pull-left">
                                    <a href="{!! route('profile.user.show', ['username' => $notification->data['username']]) !!}">
                                        <img class="media-object avatar medium-avatar" src="{!! $notification->data['user_avatar'] !!}" alt="{!! $notification->data['full_name'] !!}"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{!! $notification->data['full_name'] !!}</h4>
                                    {{ $notification->data['full_name'] }} &nbsp; {{ $notification->data['message'] }} <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if(isset($notification->data['type']) && $notification->data['type'] == 'send_friend_request')
                                    <div class="pull-right">
                                        <a href="{{ route('friends.store') }}" data-method="POST" data-username="{{ $notification->data['username'] }}" data-token="{{ Session::get('_token') }}" class="btn btn-primary btn-success accept-friend-button btn-sm" role="button">
                                            <i class="fa fa-check-circle fa-fw"></i>&nbsp;Accept</a>
                                        <a href="{{ route('request.del') }}" data-method="DELETE" data-username="{{ $notification->data['username'] }}" data-token="{{ Session::get('_token') }}" class="btn btn-primary btn-danger del-friend-button btn-sm" role="button">
                                            <i class="glyphicon glyphicon-remove"></i>&nbsp;Decline</a>
                                    </div>
                                    @endif
                                </div>
                              @else
                                <div class="media-body">
                                    <h4 class="media-heading">{!! $notification->data['title'] !!}</h4>
                                    {{ $notification->data['body'] }} <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                              </div>
                              @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
