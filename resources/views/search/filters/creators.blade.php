<?php $i = 1; ?>
<div id="auteur-refinement">
    <div class="head"><strong>Auteur</strong></div>

    <ul class="refinement">
        @foreach($filter['creators'] as $item => $value)
            @if($i < 6)
            <li><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @else
            <li style="display: none"><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @endif
            <?php $i++; ?>
        @endforeach
        <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
    </ul>
</div>