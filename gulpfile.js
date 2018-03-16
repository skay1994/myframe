/**
 * Created by skay_ on 24/04/2017.
 */
(function () {

    var gulp = require('gulp'),
        sass = require('gulp-sass'),
        minify = require('gulp-lazy-minify'),
        concat = require('gulp-concat'),
        live = require('gulp-live-server');

    var src_scss = './assets/css/*.scss',
        src_css = './assets/css',
        src_js = './assets/js/files/*.js';

    gulp.task('scss',function () {
        return gulp.src(src_scss)
            .pipe(sass().on('error',sass.logError))
            .pipe(concat('custom.css'))
            .pipe(minify())
            .pipe(gulp.dest(src_css));
    });

    gulp.task('concat-js',function () {
        gulp.src(src_js)
            .pipe(concat('script.js'))
            // .pipe(minify())
            .pipe(gulp.dest('./assets/js'));
    });

    gulp.task('css-watch',function () {
        gulp.watch(src_scss,['scss']);
    });

    gulp.task('js-watch',function () {
        gulp.watch(src_js,['concat-js']);
    });

    gulp.task('js-css-watch',function () {
        gulp.watch(src_scss,['scss']);
        gulp.watch(src_js,['concat-js']);
    });

    gulp.task('live-edit',function () {
        var server = live.static('public',3000);
        server.start();

        gulp.watch(src_scss,['scss',function (file) {
            server.notify.apply(server,[file])
        }]);
        gulp.watch(src_js,['concat-js',function (file) {
            server.notify.apply(server,[file])
        }]);
        gulp.watch('./public/index.html',function (file) {
            server.notify.apply(server,[file])
        })
    });

    gulp.task('default',['live-edit'])
})();