/* 
 * Place third party dependencies in the lib folder.
 * Configure loading modules from the lib directory or CDN.
 */
requirejs.config({
    baseUrl: "js/books/",
    paths: {
        lodash: "../vendors",
        backbone: "vendor/backbone-min",
        //jquery: "vendor/jquery-3.1.0.min",
        jquery: "vendor/jquery",
        css_browser_selector: "vendor/css_browser_selector",
        modernizr: "vendor/modernizr.custom",
        text: "vendor/require.text",
        localstorage: "vendor/backbone.localstorage",
        browser: "vendor/css_browser_selector"
    },
    shim: {
        lodash: {
            exports: '_'
        },
        backbone: {
            deps: ['jquery', 'lodash'],
            exports: 'Backbone'
        },
        localstorage: {
            deps: ['lodash', 'jquery', 'backbone']
        },
        jqueryui: {
            deps: ['jquery']
        },
        'app/init': {
            deps: ['jquery', 'lodash', 'backbone', 'modernizr']
        }
    }
});

// Load the main app module to start the app
requirejs(["app/init"]);