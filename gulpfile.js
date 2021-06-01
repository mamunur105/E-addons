/**
 * Gulpfile.
 *
 * Gulp with WordPress.
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Concatenates & uglifies Vendor and Custom JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Watches files for changes in PHP.
 *      7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @author S.M. Rafiz <https://github.com/smrafiz>
 * @version 1.0.0
 */

/**
 * Load Codexin Configuration.
 *
 */
const config = require('./codexin.config.js');

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them in semantic names.
 */
const gulp = require('gulp');

// CSS related plugins.
const sass         = require('gulp-sass');                 // Gulp plugin for SASS compilation.
const minifycss    = require('gulp-uglifycss');            // Minifies CSS files.
const autoprefixer = require('gulp-autoprefixer');         // Autoprefixing magic.
const mmq          = require('gulp-merge-media-queries');  // Combine matching media queries into one.
const beautify     = require('gulp-cssbeautify');          // Generates beautiful CSS

// JS related plugins.
const concat = require('gulp-concat');  // Concatenates JS files.
const uglify = require('gulp-uglify');  // Minifies JS files.
const babel  = require('gulp-babel');   // Compiles ESNext to browser compatible JS.

// Image related plugins.
const imagemin = require('gulp-imagemin');  // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
const rename      = require('gulp-rename');                 // Renames files E.g. style.css -> style.min.css.
const lineec      = require('gulp-line-ending-corrector');  // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings).
const filter      = require('gulp-filter');                 // Enables you to work on a subset of the original files by filtering them using a glob.
const sourcemaps  = require('gulp-sourcemaps');             // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file.
const notify      = require('gulp-notify');                 // Sends message notification to you.
const browserSync = require('browser-sync').create();       // Reloads browser and injects CSS. Time-saving synchronized browser testing.
const wpPot       = require('gulp-wp-pot');                 // For generating the .pot file.
const sort        = require('gulp-sort');                   // Recommended to prevent unnecessary changes in pot-file.
const cache       = require('gulp-cache');                  // Cache files in stream for later use.
const remember    = require('gulp-remember');               // Adds all the files it has ever seen back into the stream.
const plumber     = require('gulp-plumber');                // Prevent pipe breaking caused by errors from gulp plugins.
const newer       = require('gulp-newer');                  // Passing through only those source files that are newer than corresponding destination files
const del         = require('del');                         // Deletes files and folders
const beep        = require('beepbeep');

// Build related plugins
const zip = require('gulp-zip');

/**
 * Custom Error Handler.
 *
 * @param Mixed err
 */
const errorHandler = (r) => {
	notify.onError('❌  ===> ERROR: <%= error.message %>')(r);
	beep();
};

/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 * @link http://www.browsersync.io/docs/options/
 *
 * @param {Mixed} done Done.
 */
const browsersync = (done) => {
	browserSync.init({
		proxy        : config.projectURL,
		open         : config.browserAutoOpen,
		injectChanges: config.injectChanges,
		watchEvents  : [ 'change', 'add', 'unlink', 'addDir', 'unlinkDir' ]
	});
	done();
};

// Helper function to allow browser reload with Gulp 4.
const reload = (done) => {
	browserSync.reload();
	done();
};

/**
 * Task: `styles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles SASS to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task('styles', () => {
	return (
		gulp
			.src(config.styleSRC, { allowEmpty: true })
			.pipe(plumber(errorHandler))
			.pipe(sourcemaps.init())
			.pipe(
				sass({
					errLogToConsole: config.errLogToConsole,
					outputStyle: config.outputStyle,
					precision: config.precision
				})
			)
			.on('error', sass.logError)
			.pipe(autoprefixer(config.BROWSERS_LIST))
			.pipe(lineec())
			.pipe(beautify())
			.pipe(sourcemaps.write({ includeContent: true }))
			.pipe(sourcemaps.init({ loadMaps: true }))
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(config.styleDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(rename({ suffix: '.min' }))
			.pipe(minifycss({ maxLineLen: 10 }))
			.pipe(lineec())
			.pipe(gulp.dest(config.styleDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(notify({ message: '✅  \n===> Frontend Styles — completed!', onLast: true }))
	);
});

/**
 * Task: `buildStyles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles SASS to CSS
 *    3. Autoprefixes it and generates style.css
 *    4. Merges media queries.
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task('buildStyles', () => {
	return (
		gulp
			.src(config.styleSRC, { allowEmpty: true })
			.pipe(plumber(errorHandler))
			.pipe(
				sass({
					errLogToConsole: config.errLogToConsole,
					outputStyle: config.outputStyle,
					precision: config.precision
				})
			)
			.on('error', sass.logError)
			.pipe(autoprefixer(config.BROWSERS_LIST))
			.pipe(lineec())
			.pipe(mmq({ log: true })) // Merge Media Queries
			.pipe(beautify())
			.pipe(gulp.dest(config.styleDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(rename({ suffix: '.min' }))
			.pipe(minifycss({ maxLineLen: 10 }))
			.pipe(lineec())
			.pipe(gulp.dest(config.styleDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(notify({ message: '✅  \n===> Frontend Build Styles — completed!', onLast: true }))
	);
});

/**
 * Task: `admin`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates admin.css
 */
