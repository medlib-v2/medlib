(function(){

	// Ajax friend activity
	$('.friend-request-button').click(handleAjaxRequests);
	$('.accept-friend-button').click(handleAjaxRequests);

	function handleAjaxRequests() {

		event.preventDefault();

		var button = $(this);

		var username = button.data('username');
		var token = button.data('token');

		var url = button.attr('href');

		var method = button.data('method') || 'POST';

		var className = button.attr('class');

		var imgPath = button.closest('.panel-default').find('.img-circle').attr('src') || button.closest('.profile-userpic').find('.img-circle').attr('src');

		console.log('Url : '+ url + ' TOKEN : ' + token);

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

					case 'btn btn-success friend-request-button':

						button.attr('disabled', 'disabled').text('Requested');
						Messenger().post({
							message: 'Your request was be send with successful!',
							type: 'success',
							showCloseButton: true
						});
						break;

					case 'btn btn-primary btn-success accept-friend-button btn-sm':

						button.attr('disabled', 'disabled').text('Friend added');
						Messenger().post({
							message: 'Friend added with successful!',
							type: 'success',
							showCloseButton: true
						});
						button.closest('.item').remove().fadeOut(300);
						break;

					case 'btn btn-primary add-friend-button-2 btn-sm':

						button.closest('.listed-object-close').slideUp();

			         if(data.count == 0)
			        {

			        	$('.users-list').append('<div class="alert alert-info" role="alert">'+
						'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');
			        }


	        		$('#no-friend-chat-alert').hide();

					$('#friend-list').append('<div id="friend-side-list" class="list-group">'+
					'<a href="#" class="list-group-item side-list disabled" data-username = "'+ username +'">'+
					'<div class="media"><div class="pull-left">'+
					'<img class="media-object avatar small-avatar" src="'+imgPath+'" alt="'+ username+'">'+
					'</div><div class="media-body">'+
					''+ friendName +' <span class="glyphicon glyphicon-flash text-success"></span>'+
					'</div></div></a></div>');

		        	var friendsCount = $('.friends-count').text();

					var actualFriendsCount = parseInt(friendsCount) + 1;

					$('.friends-count').text(actualFriendsCount);

					break;

					case 'btn btn-primary unfriend-button btn-sm':

					 if(data.count == 0) {
						 $('#friend-side-list').hide();
						 $('#friend-list').append('<div id="no-friend-chat-alert" class="alert alert-info" role="alert">'+
							 '<span class="glyphicon glyphicon-info-sign"></span>'+
							 ' You don\'t have any friends.</div>'
						 );
					 }

				    var friendsCount = $('.friends-count').text();

					var actualFriendsCount = parseInt(friendsCount) - 1;

					$('.friends-count').text(actualFriendsCount);

					$( "#chat-list-user-"+userId ).hide('slide', {direction : 'right'}, 300);

					button.attr('disabled', 'disabled').text('Removed');

					break;

					case 'btn btn-primary unfriend-button-2 btn-sm':

			         button.closest('.listed-object-close').slideUp();

			        if(data.count == 0)
			        {
			        	$('.users-list').append('<div class="alert alert-info" role="alert">'+
						'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');
			        }

					break;

					case 'btn btn-primary unfriend-button-3 btn-sm':

				        button.closest('.listed-object-close').slideUp();

				        $( "a[data-username="+button.attr('data-username')+"]" ).hide('slide', {direction : 'right'}, 300);

				        if(data.count == 0)
				        {
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

						if($('#no-friend-chat-alert').is(":visible"))
						{
							window.location.replace("/");
						}
						else
						{
							$('.side-list').each(function(){
							var friendListUserId = $(this).attr('data-username');
							sessionStorage.removeItem('conversation-with-'+friendListUserId);
							});
							window.location.replace("/");
						}
					break;
				}
			}
			else if(data.response == 'failed')
			{
				$('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);
			}
			else
			{
				alert('Something went wrong. Please try again later.');
			}
		})

		.fail(function(jqxhr) {
			return alert('something went wrong. Please try again.');
		});

		return false
	}
})(jQuery);