    if ( typeof module === 'object' && typeof module.exports === 'object' ) {
        module.exports = Medlib;
        // AMD
    } else if ( typeof define === 'function' && define.amd) {
        define( [], function () {
            return Medlib;
        } );
        // window
    } else if ( !window.Medlib ) {
        window.Medlib = Medlib;
    }

})(jQuery, window, document, undefined, FastClick);
