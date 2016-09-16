(function ($) {
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

    function handlerMulti (e) {
        e.preventDefault();
        var jqEl = $(e.currentTarget);
        var element = jqEl.parents('.query');
        var $row = jqEl.parents('.row');
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

    function parseQuery(e) {
        e.preventDefault();
        var param, name, value, array = [];
        form.find(formFields).map(function() {
            param = $(this);
            name = param.attr('name');
            value = param.val();
            var tmp = "query["+ ind +"].title";
            console.log(tmp);
            if(name == tmp){
                console.log("title : " + value);
            }
            ind++;
            console.log(name, value);
        });
        return false;
    }

    form.submit(parseQuery).on('click', '.picto-add-btn, .picto-remove-btn', handlerMulti);
    
    
    function getTemplate(index) {

        var $display = (index == 2 )? 'style="display: none;"' : '';

        action = '<div class="col-md-1 col-sm-1 col-xs-1">'+
            '<select name="query[' + index + '].action" class="form-control">' +
            '<option value="and">et</option>' +
            '<option value="or">ou</option>' +
            '<option value="not">sauf</option>' + '</select></div>';

        template = '<div class="row">' + action +
            '<div class="col-md-3 col-sm-3 col-xs-3">'+
            '<select data-placeholder="Mots auteur(s)" data-width="auto" class="select2 form-control" name="query['+ index +'].title">'+
                '<option value="4">Mots du titre</option>'+
                '<option value="21">Mots sujet</option>'+
                '<option value="1004" selected="">Mots auteur(s)</option>'+
                '<option value="1">Nom de personne</option>'+
                '<option value="2">Organisme auteur</option>'+
                '<option value="8139">Tous numéros</option>'+
                '<option value="8063">Titre complet</option>'+
                '<option value="8062">Titre abrégé (périodiques)</option>'+
                '<option value="8109">Collection</option>'+
                '<option value="1018">Editeur</option>'+
                '<option value="63">Note de thèse</option>'+
                '<option value="5">Note de récompense</option>'+
                '<option value="62">Résumé ; sommaire</option>'+
                '<option value="1016">Tous les mots</option>'+
                '<option value="8082">Vedette matière</option>'+
                '<option value="8864">reliure ; provenance ; conservation</option>'+
                '<option value="8865">Note de livre ancien</option>'+
                '<option value="1026">Titre en relation</option>'+
                '<option value="7">ISBN livres</option>'+
                '<option value="8">ISSN périodiques</option>'+
                '<option value="8141">Mots sujet anglais</option>'+
                '<option value="25">Sujet MESH anglais</option>'+
                '<option value="54">Langue du document (code)</option>'+
                '<option value="55">Pays de publication (code)</option>'+
                '<option value="8148">PCP : Plan de conservation partagée</option>'+
            '</select></div>'+
            '<div class="col-md-7 col-sm-7 col-xs-7">'+
                '<div class="form-group"><input class="form-control" id="query-' +index + '" type="text" name="query['+ index +'].query" value="" data-parsley-trigger="change" data-parsley-validation-threshold="1" required="required">'+
            '</div></div>'+
            '<div class="col-md-1 col-sm-1 col-xs-1 " id="add-remove">'+
            '<a href="#" data-action="add" class="pictos picto-add-btn" id="plus'+ index +'"'+ $display +'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>'+
            '<a href="#" data-action="delete" class="pictos picto-remove-btn" style="display: inline-block;" id="minus'+ index +'"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>'+
            '</div></div>';

        return template;
    }
})(jQuery);