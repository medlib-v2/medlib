@extends('layouts.email.master')

@section('title', trans('emails.title_confirmation_email'))

@section('content_title', trans('emails.content_title_confirmation_email'))

@section('content')
    <td class="container" width="600">
        <div class="content">
            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="{{ url($user_avatar) }}">
                <tr>
                    <td class="content-wrap">
                        <meta itemprop="name" content="Confirm Account"/>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <!-- USER IMAGE -->
                                    <p><img src="{{ url($user_avatar) }}" style="width:90px; height:auto;" alt="{{ $last_name }}" /></p>
                                    <!-- / USER IMAGE -->
                                    <h3>Hi {{ $first_name." ". $last_name }},</h3>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block">
                                    <p>An account has been created for you at the medlib plateform. Please activate your account...</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block" itemprop="handler" itemscope itemtype="{{ url('register/verify/' . $confirmation_code ) }}" align="center">
                                    <a href="{{ url('register/verify/' . $confirmation_code ) }}" class="btn btn-primary" itemprop="url">Activater mon compte</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block">
                                    <p>If the account was created in error, you can visit the link above and select "Decline" to decline this invitation.</p>
                                    <p class="content-map">
                                        <small>
                                            If you can't get the button to work, paste this link into your browser: <br/>
                                            {{ url('register/verify/'.$confirmation_code ) }}
                                        </small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block">&mdash; Best Regards</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            @extends('layouts.email.footer')
        </div>
    </td>
@endsection