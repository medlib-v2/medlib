(function($) {

    var type;
    var parentType;
    // The small arrow that marks the active search icon:
    $('ul.icons li').click(function () {
        var el = $(this);
        // Set the search type
        type = el.attr('data-searchType');
    });

    $('#submitButton').on('click', submitSearch);

    function submitSearch(event) {

        event.preventDefault();
        $('#submitButton').attr("disabled","disabled");

        var query = $('#ssearch').val();
        if (query.length == 0) {
            var msg = $('#danger');
            msg.empty();
            msg.append('<p class="help-block text-warning">Merci de remplire ce champ</p>');
            msg.show().fadeOut(3000, function () {
                msg.empty();
                msg.append('&nbsp;');
                msg.show();
            });
        }
        else {
            var form = $('.inpt-search form');
            var hidden_input = $('#hidden-input');
            if( hidden_input.val() == undefined) {
                form.addHidden('type', type);
            } else {
                hidden_input.remove();
                form.addHidden('type', type);
            }
            jProgress.start();

            var url = form.attr('action') + '?' + form.serialize();
            window.history.replaceState(null, null, url);

            $.get(url)
                .done(function(data){
                    jProgress.done();
                    var content = $('div #content');
                    var html = $('<div/>').attr('id', 'result');
                    $(document).prop('title', 'Résultat de la recherche pour '+ query);
                    content.empty();
                    html.empty();
                    html.append(data);
                    html.appendTo(content);
                    })
                .fail(function(xhr, status, responseText ){
                    jProgress.done();
                    var response = xhr.responseJSON;
                    if(isset(response.require.query)){
                        var msg = $('#danger');
                        msg.empty();
                        msg.append('<p class="help-block text-warning">'+ response.require.query +  '</p>');
                        msg.show().fadeOut(3000, function () {
                            msg.empty();
                            msg.append('&nbsp;');
                            msg.show();
                            location.reload();
                        });
                    }
                    if(isset(response.require.qdb)){
                        console.log(response.require.qdb);
                        location.reload();
                    }
                });
            //form.submit();
            //setTimeout(function(){jProgress.done();}, 9000);
        }
    }

    function isset(variable) {
        return !!(variable !== "" && variable != null && variable !== undefined && typeof(variable) != "undefined");
    }
})(jQuery);