gulp.task('admin', () => {
	return (
		gulp
			.src(config.styleAdminSRC, { allowEmpty: true })
			.pipe(plumber(errorHandler))
			.pipe(sourcemaps.init())
			.pipe(
				sass({
					errLogToConsole: config.errLogToConsole,
					outputStyle: config.outputStyle,
					precision: config.precision
				})
			)
			.on('error', sass.logError)
			.pipe(autoprefixer(config.BROWSERS_LIST))
			.pipe(lineec())
			// .pipe(mmq({ log: true })) // Merge Media Queries
			.pipe(beautify())
			.pipe(sourcemaps.write({ includeContent: true }))
			.pipe(sourcemaps.init({ loadMaps: true }))
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(config.styleAdminDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(rename({ suffix: '.min' }))
			.pipe(minifycss({ maxLineLen: 10 }))
			.pipe(lineec())
			.pipe(gulp.dest(config.styleAdminDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(notify({ message: '✅  \n===> Admin Styles — completed!', onLast: true }))
	);
});

/**
 * Task: `buildAdmin`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Merges media queries.
 *    4. Autoprefixes it and generates admin.css
 */
gulp.task('buildAdmin', () => {
	return (
		gulp
			.src(config.styleAdminSRC, { allowEmpty: true })
			.pipe(plumber(errorHandler))
			.pipe(
				sass({
					errLogToConsole: config.errLogToConsole,
					outputStyle: config.outputStyle,
					precision: config.precision
				})
			)
			.on('error', sass.logError)
			.pipe(autoprefixer(config.BROWSERS_LIST))
			.pipe(lineec())
			.pipe(mmq({ log: true })) // Merge Media Queries
			.pipe(beautify())
			.pipe(gulp.dest(config.styleAdminDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(rename({ suffix: '.min' }))
			.pipe(minifycss({ maxLineLen: 10 }))
			.pipe(lineec())
			.pipe(gulp.dest(config.styleAdminDestination))
			.pipe(filter('**/*.css'))
			.pipe(browserSync.stream())
			.pipe(notify({ message: '✅  \n===> Admin Build Styles — completed!', onLast: true }))
	);
});

/**
 * Task: `adminJS`.
 *
 * Concatenate and uglify admin JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS admin files
 *     2. Concatenates all the files and generates admin.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates admin.min.js
 */
gulp.task('adminJS', () => {
	return gulp
		.src(config.jsAdminSRC, { since: gulp.lastRun('adminJS') }) // Only run on changed files.
		.pipe(plumber(errorHandler))
		.pipe(
			babel({
				presets: [
					[
						'@babel/preset-env', // Preset to compile your modern JS to ES5.
						{
							targets: { browsers: config.BROWSERS_LIST }
						}
					]
				]
			})
		)
		.pipe(remember(config.jsAdminSRC))
		.pipe(concat(config.jsAdminFile + '.js'))
		.pipe(lineec())
		.pipe(gulp.dest(config.jsAdminDestination))
		.pipe(
			rename({
				basename: config.jsAdminFile,
				suffix: '.min'
			})
		)
		.pipe(uglify())
		.pipe(lineec())
		.pipe(gulp.dest(config.jsAdminDestination))
		.pipe(notify({ message: '✅  \n===> Admin JS — completed!', onLast: true }));
});

/**
 * Task: `customJS`.
 *
 * Concatenate and uglify custom JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS custom files
 *     2. Concatenates all the files and generates frontend.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates frontend.min.js
 */
gulp.task('customJS', () => {
	return gulp
		.src(config.jsCustomSRC, { since: gulp.lastRun('customJS') })
		.pipe(plumber(errorHandler))
		.pipe(remember(config.jsCustomSRC))
		.pipe(concat(config.jsCustomFile + '.js'))
		.pipe(
			babel({
				presets: [
					[
						'@babel/preset-env', // Preset to compile your modern JS to ES5.
						{
							targets: { browsers: config.BROWSERS_LIST }
						}
					]
				]
			})
		)
		.pipe(lineec())
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(
			rename({
				basename: config.jsCustomFile,
				suffix: '.min'
			})
		)
		.pipe(uglify())
		.pipe(lineec())
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(notify({ message: '✅  \n===> Frontend JS — completed!', onLast: true }));
});

/**
 * Task: `images`.
 *
 * Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder
 *     2. Minifies PNG, JPEG, GIF and SVG images
 *     3. Generates and saves the optimized images
 *
 * Read the following to change these options.
 * @link https://github.com/sindresorhus/gulp-imagemin
 */
gulp.task('images', () => {
	return (
		del('./src/images/**/*.db'),
		gulp
			.src(config.imgSRC)
			.pipe(newer(config.imgSRC))
			.pipe(
				cache(
					imagemin(
						[
							imagemin.gifsicle({ interlaced: true }),
							imagemin.mozjpeg({ progressive: true }),
							imagemin.optipng({ optimizationLevel: 3 }), // 0-7 low-high.
							imagemin.svgo({
								plugins: [ { removeViewBox: true }, { cleanupIDs: false } ]
							})
						],
						{
							verbose: true
						}
					)
				)
			)
			.pipe(gulp.dest(config.imgDST))
			.pipe(notify({ message: '✅  ===> Images Optimization — completed!', onLast: true }))
	);
});

/**
 * Task: `clear-images-cache`.
 *
 * Deletes the images cache. By running the next "images" task,
 * each image will be regenerated.
 */
gulp.task('clearCache', function(done) {
	return cache.clearAll(done);
});

/**
 * WP POT Translation File Generator.
 *
 * This task does the following:
 * 1. Gets the source of all the PHP files
 * 2. Sort files in stream by path or any custom sort comparator
 * 3. Applies wpPot with the variable set at the top of this file
 * 4. Generate a .pot file of i18n that can be used for l10n to build .mo file
 */
gulp.task('translate', () => {
	return gulp
		.src(config.watchPhp)
		.pipe(sort())
		.pipe(
			wpPot({
				domain        : config.textDomain,
				package       : config.packageName,
				bugReport     : config.bugReport,
				lastTranslator: config.lastTranslator,
				team          : config.team
			})
		)
		.pipe(gulp.dest(config.translationDestination + '/' + config.translationFile))
		.pipe(notify({ message: '✅  \n===> WP Translation — completed!', onLast: true }));
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task(
	'run',
	gulp.parallel('styles', 'admin', 'adminJS', 'customJS', 'images', browsersync, () => {
		gulp.watch(config.watchPhp, reload); // Reload on PHP file changes.
		gulp.watch(config.watchStyles, gulp.parallel('styles')); // Reload on SCSS file changes.
		gulp.watch(config.watchStyles, gulp.parallel('admin')); // Reload on SCSS file changes.
		gulp.watch(config.watchJsVendor, gulp.series('adminJS', reload)); // Reload on adminJS file changes.
		gulp.watch(config.watchJsCustom, gulp.series('customJS', reload)); // Reload on customJS file changes.
		gulp.watch(config.imgSRC, gulp.series('images', reload)); // Reload on customJS file changes.
	})
);

/**
 * Clean Task.
 *
 * Delete files and folders
 */
gulp.task('clean', () => {
	return del(config.build + '**/*');
});

/**
 * Build files Task.
 *
 * Build files and folders in the dist directory
 */
gulp.task('buildFiles', () => {
	return gulp
		.src(config.buildInclude)
		.pipe(gulp.dest(config.build + config.projectName + '/'))
		.pipe(notify({ message: '✅  Copy from buildFiles complete', onLast: true }));
});

/**
 * Build Zip Task.
 *
 * Build Zip from the Build directory in dist
 */
gulp.task('buildZip', () => {
	return gulp.src(config.build+'/**/*')
		.pipe(zip(config.projectName+'.zip'))
		.pipe(gulp.dest(config.buildFinalZip))
		.pipe(notify({ message: '✅  Zip task complete', onLast: true }));
});

/**
 * Build files from scratch Task.
 *
 * Build production file from the dist directory in root
 */
gulp.task(
	'buildDist',
	gulp.series('clean', 'buildStyles', 'buildAdmin', 'adminJS', 'customJS', 'images', 'translate', 'buildFiles', 'buildZip', function(done) {
		done();
	})
);
