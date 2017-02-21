const { mix } = require('laravel-mix');
const _ = require('lodash');
const beList = require('./resources/assets/sass/components/be-list/core/js/config.json'),
    sortBundele = require('./resources/assets/sass/components/be-list/addons/sort-bundle/js/config.json'),
    textboxFilter = require('./resources/assets/sass/components/be-list/addons/textbox-filter/js/config.json'),
    paginationBundle = require('./resources/assets/sass/components/be-list/addons/pagination-bundle/js/config.json'),
    historyBundle = require('./resources/assets/sass/components/be-list/addons/history-bundle/js/config.json'),
    filterToggleBundle = require('./resources/assets/sass/components/be-list/addons/filter-toggle-bundle/js/config.json'),
    filterDropdownBundle = require('./resources/assets/sass/components/be-list/addons/filter-dropdown-bundle/js/config.json'),
    cookiesBar = require('./resources/assets/js/config.json'),
    jQuery = require('./resources/assets/js/jquery/config.json'),
    Medlib = require('./resources/assets/js/app/config.json'),
    booksApp = require('./resources/assets/js/books/config.json');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const buildBeList = _.concat(
    beList.src,
    sortBundele.src,
    textboxFilter.src,
    paginationBundle.src,
    historyBundle.src,
    filterToggleBundle.src,
    filterDropdownBundle.src
);
const modules = {
    node_path:  'node_modules',
};

const paths = {
    assets:     'resources/assets/',
    touchSwipe: '',
    bootstrapSwitch:       modules.node_path + '/bootstrap-switch/dist/js/bootstrap-switch.js',
};

mix.copy('resources/assets/images', 'public/images', false)
    .copy('resources/assets/fonts', 'public/fonts', false)
    .js(jQuery.src, jQuery.dist)
    .js('resources/assets/js/app.js', 'public/js')
    .js(cookiesBar.src, cookiesBar.dist)
    .js(booksApp.src, booksApp.dist)
    .sass('resources/assets/sass/application.scss', 'public/css')
    .combine(Medlib.src, Medlib.dist)
    .combine(buildBeList, 'public/js/be-list.min.js')
    .combine([
        paths.assets + '/js/plugins/modernizr.js',
        paths.assets + '/js/plugins/jquery.touchSwipe.min.js',
        paths.bootstrapSwitch,
    ], 'public/js/plugins.vendor.min.js')
    .version();

mix.browserSync({
    proxy: 'http://medlib.app',
    browser: ['yandex']
});