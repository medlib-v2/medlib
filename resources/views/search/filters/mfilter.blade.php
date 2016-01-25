<td class="col-sm-2 faceted">
    @if(isset($filter['format']))
    <div class="box-shadow">
        <div id="div-refinefm" class="expand-box">
            <table cellspacing="0" width="100%" class="table-layout">
                <tbody><tr><th onclick="collapsebox('div-refinefm')"><strong><a>{{ trans('search.txt.format') }}</a></strong></th></tr>
                <tr class="facet-panel">
                    <td class="box">
                        <div id="format-refinement">
                            <ul class="refinement">
                                <li>
                                    <input type="checkbox" id="format_all" name="format_all" value="format_all" checked="checked" class="facetcheckbox" disabled="">
                                    <label for="format_all"><strong>Tous les formats</strong></label><label id="all_fm_count" style="display: inline;"> (<strong>2,185</strong>)</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="format_1" name="format_1" value="format_1" class="facetcheckbox">
                                    <label for="format_1">Article (1022)</label>
                                    <script>
                                    </script>

                                    <!-- Level 2 refinement -->
                                    <ul class="refinement2">
                                        <li>
                                            <input type="checkbox" id="format_1_1" name="format_1_1" value="format_1_1" class="facetcheckbox">
                                            <label for="format_1_1">Chapitre (852)</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="format_1_2" name="format_1_2" value="format_1_2" class="facetcheckbox">
                                            <label for="format_1_2">Article téléchargeable (35)</label>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <input type="checkbox" id="format_2" name="format_2" value="format_2" class="facetcheckbox">
                                    <label for="format_2">Livre (686)</label>

                                    <!-- Level 2 refinement -->
                                    <ul class="refinement2">
                                        <li>
                                            <input type="checkbox" id="format_2_1" name="format_2_1" value="format_2_1" class="facetcheckbox">
                                            <label for="format_2_1">Print book (410)</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="format_2_2" name="format_2_2" value="format_2_2" class="facetcheckbox">
                                            <label for="format_2_2">Livre électronique (351)</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="format_2_3" name="format_2_3" value="format_2_3" class="facetcheckbox">
                                            <label for="format_2_3">Thèse/dissertation (61)</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="format_2_4" name="format_2_4" value="format_2_4" class="facetcheckbox">
                                            <label for="format_2_4">Microforme (1)</label>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <input type="checkbox" id="format_3" name="format_3" value="format_3" class="facetcheckbox">
                                    <label for="format_3">Vidéo (262)</label>
                                    <!-- Level 2 refinement -->
                                    <ul class="refinement2">
                                        <li>
                                            <input type="checkbox" id="format_3_1" name="format_3_1" value="format_3_1" class="facetcheckbox">
                                            <label for="format_3_1">Vidéo électronique (258)</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="format_3_2" name="format_3_2" value="format_3_2" class="facetcheckbox">
                                            <label for="format_3_2">DVD (4)</label>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <input type="checkbox" id="format_4" name="format_4" value="format_4" class="facetcheckbox">
                                    <label for="format_4">Documents d'archives (173)</label>

                                    <!-- Level 2 refinement -->
                                    <ul class="refinement2">
                                        <li>
                                            <input type="checkbox" id="format_4_1" name="format_4_1" value="format_4_1" class="facetcheckbox">
                                            <label for="format_4_1">Documents d'archives téléchargeables (172)</label>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <input type="checkbox" id="format_5" name="format_5" value="format_5" class="facetcheckbox">
                                    <label for="format_5">Fichier d’ordinateur (67)</label>
                                </li>

                                <li>
                                    <input type="checkbox" id="format_6" name="format_6" value="format_6" class="facetcheckbox">
                                    <label for="format_6">Trousse (2)</label>
                                </li>

                                <li class="facet_li" style="display:none">
                                    <input type="checkbox" id="format_7" name="format_7" value="format_7" class="facetcheckbox">
                                    <label for="format_7">Multimédia interactif (1)</label>
                                </li>

                                <li class="facet_li" style="display:none">
                                    <input type="checkbox" id="format_8" name="format_8" value="format_8" class="facetcheckbox">
                                    <label for="format_8">Périodique ou revue électroniques (1)</label>
                                </li>

                                <li class="facet_li" style="display:none">
                                    <input type="checkbox" id="format_9" name="format_9" value="format_9" class="facetcheckbox">
                                    <label for="format_9">Site Web (1)</label>
                                </li>

                                <li class="showmore_li">
                                    <a href="javascript:showMoreFacets();"><strong>Plus ...</strong></a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tbody></table>
        </div>
    </div>
    @endif
    <div id="inpfacet"></div>
    <div class="box-shadow">
        <div id="div-refinefm" class="expand-box">
            <table cellspacing="0" width="100%" class="table-layout">
                <tbody>
                    <tr>
                        <th onclick="collapsebox('div-refine')">
                            <strong><a>{{ trans('search.txt.refine') }}</a></strong>
                        </th>
                    </tr>
                    <tr class="facet-panel">
                        <td class="box">
                            @if(isset($filter['creators']))
                                @include('search.filters.creators')
                            @endif
                            @if(isset($filter['year']))
                                @include('search.filters.year')
                            @endif
                            @if(isset($filter['language']))
                            <div id="language-refinement">
                                <div class="head"><strong>Langue</strong></div>
                                <ul class="refinement">
                                    <li><a rel="nofollow" title="Anglais" href="#">Anglais</a> (939)</li>
                                    <li><a rel="nofollow" title="Chinois" href="#">Chinois</a> (81)</li>
                                    <li><a rel="nofollow" title="Allemand" href="#">Allemand</a> (75)</li>
                                    <li><a rel="nofollow" title="Finnois" href="#">Finnois</a> (64)</li>
                                    <li><a rel="nofollow" title="Non déterminée" href="#">Non déterminée</a> (42)</li>
                                    <li><a rel="nofollow" href="#"><strong>Plus ...</strong></a></li>
                                </ul>
                            </div>
                            @endif
                            @if(isset($filter['contenu']))
                            <div id="content-refinement">
                                <div class="head"><strong>Contenu</strong></div>
                                <ul class="refinement">
                                    <li><a rel="nofollow" title="Biographie" href="#">Biographie</a> (8)</li>
                                    <li><a rel="nofollow" title="Fiction" href="#">Fiction</a> (3)</li>
                                    <li><a rel="nofollow" title="Documentaire" href="#">Documentaire</a> (2182)</li>
                                </ul>
                            </div>
                            @endif
                            @if(isset($filter['placeOfPublication']))
                                @include('search.filters.placeOfPublication')
                            @endif
                            @if(isset($filter['subjects']))
                                @include('search.filters.subjects')
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</td>