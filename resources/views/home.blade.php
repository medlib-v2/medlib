@extends('layouts.master')

@section('title', 'Bienvennu dans Media library')

@section('class') content-search @endsection

@section('content')
    <section class="content-search-section" role="search">
        <header class="search">
            <h1 class="search-title"><span>@lang('app.name')<br>@lang('app.description')</span></h1>
            <form class="form-group" id="search_form" method="GET" action="{{ route('search.simple') }}" name="search_input" role="form">
                <div class="input-group">
                    <input id="ssearch" autocomplete="off" autofocus="true" class="form-search" placeholder="@lang('search.txt.criteria')" type="text" name="query" />
                    <span class="input-group-btn">
                        <button id="submitButton" type="submit" class="btn btn-search"><i class="fa fa-search text-gray"></i></button>
                    </span>
                    @if (isset($errors) && $errors->has('query'))
                        <p class="help-block text-danger">{{ $errors->first('query') }}</p>
                    @endif
                </div>
                <div class="row no-margin">
                    <div class="col-xs-7 col-md-8 col-sm-8 no-padding">
                        <select name="qdb" data-placeholder="@lang('search.txt.library')" class="select2 form-control select2-offscreen">
                            <option value="">@lang('search.txt.library')</option>
                            @foreach($datasource as $name => $instance)
                                <option value="{{ $name }}">{{ $instance['fullname'] }}</option>
                            @endforeach
                        </select>
                        @if (isset($errors) && $errors->has('qdb'))
                            <p class="help-block text-danger">{{ $errors->first('qdb') }}</p>
                        @endif
                    </div>
                    <div class="col-xs-5 col-md-4 col-sm-4 no-padding">
                        <ul class="icons">
                            <li class="all active" title="Web Search" data-search-type="all">@lang('search.icons.all')</li>
                            <li class="images" title="Image Search" data-search-type="images">@lang('search.icons.images')</li>
                            <li class="books" title="Book Search" data-search-type="books">@lang('search.icons.books')</li>
                            <li class="videos" title="Video Search" data-search-type="videos">@lang('search.icons.videos')</li>
                        </ul>
                    </div>
                </div>
                <ul class="search-menu">
                    <li>
                        <a id="advenced-options" href="#advence-options" class="dropdown-toggle" data-toggle="dropdown">@lang('search.txt.advanced')</a>
                        <div id="description-options" class="description" style="display:none">
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="title" value="ti" checked="checked" type="checkbox" id="title">
                                <label for="title">@lang('search.txt.title')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="author" value="au" type="checkbox" id="author">
                                <label for="author">@lang('search.txt.author')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="publisher" value="pb" type="checkbox" id="publisher">
                                <label for="publisher">@lang('search.txt.publisher')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="uniforme" value="ut" type="checkbox" id="uniforme">
                                <label for="uniforme">@lang('search.txt.uniforme')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="dofpublisher" value="yr" type="checkbox" id="dofpublisher">
                                <label for="dofpublisher">@lang('search.txt.dofpublisher')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="keywords" value="kw" type="checkbox" id="keywords">
                                <label for="keywords">@lang('search.txt.keywords')</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                                <input name="abstract" value="nt" type="checkbox" id="abstract">
                                <label for="abstract">@lang('search.txt.abstract') </label>
                            </div>
                        </div>
                    </li>
                    <li><a href="{{ route('search.advanced') }}">@lang('search.txt.advanced_search')</a></li>
                </ul>
            </form>
        </header>
    </section>
    <main id="content" class="content" role="main">
        @include('flash.message')
        <div class="form-group">
            <notifications-demo></notifications-demo>
            <div class="now">
                <div id="wrapper" class="col-sm-6 col-md-6">
                    <div id="book-details"></div>
                    <div id="books" class="books-items"></div>
                    <div id="more-books"></div>
                    <div class="information">
                        {!! trans('app.explore_universe') !!}
                        <hr>
                        {!! trans('app.universe') !!}
                    </div>
                </div>
                <div class="col-sm-1 col-md-1"></div>
                <div class="col-sm-6 col-md-6 pull-right" style="padding-top: 60px;">
                    <div class="information">
                        {!! trans('app.discover_suggestions') !!}
                        <hr>
                        {!! trans('app.discover_suggestions_content') !!}
                    </div>
                    <div class="books-items">
                        <div class="images-social">
                            <img src="{{ asset('images/reader-no-bg.png') }}" alt="social icone">
                        </div>
                    </div>
                </div>
            </div>
            <div id="danger" class="row">&nbsp;</div>
        </div>
    </main>
@endsection

@section('script')
<!-- page specific js -->
        <script type="text/javascript" src="{{ App::rev('/js/books/app.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                /**
                 * Medlib Application
                 */
                Medlib.InputField(null);
                Medlib.Arrow(null);
                @if (Auth::guest())
                Medlib.Password('#password', {
                    innerToggle: true,
                    touchSupport: Modernizr.touchevents,
                    title: 'Click here show/hide password',
                    hideToggleUntil: 'focus'
                });
                @endif
                Medlib.FormElements(null);
            });
        </script>
@endsection