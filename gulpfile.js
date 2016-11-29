require('events').EventEmitter.defaultMaxListeners = 30;

var elixir = require('laravel-elixir'),
    cssnext = require('postcss-cssnext'),
    gutils = require('gulp-util');

require('laravel-elixir-artisan-serve');
require('laravel-elixir-browserify-official');
require('laravel-elixir-browsersync-official');
require('laravel-elixir-uglify');
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
require('laravel-elixir-browserify-hmr');
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
    mix.clean()
        .less('application.less', 'public/css/application.css')
        .browserify('books/app.js', 'public/js/books/app.min.js')
        .browserify('vue/cookiesbar.js', 'public/js/vue/cookiesbar.min.js')
        .copy('resources/assets/js/jquery/jquery.min.js', 'public/js/jquery.min.js')
        .scripts([
            'bootstrap/dist/js/bootstrap.min.js',
            'jquery-pjax/jquery.pjax.js',
            'lodash/lodash.js',
            //'velocity/velocity.min.js',
            'moment/min/moment.min.js',
            'toastr/toastr.min.js',
            //'scrollMonitor/scrollMonitor.js',
            //'textarea-autosize/dist/jquery.textarea_autosize.min.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'fastclick/lib/fastclick.js',
            'bootstrap/js/transition.js',
            'bootstrap/js/collapse.js',
            'bootstrap/js/button.js',
            'bootstrap/js/tooltip.js',
            'bootstrap/js/alert.js',
            'jQuery-slimScroll/jquery.slimscroll.min.js',
            'widgster/widgster.js',
            'pace.js/pace.min.js',
            'jquery-touchswipe/jquery.touchSwipe.js',
            'select2/select2.js'
        ], 'public/js/vendors.min.js', './bower')
        .scripts([
            'js/book-previewer.js',
            'js/arrow.js'
        ], 'public/js/search-commons.min.js', './resources/assets')
        .scripts([
            'js/password.js'
        ], 'public/js/password.min.js', './resources/assets')
        .scripts([
            'js/jplist/jplist.core.min.js',
            'js/jplist/jplist.sort-bundle.min.js',
            'js/jplist/jplist.textbox-filter.min.js',
            'js/jplist/jplist.pagination-bundle.min.js',
            'js/jplist/jplist.history-bundle.min.js',
            'js/jplist/jplist.filter-toggle-bundle.min.js',
            'js/jplist/jplist.views-control.min.js'
        ],'public/js/jplist-common.min.js', './resources/assets')
        .styles(['css/application-ie9-part2.css'], 'public/css/application-ie9-part2.css', './resources/assets')
        .styles([
            'css/cookiebar.css',
            'css/jprogress.css',
            'css/progressbar.css',
            'css/messages.css',
            'css/jquery.filer.css'
            ], 'public/css/vendors.css', './resources/assets')
        .styles(['css/dashboard.css'], 'public/css/dashboard.css', './resources/assets')
        .styles(['css/email.css'], 'public/css/email.css', './resources/assets')
        .styles(['css/style.css'], 'public/css/style.css', './resources/assets')
        .styles(['css/jplist/*.css'], 'public/css/jplist-commons.css', './resources/assets')
        .uglify(['**/*.js', '!**/*.min.js', '!**/*.map'], 'public/js', {
            mangle: true,
            suffix: '.min.js'
        })
        .version([
        'css/application.css',
        'css/application-ie9-part2.css',
        'css/vendors.css',
        'css/dashboard.css',
        'css/style.css',
        'css/email.css',
        'css/jplist-commons.css',
        'js/jquery.min.js',
        'js/vendors.min.js',
        'js/password.min.js',
        'js/vue/cookiesbar.min.js',
        'js/books/app.min.js',
        'js/search-commons.min.js',
        'js/jplist-common.min.js'])
        .copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/build/fonts')
        .clean([
            'public/css',
            'public/js'
        ]);

    if (process.env.NODE_ENV !== 'production') {
        mix.artisanServe({
            php_path: '/usr/local/bin/php',
            artisan_path: './artisan',
            host: '127.0.0.1',
            port: 8000,
            show_requests: true
        })
           .browserSync({
            proxy: '127.0.0.1:8000',
            files: [
                elixir.config.appPath + '/**\/*.php',
                elixir.config.get('public.css.outputFolder') + '/**\/*.css',
                elixir.config.get('public.versioning.buildFolder') + '/rev-manifest.json',
                'resources/views/**\/*.php'
            ],
            browser: ['google chrome']
        });
    }
});