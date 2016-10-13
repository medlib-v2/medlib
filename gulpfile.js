require('events').EventEmitter.defaultMaxListeners = 30;

var elixir = require('laravel-elixir'),
    cssnext = require('postcss-cssnext'),
    gutils = require('gulp-util');

require('laravel-elixir-livereload');
/**
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
 */
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
    
    mix.copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/build/fonts');
    /**
     * [
        
      'node_modules/babel-polyfill/dist/polyfill.min.js',
      'node_modules/plyr/dist/plyr.js',
      //'node_modules/rangetouch/dist/rangetouch.js',
      //'resources/assets/js/libs/modernizr-custom.js'
    ]
     */
    mix.scripts([
            './bower/jquery/dist/jquery.min.js',
            //'./bower/jquery-ui/jquery-ui.min.js',
            './bower/jquery-pjax/jquery.pjax.js',
            './bower/bootstrap/dist/js/bootstrap.min.js',
            //'./bower/velocity/velocity.min.js',
            './bower/moment/min/moment.min.js',
            './bower/toastr/toastr.min.js',
            //'./bower/scrollMonitor/scrollMonitor.js',
            //'./bower/textarea-autosize/dist/jquery.textarea_autosize.min.js',
            './bower/bootstrap-select/dist/js/bootstrap-select.min.js',
            './bower/fastclick/lib/fastclick.js',
            './bower/bootstrap-sass/assets/javascripts/bootstrap/transition.js',
            './bower/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            './bower/bootstrap-sass/assets/javascripts/bootstrap/button.js',
            './bower/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            './bower/bootstrap-sass/assets/javascripts/bootstrap/alert.js',
            './bower/jQuery-slimScroll/jquery.slimscroll.min.js',
            './bower/widgster/widgster.js',
            './bower/pace.js/pace.min.js',
            './bower/jquery-touchswipe/jquery.touchSwipe.js',
            './bower/select2/select2.js'
        ], 'public/js/vendors.js', './')
    .scripts([
        './resources/assets/js/jplist/jplist.core.min.js',
        './resources/assets/js/jplist/jplist.sort-bundle.min.js',
        './resources/assets/js/jplist/jplist.textbox-filter.min.js',
        './resources/assets/js/jplist/jplist.pagination-bundle.min.js',
        './resources/assets/js/jplist/jplist.history-bundle.min.js',
        './resources/assets/js/jplist/jplist.filter-toggle-bundle.min.js',
        './resources/assets/js/jplist/jplist.views-control.min.js'
    ],'public/js/jplist-common.js')
    .styles(['resources/assets/css/**/*.css', '!resources/assets/css/jplist/*.css'], 'public/css/vendors.css', './')
    .styles(['resources/assets/css/jplist/*.css'], 'public/css/jplist-commons.css', './');

    mix.version(['css/application.css', 'css/vendors.css', 'js/vendors.js', 'js/jplist-commons.css', 'js/jplist-common.js']);

    if (process.env.NODE_ENV !== 'production') {
        mix.livereload();
        /**
        mix.browserSync({
            proxy: 'http://localhost',
            port: 8000,
            files: [
                elixir.config.get('public.css.outputFolder') + '/**\/*.css',
                elixir.config.get('public.versioning.buildFolder') + '/rev-manifest.json',
            ]
        });
        **/
    }
});