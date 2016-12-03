// Karma configuration

/**
 * npm install --save-dev karma-browserify browserify watchify
 * @param karma
 */
module.exports = function(karma) {
    karma.set({

        /**
         * include browserify first in used frameworks
         */
        frameworks: [ 'browserify', 'jasmine' ],

        colors: true,

        /**
         * see what is going on
         */
        logLevel: karma.LOG_DEBUG,

        /**
         * use autoWatch=true for quick and easy test re-execution once files change
         */
        autoWatch: true,

        browsers: ['Chrome'], //'PhantomJS', 'Firefox',

        /**
         * base path that will be used to resolve all patterns (eg. files, exclude)
         * This should be your JS Folder where all source javascript
         * files are located.
         */
         basePath: './resources/assets/js/',

        /**
         * list of files / patterns to load in the browser
         * The pattern just says load all files within a
         * tests directory including subdirectories
         **/
        files: [
            {pattern: 'tests/**/*.js', watched: false}
        ],

        /**
         * add additional browserify configuration properties here
         * such as transform and/or debug=true to generate source maps
         */
        browserify: {
            debug: true,
            transform: [ ['reactify', {'es6': true}], 'coffeeify', 'brfs' ],
            configure: function(bundle) {
                bundle.on('prebundle', function() {
                    bundle.external('foobar');
                    bundle.transform('babelify').plugin('proxyquireify/plugin');
                });
            },
            plugin: [require('proxyquireify').plugin]
        },
        /**
         * list of files to exclude
         */
        exclude: [
        ],

        /**
         * add preprocessor to the files that should be
         * processed via browserify
         */
        preprocessors: {
            'app.js': ['browserify', 'babel'],
            'tests/**/*.spec.js': [ 'browserify', 'babel' ]
        }
    });
};