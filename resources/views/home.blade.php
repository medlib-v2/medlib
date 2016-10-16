@extends('layouts.master')
@section('title', 'Bienvennu dans Media library')

@section('content')
<section class="content-search" role="search">
    <header class="search">
        <h1 class="search-title"><span>Medlib<br>Recherche bibliographique</span></h1>

        <form class="form-group" id="search_form" method="GET" action="{{ route('search.simple') }}" name="search_input" role="form">
            <div class="input-group">
                <input id="ssearch" autocomplete="off" autofocus="true" class="form-search" placeholder="{{ trans('search.txt.criteria') }}" type="text" name="query" />
                <span class="input-group-btn">
				        	<button id="submitButton" type="submit" class="btn btn-search"><i class="fa fa-search text-gray"></i></button>
				        </span>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-8 col-sm-8">
                    <select name="qdb" data-placeholder="Selectionner une bibliothèque..." data-width="auto" data-minimum-results-for-search="10" tabindex="-1" class="select2 form-control select2-offscreen" id="default-select">
                            <option value=""></option>
                            @foreach($datasource as $name => $instance)
                                <option value="{{ $name }}">{{ $instance['fullname'] }}</option>
                            @endforeach
                        </select>
                    @if (isset($errors) && $errors->has('qdb'))
                    <p class="help-block text-warning">{{ $errors->first('qdb') }}</p>
                    @endif
                </div>
                <div class="col-xs-12 col-md-4 col-sm-4">
                    <ul class="icons">
                        <li class="all active" title="Web Search" data-search-type="all">All</li>
                        <li class="images" title="Image Search" data-search-type="images">Images</li>
                        <li class="books" title="Book Search" data-search-type="books">Books</li>
                        <li class="videos" title="Video Search" data-search-type="video">Videos</li>
                    </ul>
                </div>
            </div>
            <ul class="search-menu">
                <li>
                    <a id="AdvencedOptions" href="#advenceOptions" class="dropdown-toggle" data-toggle="dropdown">{{ trans('search.txt.advanced') }}</a>
                    <div id="DescriptionOptions" class="description" style="display:none">
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="title" value="ti" checked="checked" type="checkbox" id="title">
                            <label for="title">{{ trans('search.txt.title') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="author" value="au" type="checkbox" id="author">
                            <label for="author">{{ trans('search.txt.author') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="publisher" value="pb" type="checkbox" id="publisher">
                            <label for="publisher">{{ trans('search.txt.publisher') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="uniforme" value="ut" type="checkbox" id="uniforme">
                            <label for="uniforme">{{ trans('search.txt.uniforme') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="dofpublisher" value="yr" type="checkbox" id="dofpublisher">
                            <label for="dofpublisher">{{ trans('search.txt.dofpublisher') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="keywords" value="kw" type="checkbox" id="keywords">
                            <label for="keywords">{{ trans('search.txt.keywords') }}</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 checkbox checkbox-primary">
                            <input name="abstract" value="nt" type="checkbox" id="abstract">
                            <label for="abstract">{{ trans('search.txt.abstract') }}</label>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('search.advanced') }}">Recherche avancée</a></li>
            </ul>
        </form>
    </header>
</section>
<main id="content" class="content" role="main">
    @include('flash.message')
    <div class="form-group">
        <div class="now">
            <div id="wrapper" class="col-sm-6 col-md-6">
                <div id="book-details"></div>
                <div id="books" class="books-items">
                </div>
                <div id="more-books"></div>
                <div class="information">
                    <h6>Explorez <strong>notre univer</strong></h6>
                    <hr>
                    <p class="paraf">
                        Le univer de <strong>Medlib</strong> donne accès à un ensemble des services spécifiquement adaptées et propose également une plate-fome d’échange.
                    </p>
                </div>
            </div>
            <div class="col-sm-1 col-md-1"></div>
            <div class="col-sm-6 col-md-6 pull-right" style="padding-top: 60px;">
                <div class="information">
                    <h6>Découvrez <strong>nos suggestions du jours</strong></h6>
                    <hr>
                    <p class="paraf">
                        Rechercher tout type des documents avec <strong>Medlib</strong> , livre de science, romance etc...
                    </p>
                </div>
                <div class="books-items">
                    <div class="images-social">
                        <img src="{{ asset('images/reader-no-bg.png') }}" alt="social icone">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <div id="danger" class="row">&nbsp;</div>
    </div>
</main>
@endsection

@section('script')
<script type="text/javascript" src="{{ App::rev('js/search-commons.min.js') }}"></script>
<script data-main="js/books/app" src="{{ App::rev('js/require.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-elements-home.min.js') }}"></script>
@endsection
