!function(s){s.fn.shorten=function(e){var t={showChars:200,ellipsesText:"...",moreText:"more",lessText:"less"};return e&&s.extend(t,e),s(document).off("click",".morelink"),s(document).on({click:function(){var e=s(this);return e.hasClass("less")?(e.removeClass("less"),e.html(t.moreText)):(e.addClass("less"),e.html(t.lessText)),e.parent().prev().toggle(),e.prev().toggle(),!1}},".morelink"),this.each(function(){var e=s(this);if(!e.hasClass("shortened")){e.addClass("shortened");var n=e.html();if(n.length>t.showChars){var r=n.substr(0,t.showChars),a=n.substr(t.showChars,n.length-t.showChars),l=r+'<span class="moreellipses">'+t.ellipsesText+' </span><span class="morecontent"><span>'+a+'</span> <a href="#" class="morelink">'+t.moreText+"</a></span>";e.html(l),s(".morecontent span").hide()}}})}}(jQuery);