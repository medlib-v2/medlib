let Server = require('./server'),
    fs = require('fs'),
    dotenv = require('dotenv'),
    Log = require('./log'),
    RedisSubscriber = require('./subscribers'),
    Channel = require('./channels');

const packageFile = require('./package.json');
require('dotenv').load();

class ServerIO {
    /**
     * Create a new instance.
     */
    constructor() {
        /**
         * Default server options.
         *
         * @type {Object}
         */
        this.defaultOptions = {
            authHost: 'http://127.0.0.1',
            authEndpoint: '/broadcasting/auth',
            clients: [],
            database: 'redis',
            databaseConfig: {
                redis: {
                    port: process.env.REDIS_PORT || 6379,
                    host: process.env.REDIS_HOST || '127.0.0.1',
                    db: process.env.REDIS_DATABASE || 0,
                    password: process.env.REDIS_PASSWORD || null
                },
                sqlite: {
                    databasePath: '/database/server-io.sqlite'
                }
            },
            devMode: (process.env.APP_DEBUG === 'true' || process.env.APP_DEBUG === true),
            host: process.env.SOCKET_URL || '127.0.0.1',
            port: process.env.SOCKET_PORT || 6001,
            protocol: "http",
            socketio: {},
            sslConfig: {
                key: (process.env.SOCKET_SSL_KEY_FILE ? fs.readFileSync(process.env.SOCKET_SSL_KEY_FILE) : null),
                cert: (process.env.SOCKET_SSL_CERT_FILE ? fs.readFileSync(process.env.SOCKET_SSL_CERT_FILE) : null),
                ca: (process.env.SOCKET_SSL_CA_FILE ? fs.readFileSync(process.env.SOCKET_SSL_CA_FILE) : null)
            }
        };

        /**
         * Configurable server options.
         *
         * @type {Object}
         */
        this.options = {};

        /**
         * Socket.io server instance.
         *
         * @type {Server}
         */
        this.server = null;

        /**
         * Channel instance.
         *
         * @type {Channel}
         */
        this.channel = null;

        /**
         * Redis subscriber instance.
         *
         * @type {RedisSubscriber}
         */
        this.redisSub = null;
    }

    /**
     * Start the Server IO.
     *
     * @param  {Object} options
     * @return {Promise}
     */
    run(options) {
        return new Promise((resolve, reject) => {
            this.options = Object.assign(this.defaultOptions, options);
            this.startup();
            this.server = new Server(this.options);
            this.server.init().then(io => {
                this.init(io).then(() => {
                    Log.info('\nServer ready!\n');
                    resolve(this);
                }, error => Log.error(error));
            }, error => Log.error(error));
        });
    }

    /**
     * Initialize the class
     *
     * @param {Socket} io
     */
    init(io) {
        return new Promise((resolve, reject) => {
            this.channel = new Channel(io, this.options);
            this.redisSub = new RedisSubscriber(this.options);
            this.onConnect();
            this.listen().then(() => resolve());
        });
    }

    /**
     * Text shown at startup.
     *
     * @return {void}
     */
    startup() {
        Log.title(`\nM E D L I B   S E R V E R    I O \n`);
        Log.info(`version ${packageFile.version}\n`);
        if (this.options.devMode) {
            Log.warning('Starting server in DEV mode...\n');
        } else {
            Log.info('Starting server...\n')
        }
    }

    /**
     * Listen for incoming event from subscibers.
     *
     * @return {Promise}
     */
    listen() {
        return new Promise((resolve, reject) => {
            let redis = this.redisSub.subscribe((channel, message) => {
                return this.broadcast(channel, message);
            });
            Promise.all([redis]).then(() => resolve());
        });
    }

    /**
     * Return a channel by its socket id.
     *
     * @param  {string} socket_id
     * @return {any}
     */
    find(socket_id) {
        return this.server.io.sockets.connected[socket_id];
    }

    /**
     * Broadcast events to channels from subscribers.
     *
     * @param  {string} channel
     * @param  {any} message
     * @return {boolean}
     */
    broadcast(channel, message) {
        if (message.socket && this.find(message.socket)) {
            return this.toOthers(this.find(message.socket), channel, message);
        } else {
            return this.toAll(channel, message);
        }
    }

    /**
     * Broadcast to others on channel.
     *
     * @param  {Socket} socket
     * @param  {string} channel
     * @param  {any} message
     * @return {boolean}
     */
    toOthers(socket, channel, message) {
        socket.broadcast.to(channel)
            .emit(message.event, channel, message.data);

        return true
    }

    /**
     * Broadcast to all members on channel.
     *
     * @param  {string} channel
     * @param  {any} message
     * @return {boolean}
     */
    toAll(channel, message) {
        this.server.io.to(channel)
            .emit(message.event, channel, message.data);

        return true
    }

    /**
     * On server connection.
     *
     * @return {void}
     */
    onConnect() {
        this.server.io.on('connection', socket => {
            this.onSubscribe(socket);
            this.onUnsubscribe(socket);
            this.onDisconnecting(socket);
            this.onClientEvent(socket);
        });
    }

    /**
     * On subscribe to a channel.
     *
     * @param  {object} socket
     * @return {void}
     */
    onSubscribe(socket) {
        socket.on('subscribe', data => {
            this.channel.join(socket, data);
        });
    }

    /**
     * On unsubscribe from a channel.
     *
     * @param  {object} socket
     * @return {void}
     */
    onUnsubscribe(socket) {
        socket.on('unsubscribe', data => {
            this.channel.leave(socket, data.channel, 'unsubscribed');
        });
    }

    /**
     * On socket disconnecting.
     *
     * @return {void}
     */
    onDisconnecting(socket) {
        socket.on('disconnecting', (reason) => {
            Object.keys(socket.rooms).forEach(room => {
                if (room !== socket.id) {
                    this.channel.leave(socket, room, reason);
                }
            });
        });
    }

    /**
     * On client events.
     *
     * @param  {object} socket
     * @return {void}
     */
    onClientEvent(socket) {
        socket.on('client event', data => {
            this.channel.clientEvent(socket, data);
        });
    }
}

module.exports = new ServerIO();
