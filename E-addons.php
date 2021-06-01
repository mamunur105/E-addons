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
 * Description:       WordPress E-addons Plugin.
 * Version:           1.0.0
 * Author:            Mamunur Rashid
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
\register_activation_hook( __FILE__, '\EM\Eaddons\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\EM\Eaddons\Deactivator::deactivate' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action(
	'plugins_loaded',
	function () {
		define( 'Eaddons_PLUGIN_VERSION', '1.0.0' );
		define( 'Eaddons_PLUGIN_NAME', 'E-addons' );
		define( 'Eaddons_PLUGIN_PREFIX', 'Eaddons' );
		define( 'Eaddons_PLUGIN_DIR', __DIR__ );
		define( 'Eaddons_PLUGIN_FILE', __FILE__ );
		$plugin = new \EM\Eaddons\Plugin();
		$plugin->run();
	}
);
