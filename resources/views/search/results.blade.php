@extends('layouts.master')

@section('title', trans('search.txt.search_results'). " ". trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.'))

@section('class') container-fluid @endsection

@section('content')
<section class="content-search-results" role="search">
    <header class="result">
        @include('flash.message')
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                @include('search.header.search-simple')
            </div>
            <div class="col-md-1"></div>
        </div>
    </header>
</section>
<main id="content" class="content" role="main">
    @if (!array_key_exists('error', $results))
    <div class="content-results">
        <div class="row">
            <!-- Starting filter -->
            <div class="col-md-2">
                @include('search.filters.mfilter')
            </div>
            <!-- Ending filter -->
            <!-- Beginning content search -->
            <div class="col-md-10">
                @include('search.contents.content')
            </div>
            <!-- Ending content search -->
        </div>
    </div>
    @else
    <div class="content-results">
        <div class="row">
            <!-- Starting filter -->
            <div class="col-md-2">
                @include('search.filters.mfilter')
            </div>
            <!-- Ending filter -->
            <!-- Beginning content search -->
            <div class="col-md-10">
                @include('search.contents.not-found')
            </div>
            <!-- Ending content search -->
        </div>
    </div>
    @endif
</main>
@endsection

@section('script')
    <!-- SCRIPT -->
    <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
    <script type="text/javascript" src="{{ App::rev('js/be-list.min.js') }}"></script>
    <script type="text/javascript" src="{{ App::rev('js/preview/app.min.js') }}"></script>
    <script>
        (function($) {
            /**
             * $('.list-item a').books();
             **/
            Medlib.BeShorten(".more", {
                showChars: 300,
                moreText: "{{ trans('search.txt.show') }}",
                lessText: "{{ trans('search.txt.hide') }}"
            });

            $('#pagination').beList({
                itemsBox: '.list',
                itemPath: '.list-item',
                panelPath: '.be-list-panel'
            });
        })(jQuery);
    </script>
@endsection
