<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mamunur105/E-addons
 * @since             1.0.0
 * @package           PluginBoilerplate
 *
 * @wordpress-plugin
 * Plugin Name:       E-addons
 * Plugin URI:        https://github.com/mamunur105/E-addons/
 * Description:       WordPress Cxn Plugin.
 * Version:           1.0.0
 * Author:            Codexin Technologies
 * Author URI:        https://github.com/mamunur105/E-addons/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       PluginBoilerplate
 * Domain Path:       /languages
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in lib/Activator.php
 */
\register_activation_hook( __FILE__, '\Codexin\PluginBoilerplate\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\Codexin\PluginBoilerplate\Deactivator::deactivate' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action(
	'plugins_loaded',
	function () {
		define( 'CDXN_PLUGIN_VERSION', '1.0.0' );
		define( 'CDXN_PLUGIN_NAME', 'PluginBoilerplate' );
		define( 'CDXN_PLUGIN_PREFIX', 'cdxn_mlh' );
		define( 'CDXN_PLUGIN_DIR', __DIR__ );
		define( 'CDXN_PLUGIN_FILE', __FILE__ );
		$plugin = new \Codexin\PluginBoilerplate\Plugin();
		$plugin->run();
	}
);
