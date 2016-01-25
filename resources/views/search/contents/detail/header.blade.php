<img class="img_plus" src="{{ url('images/tree_minus.gif') }}" id="detail" title="détail" border="0" hspace="3">
@if($result->material == "Unknown")
    <img src="{{ url('images/icon_unknown_16x16.png') }}">
@elseif($result->material == "Visual")
    <img src="{{ url('images/icon_per_16x16.gif') }}">
@elseif($result->material == "Music CD")
    <img src="{{ url('images/24/audio-cd.png') }}">
@elseif($result->material == "VHS (1/2 in., videocassette)")
    <img src="{{ url('images/icon_vhs_16x16.png') }}">
@endif
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