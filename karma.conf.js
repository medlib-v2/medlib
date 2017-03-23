let webpackConfig = require('./resources/assets/js/tests/webpack');
let basePath = './resources/assets/js/';
/**
 * Karma configuration
 *
 * @param karma
 */
module.exports = function(karma) {
    karma.set({

        /**
         * include mocha first in used frameworks
         */
        frameworks: ['mocha', 'sinon-chai'],

        colors: true,

        basePath: basePath,
        /**
         * see what is going on
         * Options: LOG_DISABLE, LOG_ERROR, LOG_WARN, LOG_INFO, LOG_DEBUG
         */
        logLevel: karma.LOG_DEBUG,

        browsers: ['PhantomJS'],

        /**
         * list of files / patterns to load in the browser
         * The pattern just says load all files within a
         * tests directory including subdirectories
         **/
        files: [
            '../../../node_modules/babel-polyfill/dist/polyfill.js',
            //{ pattern: 'tests/**/*.spec.js', watched: false },
            { pattern: 'tests/unit/index.js', watched: false },
        ],

        /**
         * list of files to exclude
         */
        exclude: [
            'node_modules'
        ],

        plugins: [
            'karma-mocha',
            'karma-webpack',
            'karma-coverage',
            'karma-sinon-chai',
            'karma-spec-reporter',
            'karma-sourcemap-loader',
            'karma-phantomjs-launcher',
            'karma-babel-preprocessor',
        ],

        babelPreprocessor: {
            options: {
                presets: ['es2015'],
                sourceMap: 'inline'
            },
        },

        reporters: ['spec', 'coverage'],

        /**
         * add preprocessor to the files that should be
         * processed via webpack
         */
        preprocessors: {
            'app.js': ['webpack'],
            //'tests/**/*.spec.js': ['webpack', 'sourcemap'],
            'tests/unit/index.js': ['webpack', 'sourcemap']
        },
        webpack: webpackConfig,
        webpackMiddleware: {
            noInfo: true,
            stats: 'errors-only'
        },
        coverageReporter: {
            dir: './coverage',
            reporters: [
                { type: 'html', subdir: 'html' },
                { type: 'lcov', subdir: '.' },
                { type: 'text-summary' }
            ]
        },

        /**
         * use autoWatch=true for quick and easy test re-execution once files change
         */
        autoWatch: true,

        /**
         * if you want to continuously re-run tests on file-save,
         * replace the following line with `autoWatch: true`
         */
        singleRun: true,

        /**
         * Concurrency level
         * How many browser should be started simultaneous
         */
        concurrency: Infinity,
    });
};