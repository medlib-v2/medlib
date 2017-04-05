<?php
use Medlib\BookCover\Facades\Cover;

$replacements = ['-','_',' '];
$data = Cover::setTitle($result->title)
    ->setSubtitle('with special chapters on photography, cover design and book manufacturing')
    ->setCreators((isset($result->creators[0])) ? $result->creators[0]['name']: '')
    ->setEdition('3rd enl. ed.')
    ->setPublisher($result->publisher)
    ->setDatePublished($result->year)
    ->randomizeBackgroundColor()
    ->getImageBase64();
?>
<div id="cover-{{ $counter }}" class="col-xs-3 col-sm-3 col-md-2">
    <img class="cover" src="{{ (isset($result->isbns) and !empty($result->isbns)) ? getAmazonCover(cleanIsbn($result->isbns[0], $replacements)) : $data }}" title="{{ $result->title }}" alt="{{ $result->title }}">
    @if(isset($result->isbns) and !empty($result->isbns))
    <a href="#"
      id="preview-{{ cleanIsbn($result->isbns[0]) }}"
       :isbn="'{{ cleanIsbn($result->isbns[0]) }}'"
      rel="item-preview-sub"
      class="preview"
      title="Voir cet ouvrage en ligne" :page-id="'PA1'" v-preview>Voir en ligne</a>
    @endif
</div>
