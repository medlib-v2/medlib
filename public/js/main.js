!function(){function e(){event.preventDefault();var e=$(this),s=e.data("username"),t=e.data("token"),n=e.attr("href"),a=e.data("method")||"POST",r=e.attr("class"),o=e.closest(".panel-default").find(".img-circle").attr("src")||e.closest(".profile-userpic").find(".img-circle").attr("src");return console.log("Name : "+s+"\nUrl : "+n+"\nMethod : "+a+"\nTOKEN : "+t+"\nClass :"+r+"\nImages : "+o),$.ajax({type:a,url:n,data:{username:s,_token:t}}).done(function(s){if("success"==s.response)switch(r){case"btn btn-success add-friend-request-button":e.empty(),e.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Requested'),e.attr("disabled","disabled"),Messenger().post({message:s.message,type:"success",showCloseButton:!0});break;case"btn btn-primary btn-success accept-friend-button btn-sm":e.empty(),e.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Friend added'),e.attr("disabled","disabled"),Messenger().post({message:s.message,type:"success",showCloseButton:!0}),e.closest(".panel-default").parents(".item").fadeOut(300),0==s.count&&e.parents(".col-md-12").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');break;case"btn btn-primary btn-danger del-friend-button btn-sm":e.closest(".panel-default").parents(".item").fadeOut(300),Messenger().post({message:s.message,type:"success",showCloseButton:!0}),0==s.count&&e.parents(".col-md-12").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friend requests.</div>');break;case"btn btn-danger del-friend-button":e.removeClass(),e.addClass("btn btn-success send-friend-request-button"),e.attr("href",n+"/requests"),e.attr("data-method","POST"),e.data("method","POST"),e.empty(),e.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Add friend');break;case"btn btn-success send-friend-request-button":e.empty(),e.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;Requested'),e.attr("disabled","disabled"),Messenger().post({message:s.message,type:"success",showCloseButton:!0});break;case"btn btn-primary unfriend-button-3 btn-sm":e.closest(".listed-object-close").slideUp(),$("a[data-username="+e.attr("data-username")+"]").hide("slide",{direction:"right"},300),0==s.count&&($(".users-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>'),$("#friend-side-list").hide(),$("#friend-list").append('<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don\'t have any friends.</div>'));var t=$(".friends-count").text(),a=parseInt(t)-1;$(".friends-count").text(a);break;case"logout-link":$("#no-friend-chat-alert").is(":visible")?window.location.replace("/"):($(".side-list").each(function(){var e=$(this).attr("data-username");sessionStorage.removeItem("conversation-with-"+e)}),window.location.replace("/"))}else"failed"==s.response?Messenger().post({message:s.message,type:"error",showCloseButton:!0}):Messenger().post({message:"Something went wrong. Please try again.",type:"error",showCloseButton:!0})}).fail(function(e){"failed"==e.response&&Messenger().post({message:e.message,type:"error",showCloseButton:!0}),console.log(e),Messenger().post({message:"Something went wrong. Please try again.",type:"error",showCloseButton:!0})}),!1}$(".add-friend-request-button").click(e),$(".users-list").on("click",".accept-friend-button",e),$(".users-list").on("click",".del-friend-button",e),$(".profile-userpic").on("click",".send-friend-request-button",e),$(".profile-userpic").on("click",".del-friend-button",e)}(jQuery);