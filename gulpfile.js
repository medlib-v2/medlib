'use strict';

var gulp = require('gulp'),
    livereload = require('gulp-livereload'),
    path = require('path'),
    minifyHtml = require('gulp-minify-html'),
    less = require('gulp-less'),
    minifyCss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    gutil = require('gulp-util'),
    filesize = require('gulp-filesize'),
    ttf2woff = require('gulp-ttf2woff'),
    trycatch = require('gulp-trycatch-closure'),
    LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    autoprefix = new LessPluginAutoPrefix({ browsers: ["last 2 versions"] }),
    /**
    prefix	= require('gulp-autoprefixer'),
    mergeJs = require('gulp-merge'),
    **/
    changed = require('gulp-changed'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch'),
    clean = require('gulp-clean'),


    /** Application Medlib **/
    /**
    'public/js/settings-app.min.js',
    'public/js/app.min.js',
    **/

    /** Bootstrap core JavaScript  **/
    /*
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
    **/
    settings = {
        assetsFolder: './public/',
        assetsPlugins: './bower/bower_components/',
        buildFolder: './resources/assets/',
        fonts: {
            glyphicons: './bower/bower_components/bootstrap/fonts/',
            fontawesome: './bower/bower_components/fontawesome/fonts/',
            ionicons: './bower/bower_components/ionicons/fonts/',
            weathericons: 'bower/bower_components/weather-icons/font/',
            worksans: './resources/assets/fonts/worksans/',
            dest: './resources/assets/fonts/'
        },
    },
    jplist = {
        src: [
            './resources/assets/js/jplist/jplist.core.min.js',
            './resources/assets/js/jplist/jplist.sort-bundle.min.js',
            './resources/assets/js/jplist/jplist.textbox-filter.min.js',
            './resources/assets/js/jplist/jplist.pagination-bundle.min.js',
            './resources/assets/js/jplist/jplist.history-bundle.min.js',
            './resources/assets/js/jplist/jplist.filter-toggle-bundle.min.js',
            './resources/assets/js/jplist/jplist.views-control.min.js'
        ],
        dest: './public/js'
    };


/**
 * Before clean all content
 */
gulp.task('clean-application', function() {
    return gulp.src(settings.assetsFolder + 'css/application.css', { read: false })
        .pipe(clean({ force: true }));
});

gulp.task('clean-scripts', [], function() {
    //return gulp.src(settings.assetsFolder+'js/*.js', {read: false})
    //	.pipe(clean({force: true}));
});

/**
 * copy all fonts in fonts folder
 */
/**
gulp.task('copyfonts', function() {
	gulp.src( settings.fonts.glyphicons + '*.{ttf,woff,eof,svg}')
		.pipe(gulp.dest(settings.fonts.dest + 'glyphicons'));

	gulp.src( settings.fonts.fontawesome + '*.{ttf,woff,eof,svg}')
		.pipe(gulp.dest(settings.fonts.dest + 'fontawesome'));

	gulp.src( settings.fonts.ionicons + '*.{ttf,woff,eof,svg}')
		.pipe(gulp.dest(settings.fonts.dest + 'ionicons'));

	gulp.src( settings.fonts.weathericons + '*.{ttf,woff,eof,svg}')
		.pipe(gulp.dest(settings.fonts.dest + 'weather-icons'));
});
**/
/**
 * Concat the all js plugins
 */
gulp.task('vendor', function() {
    return gulp.src([
            settings.assetsPlugins + 'jquery/dist/jquery.min.js',
            settings.assetsPlugins + 'jquery-ui/jquery-ui.min.js',
            settings.assetsPlugins + 'jquery-pjax/jquery.pjax.js',
            settings.assetsPlugins + 'bootstrap/dist/js/bootstrap.min.js',
            settings.assetsPlugins + 'velocity/velocity.min.js',
            settings.assetsPlugins + 'moment/min/moment.min.js',
            settings.assetsPlugins + 'toastr/toastr.min.js',
            settings.assetsPlugins + 'scrollMonitor/scrollMonitor.js',
            settings.assetsPlugins + 'textarea-autosize/dist/jquery.textarea_autosize.min.js',
            settings.assetsPlugins + 'bootstrap-select/dist/js/bootstrap-select.min.js',
            settings.assetsPlugins + 'fastclick/lib/fastclick.js',
            settings.assetsPlugins + 'bootstrap-sass/assets/javascripts/bootstrap/transition.js',
            settings.assetsPlugins + 'bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            settings.assetsPlugins + 'bootstrap-sass/assets/javascripts/bootstrap/button.js',
            settings.assetsPlugins + 'bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            settings.assetsPlugins + 'bootstrap-sass/assets/javascripts/bootstrap/alert.js',
            settings.assetsPlugins + 'jQuery-slimScroll/jquery.slimscroll.min.js',
            settings.assetsPlugins + 'widgster/widgster.js',
            settings.assetsPlugins + 'pace.js/pace.min.js',
            settings.assetsPlugins + 'jquery-touchswipe/jquery.touchSwipe.js'
        ])
        .pipe(uglify())
        .pipe(concat('vendor.min.js'))
        .pipe(gulp.dest(settings.assetsFolder + 'js'))
        .pipe(filesize())
        .on('error', gutil.log);
});

/**
 * Compile all js applications
 */
gulp.task('js', ['clean-scripts'], function() {
    gulp.src(settings.buildFolder + 'js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest(settings.assetsFolder + 'js'));
});

/**
 * Compile css
 */
gulp.task('css', ['clean-application'], function() {
    return gulp.src(settings.buildFolder + 'less/application.less')
        .pipe(changed(settings.assetsFolder + 'css/'))
        .pipe(less({
            plugins: [autoprefix],
            paths: [path.join(settings.buildFolder, 'less')]
        }))
        //.pipe(trycatch())
        .pipe(minifyCss())
        .pipe(gulp.dest(settings.assetsFolder + 'css/'))
        .on('error', gutil.log);
});

gulp.task('watch', function() {
    return gulp.watch(settings.buildFolder + 'less/**/*.less', ['css']);
});

gulp.task('default', ['vendor', 'js', 'css', 'watch']);