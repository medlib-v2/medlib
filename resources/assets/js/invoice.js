$(function(){

    function pageLoad(){
        $('#print').click(function(){
            window.print();
        })
    }

    pageLoad();
    MedlibApp.onPageLoad(pageLoad);

});