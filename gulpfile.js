const gulp = require('gulp');
const pug = require('gulp-pug');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const browsersync = require('browser-sync');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const del = require('del');

const paths = {
  src: 'src',
  dist: 'dist'
};

//Pug
gulp.task('html', function() {
  return gulp.src([
      paths.src + '/pug/*.pug',
      '!' + paths.src + '/pug/_*.pug'
    ])
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(pug({ pretty: true }))
    .pipe(gulp.dest(paths.dist))
});

//Sass
gulp.task('css', function() {
  return gulp.src([
      paths.src + '/**/*.scss',
      '!' + paths.src + '/**/_*.scss'
    ])
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(sass({
      outputStyle: 'expanded'
    }))
    .pipe(autoprefixer({
      overrideBrowserslist: 'last 2 versions'
    }))
    .pipe(gulp.dest(paths.dist + '/css'))
});

//JavaScript
gulp.task('js', function() {
  return gulp.src(
      paths.src + '/javascripts/**/*'
    )
    .pipe(uglify())
    .pipe(gulp.dest(paths.dist + '/javascripts'))
});

//Browser Sync
gulp.task('browser-sync', function(done) {
  browsersync({
    server: { //ローカルサーバー起動
      baseDir: paths.dist
    }
  });
  done();
});

//Watch
gulp.task('watch', function() {
  const reload = () => {
    browsersync.reload(); //リロード
  };
  gulp.watch(paths.src + '/**/*').on('change', gulp.series('css', reload));
  gulp.watch(paths.src + '/**/*').on('change', gulp.series('html', reload));
  gulp.watch(paths.src + '/javascripts/**/*').on('change', gulp.series('js', reload));
});

//Clean
gulp.task('clean', function(done) {
  del.sync(paths.dist + '/**', '！' + paths.dist);
  done();
});

//Default
gulp.task('default',
  gulp.series(
    'clean',
    gulp.parallel(
      'html',
      'css',
      'js',
      'watch',
      'browser-sync'
    )));