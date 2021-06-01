<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

/**
 * Fired during plugin activation
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/includes
 */

namespace Codexin\PluginBoilerplate;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/includes
 * @author     Your Name <email@codexin.com>
 */
class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'cdxn_mlh_plugin_activation_time', time() );
	}

}
