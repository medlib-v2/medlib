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
        @include('layouts.favicons')

        <!-- CSS -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="{{ App::rev('/css/application.css') }}" type="text/css">
        @yield('sytle')

        <!-- TITLE -->
        <title>Medlib</title>
