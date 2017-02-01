    (function($, window) {
        "use strict";
        /**
         * Constructor
         * @param element
         * @param options
         * @constructor
         */
        function beSwitch(element, options) {
            this.element = $(element);
            if (options == null) {
                options = {};
            }
            this.init(options);
        }

        beSwitch.prototype = {
            init: function (options) {
                console.log(options);
            }
        };

    })(window.jQuery, window);

    /**
     *
     * @type type Medlib.Password(element, options)
     */
    Medlib.plugin('beSwitch', function(element, options){
        return {
            main: function () {
                $(element).beSwitch(options);
            }
        }
    });

    var chatStatus = jQuery('input[name="chatStatus"]');

    chatStatus.on('change', function(event, state) {
        event.preventDefault();
        console.log('chatStatus', event, state);
        jQuery.post("/caht/chatstatus", { chat_status: Number(state) } );
    });