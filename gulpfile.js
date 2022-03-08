const gulp         = require('gulp');
const sass         = require('gulp-sass');
const postcss      = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const concat       = require('gulp-concat');
//const terser       = require('gulp-terser');
const rename       = require('gulp-rename');
const ngAnnotate   = require('gulp-ng-annotate');
const config       = require('./gulpfile-config');

// Concat front end Files
/*gulp.task('concat', function () {
    return gulp.src(config.frontend.js.source)
        .pipe(ngAnnotate())
        .pipe(concat(config.frontend.js.filename))
        .pipe(gulp.dest(config.frontend.js.destination));
});*/

// Compress js Files
/*gulp.task('compressjs', function () {
    return gulp.src(config.frontend.js.destination + '/' + config.frontend.js.filename)
        //.pipe(terser())
        .pipe(gulp.dest(config.frontend.js.destination));
});*/

// Compile front end SASS
gulp.task('sass', function () {
    return gulp.src(config.frontend.sass.source)
        .pipe(sass({
            outputStyle : 'compressed',
            includePaths: config.sassPaths
        }))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulp.dest(config.frontend.sass.destination));
});

// Concat LMS Files
/*gulp.task('concat:lms', function () {
    return gulp.src(config.lms.js.source)
        .pipe(ngAnnotate())
        .pipe(concat(config.lms.js.filename))
        .pipe(gulp.dest(config.lms.js.destination));
});

// Compile LMS SASS
gulp.task('sass:lms', function () {
    return gulp.src(config.lms.sass.source)
        .pipe(sass({
            includePaths: config.sassPaths
        }))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulp.dest(config.lms.sass.destination));
});*/

// Watch for Changes
gulp.task('watch', function () {
    //gulp.watch(config.frontend.js.watch, gulp.series('concat'));
    gulp.watch(config.frontend.sass.watch, gulp.series('sass'));
});

gulp.task('default', gulp.series(
    'sass'
    //'concat'
));

/*gulp.task('lms', gulp.series(
    'sass:lms',
    'concat:lms'
));*/
