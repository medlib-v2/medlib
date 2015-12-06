@extends('layouts.master')

@section('title', 'Page not found')

@section('content')
    <div class="container">
        <main id="content" class="error-container" role="main">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                    <div class="error-container">
                        <h1 class="error-code">404</h1>
                        <p class="error-info">
                            Opps, it seems that this page does not exist.
                        </p>
                        <p class="error-help mb">
                            If you are sure it should, search for it.
                        </p>
                        <div class="form-group">
                            <input class="form-control input-no-border" type="text" placeholder="Search Pages">
                        </div>
                        <a href="search.html" class="btn btn-inverse">
                            Search <i class="fa fa-search text-warning ml-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection