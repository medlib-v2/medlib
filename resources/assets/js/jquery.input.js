(function($){

    $.fn.addHidden = function (name, value) {
        return this.each(function () {
            var input = $("<input>").attr("id", "hidden-input").attr("type", "hidden").attr("name", name).val(value);
            $(this).append($(input));
        });

        return this;
    }
})(jQuery);