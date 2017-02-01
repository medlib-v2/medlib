(function(){

    /**
	 * checkout informing friends when friend request is accepted
     */

    /**
	 * login bottom message alert
     */
	jQuery('.welcome-alert').fadeIn(300).delay(3500).fadeOut(300);

    /**
	 * Register and Connect to websocket
     */
	var socket = io.connect('http://localhost:6379');
            
    socket.emit('register', {'userId': userId});

    /**
	 * Listening to websocket alerts//
     */
 	socket.on(userId, function(data){

        /**
		 * Updating chat status
         */
 		if(data.clientcode == 21) {
            /**
			 * Update chat status on current user
             */
 			if(data.relatedToId == userId) {
 				if(data.message == true) {
 					jQuery('#friend-list .wrapper-2').hide();

 					jQuery('#friend-list .wrapper').hide();
 				}
 				else {
 					jQuery('#friend-list .wrapper-2').hide();

 					jQuery('#friend-list .wrapper').show();
 				}
 			}
 			else {
                /**
				 * Alert/changeStatus on all connected friends of currentuser who changed chat status
                 */
	 			if(data.message == true) {
	 				console.log(data.relatedToId);
	 				jQuery( "a[data-userid="+data.relatedToId+"]" ).removeClass('disabled');
	 			}
	 			else {
	 				console.log(data.relatedToId);
	 				jQuery( "a[data-userid="+data.relatedToId+"]" ).addClass('disabled');
	 			}
 			}
 		}
        /**
		 * Alerting all connected friends that current user has logged in/out
         */
 		else if(data.clientcode == 22) {
 			
 			if(data.message == false) {
 				jQuery( "a[data-userid="+data.relatedToId+"]" ).addClass('disabled');
 			}
 		}
        /**
		 * Record chat messages sent to current user
         */
 		else if(data.clientcode == 23)
 		{
            /**
			 * Determine if current user is available to chat
             * @type {boolean}
             */
 			var availabilityStatus = jQuery('input[name="chatStatus"]').is(":checked") ? true : false;

 			if(availabilityStatus) {
                /**
				 * Determine if message sender available to chat
                 * @type {*}
                 */
	 			var friendLink = jQuery("a[data-userid = "+data.relatedToId+"]");

	 			if(friendLink.hasClass('disabled')) {
	 				return false;
	 			}
	 			else {
                    /**
					 * Handle chat messages when both users are available to chat
                     */
	 				handleChatMessages({"friendId": data.relatedToId, "message" : data.message});

		 			if(jQuery('#chatwithuser'+data.relatedToId).length) {
		 				jQuery('#chatwithuser'+data.relatedToId).find('ul').append('<li>'+data.message+'</li>');

		 				jQuery('#chatwithuser'+data.relatedToId).show();

		 				console.log('opened already created chat object');	
		 			}
		 			else {
						var friendProfileImage = friendLink.find('.avatar').attr('src'),
							friendName = friendLink.find('.avatar').attr('alt');

		 				openChatBox({"friendProfileImage": friendProfileImage, "friendName": friendName, "friendId": data.relatedToId});

		 				console.log('created new chat box object');
			 		}
	 			}
 			}
 			else { return availabilityStatus; }
 		}
        /**
		 * Alerting connected friend when a user has terminated the friendship with her
         */
 		else if(data.clientcode == 24)
 		{
 			if(! data.message) {
 				jQuery('#friend-side-list').hide();
 				
 				jQuery('#friend-list').append('<div id="no-friend-chat-alert" class="alert alert-info" role="alert">'+
 					'<span class="glyphicon glyphicon-info-sign"></span>'+
 					' You don\'t have any friends.</div>');

 				var friendsCount = jQuery('.friends-count').text(),
					actualFriendsCount = parseInt(friendsCount) - 1;

				jQuery('.friends-count').text(actualFriendsCount);

 				if(jQuery(location).attr('href') == "/friends") {
 					jQuery('.users-list').hide();

 					jQuery('#center-column').append('<div class="alert alert-info" role="alert">'+
					'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>');
 			
 				}
 				else if(jQuery(location).attr('href') == "/users") {
 					jQuery( "a[data-userid = "+data.relatedToId+"]" ).attr('disabled', 'disabled').text('Removed');
 				}
 				else if(jQuery(location).attr('href') == "/users/"+data.relatedToId) {
 					jQuery( "a[data-userid = "+data.relatedToId+"]" ).attr('disabled', 'disabled').text('Removed');
 				}		
 			}
 			else {
 				var friendsCount = jQuery('.friends-count').text(),
					actualFriendsCount = parseInt(friendsCount) - 1;

				jQuery('.friends-count').text(actualFriendsCount);

 				jQuery( "#chat-list-user-"+data.relatedToId ).hide('slide', {direction : 'right'}, 300);

 				if(jQuery(location).attr('href') == "/friends")
 				{
 					jQuery( "a[data-userid = "+data.relatedToId+"]" ).closest('.listed-object-close').hide();
 				}
 				else if(jQuery(location).attr('href') == "/users")
 				{
 					jQuery( "a[data-userid = "+data.relatedToId+"]" ).attr('disabled', 'disabled').text('Removed');
 				}
 				else if(jQuery(location).attr('href') == "/users/"+data.relatedToId)
 				{
 					jQuery( "a[data-userid = "+data.relatedToId+"]" ).attr('disabled', 'disabled').text('Removed');
 				}
 			}
 		}
	 }); //End listening for socket alerts


    /**
	 * Handle ajax form submissions
     */
	jQuery('.message-form').submit(handleFormSubmisions);
	jQuery('.message-response-form').submit(handleFormSubmisions);
	jQuery('.feed-form').submit(handleFormSubmisions);

	function handleFormSubmisions() {

		var form = jQuery(this),
			url = form.prop('action'),
			method = form.find('input[name="_method"]').val() || 'POST',
			formData = form.serialize();

        jQuery.ajax({

			type: method,
			url: url,
			data: formData
		}).done(function(data) {
			if(data.response == 'success'){

				switch (form.prop('class')) {				   

					case 'message-form':
						jQuery('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);
						form.find('textarea').val("");
					break;

					case 'message-response-form':
						// jQuery('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);
						jQuery('.message-response-list').prepend('<div class="media listed-object-close">'+
						'<div class="pull-left"><a href="#"><img class="media-object avatar small-avatar"'+ 
						'src="'+userProfileImage+'" alt="'+userFirstname+'"></a>'+		
						'</div><div class="media-body"><p><span class="text-muted">Just now you wrote:</span>'+
						'<a href="#"><span></span></a></p><div>'+form.find('textarea').val()+'</div></div></div>');

						form.find('textarea').val("");
					break;

					case 'feed-form':
						var feedsCount = jQuery('.feeds-count').text(),
							actualFeedsCount = parseInt(feedsCount) + 1;

						jQuery('.feeds-count').text(actualFeedsCount);

						jQuery('.feed-list').prepend('<div id="feedid" class="media listed-object">'+
							'<div class="pull-left"><img class="media-object avatar medium-avatar" src="'+data.userProfileImage+'" alt="'+data.userFirstname+'">'+
							'</div><div class="media-body"><h4 class="media-heading">'+data.userFirstname+'</h4><p>Just now</p>'+
							data.feedBody+'</div></div>');

						form.find('textarea').val("");

						jQuery('.no-feeds-info').hide();
			       	break;
				}
			}
			else if(data.response == 'failed') {
				switch (form.prop('class')) {
					case 'message-form':
			        	jQuery('.center-alert').html('Your message is empty').fadeIn(300).delay(2000).fadeOut(300);
					break;

					case 'message-response-form':
						 jQuery('.center-alert').html('Your message is empty').fadeIn(300).delay(2000).fadeOut(300);
					break;
				}
		        form.find('textarea').val("");					
			}
		}).fail(function(){
			return alert('something went wrong. Please try again.');
		});
		//end ajax
		return false;
	}//end handle ajax form submissions


    /**
	 * Handle ajax friend activity

     */
	jQuery('.friend-request-button').click(handleAjaxRequests);
	jQuery('.add-friend-button').click(handleAjaxRequests);
	jQuery('.add-friend-button-2').click(handleAjaxRequests);
	jQuery('.unfriend-button').click(handleAjaxRequests);
	jQuery('.unfriend-button-2').click(handleAjaxRequests);
	jQuery('.unfriend-button-3').click(handleAjaxRequests);
	jQuery('.logout-link').click(handleAjaxRequests);

	function handleAjaxRequests() {

		var button = jQuery(this),
			userId = button.attr('data-userid'),
			url = button.attr('href'),
			method = button.attr('data-method') || 'POST',
			className = button.attr('class'),
			imgPath = button.closest('.listed-object-close').find('.avatar').attr('src') || button.closest('#profile-card').find('.avatar').attr('src'),
			friendName = button.closest('.listed-object-close').find('.avatar').attr('alt') || button.closest('#profile-card').find('.avatar').attr('alt');


		jQuery.ajax({

			type: method,
			url: url,
			data: {userId: userId}
		}).done(function(data){

			if(data.response == 'success') {
				switch (className) {
					case 'btn btn-primary friend-request-button btn-sm':
                        /**
						 * Enable if you want the center alert to show
                         */
                        // jQuery('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);
						button.attr('disabled', 'disabled').text('Requested');
					break;

					case 'btn btn-primary add-friend-button btn-sm':
                        /**
						 * Enable if you want the center alert to show
                         */
                        // jQuery('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);

						button.attr('disabled', 'disabled').text('Friend added');
		        		jQuery('#no-friend-chat-alert').hide();
						jQuery('#friend-list').append('<div id="friend-side-list" class="list-group">'+
						'<a href="#" class="list-group-item side-list disabled" data-userid = "'+ userId +'">'+						
						'<div class="media"><div class="pull-left">'+
						'<img class="media-object avatar small-avatar" src="'+ imgPath+'" alt="'+ friendName+'">'+        
						'</div><div class="media-body">'+						     	
						''+ friendName +' <span class="glyphicon glyphicon-flash text-success"></span>'+
						'</div></div></a></div>');
					break;

					case 'btn btn-primary add-friend-button-2 btn-sm':
						button.closest('.listed-object-close').slideUp();

						if(data.count == 0) {
							jQuery('.users-list').append('<div class="alert alert-info" role="alert">'+
							'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');
						}

						jQuery('#no-friend-chat-alert').hide();
						jQuery('#friend-list').append('<div id="friend-side-list" class="list-group">'+
						'<a href="#" class="list-group-item side-list disabled" data-userid = "'+ userId +'">'+
						'<div class="media"><div class="pull-left">'+
						'<img class="media-object avatar small-avatar" src="'+imgPath+'" alt="'+ friendName+'">'+
						'</div><div class="media-body">'+''+ friendName +' <span class="glyphicon glyphicon-flash text-success"></span>'+
						'</div></div></a></div>');

						var friendsCount = jQuery('.friends-count').text(),
							actualFriendsCount = parseInt(friendsCount) + 1;

						jQuery('.friends-count').text(actualFriendsCount);
					break;

					case 'btn btn-primary unfriend-button btn-sm':

						if(data.count == 0) {
				        	jQuery('#friend-side-list').hide();
							jQuery('#friend-list').append('<div id="no-friend-chat-alert" class="alert alert-info" role="alert">'+
			 				'<span class="glyphicon glyphicon-info-sign"></span>'+
			 				' You don\'t have any friends.</div>');
						}

						var friendsCount = jQuery('.friends-count').text(),
						actualFriendsCount = parseInt(friendsCount) - 1;

						jQuery('.friends-count').text(actualFriendsCount);
						jQuery( "#chat-list-user-"+userId ).hide('slide', {direction : 'right'}, 300);
						button.attr('disabled', 'disabled').text('Removed');
					break;

					case 'btn btn-primary unfriend-button-2 btn-sm':
						button.closest('.listed-object-close').slideUp();
						if(data.count == 0) {
							jQuery('.users-list').append('<div class="alert alert-info" role="alert">'+
							'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');
						}
					break;

					case 'btn btn-primary unfriend-button-3 btn-sm':

				        button.closest('.listed-object-close').slideUp();

				        jQuery( "a[data-userid="+button.attr('data-userid')+"]" ).hide('slide', {direction : 'right'}, 300);
				     
				        if(data.count == 0) {
				        	jQuery('.users-list').append('<div class="alert alert-info" role="alert">'+
							'<span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>');

				        	jQuery('#friend-side-list').hide();
							jQuery('#friend-list').append('<div class="alert alert-info" role="alert">'+
			 					'<span class="glyphicon glyphicon-info-sign"></span>'+
			 					' You don\'t have any friends.</div>');
				        }

					    var friendsCount = jQuery('.friends-count').text(),
							actualFriendsCount = parseInt(friendsCount) - 1;
						jQuery('.friends-count').text(actualFriendsCount);
					break;

					case 'logout-link':

						if(jQuery('#no-friend-chat-alert').is(":visible")) {
							window.location.replace("/");	
						}
						else {
							jQuery('.side-list').each(function(){
								var friendListUserId = jQuery(this).attr('data-userid');
								sessionStorage.removeItem('conversation-with-'+friendListUserId);
							});
							window.location.replace("/");
						}
					break;
				}
			}
			else if(data.response == 'failed') {
				jQuery('.center-alert').html(data.message).fadeIn(300).delay(2500).fadeOut(300);
			}
			else {
				alert('Something went wrong. Please try again later.');	
			}
		}).fail(function(data) {
			return alert('something went wrong. Please try again.');
		});

		return false
	}

    /**
	 * End handle ajax friend activity
     */

    /**
	 * Update message open status
     */
	jQuery('.open-message').click(function(){

		var messageResponseId = jQuery(this).attr('data-message-response-id'),
			openValue = 1;

        jQuery.ajax({

			type: "put",
			url: "/message-response",
			data: {openValue : openValue, "messageResponseId": messageResponseId}
		}).done(function(data){

			return false
		}).fail(function(){
			return alert('something went wrong. Please try again.');
		});

	});

    /**
	 * Remove message
     */
	jQuery('.delete-message').click(function(){
		jQuery(this).closest(jQuery('.listed-object-close')).slideUp();
		var messageId = jQuery(this).attr('data-message-id');

        jQuery.ajax({

			type: "delete",
			url: "/message-delete",
			data: {messageId: messageId}

		}).done(function(data){

			var messageCount = jQuery('.message-count').text(),
				actualMessageCount = messageCount - 1;

			jQuery('.message-count').text(actualMessageCount);

			if(data.count == 0) {
				jQuery('.message-list').append('<div class="alert alert-info" role="alert">'+
					'<span class="glyphicon glyphicon-info-sign"></span> Your inbox is empty.</div>');
			}

		}).fail(function(){
			return alert('something went wrong. Please try again.');
		});
		return false;

	});
    /**
	 * End remove message
     */
    /**
	 * show message responses
     */
	jQuery('.glyphicon-chevron-down').first().switchClass('glyphicon-chevron-down', 'glyphicon-chevron-up');
	jQuery('.message-body').first().css('display', 'block');

    /**
	 * Open / close email message
     */
	jQuery('.expand-message').click(function(){

		if(jQuery(this).hasClass('glyphicon-chevron-down')) {
			jQuery(this).switchClass( "glyphicon-chevron-down", "glyphicon-chevron-up");
		}
		else if(jQuery(this).hasClass('glyphicon-chevron-up')) {
			jQuery(this).switchClass( "glyphicon-chevron-up", "glyphicon-chevron-down");
		}

		jQuery(this).closest('.media-body').find(jQuery('.message-body')).toggle("slide", { direction: "up"} );
		return false;

	});

    /**
	 * Handling chat activity
	 * Update current user's chat status
     */
	var chatStatus = jQuery('input[name="chatStatus"]').bootstrapSwitch();

	chatStatus.on('switchChange.bootstrapSwitch', function(event, state) {
        jQuery.post( "/chatstatus", { chatStatus: Number(state) } );
	});

    /**
	 * Getting conversation data from session storage
     * @param userId
     * @returns {Array}
     */
    function getChatConversationData(userId) {
    	if (localStorage) {
	    	var conversation = [];
	    	conversation = JSON.parse( sessionStorage.getItem( 'conversation-with-'+userId ) );
	    	return conversation;
    	}
    }
    /**
	 * Saving messages in session storage
     * @param params
     */
    function handleChatMessages(params) {
    	var conversation = getChatConversationData(params.friendId);

    	if(!conversation) {
    		sessionStorage.setItem('conversation-with-'+params.friendId, JSON.stringify({"messages": [params.message]}));  		
    	}
    	else {
    		conversation["messages"].push(params.message);
    		sessionStorage.setItem('conversation-with-'+params.friendId, JSON.stringify(conversation));
    	}
    }

    /**
	 * Opening chat box when clicking any friends on side list
     */
	jQuery('a', jQuery('#friend-list')).click(function(){
		if(! jQuery(this).hasClass('disabled')) {
			var friendProfileImage = jQuery(this).attr('data-profileimage'),
				friendName = jQuery(this).attr('data-firstname'),
				friendId = jQuery(this).attr('data-userid');
			if (jQuery('#chatwithuser'+friendId).length){
				jQuery('#chatwithuser'+ friendId).show();
			}
			else {
				openChatBox({"friendProfileImage": friendProfileImage, "friendName": friendName, "friendId": friendId});
			}
		}
		return false
	});


    /**
	 * end handling chat activity
     * @param params
     */
	function openChatBox(params) {
		var friendProfileImage = params.friendProfileImage,
			friendName = params.friendName,
			friendId = params.friendId,
			marginLeft = "";
        /**
		 * margin left of newly created form
         */
		if(jQuery('.chat-room').length) {
			marginLeft = parseInt(jQuery('.chat-room' ).last().css('margin-left').slice(0, -2)) + 273;
		}
		else {
			marginLeft = 0;
		}
        /**
		 * This will not allow a 5th chat window to open
         */
		if(marginLeft < 819)
		{
			jQuery('#chat-container').append(generateChatForm(friendProfileImage, friendName, friendId, marginLeft));
		}
	}

    /**
	 * End openChatBox
     * @param friendProfileImage
     * @param friendName
     * @param friendId
     * @param marginLeft
     * @returns {*}
     */
	function generateChatForm(friendProfileImage, friendName, friendId, marginLeft) {

        /**
		 * create each form element
         */
		var $mainDiv = jQuery("<div></div>").attr("id", "chatwithuser"+friendId).css('margin-left', marginLeft+'.px').addClass("chat-room chat-full col-md-3"),
			$mediaClass = jQuery("<div></div>").addClass("media").appendTo($mainDiv),
			$mediaLeftClass = jQuery("<div></div>").addClass("media-left").appendTo($mediaClass),
			$mediaObjectClass = jQuery("<img/>", {
				"class" : "media-object avatar small-avatar",
				"src"	: friendProfileImage,
				"alt"	: friendName
			}).appendTo($mediaLeftClass),
			$mediaBodyClass = jQuery("<div></div>").addClass("media-body").appendTo($mediaClass),
			$mediaHeadingClass = jQuery("<p></p>").addClass('media-heading').text(friendName).appendTo($mediaBodyClass),
			$closeButton = jQuery("<a/>", {
				'href': '#',
				click : function() {
					jQuery(this).closest("#chatwithuser"+friendId).hide();
					return false;
				}
			}).appendTo($mediaHeadingClass),
			$closeSpan = jQuery("<span></span>").addClass('glyphicon glyphicon-remove').appendTo($closeButton),
			$minimizeButton = jQuery("<a/>", {
				'href': '#',
				click : function() {
					if(jQuery(this).children('span').hasClass('glyphicon-chevron-down')) {
						jQuery(this).children('span').switchClass( "glyphicon-chevron-down", "glyphicon-chevron-up");
					}
					else if(jQuery(this).children('span').hasClass('glyphicon-chevron-up')) {
						jQuery(this).children('span').switchClass( "glyphicon-chevron-up", "glyphicon-chevron-down");
					}
					jQuery(this).closest("#chatwithuser"+friendId).find(".chat-body-form").toggle( "slide", { direction: "down"} );
					return false;
				}
			}).appendTo($mediaHeadingClass),
			$minimizeSpan = jQuery("<span></span>").addClass('glyphicon glyphicon-chevron-down').appendTo($minimizeButton),
			$chatBodyFormClass = jQuery("<div></div>").addClass("chat-body-form").appendTo($mediaBodyClass),
			$chatBodyClass = jQuery("<div></div>").addClass("chat-body").appendTo($chatBodyFormClass),
			$messagesClass = jQuery("<ul></lu>").addClass("messages").appendTo($chatBodyClass),
			chatConversationWithFriend = [];

		chatConversationWithFriend = JSON.parse( sessionStorage.getItem( 'conversation-with-'+friendId ) );

		if(chatConversationWithFriend) {
			for(i = 0; i < chatConversationWithFriend['messages'].length; i++) {
				var $eachMessage = jQuery("<li></li>").text(chatConversationWithFriend['messages'][i]).appendTo($messagesClass);
			}						
		}				

		var $chatForm = jQuery("<form/>", {
			submit: function(){
				parentDiv = jQuery(this).closest('#chatwithuser'+friendId);
				messageBody = parentDiv.find('ul');
				textField = jQuery(this).find('textarea');

				var message = textField.val();

				if(!message == "") {
					textField.val('');
					jQuery.ajax({
						type: "POST",
						url: "/chat",
						data: { receiverId: friendId, message: userFirstname+": "+message }
					}).done(function(data){
                        /**
						 * Determine the receiver is available to chat
                         */
						if(data.availableToChat == true) {
							messageBody.append((jQuery('<li>').text(userFirstname+": "+message)));
							handleChatMessages({"friendId": friendId, "message" : userFirstname+": "+message});
						}
						else {
                            /**
							 * user is not available to chat
                             */
							messageBody.append((jQuery('<li>').text(friendName+" is offline").css("color", "red")));
						}
					})
					.fail(function() {
						return alert('something went wrong. Please try again.');
					});
				}
				return false
			}
            /**
			 * end submit
             */
		}).appendTo($chatBodyFormClass);

		var $formGroupClass = jQuery("<div></div>").addClass("form-group form-group-sm").appendTo($chatForm),
			$formTextArea = jQuery("<textarea></textarea>")
				.addClass("form-control")
				.attr( "placeholder", "Enter message" )
				.attr("rows", "1")
				.attr("name", "body")
				.appendTo($formGroupClass),
			$formButton = jQuery("<button/>", {
				"type" : "submit",
				"class": "btn btn-default",
				text: "Submit"
			}).appendTo($chatForm);
		return $mainDiv;

	}

    /**
	 * Loading feeds when scrolling
     */
	if(jQuery(location).attr('href') == "http://larasocial.info/feeds") {

		jQuery(window).scroll(function(){

			if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height() - 850) {
				jQuery('#go-up').show();
			}
			else {
				jQuery('#go-up').hide();
			}

			if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height() - 300){

				var skipQty = jQuery('.listed-object').length;

				if(skipQty <= 10) { skipQty = 10; }
				
				if(skipQty < jQuery('.feed-list').attr('data-feedcount')) {

					jQuery('#loader').fadeIn('slow', function() {
                        jQuery.ajax({
							url: "feeds/more",
							data: { 'skipQty' : skipQty}
						}).done(function(data) {
							jQuery('#loader').fadeOut('slow', function() {
								var feedsHTML = "";
                                jQuery.each(data.feeds, function(index, feed){

									if (jQuery('#feedid'+feed.id).length == 0) {
										feedsHTML += '<div id="feedid'+feed.id+'" class="media listed-object">'+
										'<div class="pull-left"><img class="media-object avatar medium-avatar" src="'+feed.poster_profile_image+'"'+
										' alt="'+feed.poster_firstname+'"></div><div class="media-body"><h4 class="media-heading">'+feed.poster_firstname+'</h4>'+
										'<p>'+$.timeago(feed.created_at)+'</p>'+feed.body+'</div></div>';
									}
									else { return false }
								});
								jQuery('.feed-list').append(feedsHTML);
							});
                            /**
							 * Finish fading out loader
                             */
						}).fail(function() {
							return alert('something went wrong. Please try again.');
						});
					});
				}
				else { return false }
			}
		});
	}
    /**
	 * scrolling Top
     */
	jQuery("body").scrollspy({target: "#go-up"});
})();