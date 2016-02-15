$(document).ready(function(){
    $(".search-db1").keyup(function()
    {
        var searchbox = $(this).val();
        var dataString = 'searchword='+ searchbox;
        if(searchbox=='')
        {}
        else
        {
            $.ajax({
                type: "GET",
                source: "/dashboard/search",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#display").html(html).show();
                }
            });
        }
        return false;
    });
});
