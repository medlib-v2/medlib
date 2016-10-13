<?php
$order = ['--', '.'];
$replace = " ";
$i = 1;

?>
<div id="sujet-refinement">
    <div class="head"><strong>Sujet</strong></div><ul class="refinement">
        @foreach($filter['subjects'] as $item => $value)
            @if($i < 6)
            <li><a rel="nofollow" title="{{ str_replace($order, $replace, $item) }}" href="#">{{ str_replace($order, $replace, $item) }}</a> ({{ $value }})</li>
            @else
            <li style="display: none">
                <a rel="nofollow" title="{{ str_replace($order, $replace, $item) }}" href="#">{{ str_replace($order, $replace, $item) }}</a> ({{ $value }})</li>
            @endif
            <?php $i++; ?>
        @endforeach
        <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
    </ul>
</div>