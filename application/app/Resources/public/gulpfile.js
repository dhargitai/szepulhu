// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// Lint Task
gulp.task('lint', function() {
return gulp.src('js/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

// Compile Our Sass
gulp.task('sass', function() {
return gulp.src('css/application.scss')
    .pipe(sass())
    .pipe(gulp.dest('../../../web/css'))
    .pipe(minifyCss())
    .pipe(rename('style.css'))
    .pipe(gulp.dest('../../../web/css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
return gulp.src([
        'js/jquery/jquery.js',
        'js/foundation/foundation.min.js',
        'js/app.js'
    ])
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('../../../web/js'))
    .pipe(rename('scripts.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('../../../web/js'));
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('js/*.js', ['lint', 'scripts']);
    gulp.watch('css/*.scss', ['sass']);
});

// Build
gulp.task('build', ['lint', 'sass', 'scripts']);

// Default Task
gulp.task('default', ['build', 'watch']);
