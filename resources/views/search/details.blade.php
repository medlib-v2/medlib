@extends('layouts.master') 

@section('title', trans('search.txt.search_results'). " ". trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.'))

@section('class') container-fluid @endsection

@section('content')
<section class="content-search-results" role="search">
    <header class="result">
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
    <div>
        <!-- Begin results info -->
        @include('search.details.contents.pagination')
        <!-- End results info -->
        <div class="row">
            <!-- Beginning content search -->
            <div class="col-md-9">
                @include('search.details.contents.content')
            </div>
            <!-- Ending content search -->
            <!-- Starting filter -->
            <div class="col-md-3">
                @include('search.details.locastion.library')
            </div>
            <!-- Ending filter -->
        </div>
    </div>
    @endif
</main>
@endsection 

@section('script')
    <!-- SCRIPT -->
    <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
    <script type="text/javascript" src="{{ App::rev('js/be-list.min.js') }}"></script>
    <script>
        (function($) {
            $('.isbns').books();

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
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
