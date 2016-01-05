@extends('layouts.master')

@section('title', 'Bienvennu dans Medlib')

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <div class="col-md-2 col-xs-1 col-sm-1"></div>
            <div class="col-md-7 col-xs-10 col-sm-10 inpt-search">
                <form method="GET" action="{{ url('search/simple') }}" name="search_input" onsubmit="if (search_input.query.value.length == 0) { return false; }" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 col-md-12 input-group input-group-md">
                                <input id="ssearch" type="search"  name="query" placeholder="Critère de recherche ..." class="search-query form-control" id="search" style="height:40px;">
                                <span class="input-group-btn">
							        <button id="submitButton" class="btn btn-primary" style="height:40px;" type="submit">
                                        <span class="visible-md visible-sm visible-lg hidden-xs">Rechercher</span>
                                        <i class="visible-xs hidden-sm fa fa-search text-white"></i>
                                    </button>
						        </span>
                            </div>
                        </div>
                        <div class="row">&nbsp</div>
                        <div class="row">

                            <div class="col-xs-12 col-md-8 col-sm-8">
                                <select name="qdb" data-placeholder="Select source database..." data-width="auto" data-minimum-results-for-search="10" tabindex="-1" class="select2 form-control select2-offscreen" id="default-select">
                                    <option value=""></option>
                                    @foreach($datasource as $name => $instance)
                                        <option value="{{ $name }}">{{ $instance['fullname'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('qdb')) <p class="help-block text-warning">{{ $errors->first('qdb') }}</p> @endif
                            </div>

                            <div class="col-xs-12 col-md-4 col-sm-4">
                                <ul class="icons">
                                    <li class="all" title="Web Search" data-searchType="all">All</li>
                                    <li class="images" title="Image Search" data-searchType="images">Images</li>
                                    <li class="books" title="Book Search" data-searchType="books">Books</li>
                                    <li class="videos" title="Video Search" data-searchType="video">Videos</li>
                                </ul>
                            </div>
                        </div>
                        <!-- and advenced options -->
                        <div class="row">
                            <div class="form-group mt">
                                <div id="AdvencedOptions" class="panel-title AdvencedOptions" >
                                    <img src="{{ asset('/images/tree_plus.gif') }}"/>
                                    <label><span> Options Avancées</span></label>
                                </div>
                                <div id="DescriptionOptions" class="description" style="display:none">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class="">	<input name="title" value="ti" checked="checked" type="checkbox"> Titres</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="author" value="au" type="checkbox"> Auteurs</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="publisher" value="pb" type="checkbox"> Editeurs</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="uniforme" value="ut" type="checkbox"> Titres uniformes</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="dofpublisher" value="yr" type="checkbox"> Date  publication </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="keywords" value="kw" type="checkbox"> Mots-clés</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <label class=""><input name="abstract" value="nt" type="checkbox"> Résumé et notes </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- and advenced options -->
                    </div>
                </form>
                <div><span class="link" ><a href="{{ route('search.advanced') }}">Recherche avancée</a></span></div>
            </div>
            <div class="col-md-2 col-xs-1 col-sm-2"></div>
        </div>
    </div>
@endsection