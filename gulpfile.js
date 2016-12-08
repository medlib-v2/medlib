require('events').EventEmitter.defaultMaxListeners = 30;

var elixir = require('laravel-elixir'),
    cssnext = require('postcss-cssnext'),
    gutils = require('gulp-util'),
    shell  = require('gulp-shell'),
    gulp   = require('gulp'),
    jQuery = require('./resources/assets/js/jquery/config.json'),
    App = require('./resources/assets/js/config.json'),
    booksApp = require('./resources/assets/js/books/config.json'),
    vue = require('./resources/assets/js/vue/config.json'),
    beList = require('./resources/assets/less/plugins/be-list/core/js/config.json'),
    sortBundele = require('./resources/assets/less/plugins/be-list/addons/sort-bundle/js/config.json'),
    textboxFilter = require('./resources/assets/less/plugins/be-list/addons/textbox-filter/js/config.json'),
    paginationBundle = require('./resources/assets/less/plugins/be-list/addons/pagination-bundle/js/config.json'),
    historyBundle = require('./resources/assets/less/plugins/be-list/addons/history-bundle/js/config.json'),
    filterToggleBundle = require('./resources/assets/less/plugins/be-list/addons/filter-toggle-bundle/js/config.json'),
    filterDropdownBundle = require('./resources/assets/less/plugins/be-list/addons/filter-dropdown-bundle/js/config.json');

require('laravel-elixir-browserify-official');
require('laravel-elixir-browsersync-official');
require('laravel-elixir-browserify-hmr');
require('laravel-elixir-uglify');
require('laravel-elixir-clean-unofficial');

var Task = elixir.Task;
elixir.extend('lang', function() {
    new Task('lang', function(){
        return gulp.src('').pipe(shell('php artisan js-localization:refresh'));
    });

});

elixir.config.js.browserify.transformers.push({
    name: 'vueify',

    options: {
        postcss: [cssnext({
            autoprefixer: {
                browsers: ['last 2 versions', 'ie >= 8', 'safari 5', 'opera 12.1', 'ios 6', 'android 4']
            }
        })]
    }
});

/**
 * elixir.config.js.browserify.watchify.enabled = true;
 * if(elixir.isWatching()){
 *  elixir.config.js.browserify.plugins.push({
 *      name: "browserify-hmr",
 *      options : {}
 *   });
 * }
 *
 * require('laravel-elixir-vueify');
 * elixir.config.js.browserify.plugins.push({
 *   name: 'vueify-extract-css',
 *   options: {
 *       out: 'path/to/extracted/bundle.css'
 *   }
 * });
 **/

/**
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir(function(mix) {
    mix //.clean()
        .less('application.less', 'public/css/application.css')
        .browserify(App.main.src, App.main.dist)
        .browserify(booksApp.src, booksApp.dist)
        .browserify(vue.cookiesBar.src, vue.cookiesBar.dist)
        .copy(jQuery.src, jQuery.dist)
        .styles([
            vue.cookiesBar.css,
            'less/plugins/select2/css/select2.css',
            'less/plugins/material-design-icons/css/material-design-iconic-font.min.css',
            'less/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css'],
            'public/css/vendors.min.css', 'resources/assets/')
        .scripts([
            'less/plugins/select2/js/select2.js',
            'less/plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js',
            'js/plugins/jquery.touchSwipe.min.js'],
            'public/js/plugins.vendor.min.js', 'resources/assets')
        .scripts(App.plugins.src, App.plugins.dist)
        .scripts(beList.src, beList.dist, 'resources/assets/less/plugins/be-list')
        .scripts(sortBundele.src, sortBundele.dist, 'resources/assets/less/plugins/be-list')
        .scripts(textboxFilter.src, textboxFilter.dist, 'resources/assets/less/plugins/be-list')
        .scripts(paginationBundle.src, paginationBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(historyBundle.src, historyBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(filterToggleBundle.src, filterToggleBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(filterDropdownBundle.src, filterDropdownBundle.dist, 'resources/assets/less/plugins/be-list')
        .uglify(['**/*.js', '!**/*.min.js', '!**/*.map'], 'public/js', {
            mangle: true,
            suffix: '.min.js'
        })
        .scripts([
            beList.dist,
            sortBundele.dist,
            textboxFilter.dist,
            paginationBundle.dist,
            historyBundle.dist,
            filterToggleBundle.dist,
            filterDropdownBundle.dist
        ], 'public/js/be-list.min.js', './')
        .version([
            'css/application.css',
            'css/vendors.min.css',
            'js/jquery.min.js',
            'js/app.min.js',
            'js/plugins.vendor.min.js',
            'js/medlib.plugins.min.js',
            'js/vue/cookiesbar.min.js',
            'js/books/app.min.js',
            'js/be-list.min.js'
        ])
        .copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/build/fonts')
        .clean([
            'public/css',
            'public/js'
        ]);
        //.lang();

    if (process.env.NODE_ENV !== 'production') {

        mix.browserSync({
            proxy: 'medlib-v2.lan',
            files: [
                elixir.config.appPath + '/**/*.php',
                elixir.config.get('public.css.outputFolder') + '/**\/*.css',
                elixir.config.get('public.versioning.buildFolder') + '/rev-manifest.json',
                'resources/views/**/*.php'
            ],
            browser: ['google chrome']
        });
    }
});
