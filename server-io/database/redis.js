let Redis = require('ioredis');

class RedisDatabase {
    /**
     * Create a new cache instance.
     */
    constructor(options) {
        /**
         * Redis client.
         *
         * @type {object}
         */
        this._redis = new Redis(options.databaseConfig.redis);
    }

    /**
     * Retrieve data from redis.
     *
     * @param  {string}  key
     * @return {Promise}
     */
    get(key) {
        return new Promise((resolve, reject) => {
            this._redis.get(key).then(value => resolve(JSON.parse(value)));
        });
    }

    /**
     * Store data to cache.
     *
     * @param  {string} key
     * @param  {any}  value
     * @return {void}
     */
    set(key, value) {
        this._redis.set(key, JSON.stringify(value));
    }
}

module.exports = RedisDatabase;
