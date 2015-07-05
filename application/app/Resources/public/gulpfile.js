// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var es = require('event-stream');

// Lint Task
gulp.task('lint', function() {
    return gulp.src('js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass and concatenate CSS from vendors
gulp.task('css', function() {
    var vendorFiles = gulp.src([
        'bower_components/jquery-ui/themes/smoothness/jquery-ui.css',
        'bower_components/jquery-ui/themes/smoothness/theme.css'
    ]);
    var appFiles = gulp.src('css/*.scss')
        .pipe(sass({ style: 'compressed' }));

    return es.concat(vendorFiles, appFiles)
        .pipe(concat('style.css'))
        .pipe(gulp.dest('../../../web/css'))
        .pipe(minifyCss())
        .pipe(rename('style.css'))
        .pipe(gulp.dest('../../../web/css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src([
            'js/jquery/jquery.js',
            'bower_components/jquery-ui/jquery-ui.js',
            'bower_components/jquery-ui/ui/i18n/datepicker-hu.js',
            'bower_components/js-cookie/src/js.cookie.js',
            'js/foundation/foundation.min.js',
            'js/geoposition/geoPosition.js',
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
    gulp.watch('css/*.scss', ['css']);
});

// Build
gulp.task('build', ['lint', 'css', 'images', 'scripts']);

// Default Task
gulp.task('default', ['build', 'watch']);
