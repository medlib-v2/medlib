$(function(){function e(e){s=e.target.files}function t(e){e.preventDefault();var t=$(this),o=$("#image").parent(".image"),a=$("#videoUrl").parent(".video"),n=$("#geocomplete").parent(".place");return o.hideLoader("hide"),a.hideLoader("hide"),n.hideLoader("hide"),$("input[name='shareType']").val(t.attr("id")),"video"==t.attr("id")&&(a.showLoader("hide"),o.hideLoader("hide"),n.hideLoader("hide")),"photos"==t.attr("id")&&(a.hideLoader("hide"),o.showLoader("hide"),n.hideLoader("hide")),"place"==t.attr("id")&&(a.hideLoader("hide"),o.hideLoader("hide"),n.showLoader("hide")),!1}function o(){$("div.postloader").html('<img src="http://medlib-v2.lan/images/ajax-loader.gif">'),$.post("getData.php?lastID="+$(".post-list:last").attr("id"),function(e){""!=e&&$(".post-list:last").after(e),$("div.postloader").empty()})}function a(e){e.stopPropagation(),e.preventDefault();var t=$(this),o=t.attr("action"),a=t.attr("method")||"POST",r=t.find("input[name='_token']").val(),l={},d=t.find("input[name='shareType']"),p=t.find("textarea"),m=t.find("input[name='senderName']"),c=t.find("input[name='senderProfileImage']"),h=t.find("input[name='image']"),u=t.find("input[name='videoUrl']"),g=t.find("input[name='location']"),f=t.find("#geocomplete"),v=t.find("#map_can");l.lat=t.find("input[name='lat']").val(),l.lng=t.find("input[name='lng']").val();var w=window.FormData?new FormData:null,L=null!==w?w:t.serialize();if(L.append("_token",r),L.append(m.attr("name"),m.val()),L.append(c.attr("name"),c.val()),""==p.val()&&"body"==p.attr("name"))return Messenger().post({message:"Please write something.",type:"error",showCloseButton:!0}),!1;if(L.append(p.attr("name"),p.val()),"photos"==d.val()){var y=h.val();if(""==y)return Messenger().post({message:"<span class='error'>Please Browse to upload a valid image file</span><h2>Note</h2><span class='error_message'>Only JPEG, JPG and PNG Images type allowed</span>",type:"error",showCloseButton:!0}),!1;var b=["image/jpeg","image/png","image/jpg"],C=s[0].type;if(C!=b[0]&&C!=b[1]&&C!=b[2])return Messenger().post({message:"<span class='error'>Please select a valid image file</span><h2>Note</h2><span class='error_message'>Only JPEG, JPG and PNG Images type allowed</span>",type:"error",showCloseButton:!0}),!1;$.each(s,function(e,t){L.append(h.attr("name"),t)})}if("video"==d.val()){if(""==u.val()&&"videoUrl"==u.attr("name"))return Messenger().post({message:"Video Url could not be empty",type:"error",showCloseButton:!0}),!1;var P=n(u);if(0==P)return Messenger().post({message:"Not a valid <b>Youtube/Vimeo</b> video URL",type:"error",showCloseButton:!0}),!1;L.append(u.attr("name"),u.val())}if("place"==d.val()){if(""==g.val()&&"location"==g.attr("name"))return Messenger().post({message:"Place could not be empty.",type:"error",showCloseButton:!0}),!1;if(""==l.lat||""==l.lng)return console.log(l.lng.val()),Messenger().post({message:"Not a valid place.",type:"error",showCloseButton:!0}),!1;L.append(g.attr("name"),JSON.stringify(l))}i(o,a,L).done(function(e){console.log("Done :",e)}).fail(function(e){Messenger().post({message:e.responseText,type:"error",showCloseButton:!0})}),p.resetForm(),h.resetForm().hideLoader("hide"),u.resetForm().hideLoader("hide"),g.resetForm().hideLoader("hide"),d.val("status"),v.hideLoader("hide"),f.showLoader("hide"),f.parent(".place").hideLoader("hide")}function n(e){var t=e.val(),o=/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/,a=/^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;return!(!o.test(t)&&!a.test(t))}function i(e,t,o){return $.ajax({url:e,type:t,contentType:!1,processData:!1,dataType:"json",data:o})}function r(e){e.preventDefault();var t=$("#map_can");t.showLoader("hide")}$.fn.showLoader=function(e){$(this).removeClass(e)},$.fn.hideLoader=function(e){$(this).addClass(e)},$.fn.getLocation=function(e){$("#geoLoader").html("<img src='"+e+"images/ajax.gif' class='padding10'/> Loading Geo Location"),navigator.geolocation?(navigator.geolocation.getCurrentPosition(r),this.showLoader("hide")):x.innerHTML="Geolocation is not supported by this browser."},$.fn.resetForm=function(){var e=/^(?:color|date|datetime|email|month|number|hidden|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var t=this.type,o=this.tagName.toLowerCase();return"form"==o?$(":input",this).resetForm():void(e.test(t)||"textarea"==o?$(this).val(""):"checkbox"==t||"radio"==t?$(this).checked=!1:"select-multiple"==t||"select-one"==t||"select"==o?$(this).selectedIndex=-1:"file"==t?/MSIE/.test(navigator.userAgent)?$(this).replaceWith($(this).clone(!0)):$(this).val(""):"hidden"==t&&$(this).val(""))})},$(window).scroll(function(){$(window).scrollTop()==$(document).height()-$(window).height()&&o()});var s;$("#geocomplete").geocomplete({map:".map_canvas",details:"form",types:["geocode","establishment"],mapOptions:{zoom:8,disableDefaultUI:!0,draggable:!1,zoomControl:!0,zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL}},markerOptions:{animation:google.maps.Animation.DROP,flat:!0}}),$("#center-column").on("click","#status",t),$("#center-column").on("click","#photos",t),$("#center-column").on("click","#video",t),$("#center-column").on("click","#place",t),$("#center-column").on("submit","form",a),$("#center-column").on("change","input[type=file]",e),$("#center-column").on("change","#geocomplete",r)});