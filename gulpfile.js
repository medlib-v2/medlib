require('events').EventEmitter.defaultMaxListeners = 30;

const elixir = require('laravel-elixir'),
    cssnext = require('postcss-cssnext'),
    gulp   = require('gulp'),
    shell  = require('gulp-shell'),
    Task = elixir.Task,
    jQuery = require('./resources/assets/js/jquery/config.json'),
    booksApp = require('./resources/assets/js/books/config.json'),
    Medlib = require('./resources/assets/js/app/config.json'),
    vue = require('./resources/assets/js/config.json'),
    beList = require('./resources/assets/less/plugins/be-list/core/js/config.json'),
    sortBundele = require('./resources/assets/less/plugins/be-list/addons/sort-bundle/js/config.json'),
    textboxFilter = require('./resources/assets/less/plugins/be-list/addons/textbox-filter/js/config.json'),
    paginationBundle = require('./resources/assets/less/plugins/be-list/addons/pagination-bundle/js/config.json'),
    historyBundle = require('./resources/assets/less/plugins/be-list/addons/history-bundle/js/config.json'),
    filterToggleBundle = require('./resources/assets/less/plugins/be-list/addons/filter-toggle-bundle/js/config.json'),
    filterDropdownBundle = require('./resources/assets/less/plugins/be-list/addons/filter-dropdown-bundle/js/config.json');

require('laravel-elixir-vue-2');

require('laravel-elixir-browserify-official');
require('laravel-elixir-browserify-hmr');
require('laravel-elixir-clean-unofficial');

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
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
let modules = {
    node_path:  'node_modules',
    plugins:    'less/plugins'
};

let paths = {
    assets:     'resources/assets/',
    select2:    {
        css:    modules.plugins    + '/select2/css/select2.css',
        js:     modules.plugins    + '/select2/js/select2.js',
    },
    material:   modules.plugins    + '/material-design-icons/css/material-design-iconic-font.min.css',
    scrollbar:  {
        css:    modules.plugins    + '/perfect-scrollbar/css/perfect-scrollbar.min.css',
        js:     modules.plugins    + '/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'
    },
    touchSwipe: '',
    socket:     modules.node_path  + '/socket.io-client/dist/socket.io.js',
    bootstrapSwitch:       modules.node_path + '/bootstrap-switch/dist/js/bootstrap-switch.js',
};

elixir.extend('lang', function() {
    new Task('lang', function(){
        return gulp.src('').pipe(shell('php artisan js-localization:refresh'));
    });

});

elixir(mix => {
    mix.less('application.less')
        .webpack('app.js', 'public/js/app.min.js')
        .browserify(booksApp.src, booksApp.dist)
        .webpack(vue.cookiesBar.src, vue.cookiesBar.dist)
        .copy(jQuery.src, jQuery.dist)
        .styles([
            //vue.cookiesBar.css,
            paths.select2.css,
            paths.material,
            paths.scrollbar.css
        ], 'public/css/vendors.min.css', paths.assets)
        .scripts([
            paths.assets + '/js/plugins/modernizr.js',
            paths.assets + paths.select2.js,
            paths.assets + paths.scrollbar.js,
            paths.assets + '/js/plugins/jquery.touchSwipe.min.js',
            //paths.socket,
            paths.bootstrapSwitch,
            'vendor/andywer/js-localization/resources/js/localization.js'
        ], 'public/js/plugins.vendor.min.js', './')
        .scripts(Medlib.src, Medlib.dist)
        .scripts(beList.src, beList.dist, 'resources/assets/less/plugins/be-list')
        .scripts(sortBundele.src, sortBundele.dist, 'resources/assets/less/plugins/be-list')
        .scripts(textboxFilter.src, textboxFilter.dist, 'resources/assets/less/plugins/be-list')
        .scripts(paginationBundle.src, paginationBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(historyBundle.src, historyBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(filterToggleBundle.src, filterToggleBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts(filterDropdownBundle.src, filterDropdownBundle.dist, 'resources/assets/less/plugins/be-list')
        .scripts([
            beList.dist,
            sortBundele.dist,
            textboxFilter.dist,
            paginationBundle.dist,
            historyBundle.dist,
            filterToggleBundle.dist,
            filterDropdownBundle.dist
        ], 'public/js/be-list.min.js', './')
        .copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/build/fonts');

    if (process.env.NODE_ENV == 'production') {
        mix.version([
            'css/application.css',
            'css/vendors.min.css',
            'js/jquery.min.js',
            'js/app.min.js',
            'js/plugins.vendor.min.js',
            'js/books/app.min.js',
            'js/cookiesbar.min.js',
            'js/be-list.min.js',
            'js/medlib.min.js'
        ]).clean([
            'public/css',
            'public/js'
        ]);//.lang();
    }

    if (process.env.NODE_ENV !== 'production') {

        mix.browserSync({
            proxy: 'http://127.0.0.1:8000',
            files: [
                elixir.config.appPath + '/**/*.php',
                elixir.config.get('public.css.outputFolder') + '/**\/*.css',
                elixir.config.get('public.versioning.buildFolder') + '/rev-manifest.json',
                'resources/views/**/*.php'
            ],
            browser: ['yandex']
        }).version([
            'css/application.css',
            'css/vendors.min.css',
            'js/jquery.min.js',
            'js/app.min.js',
            'js/plugins.vendor.min.js',
            'js/books/app.min.js',
            'js/cookiesbar.min.js',
            'js/be-list.min.js',
            'js/medlib.min.js'
        ]);
    }
});
