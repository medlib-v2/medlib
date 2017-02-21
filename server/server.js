let jwt = require('jsonwebtoken'),
    fs = require('fs'),
    logger = require('winston'),
    clients = {},
    server;

/**
 * Logger config
 */
logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, { colorize: true, timestamp: true });

require('dotenv').load();

let debug = (process.env.APP_DEBUG === 'true' || process.env.APP_DEBUG === true),
    Redis = require('ioredis'),
    redis = new Redis({
        port: process.env.REDIS_PORT || 6379,
        host: process.env.REDIS_HOST || '127.0.0.1',
        db: process.env.REDIS_DATABASE || 0,
        password: process.env.REDIS_PASSWORD || null
    });

if (/^https/i.test(process.env.SOCKET_URL)) {
    let ssl_conf = {
        key:  (process.env.SOCKET_SSL_KEY_FILE  ? fs.readFileSync(process.env.SOCKET_SSL_KEY_FILE)  : null),
        cert: (process.env.SOCKET_SSL_CERT_FILE ? fs.readFileSync(process.env.SOCKET_SSL_CERT_FILE) : null),
        ca:   (process.env.SOCKET_SSL_CA_FILE   ? fs.readFileSync(process.env.SOCKET_SSL_CA_FILE)   : null)
    };
    server = require('https').createServer(ssl_conf, handler);
} else {
    server = require('http').createServer(handler);
}

let io  = require('socket.io')(server);

server.listen(parseInt(process.env.SOCKET_PORT), function() {
    if (debug) {
        logger.info('Server is running! ', process.env.SOCKET_URL ,process.env.SOCKET_PORT);
    }
});

function handler(req, res) {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.writeHead(200);
    res.end('');
}

/**
 * Middleware to check the JWT
 */
io.use(function(socket, next) {
    let decoded;

    logger.info('socket', socket.handshake);

    if (debug) {
        logger.info('Token - ' + socket.handshake.query.jwt);
    }

    try {
        decoded = jwt.verify(socket.handshake.query.jwt, process.env.JWT_SECRET);

        if (debug) {
            logger.info(decoded);
        }

    } catch (err) {
        if (debug) {
            logger.error(err);
        }

        next(new Error('Invalid token!'));
    }

    if (decoded) {
        /**
         * everything went fine - save user_id as property of given connection instance
         */
        socket.user_id = decoded.data.user_id;
        next();
    } else {
        /**
         * invalid token - terminate the connection
         */
        next(new Error('Invalid token!'));
    }
});

io.on('connection', function(socket) {
    // io.emit('chat.message', 'User joined the chat');
    /**
     * Regiter a client based on user_id
     */
    socket.on('register', function(data) {
        if (clients[data.user_id] && clients[data.user_id].sockets instanceof Array) {
            /**
             * if user is already registered
             * with one or many socket clients,
             * just push socket id to array of sockets
             */
            clients[data.user_id].sockets.push(socket.id);

        } else {
            /**
             * if it is the first socket client
             * add an array and push socket id
             * @type {{sockets: Array}}
             */
            clients[data.user_id] = { sockets: []};

            clients[data.user_id].sockets.push(socket.user_id);
        }
        if (debug) {
            logger.info('connection -> user_id = ' + data.user_id +' socket_id = ' + socket.user_id);
        }
    });

    socket.on('broadcast', function (data) {

        /**
         * When LAMP server broadcast look for user in list of clients
         */
        if(clients[data.user_id]) {
            for(var soct in clients[data.user_id].sockets) {

                /**
                 * Proxy event to all connected sockets
                 */
                io.sockets.connected[clients[data.user_id].sockets[soct]].emit(data.receiver_id, data);

                if (debug) {
                    logger.info('New data was sent = ' + JSON.stringify(data));
                }
            }
        }
        else
        {
            if (debug) {
                logger.info('user_id is not open for communication: ' + data.user_id);
            }
        }
    });

    /**
     * message sent
     */
    socket.on('chat.message', function(message) {
        /**
         * broadcast message to all listeners
         */
        io.emit('chat.message', message);
    });

    socket.on('disconnect', function () {

        // io.emit('chat.message', 'User has disconnected');
        /**
         * when socket  disconnects remove socket from list of sockets
         */
        for(var name in clients) {

            for (var soct in clients[name].sockets) {

                if(clients[name].sockets[soct] === socket.user_id) {
                    /**
                     * remove socket from array of sockets
                     */
                    clients[name].sockets.splice(soct, 1);

                    if (debug) {
                        logger.info('socket removed');
                    }

                    /**
                     * if no more sockets are connected
                     * remove user from list of clients
                     */
                    if (clients[name].sockets.length === 0) {
                        delete clients[name];

                        if (debug) {
                            logger.info('user_id completely removed');
                        }
                    }
                    break;
                }
            }
        }
    });
});

redis.psubscribe('*', function(err, count) {
    if (debug) {
        logger.info('subscribe');

        if(err) throw err;

        logger.info("count: " + count);
    }
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);

    if (message.event.indexOf('RestartSocketServer') !== -1) {

        if (debug) {
            logger.info('Restart command received');
        }

        process.exit();
        return;
    }

    if (debug) {
        logger.info('Message received from event ' + message.event + ' to channel ' + channel);
    }

    //channel + ':' + message.event
    const emitChannel = `${channel}:${message.event}`;
    io.emit(emitChannel, message.data);
});

redis.on('error', function(err) {
    if(err) throw err;
    logger.info("Redis is not running");
});

redis.on('ready', function(){
    logger.info("Redis is running");
});
