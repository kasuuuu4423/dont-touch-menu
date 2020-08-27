const gulp = require('gulp');
const pug = require('gulp-pug');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const browsersync = require('browser-sync');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');

const paths = {
  'root': './dist/',
  'pug': './src/pug/**/*.pug',
  'js': './src/js/**/*.js',
  'html': './dist/',
  'scss': './src/scss/**/*.scss',
  'css': './dist/css/',
  'dist-js': './dist/js/',
}

//gulpコマンドの省略
const { watch, series, task, src, dest, parallel } = require('gulp');

task('copy-js', (done) =>{
  src(paths['js']).pipe(dest(paths['dist-js']));
  done();
});

//Sass
task('sass', function() {
  return (
    src(paths.scss)
    .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))
    .pipe(sass({
      outputStyle: 'expanded' // Minifyするなら'compressed'
    }))
    .pipe(dest(paths.css))
  );
});

//Pug
task('pug', function() {
  return (
    src([paths.pug, '!./src/pug/**/_*.pug'])
    .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))
    .pipe(pug({
      pretty: true,
    }))
    .pipe(dest(paths.html))
  );
});

// browser-sync
task('browser-sync', (done) => {
  return browsersync.init({
    server: {
      baseDir: paths.root
    },
    port: 8080,
    reloadOnRestart: true
  });
  done();
});

task('reload', (done) => {
  browsersync.reload();
  done();
});


//watch
task('watch', (done) => {
  watch([paths.scss], series('sass', 'reload'));
  watch([paths.pug], series('pug', 'reload'));
  watch([paths.js], series('copy-js', 'reload'));
  done();
});


gulp.task('default',
  gulp.series(
    'watch',
    'browser-sync',
  )
);