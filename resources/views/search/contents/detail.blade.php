<div id="etagere-notice-list">
    <div class="notice-parent">

        <img class="img_plus" src="{{ url('images/tree_minus.gif') }}" name="imEx" id="detail" title="détail" border="0" hspace="3">
        <img src="{{ url('images/icon_a_16x16.gif') }}" alt="Document: texte imprimé" title="Document: texte imprimé">
        <span notice="123313" class="header_title">{{ $result->title }}</span>
    </div>

    <div class="row"></div>
    <div id="" style="display:block;">
        <table>
            <tbody>
            @if(isset($result->material))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Type document :</span></td>
                    <td colspan="3"><span class="public_title"></span>{{ $result->material }}</td>
                </tr>
            @endif
            @if (isset($result->title))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Titre :</span></td>
                    <td colspan="3"><span class="public_title"></span>{{ $result->title }}</td>
                </tr>
            @endif
            @if(isset($result->creators))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Auteurs : </span></td>
                    <td colspan="3">
                        @foreach ($result->creators as $creator)
                            <a href="#">{{ $creator['normalizedName'] }}</a>,
                            {{ ($creator['role'] == 'main') ? 'Auteur' : 'Contributeur'}}<br />
                        @endforeach
                    </td>
                </tr>
            @endif
            @if(isset($result->publisher))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Editeur : </span></td>
                    <td><a href="#">{{ $result->publisher }}</a>
                        @if(isset($result->year))
                            {{ $result->year }}
                        @endif
                    </td>
                </tr>
            @endif
            @if(isset($result->placeOfPublication))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Place de publication : </span></td>
                    <td>{{ $result->placeOfPublication }}</td>
                </tr>
            @endif
            <tr>
                <td align="right" class="bg-grey"><span class="etiq_champ">Collection : </span></td>
                <td colspan="3"><a href="#">En voiture Simone !</a></td>
            </tr>
            @if(isset($result->pages))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Description : </span></td>
                    <td colspan="3">{{ $result->extent }}
                </tr><tr class="tr_spacer"><td class="td_spacer">&nbsp;</td>
                    </td>
                    <td colspan="3">{{ $result->pages }} pages.</td>
                </tr>
            @endif
            @if(!is_null($result->notes))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Résumé : </span></td>
                    <td>
                        @foreach ($result->notes as $note)
                            <div>{{ $note }}</div>
                        @endforeach
                    </td>
                </tr>
            @endif
            @if(isset($result->summary))
                <tr>
                    <td align="right" class="bg-grey"><span class="etiq_champ">Extrait  :</span></td>
                    <td>
                        {{ $result->summary['text'] }}
                    </td>
                </tr>
            @endif
            <tr>
                <td align="right" class="bg-grey"><span class="etiq_champ">Type :</span></td>
                <td colspan="3">texte imprimé&nbsp; ; &nbsp;fiction</td>
            </tr>
            <tr>
                <td align="right" class="bg-grey"><span class="etiq_champ">Genre&nbsp;: </span></td>
                <td colspan="3">roman</td>
            </tr>
            <tr>
                <td align="right" class="bg-grey"><span class="etiq_champ">Thème de fiction&nbsp;: </span></td>
                <td colspan="3">aventure/humour</td>
            </tr>
            </tr><tr class="tr_spacer"><td class="td_spacer">&nbsp;</td>
            </tbody>
        </table>
    </div>
</div>
