let request = require('request'),
    Channel = require('./index'),
    Log = require('./../log');

class PrivateChannel {
    /**
     * Create a new private channel instance.
     */
    constructor(options) {
        /**
         * Options.
         *
         * @type {Object}
         */
        this.options = options;

        /**
         * Request client.
         *
         * @type {Object}
         */
        this.request = request;
    }

    /**
     * Send authentication request to application server.
     *
     * @param  {object} socket
     * @param  {object} data
     * @return {Promise}
     */
    authenticate(socket, data) {
        let options = {
            url: this.authHost() + this.options.authEndpoint,
            form: {channel_name: data.channel},
            headers: (data.auth && data.auth.headers) ? data.auth.headers : {},
            rejectUnauthorized: false
        };
        return this.serverRequest(socket, options);
    }

    /**
     * Get the auth endpoint.
     *
     * @return {string}
     */
    authHost() {
        return (this.options.authHost) ?
            this.options.authHost : this.options.host;
    }

    /**
     * Send a request to the server.
     *
     * @param  {Object} socket
     * @param  {object} options
     * @return {Promise}
     */
    serverRequest(socket, options) {
        return new Promise((resolve, reject) => {
            options.headers = this.prepareHeaders(socket, options);
            let body;

            this.request.post(options, (error, response, body, next) => {
                if (error) {
                    if (this.options.devMode) {
                        Log.error(`[${new Date().toLocaleTimeString()}] - Error authenticating ${socket.id} for ${options.form.channel_name}`);
                    }

                    Log.error(error);

                    reject({reason: 'Error sending authentication request.', status: 0});
                } else if (response.statusCode !== 200) {
                    if (this.options.devMode) {
                        Log.warning(`[${new Date().toLocaleTimeString()}] - ${socket.id} could not be authenticated to ${options.form.channel_name}`);
                        Log.error(response.body);
                    }

                    reject({
                        reason: 'Client can not be authenticated, got HTTP status ' + response.statusCode,
                        status: response.statusCode
                    });
                } else {
                    if (this.options.devMode) {
                        Log.info(`[${new Date().toLocaleTimeString()}] - ${socket.id} authenticated for: ${options.form.channel_name}`);
                    }

                    try {
                        body = JSON.parse(response.body);
                    } catch (e) {
                        body = response.body
                    }

                    resolve(body);
                }
            });
        });
    }

    /**
     * Prepare headers for request to app server.
     *
     * @param  {object} options
     * @return {any}
     */
    prepareHeaders(socket, options) {
        options.headers['Cookie'] = socket.request.headers.cookie;
        options.headers['X-Requested-With'] = 'XMLHttpRequest';

        return options.headers;
    }
}

module.exports = PrivateChannel;