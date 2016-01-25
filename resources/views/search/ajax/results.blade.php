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