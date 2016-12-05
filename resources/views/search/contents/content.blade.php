<div class="content">
    <div id="pagination" class="be-list">
        <div class="be-list-panel panel-top">
            <!-- Begin results info -->
            @include('search.contents.pagination')
            <!-- End results info -->
            <div class="results-actions">
                <table cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            @include('search.contents.menu')
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <!-- END results-actions -->
            <div class="list">
                <?php $counter = 0; ?>
                <!-- ==================== Beginning result ================== -->
                @foreach ($results as $result)
                <?php $counter++; ?>
                @include('search.contents.detail')
                @endforeach
                <!-- ==================== Ending result ================== -->
            </div>
            <!-- Begin results info -->
            @include('search.contents.pagination')
            <!-- End results info -->
        </div>
    </div>
</div>
