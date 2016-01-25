<form method="GET" action="{{ url('search/simple') }}" name="search_input" role="form">
    <div class="form-group">
        <div class="col-sm-8 col-xs-8 col-md-8">
            <div class="input-group input-group-md">
                <input id="ssearch" type="search"
                       name="query"
                       placeholder="{{ trans('search.txt.criteria') }}"
                       value="{{ trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.') }}"
                       class="search-query form-control"
                       style="height:40px;">
                                    <span class="input-group-btn">
							        <button id="submitButton" class="btn btn-primary" style="height:40px;" type="submit">
                                        <span class="visible-md visible-sm visible-lg hidden-xs">{{ trans('search.btn.find') }}</span>
                                        <i class="visible-xs hidden-sm fa fa-search text-white"></i>
                                    </button>
						        </span>
            </div>
            <input type="hidden" name="qdb" value="{{ \Illuminate\Support\Facades\Input::get('qdb') }}">
        </div>
        <div class="col-sm-4 col-xs-4 col-md-4">
            <ul class="icons">
                <li class="all" title="Web Search" data-searchType="all">All</li>
                <li class="images" title="Image Search" data-searchType="images">Images</li>
                <li class="books" title="Book Search" data-searchType="books">Books</li>
                <li class="videos" title="Video Search" data-searchType="video">Videos</li>
            </ul>
        </div>
        <div id="danger" class="col-xs-12 col-md-8 col-sm-8">&nbsp;</div>
        <div class="col-xs-12 col-md-12 col-sm-12" style="padding-left: 0px;">
            <div id="AdvencedOptions" class="panel-title AdvencedOptions" >
                <img src="{{ asset('/images/tree_plus.gif') }}"/>
                <label><span> {{ trans('search.txt.advanced') }}</span></label>
            </div>
            <!-- and advenced options -->
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
            <!-- and advenced options -->
        </div>
    </div>
</form>