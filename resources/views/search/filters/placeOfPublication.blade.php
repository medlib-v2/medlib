<?php $i = 1; ?>
<div id="public-refinement">
    <div class="head"><strong>Publication</strong></div>
    <ul class="refinement">
        @foreach($filter['placeOfPublication'] as $item => $value)
            @if($i < 8)
            <li><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @else
            <li style="display: none"><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @endif
            <?php $i++; ?>
        @endforeach
    </ul>
</div>