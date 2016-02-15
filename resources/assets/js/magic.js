$(document).ready(function(){
	// submit the form
	$('form').submit(function(event){
		
		$('.form-group').removeClass(); // remove the error class
		$('.help-block').remove(); // remove the error text
		/**
		var formData = {
			'qdb' 			: $('select[name=qdb]').val(),
			'query' 		: $('input[name=query]').val(),
			'title' 		: $('input[name=title]').val(),
			'author' 		: $('input[name=author]').val(),
			'publisher' 	: $('input[name=publisher]').val(),
			'uniforme' 		: $('input[name=uniforme]').val(),
			'dofpublisher' 	: $('input[name=dofpublisher]').val(),
			'keywords' 		: $('input[name=keywords]').val(),
			'abstract' 		: $('input[name=abstract]').val()
		};
		**/
		var $form = ('.search_input');
		var url = $form.attr('action') + '?' + $form.serialize();
		$('#' + id).html(url);
		$.get({
			type 		: 'GET',
			url 		: action,
			data		: $form,
			dataType 	: 'json',
			encode 		: true
			
		}).done(function(data){
			console.log(data);
			
		}).fail(function(data){
			console.log(data);
		});
		
		event.preventDefault();
	});
});