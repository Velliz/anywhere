var gulp = require('gulp'),
    connect = require('gulp-connect-php'),
    browserSync = require('browser-sync');

gulp.task('connect-sync', function () {
    connect.server({}, function () {
        browserSync({
            proxy: '127.0.0.1:8000'
        });
    });

    gulp.watch('**/*.php').on('change', function () {
        browserSync.reload();
    });
    gulp.watch('**/*.html').on('change', function () {
        browserSync.reload();
    });
    gulp.watch('**/*.js').on('change', function () {
        browserSync.reload();
    });
    gulp.watch('**/*.css').on('change', function () {
        browserSync.reload();
    });
});