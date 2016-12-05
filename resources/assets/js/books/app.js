let Backbone = require('backbone');
    Backbone.$ = window.jQuery;
let Router = require('./routers/routes'),
    /**
     * Instiantiate the router
     */
    router = new Router();
/**
 * Start Backbone history for bookmarkable URL's
 */
Backbone.history.start();