(function($){
    function pageLoad(){
        $('.widget').widgster();
        $('[data-toggle=tooltip]').tooltip();
        $('[data-toggle=popover]').popover();
    }
    pageLoad();
    MedlibApp.onPageLoad(pageLoad);
})(jQuery);