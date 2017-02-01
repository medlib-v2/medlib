<td class="col-md-4 col-sm-4" id="records-actions">
    <a id="be-select-all" class="be-select-all" href="javascript:listCheckAll();">
        <span class="glyphicon glyphicon-check"></span><span>@lang('search.txt.select.check_all') </span>
    </a>
    <a id="be-select-none" class="be-select-none" href="javascript:listClearAll();">
        <span class="glyphicon glyphicon-remove"></span><span>@lang('search.txt.select.clear_all')</span>
    </a>
</td>
<!-- items per page dropdown -->
<td class="col-md-7 col-sm-7">
    <!-- ios button: show/hide panel -->
    <div class="be-list-ios-button"><i class="fa fa-sort"></i>Pagination</div>
    <!-- back button button -->
    <button type="button" data-control-type="back-button" data-control-name="back-button" data-control-action="back-button">
        <i class="fa fa-arrow-left"></i>&nbsp;@lang('search.txt.go_back')
    </button>

    <!-- reset button -->
    <button type="button" class="be-list-reset-btn" data-control-type="reset" data-control-name="reset" data-control-action="reset" style="width: auto;">
        <i class="fa fa-share"></i>&nbsp;@lang('search.txt.reset')&nbsp;
    </button>

    <!-- items per page dropdown -->
    <div class="be-list-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging">
        <ul>
            <li><span data-number="10" data-default="true">@lang('search.txt.number_pages.10_par_page')</span></li>
            <li><span data-number="20">@lang('search.txt.number_pages.20_par_page')</span></li>
            <li><span data-number="50">@lang('search.txt.number_pages.50_par_page')</span></li>
            <li><span data-number="all">@lang('search.txt.number_pages.all_page')</span></li>
        </ul>
    </div>

    <!-- pagination info label -->
    <!--
    <div class="be-list-label" data-type="<strong>Page {current} @lang('search.txt.of'){pages}</strong>" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">
    </div> -->

</td>
<!-- / items per page dropdown -->
<!-- panel -->
<td class="col-sm-8 col-md-3">
    <!-- sort dropdown -->
    <div class="be-list-drop-down" data-control-type="sort-drop-down" data-control-name="sort" data-control-action="sort" data-datetime-format="{year}">
        <ul>
            <li><span data-path="default">@lang('search.txt.sort_by.default')&nbsp;</span></li>
            <li><span data-path=".title" data-order="asc" data-type="text">@lang('search.txt.sort-by.title_asc')</span></li>
            <li><span data-path=".title" data-order="desc" data-type="text">@lang('search.txt.sort_by.title_desc')</span></li>
            <li><span data-path=".author" data-order="asc" data-type="text">@lang('search.txt.sort_by.author_a_z')</span></li>
            <li><span data-path=".author" data-order="desc" data-type="text">@lang('search.txt.sort_by.author_z_a')</span></li>
            <li><span data-path=".number" data-order="asc" data-type="number" data-default="true">@lang('search.txt.sort_by.number_asc')</span></li>
            <li><span data-path=".number" data-order="desc" data-type="number">@lang('search.txt.sort-by.number-desc')</span></li>
            <li><span data-path=".date" data-order="asc" data-type="datetime">@lang('search.txt.sort_by.date_asc')</span></li>
            <li><span data-path=".date" data-order="desc" data-type="datetime">@lang('search.txt.sort_by.date_desc') </span></li>
        </ul>
    </div>
</td>
<!-- /panel -->