<?php $i = 1; ?>
<div id="year-refinement">
    <div class="head"><strong>Année</strong></div>
    <ul class="refinement">
        @foreach($filter['year'] as $item => $value)
            @if($i < 8)
            <li><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @else
            <li style="display: none"><a rel="nofollow" title="{{ $item }}" href="#">{{ $item }}</a> ({{ $value }})</li>
            @endif
            <?php $i++; ?>
        @endforeach
        <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
    </ul>
</div>