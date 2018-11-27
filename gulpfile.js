// npm install --save-dev   gulp  gulp-changed  gulp-jscs  gulp-uglify  gulp-watch gulp-rev  gulp-minify-css gulp-watch

var gulp = require('gulp'),
    changed = require('gulp-changed'),
    jscs = require('gulp-jscs'),
    uglify = require('gulp-uglify'),
    // watch = require('gulp-watch'),
    rev = require('gulp-rev'),
    minifycss = require('gulp-minify-css');

var SCRIPT_SRC = 'web/scripts/**/*.js';
var STYLE_SRC = 'web/styles/**/*.css';
var buildFolder = 'web/build';

/** gulp 3.9
 gulp.task('minifyscript', function() {
    return gulp.src(SCRIPT_SRC, {base: 'web'})
    // `changed` 任务需要提前知道目标目录位置才能找出哪些文件是被修改过的
        //.pipe(changed(buildFolder))// 只有被更改过的文件才会通过这里
        //.pipe(watch(SRC))//只重新编译被更改过的文件
        //.pipe(jscs())
        .pipe(uglify())
        //.pipe(gulp.dest(buildFolder))//// copy original src to build dir
        .pipe(rev())
        .pipe(gulp.dest(buildFolder))// write rev'd src to build dir
        .pipe(rev.manifest('web/build/rev-manifest.json',{
            base: buildFolder,
            merge: true // merge with the existing manifest (if one exists)
        }))
        .pipe(gulp.dest(buildFolder));//compressed file  // write manifest to build dir
});

 gulp.task('minifycss', function() {
    return gulp.src(STYLE_SRC, {base: 'web'})
        .pipe(minifycss())   //执行压缩
        //.pipe(gulp.dest(buildFolder))//// copy original src to build dir
        .pipe(rev())
        .pipe(gulp.dest(buildFolder))// write rev'd src to build dir
        .pipe(rev.manifest('web/build/rev-manifest.json', {
            base: buildFolder,
            merge: true // merge with the existing manifest (if one exists)
        }))
        .pipe(gulp.dest(buildFolder));//compressed file  // write manifest to build dir
});


 gulp.task('default', function () {
    // gulp.watch(SCRIPT_SRC, ['script', 'minifycss'], function(event){
    //     //console.log(event);
    // });

    gulp.start('minifyscript', 'minifycss');
});
 */


//gulp 4.0
var del = require('del');
function minifyScript() {
    return gulp.src(SCRIPT_SRC, {base: 'web'})
    // `changed` 任务需要提前知道目标目录位置才能找出哪些文件是被修改过的
    //.pipe(changed(buildFolder))// 只有被更改过的文件才会通过这里
    //.pipe(watch(SRC))//只重新编译被更改过的文件
    //.pipe(jscs())
        .pipe(uglify())
        //.pipe(gulp.dest(buildFolder))//// copy original src to build dir
        .pipe(rev())
        .pipe(gulp.dest(buildFolder))// write rev'd src to build dir
        .pipe(rev.manifest('web/build/rev-manifest.json', {
            base: buildFolder,
            merge: true // merge with the existing manifest (if one exists)
        }))
        .pipe(gulp.dest(buildFolder));//compressed file  // write manifest to build dir
}


function minifyCss() {
    return gulp.src(STYLE_SRC, {base: 'web'})
        .pipe(minifycss())   //执行压缩
        //.pipe(gulp.dest(buildFolder))//// copy original src to build dir
        .pipe(rev())
        .pipe(gulp.dest(buildFolder))// write rev'd src to build dir
        .pipe(rev.manifest('web/build/rev-manifest.json', {
            base: buildFolder,
            merge: true // merge with the existing manifest (if one exists)
        }))
        .pipe(gulp.dest(buildFolder));//compressed file  // write manifest to build dir
}

/* Not all tasks need to use streams, a gulpfile is just another node program
 * and you can use all packages available on npm, but it must return either a
 * Promise, a Stream or take a callback and call it
 */
function clean() {
    // You can use multiple globbing patterns as you would with `gulp.src`,
    // for example if you are using del 2.0 or above, return its promise
    return del([ 'web/assets/*' , 'web/build']);
}

function watch() {
    gulp.watch(SCRIPT_SRC, minifyScript);
    gulp.watch(STYLE_SRC, minifyCss);
}

/*
 * You can use CommonJS `exports` module notation to declare tasks
 */
exports.clean = clean;
exports.scripts = minifyScript;
exports.styles = minifyCss;
exports.watch = watch;

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 * 不能使用并发模式，因为涉及到写rev文件
 */
// var build = gulp.series(clean, gulp.parallel(minifyScript, minifyCss));
var build = gulp.series(clean, gulp.series(minifyScript, minifyCss));

/*
 * You can still use `gulp.task` to expose tasks
 */
// gulp.task('build', build);

/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task('default', build);

