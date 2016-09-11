        <!-- META -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="Medlib : Application de recherche bibliothécaire utilisant le
            protocole de communication Zebra (Z3959)">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="keywords" content="Medlib : Search, Recherche, yaz, Z3950, Book, Books">
        <meta name="author" content="Patrick Luzolo, Walid Fadlhaoui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ url('favicons/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ url('favicons/favicon.ico') }}">

        <!-- CSS -->
        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
        <!--[if IE 9]>
        <link href="{{ asset('css/application-ie9-part2.css') }}" rel="stylesheet">
        <![endif]-->
        <link href="{{ asset('css/application.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/progressbar.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/jprogress.css') }}" rel="stylesheet" type="text/css">
        @yield('sytle')

        <!-- TITLE -->
        <title>Medlib - @yield('title')</title>

        <!-- SCRIPT --
        <!--<script src="{{ url('js/jquery.min.js') }}"></script>-->