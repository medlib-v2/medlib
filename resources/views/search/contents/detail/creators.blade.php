<?php
    $last = count($result->creators);
    $counter = 1;
    $order = [',', '.'];
    $replace = "";
?>
@if(isset($result->creators))
<div class="author">de&nbsp;
    @foreach ($result->creators as $creator)
        <a href="{{
            route('search.simple', [
                'query' => str_replace($order, $replace, $creator['name']),
                'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                'author' => 'au'])}}" title="Chercher d’autres ouvrages de cet auteur">{{ $creator['name'] }}</a>
                <!--  {{ ($creator['role'] == 'main') ? 'Auteur' : 'Contributeur'}}<br /> -->
        <?php $counter++; ?>
        @if($counter != $last)
            <span>.</span>
        @else
            <span>,</span>
        @endif
    @endforeach
</div>
@endif