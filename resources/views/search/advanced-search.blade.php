@extends('layouts.master')

@section('title', trans('search.txt.advanced-text'))

@section('class') container-fluid @endsection

@section('content')
<div class="content">
    <div class="container-float">
        <div class="container-fluid">
            <h1 class="display-4">@lang('search.txt.advanced-text')</h1>

            {!! Form::open(['id' => 'validation-form','method' => 'GET', 'route' => 'search.advanced', 'accept-charset' => 'UTF-8', 'role'=> 'form']) !!}
            <!-- Information -->
            <div style="background: #ccc;">
                <p>La recherche avancée permet une interrogation plus fine à votre recherche. Tous les critères présents sur cette page peuvent être utilisés de manière indépendante ou croisée.<br>Plus d'informations dans la <a href="#/help/content/search-advanced" class="lien-aide" onclick="clickTogo('N', 'search-advanced');">rubrique Aide</a></p>
                <p>Inscrivez des termes de recherche dans au moins une des zones ci-dessous.</p>
            </div>
            <!-- /Information -->

            <div id="panel-advanced" class="panel-group accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#panel-advanced" href="#words">
                                <i class="icon glyphicon glyphicon-chevron-down"></i>&nbsp;&nbsp;Par mots</a>
                        </h4>
                    </div>
                    <div id="words" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="query">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-xs-7 col-md-8 col-sm-8 no-padding" style="width: 100%;">
                                            <div class="form-group">
                                                <select id="qdb" name="qdb" data-placeholder="@lang('search.txt.library')" class="select2 form-control select2-offscreen">
                                                <option value="">@lang('search.txt.library')}</option>
                                                @foreach($datasource as $name => $instance)
                                                    <option value="{{ $name }}">{{ $instance['fullname'] }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            @if (isset($errors) && $errors->has('qdb'))
                                                <p class="help-block text-danger">{{ $errors->first('qdb') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="words-point" class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-1 col-sm-1 col-xs-1"><input type="hidden" name="words[0][condition]" value="-1"></div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group @if (isset($errors) and  $errors->has('title')) has-error @endif">
                                                    {!! Form::select('words[0][title]', [
                                                        'ti'     => 'Mots du titre',
                                                        'sub'    => 'Mots sujet',
                                                        'aup'    => 'Mots auteur(s)',
                                                        'pn'     => 'Nom de personne',
                                                        'cn'     => 'Organisme auteur',
                                                        'tov'    => 'Titre abrégé (périodiques)',
                                                        'tc'     => 'Collection',
                                                        'pb'     => 'Editeur',
                                                        'note'   => 'Note de thèse',
                                                        'ts'     => 'Note de récompense',
                                                        'abs'    => 'Résumé; sommaire',
                                                        'kw'     => 'Tous les mots',
                                                        'trp'    => 'Titre en relation',
                                                        'isbn'   => 'ISBN livres',
                                                        'isn'    => 'ISSN périodiques',
                                                        'mesh'   => 'Sujet MESH anglais',
                                                        'ln'     => 'Langue du document (code)',
                                                        'cna'    => 'Pays de publication (code)'
                                                        ], 'ti',
                                                        [
                                                            'placeholder' => 'Mots auteur(s)',
                                                            'required' => 'required',
                                                            'class' => 'select2 form-control'
                                                        ])
                                                    !!}
                                                    @if (isset($errors) and $errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                <div class="form-group">
                                                    {{ Form::text('words[0][query]', null,
                                                    ['class' => 'form-control',
                                                    'required' => 'required',
                                                    'id' =>'query-0',
                                                    'data-parsley-trigger' => 'change',
                                                    'data-parsley-validation-threshold' => '1'
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-1 " id="add-remove">
                                                <a href="#" class="icons icons-add-btn" data-action="add" id="plus"><span class="icon glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#panel-advanced" href="#localisation" class="collapsed">
                                <i class="icon glyphicon glyphicon-chevron-down"></i>&nbsp;&nbsp;Par localisation</a>
                        </h4>
                    </div>
                    <div id="localisation" class="panel-collapse collapse">
                        <div class="panel-body">
                            @include('search.contents.advanced.country')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#panel-advanced" href="#document-type" class="collapsed">
                                <i class="icon glyphicon glyphicon-chevron-down"></i>&nbsp;&nbsp;Par nature de document</a>
                        </h4>
                    </div>
                    <div id="document-type" class="panel-collapse collapse">
                        <div class="panel-body">
                            @include('search.contents.advanced.typedoc')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#panel-advanced" href="#langue" class="collapsed">
                                <i class="icon glyphicon glyphicon-chevron-down"></i>&nbsp;&nbsp;Par langue / Par date de publication</a>
                        </h4>
                    </div>
                    <div id="langue" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @include('search.contents.advanced.language')
                                </div>
                                <div class="col-md-6">
                                    @include('search.contents.advanced.data-publish')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <!-- Button submit -->
                <button class="btn btn-space btn-default btn-lg" type="button" onclick="location.replace('/search/advanced')">
                    <span class="visible-md visible-sm visible-lg hidden-xs"><i class="icon fa fa-times"></i>&nbsp;&nbsp;Effacer la recherche</span>
                    <i class="visible-xs hidden-sm fa fa-times"></i>
                </button>
                <button class="btn btn-space btn-primary btn-lg" type="submit">
                    <span class="visible-md visible-sm visible-lg hidden-xs"><i class="icon fa fa-search"></i>&nbsp;&nbsp;Lancer la recherche</span>
                    <i class="visible-xs hidden-sm fa fa-search"></i>
                </button>
                <!-- /Button submit -->
            </div>
            {!! Form::close() !!}
        </div>
        <br><br><br>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            /**
             * Medlib Application
             */
            Medlib.InputField(null);
            Medlib.MultiTags(null);
            @if (Auth::guest())
            Medlib.Password('#password', {
                innerToggle: true,
                touchSupport: Modernizr.touch,
                title: 'Click here show/hide password',
                hideToggleUntil: 'focus'
            });
            @endif
            Medlib.FormElements(null);
        });
    </script>
@endsection
