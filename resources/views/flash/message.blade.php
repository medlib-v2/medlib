@if (Session::has('info'))
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="glyphicon glyphicon-info-sign"></span> <strong>Info Message</strong>
        <hr class="message-inner-separator">

        <p>{{ Session::get('info') }}</p>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="glyphicon glyphicon-ok"></span> <strong>Success Message</strong>
        <hr class="message-inner-separator">

        <p>{{ Session::get('success') }}</p>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="glyphicon glyphicon-record"></span> <strong>Warning Message</strong>
        <hr class="message-inner-separator">

        <p>{{ Session::get('warning') }}</p>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="glyphicon glyphicon-hand-right"></span> <strong>Danger Message</strong>
        <hr class="message-inner-separator">

        <p>{{ Session::get('error') }}</p>
    </div>
@endif

 @if(Session::has('message'))
    <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span class="glyphicon glyphicon-info-sign"></span> <strong>Info Message</strong>
            <hr class="message-inner-separator">

            <p>{{Session::get('message')}}</p>
    </div>
@endif

@if (Auth::check())
    <div id="socket_offline"></div>
@endif