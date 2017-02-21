let fs = require('fs'),
    http = require('http'),
    https = require('https'),
    io = require('socket.io'),
    Log = require('./log');

class Server {
    /**
     * Create a new server instance.
     */
    constructor(options) {
        this.options = options;
    }

    /**
     * Start the Socket.io server.
     *
     * @return {Promise}
     */
    init() {
        return new Promise((resolve, reject) => {
            this.serverProtocol().then(() => {
                let host = this.options.host || 'localhost';
                Log.success(`Running at ${host} on port ${this.options.port}`);
                resolve(this.io);
            }, error => reject(error));
        });
    }

    /**
     * Select the http protocol to run on.
     *
     * @return {Promise}
     */
    serverProtocol() {
        return new Promise((resolve, reject) => {
            if (this.options.protocol == 'https') {
                this.secure().then(() => {
                    resolve(this.httpServer(true));
                }, error => reject(error));
            } else {
                resolve(this.httpServer(false));
            }
        });
    }

    /**
     * Load SSL 'key' & 'cert' files if https is enabled.
     *
     * @return {Promise}
     */
    secure() {
        return new Promise((resolve, reject) => {
            if (!this.options.sslConfig.cert || !this.options.sslConfig.key) {
                reject('SSL paths are missing in server config.');
            }

            Object.assign(this.options, {
                cert: fs.readFileSync(this.options.sslConfig.cert),
                key: fs.readFileSync(this.options.sslConfig.key)
            });

            resolve(this.options);
        });
    }

    /**
     * Create a socket.io server.
     *
     * @return {any}
     */
    httpServer(secure) {
        if (secure) {
            this.server = https.createServer(this.options, this.handler);
        } else {
            this.server = http.createServer(this.handler);
        }

        this.server.listen(this.options.port, this.options.host);

        return this.io = io(this.server, this.options.socketio);
    }

    /**
     *
     * @param req
     * @param res
     */
    handler(req, res) {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.writeHead(200);
        res.end('');
    }
}

module.exports = Server;
