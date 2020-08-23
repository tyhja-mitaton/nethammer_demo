var gulp = require('gulp'),
  sass = require('gulp-sass'),
  csscomb = require('gulp-csscomb'), 
  cleancss = require('gulp-clean-css'),
  rename = require('gulp-rename'),
  combineMedia = require('gulp-combine-media'),
  autoprefixer = require('gulp-autoprefixer')

gulp.task('styles', function () {
  return gulp.src('sass/**/*.scss')
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(autoprefixer(['last 5 versions']))
	.pipe(csscomb())
    .pipe(combineMedia())
    .pipe(gulp.dest('../css'))
})

gulp.task('watch', function () {
  gulp.watch('sass/**/*.scss', gulp.parallel('styles'))
})

gulp.task('compress', function () {
  return gulp.src('sass/**/*.scss')
	.pipe(sass({outputStyle: 'compressed'}))
    .pipe(autoprefixer(['last 1 versions']))
	.pipe(csscomb())
    .pipe(combineMedia())
    .pipe(cleancss({level: 2}))
    .pipe(rename({suffix: '.min', prefix: ''}))
    .pipe(gulp.dest('../css'))
})