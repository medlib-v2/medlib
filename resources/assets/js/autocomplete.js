(function($){
    $(".search-db1").keyup(function() {
        var searchbox = $(this).val();
        var dataString = 'searchword='+ searchbox;
        if(searchbox !== '')  {
            $.ajax({
                type: "GET",
                source: "/dashboard/search",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#display").html(html).show();
                }
            });
        }
        return false;
    });
})(jQuery);
