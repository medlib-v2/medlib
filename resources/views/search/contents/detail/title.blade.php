<?php
    $last = count($result->creators);
    $counter = 1;
    $order = [',', '.'];
    $replace = "";
?>
<div class="title">
    <a href="{{
            route('search.detail', [
                'query' => str_replace($order, $replace, $result->title),
                'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                'title' => 'ti'])}}" id="title-{{ $counter }}">
        @if (isset($result->title))
            <strong>{{ $result->title }}</strong>
        @endif
    </a>
</div>