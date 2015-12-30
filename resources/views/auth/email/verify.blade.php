<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Account Activation</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/email.css') }}" />
</head>
<body itemscope itemtype="{{ route('home') }}">
    <table class="body-wrap">
        <tr>
            <!-- HEADER -->
            <td class="header container">
                <div class="content">
                    <table>
                        <tr>
                            <td>
                                <a href="{{ route('home') }}">
                                    <img src="{{ url('/images/logo_a.png') }}" style="width:70px; height:auto;" />
                                </a>
                            <td align="right">
                                <h6 class="collapse">Activate Your Account</h6>
                            </td>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <!-- /HEADER -->
            <!-- BODY -->
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="{{url('avatars/'. $account['user_avatar']) }}">
                        <tr>
                            <td class="content-wrap">
                                <meta itemprop="name" content="Confirm Account"/>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            <!-- USER IMAGE -->
                                            <p><img src="{{ url('avatars/'. $account['user_avatar']) }}" style="width:90px; height:auto;" alt="{{ $account['last_name'] }}" /></p>
                                            <!-- / USER IMAGE -->
                                            <h3>Hi {{ $account['first_name']." ". $account['last_name'] }},</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <p>An account has been created for you at the medlib plateform. Please activate your account...</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block" itemprop="handler" itemscope itemtype="{{ url('register/verify/' . $account['confirmation_code'] ) }}" align="center">
                                            <a href="{{ url('register/verify/' . $account['confirmation_code'] ) }}" class="btn btn-primary" itemprop="url">Activate my account</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <p>If the account was created in error, you can visit the link above and select "Decline" to decline this invitation.</p>
                                            <p class="content-map">
                                                <small>
                                                    If you can't get the button to work, paste this link into your browser: <br/>
                                                    {{ url('register/verify/'.$account['confirmation_code'] ) }}
                                                </small>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            &mdash; Best Regards
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table width="100%">
                            <tr>
                                <td class="aligncenter content-block">Follow <a href="http://twitter.com/medlib">@Medlib</a> on Twitter.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</body>
</html>