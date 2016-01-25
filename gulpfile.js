var elixir  = require('laravel-elixir'),
    gulp 	= require('gulp'),
    uglify	= require('gulp-uglify'),
    concat	= require('gulp-concat'),
    watch = require('gulp-watch'),
    prefix	= require('gulp-autoprefixer');

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

//Display error messages
function errorLog(error)
{
    console.error.bind(error);
    this.emit('end');
}

gulp.task('script', function(){
    gulp.src('resources/assets/js/*.js')
        .pipe(uglify())
        .on('error', errorLog)
        .pipe(gulp.dest('public/js'));
});

elixir(function(mix) {
    mix.sass('app.scss');
});

gulp.task('watch', function(){
    gulp.watch('*.js', ['script']);
});

//Default Task
//gulp
gulp.task('default', ['watch']);

