(function(){
    'use strict';

    /**
     * Radio Buttons Path Filter DTO
     * @constructor
     * @param {string} path
     * @param {boolean} selected
     */
    jQuery.fn.beList.controls.RadioButtonsPathFilterDTO = function(path, selected){

        return {
            path: path
            ,type: 'text'
            ,filterType: 'path'
            ,selected: selected
        };
    };

})();

