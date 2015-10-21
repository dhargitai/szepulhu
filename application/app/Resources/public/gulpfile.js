// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var expect = require('gulp-expect-file');
var es = require('event-stream');

var targetDir = '/var/www/szepul.hu/web';

function handleError(error) {
    process.exit(1);
}

// Lint Task
gulp.task('lint', function() {
    return gulp.src('js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass and concatenate CSS from vendors
gulp.task('css', function() {
    var vendorFiles = [
            'bower_components/jquery-ui/themes/smoothness/jquery-ui.css',
            'bower_components/jquery-ui/themes/smoothness/theme.css'
        ],
        vendorSource = gulp.src(vendorFiles)
            .pipe(expect({ errorOnFailure: true }, vendorFiles))
            .on('error', handleError);
    var appFiles = [
            'bower_components/foundation/scss/normalize.scss',
            'css/*.scss'
        ],
        appSource = gulp.src(appFiles)
            .pipe(expect({ errorOnFailure: true }, appFiles))
            .on('error', handleError)
            .pipe(sass({errLogToConsole: true}))
            .pipe(sass({ style: 'compressed' }));

    return es.concat(vendorSource, appSource)
        .pipe(concat('style.css'))
        .pipe(gulp.dest(targetDir + '/css'))
        .pipe(minifyCss())
        .pipe(rename('style.css'))
        .pipe(gulp.dest(targetDir + '/css'));
});

gulp.task('images', function() {
    return gulp.src('bower_components/jquery-ui/themes/smoothness/images/*')
        .pipe(gulp.dest(targetDir + '/css/images'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    var header_files = [
            'bower_components/modernizr-min/dist/modernizr.min.js'
        ],
        footer_files = [
            'bower_components/jquery/dist/jquery.js',
            'bower_components/jquery-ui/jquery-ui.js',
            'bower_components/jquery-ui/ui/i18n/datepicker-hu.js',
            'bower_components/js-cookie/src/js.cookie.js',
            'bower_components/foundation/js/foundation.min.js',
            'js/geoposition/geoPosition.js',
            '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js',
            '../../web/js/fos_js_routes.js',
            'js/app.js'
        ];
    var result1 = gulp.src(header_files)
        .pipe(expect({ errorOnFailure: true }, header_files))
        .on('error', handleError)
        .pipe(concat('head_scripts.js'))
        .pipe(gulp.dest(targetDir + '/js'))
        .pipe(rename('head_scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(targetDir + '/js'));

    var result2 = gulp.src(footer_files)
        .pipe(expect({ errorOnFailure: true }, footer_files))
        .on('error', handleError)
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(targetDir + '/js'))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(targetDir + '/js'));

    return result1 && result2;
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
