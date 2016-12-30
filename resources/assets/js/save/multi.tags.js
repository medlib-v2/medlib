/**
 *
 * @type type Medlib.MultiTags
 */
var Medlib = (function () {
    'use strict';
    Medlib.MultiTags = function(){
        var index = 0,
            form = $('#validation-form'),
            action,
            template,
            formFields = 'input, checkbox, select, textarea',
            minus = $('#minus'),
            plus = $('#plus'),
            limit = 2,
            clone,
            ind = 0;

        var $predefinedDate = $('#predefined-date');
        $predefinedDate.empty();

        $('*:radio').on('change', function() {
            switch($(this).val()) {
                case 'predefined':
                    if ($predefinedDate.is(':empty')){
                        $predefinedDate.append(getTemplatePredefinedDate()).fadeIn();
                    }
                    break;
                case 'range':
                    $predefinedDate.fadeOut().empty();
                    console.log('range');
                    break;
            }
        });
        console.log($predefinedDate, 'predefinedDate');

        function getTemplatePredefinedDate(){
            var annee = new Date();
            var year = annee.getFullYear();

            var template = '<select title="Limiter les résultats à une année prédéfinie" class="form-control input-sm select2 inline" id="year" name="datePub[year]">'+
                '<option selected value="1516-'+ year +'">Toutes les années</option>'+
                '<option value="'+ (year -1) +'-'+ year +'">L\'année passée</option>'+
                '<option value="'+ (year -5) +'-'+ year +'">5 dernières années</option>'+
                '<option value="'+ (year -10) +'-'+ year +'">10 dernières années</option></select>';
            return template;
        }

        /**
         *
         * @param event
         * @returns {boolean}
         */
        function handlerMulti (event) {
            event.preventDefault();
            var jqEl = $(event.currentTarget),
                element = jqEl.parents('#words-point'),
                $row = jqEl.parents('.row');
            switch (jqEl.attr("data-action")) {
                case "add":
                    if(index < limit) {
                        index++;
                        clone = getTemplate(index);
                        if(index == 1) { plus.hide(); }
                        else { $(this).hide(); }
                        element.append(clone).end();
                    }
                    break;
                case "delete":
                    if(index >= 2) { element.find('#plus1').show(); }
                    else { plus.show(); }
                    index -= 1;
                    $row.remove();
                    break;
            }
            return false;
        }

        /**
         *
         * @param e
         * @returns {boolean}
         */
        function parseQuery(e) {
            /**
            e.preventDefault();
            var param, name, value, array = [];
            form.find(formFields).map(function() {
                param = $(this);
                name = param.attr('name');
                value = param.val();
                var tmp = "words["+ ind +"][title]";
                console.log(tmp);
                if(name == tmp){
                    console.log("title : " + value);
                }
                ind++;
                console.log(name, value);
            });

            form.submit();

            return false;
            **/
        }

        function getTemplate(index) {

            var $display = (index == 2 )? 'style="display: none;"' : '';

            action = '<div class="col-md-1 col-sm-1 col-xs-1">'+
                '<select name="words[' + index + '][condition]" class="form-control">' +
                '<option value="and">et</option>' +
                '<option value="or">ou</option>' +
                '<option value="not">sauf</option>' + '</select></div>';

            template = '<div class="row">' + action +
                '<div class="col-md-3 col-sm-3 col-xs-3">'+
                '<div class="form-group is-active">'+
                '<select data-placeholder="Mots auteur(s)" data-width="auto" class="select2 form-control" name="words['+ index +'][title]">'+
                '<option value="ti">Mots du titre</option>'+
                '<option value="sub">Mots sujet</option>'+
                '<option value="aup" selected="">Mots auteur(s)</option>'+
                '<option value="pn">Nom de personne</option>'+
                '<option value="cn">Organisme auteur</option>'+
                '<option value="tov">Titre abrégé (périodiques)</option>'+
                '<option value="tc">Collection</option>'+
                '<option value="pb">Editeur</option>'+
                '<option value="note">Note de thèse</option>'+
                '<option value="ts">Note de récompense</option>'+
                '<option value="abs">Résumé ; sommaire</option>'+
                '<option value="kw">Tous les mots</option>'+
                '<option value="trp">Titre en relation</option>'+
                '<option value="isbn">ISBN livres</option>'+
                '<option value="isn">ISSN périodiques</option>'+
                '<option value="mesh">Sujet MESH anglais</option>'+
                '<option value="ln">Langue du document (code)</option>'+
                '<option value="cna">Pays de publication (code)</option>'+
                '</select></div></div>'+
                '<div class="col-md-7 col-sm-7 col-xs-7">'+
                '<div class="form-group"><input class="form-control" id="query-' +index + '" type="text" name="words['+ index +'][query]" value="" data-parsley-trigger="change" data-parsley-validation-threshold="1" required="required">'+
                '</div></div>'+
                '<div class="col-md-1 col-sm-1 col-xs-1 no-padding" id="add-remove">'+
                '<a href="#" data-action="add" class="icons icons-add-btn" id="plus'+ index +'"'+ $display +'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>'+
                '<a href="#" data-action="delete" class="icons icons-remove-btn" style="display: inline-block;" id="minus'+ index +'"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>'+
                '</div></div>';

            return template;
        }

        form.submit(parseQuery).on('click', '.icons-add-btn, .icons-remove-btn', handlerMulti);
    };
    return Medlib;
})(Medlib || {});