<div id="cover" class="col-md-2">

    <img
            class="cover"
            width="142"
            src="{{ (isset($result->isbns) and !empty($result->isbns)) ? 'https://images-eu.ssl-images-amazon.com/images/P/'.$result->isbns[0].'.MZZZZZZZ.jpg' : '/images/no_book_cover.jpg' }}"
            title="{{ $result->title }}"
            alt="{{ $result->title }}">

    <a
            href="javascript:void(0)"
            id="item-preview" rel="item-preview-sub"
            class="preview"
            title="Voir cet ouvrage en ligne"
            style="display: block;">Voir en ligne</a>
</div>