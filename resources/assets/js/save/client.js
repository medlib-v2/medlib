/**
 *
 * @type type Medlib.WebSocket
 */
var Medlib = (function(){
    'use strict';
    Medlib.WebSocket = function(){
        var template = '<h4><i class="icon fa fa-eye-slash"></i>' + trans('app.socket_error') + '</h4><p>'
            + trans('app.socket_error_info') + '</p>';
        /**
         * Don't need to try and connect to the web socket when not logged in
         */
        if (window.location.href.match(/login|password/) != null) {
            return;
        }

        /**
         * Register and Connect to WebSocket
         * @type {*}
         */
        Medlib.listener = io.connect(Medlib.Token.socket_url, {
            query: 'jwt=' + Medlib.Token.jwt
        });

        /**
         * Status connexion
         * @type {boolean}
         */
        Medlib.connectionError = false;

        Medlib.listener.on('connect_error', function(error) {
            console.error(error);
            if (!Medlib.connectionError) {
                $('#socket_offline').addClass('alert alert-danger').html(template).fadeIn(300);
            }

            Medlib.connectionError = true;
        });

        Medlib.listener.on('connect', function() {
            $('#socket_offline').fadeOut(300);
            Medlib.connectionError = false;
        });

        Medlib.listener.on('reconnect', function() {
            $('#socket_offline').fadeOut(300);
            Medlib.connectionError = false;
        });

        Medlib.listener.emit('register', {'user_id': user_id});
    };
    return Medlib;
})(Medlib || {});