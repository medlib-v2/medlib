<?php 
    $i = 1;
    $order = [',', '.', '[', ']'];
    $replace = "";
?>
<div id="auteur-refinement">
    <div class="head"><strong>Auteur</strong></div>

    <ul class="refinement">
        @foreach($filter['creators'] as $item => $value)
            @if($i < 6)
            <li><a rel="nofollow" href="{{
            route('search.simple', [
                'query' => str_replace($order, $replace, $item),
                'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                'author' => 'au'])}}" title="Chercher d’autres ouvrages de cet auteur">{{ $item }}</a> ({{ $value }})</li>
            @else
            <li style="display: none"><a rel="nofollow" href="{{
            route('search.simple', [
                'query' => str_replace($order, $replace, $item),
                'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                'author' => 'au'])}}" title="Chercher d’autres ouvrages de cet auteur">{{ $item }}</a> ({{ $value }})</li>
            @endif
            <?php $i++; ?>
        @endforeach
        <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
    </ul>
</div>

