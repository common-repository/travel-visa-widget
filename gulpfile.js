'use strict';

var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    imagemin = require('gulp-imagemin'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass')(require('sass')),
    pipeline = require('readable-stream').pipeline,
    sassOutputStyle = 'compressed';


// CSS minifying
gulp.task('css', function() {
    return gulp.src('src/sass/*.scss')
        .pipe(sass({
            outputStyle: sassOutputStyle
        })
        .on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest('assets/css'));
});


// JS minifying
gulp.task('js', function(callback) {
    return pipeline(
        gulp.src('src/js/*.js'),
        uglify(),
        gulp.dest('assets/js'),
        callback
    );
});


// Images minifying
gulp.task('images', function() {
    return gulp.src('src/images/*.{png,gif,jpg,jpeg,svg}')
        .pipe(imagemin([
            imagemin.gifsicle(),
            imagemin.mozjpeg(),
            imagemin.optipng(),
            imagemin.svgo()
        ], {
            verbose: true
        }))
        .pipe(gulp.dest('assets/images'));
});


// Development build
gulp.task('watch', function() {
    sassOutputStyle = 'expanded';
    gulp.watch('src/sass/**/*.scss', gulp.series('css'));
    gulp.watch('src/js/*.js', gulp.series('js'));
    gulp.watch('src/images/*.{png,gif,jpg,jpeg,svg}', gulp.series('images'));
});


// Production build
gulp.task('default', gulp.series('css', 'js', 'images'));
