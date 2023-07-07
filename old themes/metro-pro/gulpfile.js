var gulp = require('gulp');
var compass = require('gulp-compass'),
    minifyCSS = require('gulp-minify-css'),
    util = require('util');

var paths = {
    input: {
        imagesDir        : 'src/img',
        imagesFiles      : 'src/img/**/*',
        javascriptsDir   : 'src/js',
        javascriptsFiles : [
            'src/js/**/*.js',

            // Add any JS files to ignore after the first
            '!src/js/**/*.min.js'
        ],
        stylesDir   : 'src/sass',
        stylesFiles : 'src/sass/**/*.scss',
        cssFiles    : 'src/sass/**/*.css',
    },
    output: {
        fonts       : './fonts',
        images      : './images',
        javascripts : './js',
        styles      : './',
    }
}

//
// Functions
//
function getFilesToProcess(input, allFiles) {
    if (allFiles != false)
        allFiles = true;

    if (util.isArray(input)) {
        if (allFiles) {
            return input[0];
        } else {
            var filesToProcess = []
            for (var i = 1, n = input.length; i < n; i++) {
                filesToProcess.push(input[i].substr(1));
            }
            return filesToProcess;
        }
    } else {
        return input;
    }
}

gulp.task('compass', function() {
    gulp.src('./src/sass/*.scss')
        .pipe(compass({
            css: paths.output.styles,
            sass: paths.input.stylesDir,
            image: paths.output.images
        }))
        .pipe(minifyCSS())
        .pipe(gulp.dest(paths.output.styles));
});

gulp.task('watch', function() {
    gulp.watch(getFilesToProcess(paths.input.stylesFiles), ['compass']);
});
//
// Default Task
//
gulp.task('default', function() {
    return gulp.start(['watch']);
});