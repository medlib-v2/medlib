(function($){

    //$('select.select2').select2();
    $(".select2 .form-control .select2-offscreen").select2();

    function pageLoad(){
        $('#tooltip-enabled, #max-length').tooltip();
        $(".select2").each(function(){
            $(this).select2($(this).data());
        });
    }
    pageLoad();
    MedlibApp.onPageLoad(pageLoad);
})(jQuery);
