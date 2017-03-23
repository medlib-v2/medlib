let fs = require('fs');
let colors = require("colors");
let ServerIO = require('./server-io');
let inquirer = require('inquirer');
const crypto = require('crypto');
const CONFIG_FILE = process.cwd() + '/server-io.json';

/**
 * MEDLIB Server IO CLI
 */
class Cli {
    /**
     * Create new CLI instance.
     */
    constructor() {
        /**
         * Default config options.
         *
         * @type {Object}
         */
        this.defaultOptions = ServerIO.defaultOptions;
    }

    /**
     * Initialize server with a configuration file.
     *
     * @param  {Object} yargs
     * @return {void}
     */
    init(yargs) {
        this.setupConfig().then((options) => {
            options = Object.assign({}, this.defaultOptions, options);

            if (options.addClient) {
                let client = {
                    appId: this.createAppId(),
                    key: this.createApiKey()
                };
                options.clients.push(client);

                console.log('appId: ' + colors.magenta(client.appId));
                console.log('key: ' + colors.magenta(client.key));
            }

            this.saveConfig(options).then(() => {
                console.log('Configuration file saved. Run ' + colors.magenta.bold('server start') + ' to run server.');

                process.exit();
            }, (error) => {
                console.error(colors.error(error));
            });
        }, error => console.error(error));
    }

    /**
     * Setup configuration with questions.
     *
     * @return {Promise}
     */
    setupConfig() {
        return inquirer.prompt([
            {
                name: 'devMode',
                default: false,
                message: 'Do you want to run this server in development mode?',
                type: 'confirm'
            }, {
                name: 'port',
                default: '6001',
                message: 'Which port would you like to serve from?'
            }, {
                name: 'database',
                message: 'Which database would you like to use to store presence channel members?',
                type: 'list',
                choices: ['redis', 'sqlite']
            }, {
                name: 'authHost',
                default: 'http://127.0.0.1',
                message: 'Enter the host of your Laravel authentication server.',
            }, {
                name: 'protocol',
                message: 'Will you be serving on http or https?',
                type: 'list',
                choices: ['http', 'https']
            }, {
                name: 'sslConfig.cert',
                message: 'Enter the path to your SSL cert file.',
                when: function(options) {
                    return options.protocol == 'https';
                }
            }, {
                name: 'sslConfig.key',
                message: 'Enter the path to your SSL key file.',
                when: function(options) {
                    return options.protocol == 'https';
                }
            }, {
                name: 'addClient',
                default: false,
                message: 'Do you want to generate a client ID/Key for HTTP API?',
                type: 'confirm'
            }
        ]);
    }

    /**
     * Save configuration file.
     *
     * @param  {Object} options
     * @return {Promise}
     */
    saveConfig(options) {
        let opts = {};

        Object.keys(options).filter(k => {
            return Object.keys(this.defaultOptions).indexOf(k) >= 0;
        }).forEach(option => opts[option] = options[option]);

        return new Promise((resolve, reject) => {
            if (opts) {
                fs.writeFile(
                    CONFIG_FILE,
                    JSON.stringify(opts, null, '\t'),
                    (error) => (error) ? reject(error) : resolve());
            } else {
                reject('No options provided.')
            }
        });
    }

    /**
     * Start the Laravel Echo server.
     *
     * @param  {Object} yargs
     * @return {void}
     */
    start(yargs) {
        let dir = yargs.argv.dir ? yargs.argv.dir.replace(/\/?$/, '/') : null;
        let configFile = dir ? dir + 'server-io.json' : CONFIG_FILE;

        fs.access(configFile, fs.F_OK, (error) => {
            if (error) {
                console.error(colors.error('Error: server-io.json file not found.'));

                return false;
            }

            let options = JSON.parse(fs.readFileSync(configFile, 'utf8'));

            options.devMode = yargs.argv.dev || options.devMode || false;

            ServerIO.run(options);
        });
    }

    /**
     * Create an app key for server.
     *
     * @return {string}
     */
    getRandomString(bytes) {
        return crypto.randomBytes(bytes).toString('hex');
    }

    /**
     * Create an api key for the HTTP API.
     *
     * @return {string}
     */
    createApiKey() {
        return this.getRandomString(16);
    }

    /**
     * Create an api key for the HTTP API.
     *
     * @return {string}
     */
    createAppId() {
        return this.getRandomString(8);
    }

    /**
     * Add a registered referrer.
     *
     * @param  {Object} yargs
     * @return {void}
     */
    clientAdd(yargs) {
        let options = JSON.parse(fs.readFileSync(CONFIG_FILE, 'utf8'));
        let appId = yargs.argv._[1] || this.createAppId();
        options.clients = options.clients || [];

        if (appId) {
            let index = null;
            let client = options.clients.find((client, i) => {
                index = i;
                return client.appId == appId;
            });

            if (client) {
                client.key = this.createApiKey();

                options.clients[index] = client;

                console.log(colors.green('API Client updated!'));
            } else {
                client = {
                    appId: appId,
                    key: this.createApiKey()
                };

                options.clients.push(client);

                console.log(colors.green('API Client added!'));
            }

            console.log(colors.magenta('appId: ' + client.appId));
            console.log(colors.magenta('key: ' + client.key))

            this.saveConfig(options);
        }
    }

    /**
     * Remove a registered referrer.
     *
     * @param  {Object} yargs
     * @return {void}
     */
    clientRemove(yargs) {
        let options = JSON.parse(fs.readFileSync(CONFIG_FILE, 'utf8'));
        let appId = yargs.argv._[1] || null;
        options.clients = options.clients || [];

        let index = null;

        let client = options.clients.find((client, i) => {
            index = i;
            return client.appId == appId;
        });

        if (index >= 0) {
            options.clients.splice(index, 1);
        }

        console.log(colors.green('Client removed: ' + appId));

        this.saveConfig(options);
    }
}

module.exports = Cli;
