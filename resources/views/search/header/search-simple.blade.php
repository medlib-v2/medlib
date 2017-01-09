<form class="form-group" id="search_form" method="GET" action="{{ route('search.simple') }}" name="search_input" role="form">
    <div class="input-group xs-mb-15">
        <input id="ssearch" autocomplete="off" autofocus="true" class="form-control" placeholder="@lang('search.txt.criteria')" value="{{ trim(trim(\Illuminate\Support\Facades\Input::get('query'), ',') , '.') }}" type="text" name="query" />
        <span class="input-group-btn">
        <button id="submitButton" type="submit" class="btn btn-search"><i class="fa fa-search text-gray"></i></button>
		</span>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-8 col-sm-8">
        </div>
        <div class="col-xs-12 col-md-4 col-sm-4">
            <ul class="icons">
                <li class="all active" title="Web Search" data-search-type="all">@lang('search.icons.all')</li>
                <li class="images" title="Image Search" data-search-type="images">@lang('search.icons.images')</li>
                <li class="books" title="Book Search" data-search-type="books">@lang('search.icons.books')</li>
                <li class="videos" title="Video Search" data-search-type="video">@lang('search.icons.videos')</li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-md-12 col-sm-12" style="padding-left: 0px;">
        <div id="AdvencedOptions" class="panel-title AdvencedOptions">
            <img src="{{ asset('/images/tree_plus.gif') }}" />
            <label><span> @lang('search.txt.advanced')</span></label>
        </div>
        <div id="danger" class="col-xs-12 col-md-8 col-sm-8">&nbsp;</div>
        <!-- begin advenced options -->
        <div id="DescriptionOptions" class="description" style="display:none">
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
                <label for="abstract">@lang('search.txt.abstract')</label>
            </div>
        </div>
        <!-- and advenced options -->
    </div>
    <input type="hidden" name="qdb" value="{{ \Illuminate\Support\Facades\Input::get('qdb') }}">
</form>