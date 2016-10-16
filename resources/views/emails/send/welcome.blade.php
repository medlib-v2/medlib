@extends('layouts.email.master')

@section('title', trans('emails.title_welcome_message'))

@section('content_title', trans('emails.content_title_confirmation_success'))

@section('content')
    <td class="container" width="600">
        <div class="content">
            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="{{url('avatars/'. $user_avatar) }}">
                <tr>
                    <td class="content-wrap">
                        <meta itemprop="name" content="Confirm Account"/>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    Welcome to Medlib
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