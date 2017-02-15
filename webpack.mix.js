const { mix } = require('laravel-mix');
const _ = require('lodash')
const beList = require('./resources/assets/less/plugins/be-list/core/js/config.json'),
    sortBundele = require('./resources/assets/less/plugins/be-list/addons/sort-bundle/js/config.json'),
    textboxFilter = require('./resources/assets/less/plugins/be-list/addons/textbox-filter/js/config.json'),
    paginationBundle = require('./resources/assets/less/plugins/be-list/addons/pagination-bundle/js/config.json'),
    historyBundle = require('./resources/assets/less/plugins/be-list/addons/history-bundle/js/config.json'),
    filterToggleBundle = require('./resources/assets/less/plugins/be-list/addons/filter-toggle-bundle/js/config.json'),
    filterDropdownBundle = require('./resources/assets/less/plugins/be-list/addons/filter-dropdown-bundle/js/config.json'),
    cookiesBar = require('./resources/assets/js/config.json'),
    jQuery = require('./resources/assets/js/jquery/config.json'),
    Medlib = require('./resources/assets/js/app/config.json'),
    booksApp = require('./resources/assets/js/books/config.json')
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
)
const modules = {
    node_path:  'node_modules',
    plugins:    'less/plugins'
}

const paths = {
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
    //socket:     modules.node_path  + '/socket.io-client/dist/socket.io.js',
    bootstrapSwitch:       modules.node_path + '/bootstrap-switch/dist/js/bootstrap-switch.js',
}

mix.copy('resources/assets/images', 'public/images', false)
    .copy('resources/assets/fonts', 'public/fonts', false)
    .js(jQuery.src, jQuery.dist)
    .js('resources/assets/js/app.js', 'public/js')
    .js(cookiesBar.src, cookiesBar.dist)
    .js(booksApp.src, booksApp.dist)
    //.less('resources/assets/less/application.less', 'public/css')
    .sass('resources/assets/sass/application.scss', 'public/css')
    .combine(Medlib.src, Medlib.dist)
    .combine(buildBeList, 'public/js/be-list.min.js')
    .combine([
        paths.assets + '/js/plugins/modernizr.js',
        paths.assets + paths.select2.js,
        paths.assets + paths.scrollbar.js,
        paths.assets + '/js/plugins/jquery.touchSwipe.min.js',
        //paths.socket,
        paths.bootstrapSwitch,
        'vendor/andywer/js-localization/resources/js/localization.js'
    ], 'public/js/plugins.vendor.min.js')
    .combine([
        //cookiesBar.css,
        paths.assets + paths.select2.css,
        paths.assets + paths.material,
        paths.assets + paths.scrollbar.css
    ], 'public/css/vendors.min.css')
    .version()

mix.browserSync({
    proxy: 'http://medlib.app',
    browser: ['yandex']
})