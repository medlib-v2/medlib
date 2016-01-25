@if(isset($result->pages))
    <div class="desc">Descriptions&nbsp;: <span class="item-extent">{{ $result->extent }}</span></div>
    <div class="pages">Page&nbsp;: <span class="item-pages">{{ $result->pages }} pages.</span></div>
@endif