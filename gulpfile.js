require('events').EventEmitter.defaultMaxListeners = 30;

var elixir = require('laravel-elixir'),
    cssnext = require('postcss-cssnext'),
    gutils = require('gulp-util');

//require('laravel-elixir-livereload');

require('laravel-elixir-uglify');
require('laravel-elixir-browserify-official');

elixir.config.js.browserify.transformers.push({
  name: 'vueify',

  options: {
    postcss: [cssnext({
        autoprefixer: {
          browsers: ['ie >= 8', 'last 2 versions']
        }
      })]
  }
});

if (gutils.env._.indexOf('watch') > -1) {
  elixir.config.js.browserify.plugins.push({
    name: "browserify-hmr",
    options : {}
  });
}

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
    mix.less('application.less', 'public/css/application.css');

    mix.copy('resources/assets/js/jquery/jquery.min.js', 'public/js/jquery.min.js');
    mix.copy('resources/assets/js/require.js', 'public/js/require.min.js');

    mix.scripts([
            'lodash/lodash.js',
            'jquery-pjax/jquery.pjax.js',
            'bootstrap/dist/js/bootstrap.min.js',
            //'velocity/velocity.min.js',
            'moment/min/moment.min.js',
            'toastr/toastr.min.js',
            //'scrollMonitor/scrollMonitor.js',
            //'textarea-autosize/dist/jquery.textarea_autosize.min.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'fastclick/lib/fastclick.js',
            'bootstrap-sass/assets/javascripts/bootstrap/transition.js',
            'bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            'bootstrap-sass/assets/javascripts/bootstrap/button.js',
            'bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            'bootstrap-sass/assets/javascripts/bootstrap/alert.js',
            'jQuery-slimScroll/jquery.slimscroll.min.js',
            'widgster/widgster.js',
            'pace.js/pace.min.js',
            'jquery-touchswipe/jquery.touchSwipe.js',
            'select2/select2.js'
        ], 'public/js/vendors.js', './bower/')
        .scripts([
            'js/book-previewer.js',
            'js/arrow.js'
        ], 'public/js/search-commons.js', './resources/assets')
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
        .styles(['css/jplist/*.css'], 'public/css/jplist-commons.css', './resources/assets');

    mix.uglify(['**/*.js', '!**/*.min.js', '!**/*.map'], 'public/js', {
        mangle: true,
        suffix: '.min.js'
    });

    mix.version([
        'css/application.css', 
        'css/application-ie9-part2.css',
        'css/vendors.css',
        'css/dashboard.css',
        'css/style.css',
        'css/email.css',
        'css/jplist-commons.css',
        'js/jquery.min.js',
        'js/vendors.js',
        'js/require.min.js',
        'js/search-commons.min.js',
        'js/jplist-common.min.js']);

    mix.copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/build/fonts')
        .copy('resources/assets/js/books', 'public/js/books');

    if (process.env.NODE_ENV !== 'production') {
        //mix.livereload();
        mix.browserSync({
            proxy: 'http://medlib-v2.lan',
            files: [
                elixir.config.get('public.css.outputFolder') + '/**\/*.css',
                elixir.config.get('public.versioning.buildFolder') + '/rev-manifest.json'
            ]
        });
    }
});