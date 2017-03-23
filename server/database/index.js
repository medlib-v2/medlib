let RedisDatabase = require('./redis'),
    SQLiteDatabase = require('./sqlite'),
    Log = require('./../log');

/**
 * Class that controls the key/value data store.
 */
class Database {
    /**
     * Create a new database instance.
     *
     * @param  {any} options
     */
    constructor(options) {
        if (options.database == 'redis') {
            this.driver = new RedisDatabase(options);
        } else if (options.database == 'sqlite') {
            this.driver = new SQLiteDatabase(options);
        } else {
            Log.error('Database driver not set.');
        }
    }

    /**
     * Get a value from the database.
     *
     * @return {Promise}
     */
    get(key) {
        return this.driver.get(key)
    };

    /**
     * Set a value to the database.
     *
     * @return {Promise}
     */
    set(key, value) {
        this.driver.set(key, value);
    };
}

module.exports = Database;