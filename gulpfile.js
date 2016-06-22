var elixir  = require('laravel-elixir'),
    gulp 	= require('gulp'),
    uglify	= require('gulp-uglify'),
    concat	= require('gulp-concat'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch');

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
var
    config = {
        src: [
            'public/vendor/jquery/dist/jquery.min.js',
            'public/vendor/jquery-pjax/jquery.pjax.js',
            'public/vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js',
            'public/vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js',
            'public/vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js',
            'public/vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
            'public/vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js',
            'public/vendor/jQuery-slimScroll/jquery.slimscroll.min.js',
            'public/vendor/widgster/widgster.js',
            'public/vendor/pace.js/pace.min.js',
            'public/vendor/jquery-touchswipe/jquery.touchSwipe.js',
            'public/vendor/bootstrap-select/bootstrap-select.min.js',
            'public/vendor/select2/select2.min.js',
            'public/vendor/jasny-bootstrap/js/fileinput.js',
            'vendor/jquery.sparkline/dist/jquery.sparkline.js',

            /** Application Medlib **/
            'public/js/settings-app.min.js',
            'public/js/app.min.js',

            /** Bootstrap core JavaScript  **/
            'public/js/bootstrap.min.js',
            'public/js/progressbar.min.js',
            'public/js/custom.min.js',
            'public/js/script.min.js',
            'public/js/main.min.js',
            'public/js/jquery.input.min.js',
            'public/js/jquery.param.min.js',
            'public/js/jquery.progress.min.js',
            'public/js/jquery.shorten.min.js',
            'public/js/google-books.min.js'
        ],
        dest: 'public/js'
    },
    jplist = {
        src: [
            'resources/assets/js/jplist/jplist.core.min.js',
            'resources/assets/js/jplist/jplist.sort-bundle.min.js',
            'resources/assets/js/jplist/jplist.textbox-filter.min.js',
            'resources/assets/js/jplist/jplist.pagination-bundle.min.js',
            'resources/assets/js/jplist/jplist.history-bundle.min.js',
            'resources/assets/js/jplist/jplist.filter-toggle-bundle.min.js',
            'resources/assets/js/jplist/jplist.views-control.min.js'
        ],
        dest: 'public/js'
    };

/** Display error messages **/
function errorLog(error)  {
    console.error.bind(error);
    this.emit('end');
}

gulp.task('script', function(){
    gulp.src('resources/assets/js/*.js')
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .on('error', errorLog)
        .pipe(gulp.dest(config.dest));
});

gulp.task('scripts', function() {
    return gulp.src(config.src)
        .pipe(concat('scripts.js', {newLine: ';'}))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .on('error', errorLog)
        .pipe(gulp.dest(config.dest));
});

gulp.task('jplist', function() {
    return gulp.src(jplist.src)
        .pipe(concat('jplist.js', {newLine: ';'}))
        .pipe(rename('jplist.scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(jplist.dest));
});

elixir(function(mix) {
    mix.sass('app.scss');
});

gulp.task('watch', function(){
    gulp.watch('resources/assets/js/*.js', ['script']);
    gulp.watch(['public/js/*.js', '!public/js/scripts.min.js', '!public/js/scripts.js'], ['scripts']);
});

/** Default Task gulp **/
gulp.task('default', ['watch', 'scripts', 'jplist']);