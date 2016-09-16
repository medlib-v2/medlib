<div class="list-item">
    <!-- data -->
    <div class="block">
        <div class="row" id="bibdata">
            <div class="col-md-1">
                <!-- style="display:none"  -->
            </div>
            @include('search.contents.detail.cover')
            <div class="col-md-9">
                @include('search.contents.detail.title')
                @include('search.contents.detail.creators')
                @include('search.contents.detail.material')
                @include('search.contents.detail.language')
                @include('search.contents.detail.publisher')
                @include('search.contents.detail.isbns')
                @include('search.contents.detail.pages')
                @include('search.contents.detail.notes')
                @include('search.contents.detail.summary')
                @include('search.contents.detail.add-to-list')
            </div>
        </div>
    </div>
</div>