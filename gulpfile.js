"use strict";

var gulp = require('gulp'),
	concat = require('gulp-concat'),
	maps = require('gulp-sourcemaps'),
	sass = require('gulp-sass'),
	del = require('del'),
	uglify = require('gulp-uglify-es').default,
	cleanCSS = require('gulp-clean-css'),
	rename = require("gulp-rename"),
	merge = require('merge-stream'),
	htmlreplace = require('gulp-html-replace'),
	autoprefixer = require('gulp-autoprefixer'),
	browserSync = require('browser-sync').create();

// Clean task
gulp.task('clean', function() {
	return del(['dist', 'assets/css/app.css']);
});

// Copy third party libraries from node_modules into /vendor
gulp.task('vendor:js', function() {
	return gulp.src([
		'./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
		'./node_modules/jquery/dist/jquery.min.js',
		'./node_modules/sweetalert2/dist/sweetalert2.all.min.js',
		'./node_modules/swiper/js/swiper.js',
		'./node_modules/jquery-validation/dist/jquery.validate.js',
		'./node_modules/jquery-mask-plugin/dist/jquery.mask.js',
		'./node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js'
	])
	.pipe(gulp.dest('./assets/js/vendor'));
});

// vendor task
gulp.task('vendor', gulp.parallel('vendor:js'));

gulp.task('concatScripts', function(){
	return gulp.src([
		'./assets/js/vendor/jquery.min.js',
		'./assets/js/vendor/bootstrap.bundle.min.js',
		'./assets/js/vendor/jquery.validate.js',
		'./assets/js/vendor/jquery.mask.js',
		'./assets/js/vendor/jquery.fancybox.min.js',
		'./assets/js/vendor/sweetalert2.all.min.js',
		'./assets/js/vendor/swiper-bundle.js',
		'./assets/js/vendor/menu.js',
		'./assets/js/vendor/cep.js',
		'./assets/js/functions.js'
	])
	.pipe(maps.init())
	.pipe(concat('app.js'))
	.pipe(maps.write('./'))
	.pipe(gulp.dest('assets/js'))
	.pipe(browserSync.stream());
})

// Copy Bootstrap SCSS(SASS) from node_modules to /assets/scss/bootstrap
gulp.task('bootstrap:scss', function() {
	return gulp.src(['./node_modules/bootstrap/scss/**/*'])
		.pipe(gulp.dest('./assets/scss/bootstrap'));
});

// Compile SCSS(SASS) files
gulp.task('scss', function compileScss() {
	return gulp.src(['./assets/scss/*.scss'])
		.pipe(sass.sync({
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(autoprefixer())
		.pipe(gulp.dest('./assets/css'))
});

// Minify CSS
gulp.task('css:minify', gulp.series('scss', function cssMinify() {
	return gulp.src("./assets/css/app.css")
		.pipe(cleanCSS())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('./dist/assets/css'))
		.pipe(browserSync.stream());
}));

// Minify Js
gulp.task('js:minify', function () {
	return gulp.src([
		'./assets/js/app.js'
	])
		.pipe(uglify())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('./dist/assets/js'))
		.pipe(browserSync.stream());
});

// Replace HTML block for Js and Css file upon build and copy to /dist
gulp.task('replaceHtmlBlock', function () {
	return gulp.src(['*.php'])
		.pipe(htmlreplace({
			'js': 'assets/js/app.min.js',
			'css': 'assets/css/app.min.css'
		}))
		.pipe(gulp.dest('dist/'));
});

// Configure the browserSync task and watch file path for change
gulp.task('dev', function browserDev(done) {
	browserSync.init({

		// proxy: 'localhost/modelo'
		proxy: 'projetos.local/modelo'

	});
	gulp.watch(['assets/scss/*.scss','assets/scss/**/*.scss','!assets/scss/bootstrap/**'], gulp.series('css:minify', function cssBrowserReload (done) {
		browserSync.reload();
		done(); //Async callback for completion.
	}));
	gulp.watch('assets/js/functions.js', gulp.series('concatScripts', function jsBrowserReload (done) {
		browserSync.reload();
		done();
	}));
	gulp.watch(['*.php']).on('change', browserSync.reload);
	done();
});

// Build task
gulp.task("build", gulp.series(gulp.parallel('css:minify', 'js:minify', 'vendor'), 'concatScripts', function copyAssets() {
	return gulp.src([
		'*.php',
		'adm/**',
		'favicon.ico',
		'assets/img/**',
		'assets/ajax/**',
		'assets/include/**',
		'assets/webfonts/**',
	], { base: './'})
		.pipe(gulp.dest('dist'));
}));

// Default task
gulp.task("default", gulp.series("clean", 'build', 'replaceHtmlBlock'));
