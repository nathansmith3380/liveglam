const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const jshint = require('gulp-jshint');  // cause error
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const changed = require('gulp-changed');
const imagemin = require('gulp-imagemin');
const cache = require('gulp-cache');
const pump = require('pump');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const del = require('del');
const runSequence = require('run-sequence');
const browserSync = require('browser-sync').create();
const babel = require('gulp-babel');

const plumberErrorHandler = { 
  errorHandler: notify.onError({
    title: 'Gulp',
    message: 'Error: <%= error.message %>'
  })
};

gulp.task('clear', () => 
  cache.clearAll()
);

gulp.task('sass', function(cb) {
  pump([
      gulp.src(['./assets/css/src/*.scss', './assets/css/src/new_design/*.scss', './assets/css/src/login_pages/*.scss']),
      changed('./assets/css'),
      plumber(plumberErrorHandler),
      sass(),
      autoprefixer(),
      cleanCSS(),
      concat('app.css'),
      rename({ suffix: '.min'}),
      gulp.dest('./assets/css')
    ],
    cb
  );    
});

gulp.task('js', function(cb) {
  pump([
      gulp.src(['./assets/js/src/*.js', '!./assets/js/src/*.min*']),
      babel({
        presets: [
          ['@babel/env', {
            modules: false
          }]
        ]
      }),
      changed('./assets/js'),
      // jshint(),  // cause error
      // jshint.reporter('fail'), // cause error
      uglify(),
      // concat('theme.js'), // cover later
      rename({suffix: '.min'}),
      gulp.dest('./assets/js'),
      browserSync.reload({stream: true})
    ],
    cb
  );
});

gulp.task('img', function() {
  gulp.src('./assets/img/src/*.{png,jpg,gif,svg}')
    .pipe(changed('./assets/img'))
    .pipe(imagemin([
      imagemin.gifsicle({interlaced: true}),
      imagemin.jpegtran({progressive: true}),
      imagemin.optipng({optimizationLevel: 5}),
      imagemin.svgo({
        plugins: [
          {removeViewBox: true},
          {cleanupIDs: false}
        ]
      })            
    ], {
      optimizationLevel: 7,
      progressive: true
    }))
    .pipe(gulp.dest('./assets/img'))
});

gulp.task('img-safe', function() {
  gulp.src('./assets/img/src/*.{png,jpg,gif,svg}')
    .pipe(changed('./assets/img'))
    .pipe(imagemin([
      imagemin.gifsicle({interlaced: true}),
      imagemin.jpegtran({progressive: true}),
      imagemin.optipng({optimizationLevel: 5})     
    ], {
    }))
    .pipe(gulp.dest('./assets/img'))
});

gulp.task('browser-sync', function() {
  browserSync.init({
    proxy: "http://localhost"
  });
});

/*
 * Gulp main commands
 */
//gulp.task('watch', function() {
gulp.task('watch', ['browser-sync'], function() {  
  gulp.watch('./assets/css/src/*.scss', ['sass']);
  gulp.watch('./assets/js/src/*.js', ['js']);
  gulp.watch('./assets/img/src/*.{png,jpg,gif,svg}', ['img-safe']);
  gulp.watch('*.php').on('change', browserSync.reload);
});

gulp.task('clean', function() {
  del([
    './assets/css/*',
    '!./assets/css/src',
    './assets/js/*', 
    '!./assets/js/src', 
    './assets/img/*',
    '!./assets/img/src'
  ]);
});

gulp.task('build-svg', function() {
  runSequence(
    'clear',
    ['sass', 'js', 'img']
  );
});

gulp.task('build', function() {
  runSequence(
    'clear',
    ['sass', 'js']
  );
});

gulp.task('build-all', function() {
  runSequence(
    'clear',
    ['sass', 'js', 'img-safe']
  );
});

gulp.task('default', function() {
  runSequence(
    'clear',
    ['sass', 'js', 'img-safe'], 
    'watch'
  );
});