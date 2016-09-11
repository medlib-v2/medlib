<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <title>@yield('title')</title>
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
                            <h6 class="collapse">@yield('content_title')</h6>
                        </td>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <!-- /HEADER -->
        <!-- BODY -->
        @yield('content')
        <td></td>
    </tr>
</table>
</body>
</html>