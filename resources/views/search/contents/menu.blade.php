<td class="col-md-4 col-sm-4" id="records-actions">
    <a id="record-select-all" class="record-select-all" href="javascript:listCheckAll();">
        <span class="glyphicon glyphicon-check"></span><span>{{ trans('search.txt.select.check-all') }}</span>
    </a>
    <a id="record-select-none" href="javascript:listClearAll();">
        <span class="glyphicon glyphicon-remove"></span><span>{{ trans('search.txt.select.clear-all') }}</span>
    </a>
</td>
<!-- items per page dropdown -->
<td class="col-md-7 col-sm-7">
    <!-- ios button: show/hide panel -->
    <div class="jplist-ios-button"><i class="fa fa-sort"></i>Pagination</div>
    <!-- back button button -->
    <button type="button" data-control-type="back-button" data-control-name="back-button" data-control-action="back-button">
        <i class="fa fa-arrow-left"></i>&nbsp;{{ trans('search.txt.go-back') }}
    </button>

    <!-- reset button -->
    <button type="button" class="jplist-reset-btn" data-control-type="reset" data-control-name="reset" data-control-action="reset" style="width: auto;">
        <i class="fa fa-share"></i>&nbsp;{{ trans('search.txt.reset') }}&nbsp;
    </button>

    <!-- items per page dropdown -->
    <div class="jplist-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging">
        <ul>
            <li><span data-number="10" data-default="true"> {{ trans('search.txt.number-pages.10-par-page') }} </span></li>
            <li><span data-number="20"> {{ trans('search.txt.number-pages.20-par-page') }} </span></li>
            <li><span data-number="50"> {{ trans('search.txt.number-pages.50-par-page') }} </span></li>
            <li><span data-number="all"> {{ trans('search.txt.number-pages.all-page') }} </span></li>
        </ul>
    </div>

    <!-- pagination info label -->
    <!--
    <div class="jplist-label" data-type="<strong>Page {current} {{ trans('search.txt.of') }} {pages}</strong>" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">
    </div> -->

</td>
<!-- / items per page dropdown -->
<!-- panel -->
<td class="col-sm-8 col-md-3">
    <!-- sort dropdown -->
    <div class="jplist-drop-down" data-control-type="sort-drop-down" data-control-name="sort" data-control-action="sort" data-datetime-format="{year}">
        <ul>
            <li><span data-path="default">{{ trans('search.txt.sort-by.default') }} </span></li>
            <li><span data-path=".title" data-order="asc" data-type="text">{{ trans('search.txt.sort-by.title-asc') }} </span></li>
            <li><span data-path=".title" data-order="desc" data-type="text">{{ trans('search.txt.sort-by.title-desc') }} </span></li>
            <li><span data-path=".author" data-order="asc" data-type="text">{{ trans('search.txt.sort-by.author-a-z') }} </span></li>
            <li><span data-path=".author" data-order="desc" data-type="text">{{ trans('search.txt.sort-by.author-z-a') }} </span></li>
            <li><span data-path=".number" data-order="asc" data-type="number" data-default="true">{{ trans('search.txt.sort-by.number-asc') }}</span></li>
            <li><span data-path=".number" data-order="desc" data-type="number">{{ trans('search.txt.sort-by.number-desc') }}</span></li>
            <li><span data-path=".date" data-order="asc" data-type="datetime">{{ trans('search.txt.sort-by.date-asc') }} </span></li>
            <li><span data-path=".date" data-order="desc" data-type="datetime">{{ trans('search.txt.sort-by.date-desc') }} </span></li>
        </ul>
    </div>
</td>
<!-- /panel -->