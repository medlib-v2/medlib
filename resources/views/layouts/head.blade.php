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
        <!--
        <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon-180x180.png">
        <meta name="apple-mobile-web-app-title" content="Dropzone">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <link rel="icon" type="image/png" href="/favicons/favicon-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <meta name="msapplication-TileColor" content="#0087f7">
        <meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="application-name" content="Medlib">
        -->

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
        <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>