<?php
$replacements = ['-','_',' '];
?>
<div id="cover" class="col-xs-3 col-sm-3 col-md-2">
    <img class="cover" src="{{ (isset($result->isbns) and !empty($result->isbns)) ? getAmazonCover(cleanIsbn($result->isbns[0], $replacements)) : asset('/images/no_book_cover.jpg') }}" title="{{ $result->title }}" alt="{{ $result->title }}">
    @if(isset($result->isbns) and !empty($result->isbns))
    <a href="javascript:void(0)"
      id="preview-{{ cleanIsbn($result->isbns[0]) }}"
      data-book='{
          selector: "#books-{{ cleanIsbn($result->isbns[0]) }}",
          language: "fr",
          isbn: "{{ cleanIsbn($result->isbns[0]) }}",
          title: "{{ $result->title }}",
          width: 600,
          height: 500
      }'
      rel="item-preview-sub"
      class="preview"
      title="Voir cet ouvrage en ligne"
      style="display: block;">Voir en ligne</a>
    @endif
</div>
