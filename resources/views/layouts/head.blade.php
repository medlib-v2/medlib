        <!-- META -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="Medlib : Application de recherche bibliothécaire utilisant le
            protocole de communication Zebra (Z3959)">
        <meta name="keywords" content="Medlib : Search, Recherche, yaz, Z3950, Book, Books">
        <meta name="author" content="Patrick Luzolo, Aristide Djangone, Walid Fadlhaoui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ url('favicon.ico') }}">

        <!-- CSS -->
        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
        <!--[if IE 9]>
        <link href="{{ url('css/application-ie9-part2.css') }}" rel="stylesheet">
        <![endif]-->
        <link href="{{ url('css/application.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('css/progressbar.css') }}" rel="stylesheet" type="text/css">

        <!-- TITLE -->
        <title>Medlib - @yield('title')</title>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700,900' rel='stylesheet' type='text/css'>

        <!-- SCRIPT -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <![endif]-->
        <script src="{{ url('js/jquery.min.js') }}"></script>