(function($){
    function pageLoad(){
        $('.widget').widgster();
    }
    pageLoad();
    MedlibApp.onPageLoad(pageLoad);
})(jQuery);