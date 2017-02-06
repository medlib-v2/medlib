    /**
     *
     * @type type Medlib.WebSocket()
     */
    Medlib.plugin('WebSocket', function(){
        return {
            main: function () {
                var template = '<h4><i class="icon fa fa-eye-slash"></i>' + trans('app.socket_error') + '</h4><p>'
                    + trans('app.socket_error_info') + '</p>',
                    socket = {};

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
                /**
                socket.listener = io.connect(Setting.socket_url, {
                    query: 'jwt=' + Setting.jwt
                });

                **/

                /**
                 * Status connexion
                 * @type {boolean}
                 */
                socket.connectionError = false;
                /**
                socket.listener.on('connect_error', function(error) {
                    console.error(error);
                    if (!socket.connectionError) {
                        $('#socket_offline').addClass('alert alert-danger').html(template).fadeIn(300);
                    }
                    socket.connectionError = true;
                });

                socket.listener.on('connect', function() {
                    $('#socket_offline').fadeOut(300);
                    socket.connectionError = false;
                });

                socket.listener.on('reconnect', function() {
                    $('#socket_offline').fadeOut(300);
                    Medlib.connectionError = false;
                });

                socket.listener.emit('register', {'user_id': me.id});
                **/
            }
        }
    });