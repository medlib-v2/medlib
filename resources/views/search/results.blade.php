@extends('layouts.master') @section('title', trans('search.txt.search_results'). " ". trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.')) @section('content')
<section class="content-search" role="search">
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
    <div>
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
@endsection @section('sytle')
<link href="{{ asset('css/jplist/jplist.core.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jplist/jplist.textbox-filter.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jplist/jplist.pagination-bundle.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jplist/jplist.history-bundle.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jplist/jplist.filter-toggle-bundle.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jplist/jplist.views-control.min.css') }}" rel="stylesheet" type="text/css" /> @endsection @section('script')
<script type="text/javascript" src="{{ asset('js/jplist.scripts.min.js') }}"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
    (function($) {
        $('#pagination').jplist({
            itemsBox: '.list',
            itemPath: '.list-item',
            panelPath: '.jplist-panel'
        });
        $(".more").shorten({
            "showChars": 300,
            "moreText": "{{ trans('search.txt.show') }}",
            "lessText": "{{ trans('search.txt.hide') }}"
        });
        $('.isbns').books();
    })(jQuery);
</script>
@endsection