!function(){function e(){event.preventDefault();var e=$(this),s=e.data("username"),t=e.data("token"),a=e.attr("href"),n=e.data("method")||"POST",i=e.attr("class"),r=e.closest(".panel-default").find(".img-circle").attr("src")||e.closest(".profile-userpic").find(".img-circle").attr("src");return console.log("Url : "+a+" TOKEN : "+t),$.ajax({type:n,url:a,data:{username:s,_token:t}}).done(function(t,a,n){if("success"==t.response)switch(i){case"btn btn-success friend-request-button":e.attr("disabled","disabled").text("Requested"),Messenger().post({message:"Your request was be send with successful!",type:"success",showCloseButton:!0});break;case"btn btn-primary btn-success accept-friend-button btn-sm":e.attr("disabled","disabled").text("Friend added"),Messenger().post({message:"Friend added with successful!",type:"success",showCloseButton:!0}),e.closest(".item").remove().fadeOut(300);break;case"btn btn-primary add-friend-button-2 btn-sm":e.closest(".listed-object-close").slideUp(),0==t.count&&$(".users-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>'),$("#no-friend-chat-alert").hide(),$("#friend-list").append('<div id="friend-side-list" class="list-group"><a href="#" class="list-group-item side-list disabled" data-username = "'+s+'"><div class="media"><div class="pull-left"><img class="media-object avatar small-avatar" src="'+r+'" alt="'+s+'"></div><div class="media-body">'+friendName+' <span class="glyphicon glyphicon-flash text-success"></span></div></div></a></div>');var d=$(".friends-count").text(),l=parseInt(d)+1;$(".friends-count").text(l);break;case"btn btn-primary unfriend-button btn-sm":0==t.count&&($("#friend-side-list").hide(),$("#friend-list").append('<div id="no-friend-chat-alert" class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>'));var d=$(".friends-count").text(),l=parseInt(d)-1;$(".friends-count").text(l),$("#chat-list-user-"+userId).hide("slide",{direction:"right"},300),e.attr("disabled","disabled").text("Removed");break;case"btn btn-primary unfriend-button-2 btn-sm":e.closest(".listed-object-close").slideUp(),0==t.count&&$(".users-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');break;case"btn btn-primary unfriend-button-3 btn-sm":e.closest(".listed-object-close").slideUp(),$("a[data-username="+e.attr("data-username")+"]").hide("slide",{direction:"right"},300),0==t.count&&($(".users-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>'),$("#friend-side-list").hide(),$("#friend-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>'));var d=$(".friends-count").text(),l=parseInt(d)-1;$(".friends-count").text(l);break;case"logout-link":$("#no-friend-chat-alert").is(":visible")?window.location.replace("/"):($(".side-list").each(function(){var e=$(this).attr("data-username");sessionStorage.removeItem("conversation-with-"+e)}),window.location.replace("/"))}else"failed"==t.response?$(".center-alert").html(t.message).fadeIn(300).delay(2500).fadeOut(300):alert("Something went wrong. Please try again later.")}).fail(function(e){return alert("something went wrong. Please try again.")}),!1}$(".friend-request-button").click(e),$(".accept-friend-button").click(e)}(jQuery);