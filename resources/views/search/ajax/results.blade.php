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
    <script src="{{ asset('js/scripts.min.js') }}"></script>
    <script src="{{ asset('js/jplist.scripts.min.js') }}"></script>
    <script src="{{ asset('js/jquery.shorten.min.js') }}"></script>

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
            $('.isbns').books();
        })(jQuery);
    </script>
</div>