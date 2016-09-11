define(function(require) {
    'use strict';
    var Backbone = require('backbone'),
        Router = require('app/routers/Routes');
    //Instiantiate the router
    var app = new Router();
    // Start Backbone history for bookmarkable URL's
    Backbone.history.start();
});