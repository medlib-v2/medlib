<div id="service-messages"></div>
<ol id="breadcrumb" class="breadcrumb">
    <!-- Browsing Search [ disabled ] -->
    <li> <!-- Search Link -->
        <a href="/search" id="search-link">Search</a>
    </li>
    <li class="active">Result List</li>
    <!-- Serial Link -->
    <!-- Result List/Saved Records Link -->
</ol>
<div id="list-result">
    <div id="search-summary" class="alert alert-success hidden-xs hidden-sm">
        Page : 1 to 2 of 2 items <br />
        <p class="text-gray-dark">Searched:  {{ \Illuminate\Support\Facades\Input::get('query') }} </p>
    </div>
</div>
<!--  advanced menu -->
<div id="result-list-options" class="well">
    <div class="row">
        <form action="/search/index" method="GET" name="resultsPerPage" class="form-inline col-md-12 col-sm-6" role="form" id="resultsPerPage">
            <input type="hidden" name="offset" value="0" id="offset" />
            <input type="hidden" name="isNewSearch" value="false" id="isNewSearch" />
            <input type="hidden" name="sort" value="score" id="sort" />
            <input type="hidden" name="order" value="desc" id="order" />
            <input type="hidden" name="index" value="fk_col_keywords_title" id="index" />
            <input type="hidden" name="q" value="vihsida" id="q" />
            <input type="hidden" name="type" value="1" id="type" />
            <input type="hidden" name="operator" value="NONE" id="operator" />
            <input type="hidden" name="institutions" value="UkBaUB" id="institutions" />
            <input type="hidden" name="firstpub" value="" id="firstpub" />
            <input type="hidden" name="language" value="" id="language" />
            <input type="hidden" name="serialType" value="0" id="serialType" />
            <input type="hidden" name="isBrowsing" value="false" id="isBrowsing" />
            <input type="hidden" name="browseTerm" value="" id="browseTerm" />
            <input type="hidden" name="browseIndex" value="" id="browseIndex" />
            <input type="hidden" name="browseOffset" value="" id="browseOffset" />
            <input type="hidden" name="browseTotal" value="" id="browseTotal" />
            <input type="hidden" name="filters" id="filters" />
            <label for="max">Results per page:</label>
            <select name="maxPerPage" class="form-control auto-width-size" id="max" >
                <option value="10" selected="selected" >10</option>
                <option value="25" >25</option>
                <option value="50" >50</option>
                <option value="100" >100</option>
            </select>
            <input type="submit" name="update" value="Update" class="btn btn-primary form-control auto-width-size" id="update" />
        </form>
        <div id="records-actions" class="col-md-12 col-sm-6 hidden-xs js-only">
            <br />
            <span>Records:</span>
            <a id="record-select-all" class="record-select-all">
                <span class="glyphicon glyphicon-check"></span>
                <span>Select All</span>
            </a>
            <a id="record-select-none">
                <span class="glyphicon glyphicon-remove"></span>
                <span>Deselect All</span>
            </a>
        </div>
    </div>
</div>
<!--  End advanced menu -->