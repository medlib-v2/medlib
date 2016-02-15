<div class="style" id="style">
    <link href="{{ asset('css/jplist/jplist.core.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jplist/jplist.textbox-filter.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jplist/jplist.pagination-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jplist/jplist.history-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jplist/jplist.filter-toggle-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jplist/jplist.views-control.min.css') }}" rel="stylesheet" type="text/css" />
</div>

@if (!array_key_exists('error', $results))
    <div>
        <div class="widget-table-overflow">
            <table cellspacing="0" width="100%" class="table table-lg mt-lg mb-0">
                <tbody>
                <tr>
                    <!-- Starting filter -->
                    @include('search.filters.mfilter')
                            <!-- Ending filter -->
                    <!-- Beginning content search -->
                    @include('search.contents.content')
                            <!-- Ending content search -->
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@else
    <div>
        <div class="widget-table-overflow">
            <table cellspacing="0" width="100%" class="table table-lg mt-lg mb-0">
                <tbody>
                <tr>
                    <!-- Starting filter -->
                    @include('search.filters.mfilter')
                            <!-- Ending filter -->
                    <!-- Beginning content search -->
                    @include('search.contents.not-found')
                            <!-- Ending content search -->
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="script" id="script">
    <script src="{{ asset('js/jplist/jplist.core.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.sort-bundle.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.textbox-filter.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.pagination-bundle.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.history-bundle.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.filter-toggle-bundle.min.js') }}"></script>
    <script src="{{ asset('js/jplist/jplist.views-control.min.js') }}"></script>
    <script src="{{ asset('js/jquery.shorten.js') }}"></script>

    <script>
        (function($){

            $('#pagination').jplist({
                itemsBox: '.list'
                ,itemPath: '.list-item'
                ,panelPath: '.jplist-panel'
            });

            $(".more").shorten({
                "showChars" : 300,
                "moreText"  : "{{ trans('search.txt.show') }}",
                "lessText"  : "{{ trans('search.txt.hide') }}"
            });
        })(jQuery);
    </script>
</div>