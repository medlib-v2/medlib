@if(isset($result->publisher))
<div class="publisher">Éditeur&nbsp;:&nbsp;
    <span class="item-publisher">
        <?php
            $order = [',', '.'];
            $replace = "";
        ?>
        <a href="{{
            route('search.simple', [
                'query' => str_replace($order, $replace, $result->publisher) ,
                'qdb' => trim(trim(\Illuminate\Support\Facades\Input::get('qdb'), ','), '.'),
                'publisher' => 'pb']) }}" title="Chercher d’autres ouvrages de cet Editeur">{{ $result->publisher }}</a>&nbsp;: {{ $result->placeOfPublication }} &nbsp;
        @if(isset($result->year))
                <span class="date">{{ $result->year }}.</span>
        @endif
    </span>
</div>
@elseif(isset($result->placeOfPublication))
    <div class="place">Place de publication&nbsp;:&nbsp;
        <span class="item-place">
            {{ $result->placeOfPublication }}
        </span>
    </div>
@endif
