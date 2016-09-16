<div class="content" style="margin: 20px;">
    <div id="pagination" class="jplist">
        <div class="jplist-panel panel-top">
            <br>
            <!-- END results-actions -->
            <div class="list text-shadow">
                <?php $counter = 0; ?>
                <!-- ==================== Beginning result ================== -->
                @foreach ($results as $result)
                    <?php $counter++; ?> 
                    @include('search.details.contents.detail') 
                @endforeach
                <!-- ==================== Ending result ================== -->
            </div>
        </div>
    </div>
</div>