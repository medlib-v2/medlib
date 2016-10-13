<?php 
    $i = 1; 
    $order = [',', '.', '[', ']'];
    $replace = "";
?>
<div id="public-refinement">
    <div class="head"><strong>Publication</strong></div>
    <ul class="refinement">
        @foreach($filter['placeOfPublication'] as $item => $value) 
            @if($i< 8) 
            <li>
                <a rel="nofollow" href="{{
                route('search.detail', [
                    'query' => str_replace($order, $replace, $item),
                    'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                    'publisher' => 'pb'])}}">
                    @if (isset($item)) {{ $item }} @endif
                    </a> ({{ str_replace($order, $replace, $value) }})</li>
                @else
                <li style="display: none"><a rel="nofollow" href="{{
                route('search.detail', [
                    'query' => str_replace($order, $replace, $item),
                    'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                    'publisher' => 'pb'])}}">
                    @if (isset($item)) {{ $item }} @endif
                        </a> ({{ str_replace($order, $replace, $value) }})</li>
                @endif
                <?php $i++; ?> @endforeach
            <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
    </ul>
</div>