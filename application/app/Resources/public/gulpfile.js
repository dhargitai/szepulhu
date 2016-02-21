/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file defines Gulp tasks for building the frontend specific part of the application. It includes compiling Sass
 * files, concatenating and compressing Javascript files, resizing images of the website design.
 * All assets is published in the "web" directory.
 *
 * This file does not deal with assets provided by Symfony bundles. These files will be published by the
 * "app/console assets:install" Symfony CLI command.
 */

// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minifyCss = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var expect = require('gulp-expect-file');
var es = require('event-stream');

/**
 * Build Settings
 */
var settings = {

    /*
     * Where is our code?
     */
    srcDir    : '.',

    /*
     * Where are we the application dependent libraries?
     */
    libDir    : process.env.GULP_LIB_DIR || '.',

    /*
     * Where should the final files be?
     */
    targetDir : process.env.GULP_TARGET_DIR || 'web'
};

function handleError(error) {
    process.exit(1);
}

// Lint Task
gulp.task('lint', function() {
    return gulp.src(settings.srcDir + '/js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass and concatenate CSS from vendors
gulp.task('css', function() {
    var vendorFiles = [
            settings.libDir + '/bower_components/jquery-ui/themes/smoothness/jquery-ui.css',
            settings.libDir + '/bower_components/jquery-ui/themes/smoothness/theme.css',
            settings.libDir + '/bower_components/slick-carousel/slick/slick.css'
        ],
        vendorSource = gulp.src(vendorFiles)
            //.pipe(expect({ errorOnFailure: true }, vendorFiles))
            .on('error', handleError);
    var appFiles = [
            settings.libDir + '/bower_components/foundation/scss/normalize.scss',
            settings.srcDir + '/css/*.scss'
        ],
        appSource = gulp.src(appFiles)
            //.pipe(expect({ errorOnFailure: true }, appFiles))
            .on('error', handleError)
            .pipe(sass({errLogToConsole: true, includePaths: [settings.libDir]}))
            .pipe(sass({ style: 'compressed' }));

    return es.concat(vendorSource, appSource)
        .pipe(concat('style.css'))
        .pipe(gulp.dest(settings.targetDir + '/css'))
        .pipe(minifyCss())
        .pipe(rename('style.css'))
        .pipe(gulp.dest(settings.targetDir + '/css'));
});

gulp.task('images', function() {
    return gulp.src(settings.libDir + '/bower_components/jquery-ui/themes/smoothness/images/*')
        .pipe(gulp.dest(settings.targetDir + '/css/images'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    var header_files = [
            settings.libDir + '/bower_components/modernizr-min/dist/modernizr.min.js'
        ],
        footer_files = [
            settings.libDir + '/bower_components/jquery/dist/jquery.js',
            settings.libDir + '/bower_components/jquery-ui/jquery-ui.js',
            settings.libDir + '/bower_components/jquery-ui/ui/i18n/datepicker-hu.js',
            settings.libDir + '/bower_components/js-cookie/src/js.cookie.js',
            settings.libDir + '/bower_components/foundation/js/foundation.min.js',
            settings.libDir + '/bower_components/slick-carousel/slick/slick.min.js',
            settings.libDir + '/js/geoposition/geoPosition.js',
            settings.srcDir + '/js/app.js'
        ];
    var result1 = gulp.src(header_files)
        //.pipe(expect({ errorOnFailure: true }, header_files))
        .on('error', handleError)
        .pipe(concat('head_scripts.js'))
        .pipe(gulp.dest(settings.targetDir + '/js'))
        .pipe(rename('head_scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(settings.targetDir + '/js'));

    var result2 = gulp.src(footer_files)
        //.pipe(expect({ errorOnFailure: true }, footer_files))
        .on('error', handleError)
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(settings.targetDir + '/js'))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(settings.targetDir + '/js'));

    return result1 && result2;
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch(settings.srcDir + '/js/*.js', ['lint', 'scripts']);
    gulp.watch(settings.srcDir + '/css/*.scss', ['css']);
});

// Build
gulp.task('build', ['lint', 'css', 'images', 'scripts']);

// Default Task
gulp.task('default', ['build', 'watch']);
