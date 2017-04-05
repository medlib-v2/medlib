let Redis = require('ioredis'),
    Log = require('./../log');

class RedisSubscriber {
    /**
     * Create a new instance of subscriber.
     *
     * @param {any} options
     */
    constructor(options) {
        /**
         * Redis pub/sub client.
         *
         * @type {object}
         */
        this._redis = new Redis(options.databaseConfig.redis);
    }

    /**
     * Subscribe to events to broadcast.
     *
     * @return {Promise}
     */
    subscribe(callback) {
        return new Promise((resolve, reject) => {
            this._redis.on('pmessage', (subscribed, channel, message) => {
                try {
                    message = JSON.parse(message);

                    if (message.event.indexOf('RestartSocketServer') !== -1) {
                        if (this.options.devMode) {
                            Log.info('Restart command received');
                        }
                        process.exit();
                        return;
                    }
                    if (this.options.devMode) {
                        Log.info("Channel: " + channel);
                        Log.info("Event: " + message.event);
                    }
                    callback(channel, message);
                    console.log('CHANNEL', channel)
                } catch (e) {
                    Log.info("No JSON message");
                }
            });
            this._redis.psubscribe('*', (err, count) => {
                if (err) {
                    reject('Redis could not subscribe.')
                }
                Log.success('Listening for redis events...');
                resolve();
            });
            this._redis.on('error', (err) => {
                if (err) {
                    reject('Redis could not subscribe.')
                }
            });
            this._redis.on('ready', () => {
                Log.info("Redis is running");
                resolve();
            });
        });
    }
}

module.exports = RedisSubscriber;
