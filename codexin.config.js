/**
 * WPGulp Configuration File
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 *
 * @package Cdxn_Gallery
 */

module.exports = {
	// Project options.
	projectName    : 'PluginBoilerplate',
	projectURL     : 'http://dev.test/',              // Local project URL of your already running WordPress site.
	productURL     : './',                      // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.
	browserAutoOpen: false,
	injectChanges  : true,

	// Style options.
	styleSRC             : './src/styles/frontend.scss',         // Path to frontend .scss file.
	styleDestination     : './assets/styles',                   // Path to place the compiled CSS file.
	styleAdminSRC        : './src/styles/admin.scss',   // Path to admin .scss file.
	styleAdminDestination: './assets/styles',                   // Path to place the compiled CSS file.
	outputStyle          : 'expanded',                          // Available options → 'compact' or 'compressed' or 'nested' or 'expanded'
	errLogToConsole      : true,
	precision            : 10,

	// JS Admin options.
	jsAdminSRC        : './src/scripts/admin.js',   // Path to admin JS file.
	jsAdminDestination: './assets/scripts/',                // Path to place the compiled admin JS file.
	jsAdminFile       : 'admin',                    // Compiled admin JS file name.

	// JS Custom options.
	jsCustomSRC        : './src/scripts/frontend.js',   // Path to frontend JS file.
	jsCustomDestination: './assets/scripts/',          // Path to place the compiled frontend JS file.
	jsCustomFile       : 'frontend',                    // Compiled frontend JS file name.

	// Images options.
	imgSRC: './src/images/**/*.{png,jpg,gif,svg}',   // Source folder of images which should be optimized and watched. You can also specify types e.g. raw/**.{png,jpg,gif} in the glob.
	imgDST: './assets/images/',                      // Destination folder of optimized images. Must be different from the imagesSRC folder.

	// Build options
	build: './dist/',
	buildInclude: [
		// include common file types
		'**/*.php',
		'**/*.html',
		'**/*.css',
		'**/*.js',
		'**/*.svg',
		'**/*.png',
		'**/*.jpg',
		'**/*.ttf',
		'**/*.otf',
		'**/*.eot',
		'**/*.woff',
		'**/*.woff2',
		'**/*.pot',
		'LICENSE.txt',
		'README.txt',
		'**/*/installed.json',
		'**/*/LICENSE',
		'**/*/composer.json',
		'**/*/*.mo',
		'**/*/*.po',
		'**/*/*.scss',

		// exclude files and folders
		'!**/.*',
		'!**/log.txt',
		'!node_modules/**/*',
		'!dist/**/*',
		'!codexin.config.js',
		'!gulpfile.js',
		'!src/images/**/*',
		'!src/scripts/**/*',
		'!src/styles/**/*',
		'!assets/images/**',
		'!vendor/htmlburger/carbon-fields/bin/**/*',
		'!vendor/htmlburger/carbon-fields/composer.json',
		'!vendor/htmlburger/carbon-fields/webpack.config.js'
	],
	buildFinalZip: './dist/',

	// Watch files paths.
	watchStyles  : './src/styles/**/*.scss',   // Path to all *.scss files.
	watchJsVendor: './src/scripts/*.js',       // Path to all admin JS files.
	watchJsCustom: './src/scripts/*.js',       // Path to all frontend JS files.
	watchPhp     : './**/*.php',               // Path to all PHP files.

	// Translation options.
	textDomain            : 'PluginBoilerplate',            // Your text-domain here.
	translationFile       : 'PluginBoilerplate.pot',        // Name of the translation file.
	translationDestination: './languages',                      // Where to save the translation files.
	packageName           : 'Photo gallery',                    // Package name.
	bugReport             : 'https://github.com/mamunur105/E-addons/',             // Where can users report bugs.
	lastTranslator        : 'Codexins <info@codexin.com>',      // Last translator Email ID.
	team                  : 'Codexins <support@codexin.com>',   // Team's Email ID.

	// Browsers you care about for autoprefixing. Browserlist https://github.com/ai/browserslist
	// The following list is set as per WordPress requirements. Though, Feel free to change.
	BROWSERS_LIST: [
		'last 20 version',
		'> 1%',
		'ie >= 9',
		'last 6 Android versions',
		'last 20 ChromeAndroid versions',
		'last 20 Chrome versions',
		'last 20 Firefox versions',
		'last 20 Safari versions',
		'last 20 iOS versions',
		'last 20 Edge versions',
		'last 20 Opera versions'
	]
};
