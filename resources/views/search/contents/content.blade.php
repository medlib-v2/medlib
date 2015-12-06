<div class="col-md-9 col-lg-10">
    @include('search.contents.menu')

    @if (!array_key_exists('error', $results))
    <!-- ==================== Beginning result ================== -->
    <div id="table-container" class="table-container">
        @foreach ($results as $result)
            @include('search.contents.detail')
        @endforeach
    </div>
    <!-- ==================== Ending result ================== -->
    @else
        I don't have any records!
    @endif
</div>