<div class="content" style="margin: 20px;">
    <div id="pagination" class="be-list">
        <div class="be-list-panel panel-top">
            <br>
            <!-- END results-actions -->
            <div class="list text-shadow" id="book-preview">
                <?php $counter = 0; ?>
                <!-- ==================== Beginning result ================== -->
                @foreach ($results as $result)
                    <?php $counter++; ?> 
                    @include('search.details.contents.detail') 
                @endforeach
                <!-- ==================== Ending result ================== -->
                <box-preview></box-preview>
            </div>
        </div>
    </div>
</div>