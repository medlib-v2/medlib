@extends('layouts.master')
@section('title', trans('search.txt.search_results'). " ". trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.'))
@section('content')
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
@endsection
@section('sytle')
<link href="{{ App::rev('css/jplist-commons.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
<script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
<script type="text/javascript" src="{{ App::rev('js/search-commons.min.js') }}"></script>
<script type="text/javascript" src="{{ App::rev('js/jplist-common.min.js') }}"></script>
<script>
    (function($) {
      $('.list-item a').books();
      $(".more").shorten({
          "showChars": 300,
          "moreText": "{{ trans('search.txt.show') }}",
          "lessText": "{{ trans('search.txt.hide') }}"
      });
      $('#pagination').jplist({
          itemsBox: '.list',
          itemPath: '.list-item',
          panelPath: '.jplist-panel'
      });
    })(jQuery);
</script>
@endsection
