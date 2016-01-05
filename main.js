(function(){

	// Ajax friend activity
	$('.add-friend-request-button').click(handleAjaxRequests);

	//$('.accept-friend-button').click(handleAjaxRequests);
	$('.users-list').on('click', '.accept-friend-button', handleAjaxRequests);
	$('.users-list').on('click', '.del-friend-button', handleAjaxRequests);
	$('.profile-userpic').on('click', '.send-friend-request-button', handleAjaxRequests);
	$('.profile-userpic').on('click', '.del-friend-button', handleAjaxRequests);


	function handleAjaxRequests() {

		event.preventDefault();

		var button = $(this);

		var username = button.data('username');
		var token = button.data('token');

		var url = button.attr('href');

		var method = button.data('method') || 'POST';

		var className = button.attr('class');

		var imgPath = button.closest('.panel-default').find('.img-circle').attr('src') || button.closest('.profile-userpic').find('.img-circle').attr('src');

		console.log('Name : '+ username +'\nUrl : '+ url +'\nMethod : '+ method +'\nTOKEN : ' + token +'\nClass :' + className + "\nImages : " + imgPath);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			type: method,
			url: url,
			data: {
				username: username,
				_token: token
			}
		})
		.done(function(data, text, jqxhr){

			if(data.response == 'success') {

				switch (className) {

					case 'btn btn-success add-friend-request-button':
						button.empty();
						button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Requested');
						button.attr('disabled', 'disabled');
						Messenger().post({
							message: data.message,
							type: 'success',
							showCloseButton: true
						});
						break;

					// From friends/requests Interface
					case 'btn btn-primary btn-success accept-friend-button btn-sm':
						button.empty();
						button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Friend added');
						button.attr('disabled', 'disabled');
						Messenger().post({
							message: data.message,
							type: 'success',
							showCloseButton: true
						});
						button.closest('.panel-default').parents('.item').fadeOut(300);
						if(data.count == 0) {
							button.parents('.col-md-12').append('<div class="alert alert-info" role="alert">'+
								'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>'
							);
						}
						break;

					// From friends/requests Interface
					case 'btn btn-primary btn-danger del-friend-button btn-sm':
						button.closest('.panel-default').parents('.item').fadeOut(300);
						Messenger().post({
							message: data.message,
							type: 'success',
							showCloseButton: true
						});
						if(data.count == 0) {
							button.parents('.col-md-12').append('<div class="alert alert-info" role="alert">'+
								'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>'
							);
						}
						break;

					// From users/{username}
					case 'btn btn-danger del-friend-button':
						button.removeClass();
						button.addClass('btn btn-success send-friend-request-button');
						button.attr('href', url+'/requests');
						button.attr('data-method', 'POST');
						button.data('method', 'POST');
						button.empty();
						button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Add friend');
						break;

					case 'btn btn-success send-friend-request-button':
						button.empty();
						button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Requested');
						button.attr('disabled', 'disabled');
						Messenger().post({
							message: data.message,
							type: 'success',
							showCloseButton: true
						});
						break;

					case 'btn btn-primary unfriend-button-3 btn-sm':

				        button.closest('.listed-object-close').slideUp();

				        $( "a[data-username="+button.attr('data-username')+"]" ).hide('slide', {direction : 'right'}, 300);

				        if(data.count == 0) {
				        	$('.users-list').append('<div class="alert alert-info" role="alert">'+
							'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>');

				        	$('#friend-side-list').hide();
							$('#friend-list').append('<div class="alert alert-info" role="alert">'+
			 					'<span class="glyphicon glyphicon-info-sign"></span>'+
			 					' You don\'t have any friends.</div>');
				        }

					    var friendsCount = $('.friends-count').text();
						var actualFriendsCount = parseInt(friendsCount) - 1;
						$('.friends-count').text(actualFriendsCount);

						break;

					case 'logout-link':

						if($('#no-friend-chat-alert').is(":visible")) {
							window.location.replace("/");
						}
						else {
							$('.side-list').each(function(){
								var friendListUserId = $(this).attr('data-username');
								sessionStorage.removeItem('conversation-with-'+friendListUserId);
							});
							window.location.replace("/");
						}
					break;
				}
			}
			else if(data.response == 'failed') {
				Messenger().post({
					message: data.message,
					type: 'error',
					showCloseButton: true
				});
			}
			else {
				Messenger().post({
					message: 'Something went wrong. Please try again.',
					type: 'error',
					showCloseButton: true
				});
			}
		})
		.fail(function(data, jqxhr) {
			if(data.response == 'failed') {
				Messenger().post({
					message: data.message,
					type: 'error',
					showCloseButton: true
				});
			}
			Messenger().post({
				message: 'Something went wrong. Please try again.',
				type: 'error',
				showCloseButton: true
			});
		});

		return false
	}
})(jQuery);