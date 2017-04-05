<div class="center-form">
    {!! Form::open(['route' => $path, 'class' => $formType, 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group mb-0">
        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => $placeholder]) !!}
    </div>
    @if(isset($sending_message))

        <div class="form-group">
            {!! Form::hidden('receiver_id', $user_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('sender_id', $current_user_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('sender_profile_image', $current_user_profile_image, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('sender_name', $current_username, ['class' => 'form-control']) !!}
        </div>

    @elseif(isset($sending_response_message))
        <div class="form-group">
            {!! Form::hidden('response_id', $message_response_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('message_id', $message_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('receiver_id', $receiver_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('sender_id', $sender_id, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('sender_profile_image', $sender_profile_image, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::hidden('sender_name', $sender_name, ['class' => 'form-control']) !!}
        </div>
    @elseif(isset($posting_feed))
        {!! Form::hidden('sender_name', $sender_name, ['class' => 'form-control']) !!}
        {!! Form::hidden('sender_profile_image', $sender_profile_image, ['class' => 'form-control']) !!}
        {!! Form::hidden('share_type', 'status', ['class' => 'form-control']) !!}
    @endif
    <div class="share">
        <div class="image hide">
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>
        <div class="video hide">
            <input type="text" class="form-control" placeholder="Youtube or Vimeo video URL" id="videoUrl" name="videoUrl">
        </div>
        <div class="place hide">
            <input id="geocomplete" class="form-control" type="text" name="location" placeholder="Enter a location" autocomplete="off">
            <div id="map_can" class="map_canvas hide"></div>
            <input type="hidden" name="lat">
            <input type="hidden" name="lng">
        </div>
    </div>
    <div class="btn-toolbar">
        <div class="btn-group">
            <a href="#" class="btn btn-sm btn-gray" id="status"><i class="fa fa-file fa-lg"></i> Status</a>
            <a href="#" class="btn btn-sm btn-gray" id="photos"><i class="fa fa-camera fa-lg"></i> Photos</a>
            <a href="#" class="btn btn-sm btn-gray" id="video"><i class="fa fa-film fa-lg"></i> Video</a>
            <a href="#" class="btn btn-sm btn-gray" id="place"><i class="fa fa-map-marker fa-lg"></i> Place</a>
        </div>
        <div class="pull-right">
        {!! Form::submit($button, ['class' => 'btn btn-danger btn-sm pull-xs-right', 'value' => $button, 'name'=> $button, 'id' => "btn-share" ]) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>