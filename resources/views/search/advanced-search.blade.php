@extends('layouts.master')

@section('title', trans('search.txt.advanced-text'))

@section('content')
<div class="content">
    <div class="container-float">
        <div class="container-fluid">
            <h1 class="display-4">{{ trans('search.txt.advanced-text') }}</h1>
        </div>
        <div class="container-fluid">
            <div class="col-sm-12 col-md-12 col-xs-12" id="adv-search" data-parsley-priority-enabled="false" novalidate="novalidate">
                <form id="validation-form" accept-charset="UTF-8" method="GET" action="advanced">
                    <div style="background: #ccc;">Inscrivez des termes de recherche dans au moins une des zones ci-dessous</div>
                    <div class="query">
                        <div class="row">
                            <div class="col-md-1 col-sm-1 col-xs-1"></div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <select data-placeholder="Mots auteur(s)" data-width="auto" class="form-control" name="query[0].title">
                                    <option value="4">Mots du titre</option>
                                    <option value="21">Mots sujet</option>
                                    <option value="1004" selected="">Mots auteur(s)</option>
                                    <option value="1">Nom de personne</option>
                                    <option value="2">Organisme auteur</option>
                                    <option value="8139">Tous numéros</option>
                                    <option value="8063">Titre complet</option>
                                    <option value="8062">Titre abrégé (périodiques)</option>
                                    <option value="8109">Collection</option>
                                    <option value="1018">Editeur</option>
                                    <option value="63">Note de thèse</option>
                                    <option value="5">Note de récompense</option>
                                    <option value="62">Résumé ; sommaire</option>
                                    <option value="1016">Tous les mots</option>
                                    <option value="8082">Vedette matière</option>
                                    <option value="8864">reliure ; provenance ; conservation</option>
                                    <option value="8865">Note de livre ancien</option>
                                    <option value="1026">Titre en relation</option>
                                    <option value="7">ISBN livres</option>
                                    <option value="8">ISSN périodiques</option>
                                    <option value="8141">Mots sujet anglais</option>
                                    <option value="25">Sujet MESH anglais</option>
                                    <option value="54">Langue du document (code)</option>
                                    <option value="55">Pays de publication (code)</option>
                                    <option value="8148">PCP : Plan de conservation partagée</option>
                                </select>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7">
                                <div class="form-group">
                                    <input class="form-control" id="query-0" type="text" name="query[0].query" value="" data-parsley-trigger="change" data-parsley-validation-threshold="1" required="required">
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-1 " id="add-remove">
                                <a href="#" data-action="add" class="pictos picto-add-btn" id="plus"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
                            </div>
                        </div>
                    </div>
                    <div style="float:left;width:80px;">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" style="height:40px;" type="submit">
                                <span class="visible-md visible-sm visible-lg hidden-xs">Recherche</span>
                                <i class="visible-xs hidden-sm fa fa-search text-white"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sytle')

@endsection

@section('script')
    <script src="{{ asset('vendor/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('js/form-elements.min.js') }}"></script>
    <script src="{{ asset('js/multi-tags.min.js') }}"></script>
    <script src="{{ asset('js/form-validation.min.js') }}"></script>
@endsection
