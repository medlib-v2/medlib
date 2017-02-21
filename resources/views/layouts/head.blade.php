        <!-- META -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="{{ config('app.description') }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="keywords" content="{{ config('app.keywords') }}">
        <meta name="author" content="{{ config('app.author') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="manifest" href="{{ url('manifest.json') }}" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ url('favicons/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ url('favicons/favicon.ico') }}">
        @if(!app()->environment() == "local" && !app()->environment() == "testing")
        <link rel="apple-touch-icon" type="image/png" sizes="57x57" href="{{ url('favicons/apple-touch-icon-57x57.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="60x60" href="{{ url('favicons/apple-touch-icon-60x60.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="{{ url('favicons/apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="76x76" href="{{ url('favicons/apple-touch-icon-76x76.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="{{url('favicons/apple-touch-icon-114x114.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="120x120" href="{{url('favicons/apple-touch-icon-120x120.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="144x144" href="{{ url('favicons/apple-touch-icon-144x144.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="152x152" href="{{ url('favicons/apple-touch-icon-152x152.png') }}">
        <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="{{ url('favicons/apple-touch-icon-180x180.png') }}">

        <meta name="apple-mobile-web-app-title" content="Dropzone">
        <!--
        <link rel="icon" type="image/png" sizes="192x192" href="/favicons/favicon-192x192.png">
        <link rel="icon" type="image/png" sizes="160x160" href="/favicons/favicon-160x160.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
        -->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicons/mstile-152x152.png">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="application-name" content="{{ config('app.name') }}">
        @endif
        <!-- CSS -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="{{ App::rev('/css/application.css') }}" type="text/css">
        @yield('sytle')

        <!-- TITLE -->
        <title>Medlib - @yield('title')</title>
