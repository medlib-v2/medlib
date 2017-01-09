<img class="img_plus" src="{{ url('images/tree_minus.gif') }}" id="detail" title="détail" border="0" hspace="3">
<img src="{{ image_matirial($result->material) }}">
<span notice="{{ $result->id }}" class="title">
    @if(isset($result->title))
        {{ str_finish(str_limit($result->title, 50), '&nbsp;&nbsp;/') }}
    @endif
    @foreach ($result->creators as $creator)
        <span>{{ $creator['name'] }}</span>
    @endforeach

    @if(isset($result->publisher))
        <span>&nbsp;&nbsp;/</span>
        <span>{{ $result->publisher }}&nbsp;/&nbsp;{{ $result->placeOfPublication }}
            @if(isset($result->year))
                &nbsp;{{ $result->year }}.
            @endif
        </span>
    @endif
</span>