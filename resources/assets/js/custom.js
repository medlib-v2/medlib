$(document).ready(function(){
	$("ul#nav .nav-tabs li a").click(function() {
		$("ul#nav .nav-tabs li").removeClass("selected");
		$(this).parents().addClass("selected");
		return false;
	});
});

var mImg = "../images/tree_minus.gif";
var pImg = "../images/tree_plus.gif";
$(document).ready(function(){
    $("#expandAll").click(function(){
        $(".description").slideDown();
        $(".AdvencedOptions img").attr("src", mImg)
    });

    $("#collapseAll").click(function(){
        $(".description").slideUp();
        $(".AdvencedOptions img").attr("src", pImg)
    });

    $(".AdvencedOptions").click(function(){
        var currentState = $(this).next(".description").css("display");

        if(currentState == "block"){
            $(this).next(".description").slideUp();
            $(this).children("img").attr("src", pImg).fadeIn();
        }
        else{
            $(this).next(".description").slideDown();
            $(this).children("img").attr("src", mImg).fadeIn();
        }
    });
});
